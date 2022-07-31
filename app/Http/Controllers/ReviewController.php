<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Review;
use App\Models\Project;
use App\User;
use Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show freelancers reviews'])->only('freelancer_review_index');
        $this->middleware(['permission:show client reviews'])->only('client_review_index');
    }

    public function freelancer_review_index()
    {
        $reviews = Review::where('reviewed_user_role_id', 2)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.default.reviews.freelancer', compact('reviews'));
    }

    public function client_review_index()
    {
        $reviews = Review::where('reviewed_user_role_id', 3)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.default.reviews.client', compact('reviews'));
    }

    public function review_index($type)
    {
        $reviews = Review::where('reviewed_user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.default.user.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $review = new Review;
        $review->project_id = $request->project_id;
        $review->reviewer_user_id = Auth::user()->id;
        $review->review = $request->review;
        $review->rating = $request->rating;
        if (isFreelancer()) {
            $project = Project::find($request->project_id);
            $review->reviewed_user_id = $project->client_user_id;
            $review->reviewed_user_role_id = 3;
        } else {
            $project = Project::find($request->project_id);
            $review->reviewed_user_id = $project->project_user->user_id;
            $review->reviewed_user_role_id = 2;
        }
        $review->save();

        if (isFreelancer()) {
            //freelancer to client
            NotificationUtility::set_notification(
                "client_review_by_freelancer",
                "You have been given a review for a project by",
                route('user_review', ['type'=>'client'], false),
                $project->client_user_id,
                Auth::user()->id,
                'client'
            );
            EmailUtility::send_email(
                "You have been given a review for a project",
                "You have been given a review for a project by". Auth::user()->name,
                get_email_by_user_id($project->client_user_id),
                route('user_review', ['type'=>'client'])
            );
        } else if (isClient()) {
            //client to freelancer
            NotificationUtility::set_notification(
                "freelancer_review_by_client",
                "You have been given a review for a project by",
                route('user_review', ['type'=>'freelancer'], false),
                $project->project_user->user_id,
                Auth::user()->id,
                'freelancer'
            );
            EmailUtility::send_email(
                "You have been given a review for a project",
                "You have been given a review for a project by". Auth::user()->name,
                get_email_by_user_id($project->project_user->user_id),
                route('user_review', ['type'=>'freelancer'])
            );
        }

        $userProfile = $review->reviewed->profile;
        if (count(Review::where('reviewed_user_id', $review->reviewed_user_id)->where('published', 1)->get()) > 0) {
            $userProfile->rating = Review::where('reviewed_user_id', $review->reviewed_user_id)->where('published', 1)->avg('rating');
        } else {
            $userProfile->rating = 0;
        }

        $userProfile->save();

        flash('Review has been submitted successfully')->success();
        return back();
    }

    function update_review_published(Request $request)
    {
        $review = Review::findOrFail($request->id);
        $review->published = $request->status;
        $review->save();

        $userProfile = $review->reviewed->profile;
        if (count(Review::where('reviewed_user_id', $review->reviewed_user_id)->where('published', 1)->get()) > 0) {
            $userProfile->rating = Review::where('reviewed_user_id', $review->reviewed_user_id)->where('published', 1)->avg('rating');
        } else {
            $userProfile->rating = 0;
        }

        $userProfile->save();

        return 1;
    }
}

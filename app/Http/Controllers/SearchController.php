<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\SystemConfiguration;
use \App\Models\Project;
use \App\Models\UserProfile;
use \App\Models\Skill;
use \App\Models\Service;
use \App\Models\ProjectCategory;
use \App\User;
use App\Utility\CategoryUtility;

class SearchController extends Controller
{
    public function index(Request $request){
        if($request->type == 'freelancer'){
            $type = 'freelancer';
            $keyword = $request->keyword;
            $rating = $request->rating;

            $freelancers = UserProfile::query();

            if($request->keyword != null){
                $user_ids = User::where('user_type', 'freelancer')->where('name', 'like', '%'.$keyword.'%')->pluck('id');
                $freelancers = $freelancers->whereIn('user_id', $user_ids);
            } else {
                $user_ids = User::where('user_type', 'freelancer')->pluck('id');
                $freelancers = $freelancers->whereIn('user_id', $user_ids);
            }

            if($request->rating != null){
                if ($rating == "4+") {
                    $freelancers = $freelancers->where('rating', '>', 4);
                }
                else {
                    $freelancers = $freelancers->whereIn('rating', explode('-', $rating));
                }
            }

            $total = count($freelancers->get());
            $freelancers = $freelancers->paginate(8)->appends($request->query());
            return view('frontend.default.freelancers-listing', compact('freelancers', 'total', 'keyword', 'type', 'rating'));
        } else if($request->type == 'service'){
            $type = 'service';
            $keyword = $request->keyword;
            $rating = $request->rating;

            $services = Service::where('id', '!=', null);

            if($request->keyword != null){
                $service_ids = Service::where('title', 'like', '%'.$keyword.'%')->pluck('id');
                $services = $services->whereIn('id', $service_ids);
            }


            $total = count($services->get());
            $services = $services->paginate(8)->appends($request->query());
            return view('frontend.default.services-listing', compact('services', 'total', 'keyword', 'type', 'rating'));
        }
        else {
            $type = 'project';
            $keyword = $request->keyword;
            $projectType = array('Fixed', 'Long Term');
            $bids = $request->bids;
            $sort = $request->sort;
            $category_id = (ProjectCategory::where('slug', $request->category)->first() != null) ? ProjectCategory::where('slug', $request->category)->first()->id : null;
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $project_approval = SystemConfiguration::where('type','project_approval')->first()->value;
            if($project_approval == 1){
                $projects = Project::biddable()->notcancel()->open()->where('private', '0')->where('project_approval',1);
            }else{
                $projects = Project::biddable()->notcancel()->open()->where('private', '0');
            }

            if($category_id != null){
                $projects = $projects->whereIn('project_category_id', $category_ids);
            }

            $projects = $projects->where('name', 'like', '%'.$keyword.'%');

            if($request->projectType != null){
                $projectType = $request->projectType;
                $projects = $projects->whereIn('type', $projectType);
            }

            if($request->bids != null){
                if ($bids == "30+") {
                    $projects = $projects->where('bids', '>', 30);
                }
                else {
                    $projects = $projects->whereIn('bids', explode('-', $bids));
                }
            }

            switch ($sort) {
                case '1':
                    $projects = $projects->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $projects = $projects->orderBy('price', 'asc');
                    break;
                case '3':
                    $projects = $projects->orderBy('price', 'desc');
                    break;
                case '4':
                    $projects = $projects->orderBy('bids', 'asc');
                    break;
                case '5':
                    $projects = $projects->orderBy('bids', 'desc');
                    break;
                default:
                    $projects = $projects->latest();
                    break;
            }

            $total = count($projects->get());
            $projects = $projects->paginate(8)->appends($request->query());
            return view('frontend.default.projects-listing', compact('projects', 'keyword', 'total', 'type', 'projectType', 'bids', 'sort', 'category_id'));
        }
    }

    public function searchBySkill(Request $request, $id, $type){
        $skill = Skill::findOrFail($id);

        $keyword = $request->keyword;
        $projectType = array('Fixed', 'Long Term');
        $bids = $request->bids;
        $sort = $request->sort;

        if($type == 'projects'){
            $project_approval = SystemConfiguration::where('type','project_approval')->first()->value;
            if($project_approval == 1){
                $projects = Project::biddable()->notcancel()->open()->where('private', '0')->where('project_approval',1);
            }else{
                $projects = Project::biddable()->notcancel()->open()->where('private', '0');
            }

            $projects = $projects->where('skills', 'like', '%'.'"'.$id.'"'.'%')->latest();
            $total = count($projects->get());
            $projects = $projects->paginate(8)->appends($request->query());
            return view('frontend.default.projects-listing', compact('projects', 'keyword', 'total', 'type', 'projectType', 'bids', 'sort'));
        }
    }
}

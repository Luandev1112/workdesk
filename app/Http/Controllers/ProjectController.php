<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Project;
use App\Models\ProjectBid;
use App\Models\ChatThread;
use App\Models\ProjectUser;
use App\Models\UserProfile;
use App\Models\HireInvitation;
use App\Models\ProjectCategory;
use App\Models\MilestonePayment;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Upload;
use Response;
use Illuminate\Support\Str;
use DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('client_user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.default.user.client.projects.list', compact('projects'));
    }

    public function my_open_project()
    {
        $projects = Project::where('client_user_id', Auth::user()->id)->open()->biddable()->notcancel()->latest()->paginate(10);
        return view('frontend.default.user.client.projects.my_open_projects', compact('projects'));
    }

    public function my_running_project()
    {
        if (isClient()) {
            $projects = Project::where('client_user_id', Auth::user()->id)->where('biddable', '0')->open()->notcancel()->latest()->paginate(10);
            return view('frontend.default.user.client.projects.my_running_project', compact('projects'));
        }
        elseif (isFreelancer()) {
            $running_projects = DB::table('projects')
                    ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                    ->where('project_users.user_id', Auth::user()->id)
                    ->where('projects.cancel_status', 0)
                    ->where('projects.closed', 0)
                    ->select('projects.id','project_users.hired_at')
                    ->distinct()
                    ->paginate(10);
            return view('frontend.default.user.freelancer.projects.my_running_project', compact('running_projects'));
        }
    }

    public function bidded_projects()
    {
        $bidded_projects = ProjectBid::where('bid_by_user_id', Auth::user()->id)->paginate(10);
        $total_bidded_projects = ProjectBid::where('bid_by_user_id', Auth::user()->id)->get();
        return view('frontend.default.user.freelancer.projects.bidded', compact('bidded_projects', 'total_bidded_projects'));
    }

    public function my_cancelled_project()
    {
        if (isClient()) {
            $projects = Project::where('client_user_id', Auth::user()->id)->where('cancel_status', '1')->latest()->paginate(10);
            return view('frontend.default.user.client.projects.my_cancelled_project', compact('projects'));
        }
        elseif (isFreelancer()) {
            $cancelled_projects = DB::table('projects')
                    ->orderBy('projects.created_at', 'desc')
                    ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                    ->where('projects.cancel_status', 1)
                    ->where('project_users.user_id', Auth::user()->id)
                    ->select('projects.id')
                    ->distinct()
                    ->paginate(10);

            return view('frontend.default.user.freelancer.projects.my_cancelled_project', compact('cancelled_projects'));
        }

    }

    public function my_completed_project()
    {
        if (isClient()) {
            $projects = Project::where('client_user_id', Auth::user()->id)->closed()->latest()->paginate(10);
            return view('frontend.default.user.client.projects.my_completed_project', compact('projects'));
        }
        elseif (isFreelancer()) {
            $completed_projects = getCompletedProjectsByFreelancer(Auth::user()->id)->paginate(10);
            return view('frontend.default.user.freelancer.projects.my_completed_project', compact('completed_projects'));
        }
    }

    public function project_bids($slug)
    {
        $project = Project::where('slug', $slug)->first();
        $project_bids = $project->bids;
        $bid_users = ProjectBid::where('project_id', $project->id)->latest()->paginate(10);
        return view('frontend.default.user.client.projects.bids', compact('project', 'project_bids', 'bid_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProjectCategory::all();
        $skills = Skill::all();
        $client_package = Auth::user()->userPackage;
        return view('frontend.default.user.client.projects.create', compact('categories','skills', 'client_package'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $uploadAble = false;

        if($request->projectType == 'Fixed'){
            $userPackage = Auth::user()->userPackage;
            if($userPackage->fixed_limit > 0){
                $userPackage->fixed_limit -= 1 ;
                $userPackage->save();

                $uploadAble = true;
            }
        }
        else{
            $userPackage = Auth::user()->userPackage;
            if($userPackage->long_term_limit > 0){
                $userPackage->long_term_limit -= 1 ;
                $userPackage->save();

                $uploadAble = true;
            }
        }

        if($uploadAble){
            $project = new Project;
            $project->name = $request->name;
            $project->type = $request->projectType;
            $project->price = $request->price;
            $project->project_category_id = $request->category_id;
            $project->excerpt = $request->excerpt;
            $project->skills = json_encode($request->skills);
            $project->description = $request->description;
            $project->attachment = $request->attachments;
            $project->client_user_id = Auth::user()->id;
            $project->slug = Str::slug($request->name, '-').date('Ymd-his');
            $project->save();

            //to admin
            NotificationUtility::set_notification(
                "project_created_by_client",
                "A new Project has been created by",
                route('project.details',['slug'=>$project->slug],false),
                0,
                Auth::user()->id,
                'admin'
            );
            EmailUtility::send_email(
                "A new Project has been created",
                "A new Project has been created by". Auth::user()->name,
                system_email(),
                route('project.details',['slug'=>$project->slug])
            );

            flash('Project has been created successfully')->success();
            return redirect()->route('projects.index');
        }
        else {
            flash('Sorry! Project creating limit has been reached.')->warning();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail(decrypt($id));
        $categories = ProjectCategory::all();
        $skills = Skill::all();
        if ($project->closed == '0') {
            return view('frontend.default.user.client.projects.edit',compact('categories','skills','project'));
        }
        else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->type = $request->projectType;
        $project->price = $request->price;
        $project->project_category_id = $request->category_id;
        $project->excerpt = $request->excerpt;
        $project->skills = json_encode($request->skills);
        $project->description = $request->description;
        $project->attachment = $request->attachment;
        $project->client_user_id = Auth::user()->id;
        if ($project->slug == null) {
            $project->slug = Str::slug($request->name, '-').date('Ymd-his');
        }
        if ($project->save()) {
            flash('Project has been updated successfully')->success();
            return redirect()->route('projects.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd(decrypt($id));
        $project = Project::findOrFail(decrypt($id));

        foreach ($project->projectBids as $key => $bid) {
            $bid->delete();
        }

        foreach ($project->reviews as $key =>$review) {
            $review->delete();
        }

        if ($project->project_user != null) {
            $project->project_user->delete();
        }

        $invites = HireInvitation::where('project_id', $project->id)->get();
        if ($invites != null) {
            foreach ($invites as $key =>$invite) {
                $invite->delete();
            }
        }

        $milestone_payments = MilestonePayment::where('project_id', $project->id)->get();
        if ($milestone_payments != null) {
            foreach ($milestone_payments as $key =>$milestone_payment) {
                $milestone_payment->delete();
            }
        }

        $project_users = ProjectUser::where('project_id', $project->id)->get();
        if ($project_users != null) {
            foreach ($project_users as $key =>$project_user) {
                $project_user->delete();
            }
        }

        if(Project::destroy(decrypt($id))){
            flash(translate('Project has been deleted successfully'))->success();
            return redirect()->route('all_projects');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function project_cancel($id)
    {
        $active_project = ProjectUser::where('project_id', $id)->first();
        $project = Project::findOrFail($id);
        if ($active_project == null)
        {
            $project->cancel_status = '1';
            $project->cancel_by_user_id = Auth::user()->id;
            $project->save();
            if ($project->private == '1') {
                Project::destroy($project->id);
            }
            flash(translate('Project has been cancelled successfully'))->success();
            return redirect()->back();
        }
        elseif ($active_project != null) {
            return view('frontend.default.user.projects.project_cancel_request', compact('project'));
        }
        else
        {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_bid_modal(Request $request)
    {
        $project = Project::findOrFail($request->id);
        return view('frontend.default.partials.bid_for_project_modal', compact('project'));
    }

    public function project_done($id)
    {
        $project = Project::findOrFail($id);

        if(MilestonePayment::where('project_id', $project->id)->where('paid_status', 1)->sum('amount') >= $project->project_user->hired_at){
            $project->closed = 1;
            $project->save();
            try {
                $this->check_for_client_project_badge($project->client_user_id);
                $this->check_for_freelancer_project_badge($project->project_user->user_id);
            } catch (\Exception $e) {

            }

            //to freelancer
            NotificationUtility::set_notification(
                "project_completed_by_client",
                "A Project has been marked as completed by",
                route('project.details',['slug'=>$project->slug],false),
                $project->project_user->user_id,
                Auth::user()->id,
                'freelancer'
            );
            EmailUtility::send_email(
                "A Project has been marked as completed",
                "A Project has been marked as completed by". Auth::user()->name,
                get_email_by_user_id($project->project_user->user_id),
                route('project.details',['slug'=>$project->slug])
            );
        }
        else {
            flash('Please complete the payments to end this project')->warning();
        }

        return back();
    }

    public function check_for_client_project_badge($user_id){
        $badges = Badge::where('type','project_badge')->where('role_id', 'client')->orderBy('value', 'desc')->get();
        foreach ($badges as $key => $badge) {
            if(Project::where('client_user_id', $user_id)->where('closed', 1)->count() >= $badge->value){
                $user_badge = UserBadge::where('user_id', $user_id)->where('type', 'project_badge')->first();
                if($user_badge == null){
                    $user_badge = new UserBadge;
                }
                $user_badge->user_id = $user_id;
                $user_badge->type = 'project_badge';
                $user_badge->badge_id = $badge->id;
                $user_badge->save();

                break;
            }
        }
    }

    public function check_for_freelancer_project_badge($user_id){
        $badges = Badge::where('type','project_badge')->where('role_id', 'freelancer')->orderBy('value', 'desc')->get();
        $total = 0;
        foreach (ProjectUser::where('user_id', $user_id)->get() as $key => $project_user) {
            if($project_user->project != null){
                if($project_user->project->closed){
                    $total++;
                }
            }
        }
        foreach ($badges as $key => $badge) {
            if($total >= $badge->value){
                $user_badge = UserBadge::where('user_id', $user_id)->where('type', 'project_badge')->first();
                if($user_badge == null){
                    $user_badge = new UserBadge;
                }
                $user_badge->user_id = $user_id;
                $user_badge->type = 'project_badge';
                $user_badge->badge_id = $badge->id;
                $user_badge->save();

                break;
            }
        }
    }


}

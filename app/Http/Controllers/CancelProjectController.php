<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Models\CancelProject;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Auth;

class CancelProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show project cancel requests'])->only('index');
    }
    //Admin can see Cancel Requests List
    public function index(Request $request)
    {
        $client_id = null;
        if ($request->search != null || $request->type != null) {
            if ($request->has('user_id') && $request->user_id != null) {
                $products = CancelProject::where('requested_user_id', $request->user_id);
                $client_id = $request->user_id;
            }
            $cancel_projects = CancelProject::orderBy('created_at', 'desc')->paginate(10);
        }
        else {
            $cancel_projects = CancelProject::orderBy('created_at', 'desc')->paginate(10);
        }
        return view('admin.default.project.project_cancel_request.request_lists', compact('cancel_projects', 'client_id'));
    }

    //Send Cancel Request by user
    public function store(Request $request)
    {
        $cancel_project = new CancelProject;
        $cancel_project->requested_user_id = Auth::user()->id;
        $cancel_project->project_id = $request->project_id;
        $cancel_project->reason = $request->reason;
        $cancel_project->viewed = 0;
        if ($cancel_project->save()) {

            //to admin
            NotificationUtility::set_notification(
                "project_cancel_request_by_client",
                "A Project cancellation is  requested by",
                route('cancel-project-request.index',[],false),
                0,
                Auth::user()->id,
                'admin'
            );
            EmailUtility::send_email(
                "A Project cancellation is  requested",
                "A Project cancellation is  requested by". Auth::user()->name,
                system_email(),
                route('cancel-project-request.index')
            );

            flash('Request has been created successfully')->success();
            return redirect()->route('dashboard');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function show(Request $request)
    {
        if (Gate::allows('cancel_project_request_show')) {
            $cancel_project = CancelProject::findOrFail($request->id);
            $cancel_project->viewed = 1;
            $cancel_project->save();
            return view('admin.default.project.project_cancel_request.request_details_modal', compact('cancel_project'));
        }
        else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    //Cancel Request accepted by admin
    public function request_accepted(Request $request)
    {
        if (Gate::allows('cancel_project_request_delete')) {
            $project = Project::findOrFail($request->project_id);
            $project->cancel_status = 1;
            $project->cancel_by_user_id = $request->cancel_by_user_id;
            if ($project->save()) {

                //admin to freelancer
                NotificationUtility::set_notification(
                    "project_cancel_request_approved_by_admin",
                    "A Project cancellation is approved by",
                    route('projects.my_cancelled_project',[],false),
                    $project->project_user->user_id,
                    Auth::user()->id,
                    'freelancer'
                );
                EmailUtility::send_email(
                    "A Project cancellation is approved",
                    "A Project cancellation is approved by". Auth::user()->name,
                    get_email_by_user_id($project->project_user->user_id),
                    route('projects.my_cancelled_project')
                );

                flash('Request has been accepted successfully')->success();
                return redirect()->route('cancel-project-request.index');
            }
            else {
                flash('Sorry! Something went wrong.')->error();
                return back();
            }
        }
        else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    public function destroy($id)
    {
        if (Gate::allows('cancel_project_request_delete')) {
            CancelProject::destroy($id);
            flash(translate('Project Cancel Request has been deleted successfully'))->success();
            return redirect()->route('cancel-project-request.index');
        }
        else {
            flash('You do not have access permission')->error();
            return back();
        }
    }
}

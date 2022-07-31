<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class AdminProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show all projects'])->only('all_projects');
        $this->middleware(['permission:show running projects'])->only('running_projects');
        $this->middleware(['permission:show open projects'])->only('open_projects');
        $this->middleware(['permission:show cancelled projects'])->only('cancelled_projects');

    }
    //Admin can see all projects in admin panel
    public function all_projects(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        $client_id = null;

        if ($request->search != null || $request->type != null) {
            if ($request->has('user_id') && $request->user_id != null) {
                $products = Project::where('client_user_id', $request->user_id);
                $client_id = $request->user_id;
            }
            if ($request->search != null){
                $projects = Project::where('name', 'like', '%'.$request->search.'%');
                $sort_search = $request->search;
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $projects = Project::orderBy($col_name, $query);
            }
            $projects = $projects->latest()->paginate(12);
        }
        else {
            $projects = Project::latest()->paginate(12);
        }
        return view('admin.default.project.projects.index', compact('projects', 'col_name', 'query', 'sort_search', 'client_id'));
    }

    //Admin can see all running projects in admin panel
    public function running_projects(Request $request)
    {
        $sort_search = null;
        $client_id = null;

        $projects = Project::biddisable()->open()->notcancel()->latest();

        if ($request->has('user_id') && $request->user_id != null) {
            $products = $projects->where('client_user_id', $request->user_id);
            $client_id = $request->user_id;
        }
        if ($request->search != null){
            $projects = $projects->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $projects = $projects->paginate(12);

        return view('admin.default.project.projects.running_projects', compact('projects', 'sort_search', 'client_id'));
    }

    //Admin can see all open projects in admin panel
    public function open_projects(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        $client_id = null;

        if ($request->search != null || $request->type != null) {
            if ($request->has('user_id') && $request->user_id != null) {
                $products = Project::where('client_user_id', $request->user_id);
                $client_id = $request->user_id;
            }
            if ($request->search != null){
                $projects = Project::where('name', 'like', '%'.$request->search.'%');
                $sort_search = $request->search;
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $projects = Project::orderBy($col_name, $query);
            }
            $projects = $projects->biddable()->open()->notcancel()->paginate(12);
        }
        else {
            $projects = Project::biddable()->open()->notcancel()->latest()->paginate(12);
        }
        return view('admin.default.project.projects.open_projects', compact('projects', 'col_name', 'query', 'sort_search', 'client_id'));
    }

    //Admin can see all cancelled projects in admin panel
    public function cancelled_projects(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        $client_id = null;

        if ($request->search != null || $request->type != null) {
            if ($request->has('user_id') && $request->user_id != null) {
                $products = Project::where('client_user_id', $request->user_id);
                $client_id = $request->user_id;
            }
            if ($request->search != null){
                $projects = Project::where('name', 'like', '%'.$request->search.'%');
                $sort_search = $request->search;
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $projects = Project::orderBy($col_name, $query);
            }
            $projects = $projects->biddable()->open()->notcancel()->paginate(12);
        }
        else {
            $projects = Project::where('cancel_status', '1')->latest()->paginate(12);
        }

        return view('admin.default.project.projects.cancelled_projects', compact('projects', 'col_name', 'query', 'sort_search', 'client_id'));
    }

    public function project_approval(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->project_approval = $request->status;
        if($project->save()){
            return 1;
        }
        else {
            return 0;
        }
    }
}

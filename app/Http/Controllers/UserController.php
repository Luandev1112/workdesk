<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Address;
use App\Models\ChatThread;
use App\Models\ProjectBid;
use App\Models\ProjectUser;
use App\Models\UserProfile;
use App\Models\HireInvitation;
use App\Models\PayToFreelancer;
use App\Models\MilestonePayment;
use App\Models\FreelancerAccount;
use Cache;
use Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show all freelancers'])->only('all_freelancers');
        $this->middleware(['permission:show all clients'])->only('all_clients');

    }

    public function all_freelancers(Request $request)
    {
        $sort_search = null;
        $col_name = null;
        $query = null;
        $freelancers = UserProfile::query();

        $user_ids = User::where(function($user) use ($sort_search){
            $user->where('user_type', 'freelancer');
        })->pluck('id')->toArray();

        $freelancers = $freelancers->where(function($freelancer) use ($user_ids){
            $freelancer->whereIn('user_id', $user_ids);
        });

        if ($request->search != null || $request->type != null) {
            if ($request->has('search')){
                $sort_search = $request->search;
                $user_ids = User::where(function($user) use ($sort_search){
                    $user->where('user_type', 'freelancer')->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
                })->pluck('id')->toArray();

                $freelancers = $freelancers->where(function($freelancer) use ($user_ids){
                    $freelancer->whereIn('user_id', $user_ids);
                });
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $freelancers = $freelancers->orderBy($col_name, $query);
            }

            $freelancers = $freelancers->paginate(10);
        }
        else {
            $freelancers = $freelancers->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.default.freelancer.freelancers.index', compact('freelancers', 'sort_search', 'col_name', 'query'));

    }

    public function all_clients(Request $request)
    {
        $sort_search = null;
        $col_name = null;
        $query = null;
        $clients = UserProfile::query();

        $user_ids = User::where(function($user) use ($sort_search){
            $user->where('user_type', 'client');
        })->pluck('id')->toArray();

        $freelancers = $clients->where(function($freelancer) use ($user_ids){
            $freelancer->whereIn('user_id', $user_ids);
        });


        if ($request->search != null || $request->type != null) {
            if ($request->has('search')){
                $sort_search = $request->search;
                $user_ids = User::where(function($user) use ($sort_search){
                    $user->where('user_type', 'client')->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
                })->pluck('id')->toArray();
                $clients = $clients->where(function($client) use ($user_ids){
                    $client->whereIn('user_id', $user_ids);
                });
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $clients = $clients->orderBy($col_name, $query);
            }

            $clients = $clients->paginate(10);
        }
        else {
            $clients = $clients->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('admin.default.client.clients.index', compact('clients', 'sort_search', 'col_name', 'query'));
    }

    public function freelancer_details($user_name)
    {
        $user = User::where('user_name', $user_name)->first();
        $user_profile = UserProfile::where('user_id', $user->id)->first();
        $user_account = FreelancerAccount::where('user_id', $user->id)->first();
        return view('admin.default.freelancer.freelancers.show', compact('user', 'user_profile', 'user_account'));
    }

    public function client_details($user_name)
    {
        $user = User::where('user_name', $user_name)->first();
        $user_profile = UserProfile::where('user_id', $user->id)->first();
        $user_account = FreelancerAccount::where('user_id', $user->id)->first();
        $projects = $user->number_of_projects()->paginate(10);
        return view('admin.default.client.clients.show', compact('user', 'user_profile', 'user_account','projects'));
    }

    public function userOnlineStatus()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo "User " . $user->name . " is online.";
            else
                echo "User " . $user->name . " is offline.";
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->banned){
            $user->banned = 0;
            $user->save();
            flash(translate('User has been unbanned successfully'))->success();
        }
        else{
            $user->banned = 1;
            $user->save();
            flash(translate('User has been banned successfully'))->success();
        }
        return back();
    }

    public function set_account_type(Request $request)
    {
        auth()->user()->user_type = $request->user_type;

        if(auth()->user()->save()) {
            session()->forget('new_user');
        }

        flash('User account type set successfully')->success();
        return back();

    }
}

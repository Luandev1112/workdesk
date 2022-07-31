<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\UserRole;
use App\User;
use Auth;
use Session;
use Gate;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show verification requests'])->only('index');
    }

    public function index(Request $request)
    {

            $sort_search = null;
            $users = User::where('user_type', 'freelancer')->orWhere('user_type', 'client')->orderBy('created_at', 'desc');

            if ($request->has('search')){
                $sort_search = $request->search;
                $users = $users->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            }

            $users = $users->paginate(10);
            return view('admin.default.verification_request.index', compact('users', 'sort_search'));

    }

    //Verification Info sent to admin
    public function verification_store(Request $request)
    {
        $verification = new Verification;
        $verification->type = $request->verification_type;
        $verification->user_id = Auth::user()->id;
        $verification->role_id = Session::get('role_id');
        $verification->attachment = $request->verification_file;
        if ($verification->save()) {
            flash(translate('Your verification file has been sent successfully'))->success();
            return back();
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function show($username)
    {
        $user = User::where('user_name', $username)->first();
        return view('admin.default.verification_request.show', compact('user'));
    }

    public function destroy($id)
    {
        $verification = Verification::findOrFail($id);
        if (Verification::destroy($id)) {
            flash('Verification info has been deleted successfully')->error();
            return redirect()->route('verification_requests');
        }
        else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function verification_accept(Request $request)
    {
        $verification = Verification::findOrFail($request->id);
        $verification->verified = 1;
        if ($verification->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function verification_reject(Request $request)
    {
        $verification = Verification::findOrFail($request->id);
        if (Verification::destroy($verification->id)) {
            return 1;
        }
        else {
            return 0;
        }
    }
}

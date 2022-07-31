<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Models\PayToFreelancer;
use App\Models\FreelancerAccount;
use App\Models\UserProfile;
use App\User;
use Session;
use Gate;
use Auth;

class PaytoFreelancerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show freelancer withdraw requests'])->only('withdraw_requests');
        $this->middleware(['permission:show freelancer payouts'])->only('index');
    }

    public function index(Request $request)
    {
        $sort_search = null;
        $sort_search_by_date = null;
        $pay_to_freelancers = PayToFreelancer::orderBy('created_at', 'desc')->where('paid_status', 1);
        if ($request->search != null || $request->date != null) {
            if ($request->search != null) {
                $sort_search = $request->search;
                $user_ids = User::where(function($user) use ($sort_search){
                    $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
                })->pluck('id')->toArray();
                $pay_to_freelancers = $pay_to_freelancers->where(function($freelancer) use ($user_ids){
                    $freelancer->whereIn('user_id', $user_ids);
                });
                $pay_to_freelancers = $pay_to_freelancers->paginate(12);
            }
            elseif ($request->date != null){
                $sort_search_by_date = $request->date;
                $var = explode(" / ", $request->date);
                $min_date = $var[0];
                $max_date = $var[1];
                $pay_to_freelancers = $pay_to_freelancers->whereBetween('created_at', [$min_date, $max_date])->paginate(12);
            }
        }
        else {
            $pay_to_freelancers = $pay_to_freelancers->paginate(12);
        }

        return view('admin.default.pay_to_freelancer.index', compact('pay_to_freelancers','sort_search', 'sort_search_by_date'));

    }

    public function pay_to_freelancer($id)
    {
        $withdraw_request = PayToFreelancer::find(decrypt($id));
        $user = $withdraw_request->user;
        $user_profile = UserProfile::where('user_id', $user->id)->first();

        $user_account = FreelancerAccount::where('user_id', $user->id)->first();
        return view('admin.default.withdraw_request.pay', compact('user', 'user_profile', 'user_account', 'withdraw_request'));
    }

    public function pay(Request $request)
    {
        $pay_to_freelancer = PayToFreelancer::find($request->id);
        $pay_to_freelancer->paid_by = Auth::user()->id;
        $pay_to_freelancer->paid_amount = $request->amount;
        $pay_to_freelancer->payment_method = $request->type;
        $pay_to_freelancer->reciept = $request->reciept;
        $pay_to_freelancer->paid_status = 1;
        if ($pay_to_freelancer->save()) {
            $profile = UserProfile::where('user_id', $pay_to_freelancer->user_id)->first();
            $profile->balance = $profile->balance + $pay_to_freelancer->requested_amount - $request->amount;
            $profile->save();

            //from admin to freelancer
            NotificationUtility::set_notification(
                "freelancer_withdrawal_request_accepted_by_admin",
                "A new withdrawal request has been accepted by",
                route('withdrawal_history_index',[],false),
                $pay_to_freelancer->user_id,
                Auth::user()->id,
                'freelancer'
            );
            EmailUtility::send_email(
                "A new withdrawal request has been accepted",
                "A new withdrawal request has been accepted by". Auth::user()->name,
                get_email_by_user_id( $pay_to_freelancer->user_id),
                route('withdrawal_history_index')
            );

            flash(translate('Payment has been done successfully'))->success();
            return redirect()->route('withdraw_request.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function cancel_request($id){
        $pay_to_freelancer = PayToFreelancer::find(decrypt($id));
        $pay_to_freelancer->delete();
        flash(translate('Payment has been cancelled'))->success();
        return redirect()->route('withdraw_request.index');
    }

    public function send_withdrawal_request_index()
    {
        $profile = UserProfile::where('user_id', Auth::user()->id)->where('user_role_id', Session::get('role_id'))->first();
        return view('frontend.default.user.freelancer.earnings.withdrawal-make', compact('profile'));
    }

    public function withdrawal_history_index()
    {
        $withdraw_requests = PayToFreelancer::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
        return view('frontend.default.user.freelancer.earnings.withdrawal-history', compact('withdraw_requests'));
    }

    public function withdraw_requests(Request $request)
    {
        $sort_search = null;
        $col_name = null;
        $query = null;
        $withdraw_requests = PayToFreelancer::where('paid_status', 0);
        if ($request->search != null || $request->type != null) {
            if ($request->has('search')){
                $sort_search = $request->search;
                $user_ids = User::where(function($user) use ($sort_search){
                    $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
                })->pluck('id')->toArray();
                $withdraw_requests = $withdraw_requests->where(function($withdraw_request) use ($user_ids){
                    $withdraw_request->whereIn('user_id', $user_ids);
                });
            }
            if ($request->type != null){
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $withdraw_requests = $withdraw_requests->orderBy($col_name, $query);
            }

            $withdraw_requests = $withdraw_requests->paginate(10);
        }
        else {
            $withdraw_requests = $withdraw_requests->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.default.withdraw_request.index', compact('withdraw_requests', 'sort_search', 'col_name', 'query'));

    }

    public function send_withdrawal_request_store(Request $request)
    {
        if($request->amount <= Auth::user()->profile->balance && $request->amount >= \App\Models\SystemConfiguration::where('type', 'min_withdraw_amount')->first()->value){
            $pay_to_freelancer = new PayToFreelancer;
            $pay_to_freelancer->user_id = Auth::user()->id;
            $pay_to_freelancer->requested_amount = $request->amount;
            $pay_to_freelancer->payment_method = $request->payment_method;
            $pay_to_freelancer->descriptions = $request->descriptions;
            $pay_to_freelancer->save();

            $profile = UserProfile::where('user_id', $pay_to_freelancer->user_id)->first();
            $profile->balance -= $request->amount;
            $profile->save();

            //from freelancer to admin
            NotificationUtility::set_notification(
                "freelancer_withdrawal_request",
                "A new withdrawal has been requested by",
                route('withdraw_request.index',[],false),
                0,
                Auth::user()->id,
                'admin'
            );
            EmailUtility::send_email(
                "A new withdrawal has been requested",
                "A new withdrawal has been requested by". Auth::user()->name,
                system_email(),
                route('withdraw_request.index')
            );

            flash(translate('Withdrawal request has been sent successfully'))->success();
            return redirect()->route('withdrawal_history_index');
        }
        flash('You do not have enough balance')->warning();
        return back();
    }
}

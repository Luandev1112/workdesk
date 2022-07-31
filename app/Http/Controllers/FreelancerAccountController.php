<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FreelancerAccount;
use Auth;

class FreelancerAccountController extends Controller
{
    // Freelancer Account related info store like bank, paypal etc
    public function store(Request $request)
    {
        $freelancer_account = FreelancerAccount::where('user_id', Auth::user()->id)->first();
        if ($freelancer_account != null) {
            if ($request->bank_name != null) {
                $freelancer_account->bank_name = $request->bank_name;
                $freelancer_account->bank_account_name = $request->bank_account_name;
                $freelancer_account->bank_account_number = $request->bank_account_number;
                $freelancer_account->bank_routing_number = $request->bank_routing_number;
            }
            if ($request->paypal_acc_name != null) {
                $freelancer_account->paypal_acc_name = $request->paypal_acc_name;
                $freelancer_account->paypal_email = $request->paypal_acc_email;
            }
            if ($freelancer_account->save()) {
                flash(translate('Your Info has been updated successfully'))->success();
                return redirect()->route('user.account');
            }
            else {
                flash(translate('Sorry! Something went wrong.'))->error();
                return back();
            }
        }
        else {
            $freelancer_account = new FreelancerAccount;
            $freelancer_account->user_id = Auth::user()->id;
            if ($request->bank_name != null) {
                $freelancer_account->bank_name = $request->bank_name;
                $freelancer_account->bank_account_name = $request->bank_account_name;
                $freelancer_account->bank_account_number = $request->bank_account_number;
                $freelancer_account->bank_routing_number = $request->bank_routing_number;
            }
            if ($request->paypal_acc_name != null) {
                $freelancer_account->paypal_acc_name = $request->paypal_acc_name;
                $freelancer_account->paypal_email = $request->paypal_acc_email;
            }
            if ($freelancer_account->save()) {
                flash(translate('Your Info has been updated successfully'))->success();
                return redirect()->route('user.account');
            }
            else {
                flash(translate('Sorry! Something went wrong.'))->error();
                return back();
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mehedi\Paystack\Paystack;
use Auth;
use Session;
use Redirect;

class PaystackController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        $baseUrl = "https://api.paystack.co";

        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
        $request->email = Auth::user()->email;
        $request->amount = (int) round($request->session()->get('payment_data')['amount'] * 100);
        $request->reference = $paystack->genTranxRef();
        return $paystack->getAuthorizationUrl()->redirectNow();

        return Paystack::getAuthorizationUrl()->redirectNow();
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        $baseUrl = "https://api.paystack.co";
        if (Session::get('payment_data')['payment_type'] == 'milestone_payment') {
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
            $payment = $paystack->getPaymentData();
            if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                $milestone_payment = new MilestonePaymentController;
                return $milestone_payment->milestone_payment_done($request->session()->get('payment_data'), $payment);
            }
            flash(translate('Payment cancelled'))->success();
            return redirect()->route('dashboard');
        }
        elseif (Session::get('payment_data')['payment_type'] == 'package_payment') {
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
            $payment = $paystack->getPaymentData();
            if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                $package_payment = new PackagePaymentController;
                return $package_payment->package_payment_done($request->session()->get('payment_data'), $payment);
            }
            flash(translate('Payment cancelled'))->success();
            return redirect()->route('dashboard');
        }

        elseif (Session::get('payment_data')['payment_type'] == 'service_payment') {
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
            $payment = $paystack->getPaymentData();
            if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                $service_package_payment = new ServicePaymentController;
                return $service_package_payment->service_package_payment_done($request->session()->get('payment_data'), $payment);
            }
            flash(translate('Payment cancelled'))->success();
            return redirect()->route('dashboard');
        }
    }
}

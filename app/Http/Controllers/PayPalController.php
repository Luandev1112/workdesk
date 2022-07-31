<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Models\SystemConfiguration;
use Redirect;
use Session;


class PaypalController extends Controller
{

    public function getCheckout()
    {
        // Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox_checkbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);

        if(Session::get('payment_data')['payment_type'] == 'package_payment'){
            $amount = Session::get('payment_data')['amount'];
        }
        elseif (Session::get('payment_data')['payment_type'] == 'milestone_payment') {
            $amount = Session::get('payment_data')['amount'];
        }
        elseif (Session::get('payment_data')['payment_type'] == 'service_payment') {
            $amount = Session::get('payment_data')['amount'];
        }
        elseif (Session::get('payment_data')['payment_type'] == 'wallet_payment') {
            $amount = Session::get('payment_data')['amount'];
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
             "intent" => "CAPTURE",
             "purchase_units" => [[
                 "reference_id" => rand(000000,999999),
                 "amount" => [
                     "value" => number_format($amount, 2, '.', ''),
                     "currency_code" => \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code
                 ]
             ]],
             "application_context" => [
                  "cancel_url" => url('paypal/payment/cancel'),
                  "return_url" => url('paypal/payment/done')
             ]
         ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            return Redirect::to($response->result->links[1]->href);
        }catch (HttpException $ex) {

        }
    }


    public function getCancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('payment_data');
        flash(translate('Payment cancelled'))->success();
  	    return redirect()->route('dashboard');
    }

    public function getDone(Request $request)
    {
        //dd($request->all());
        // Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (get_setting('paypal_sandbox_checkbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);

        // $response->result->id gives the orderId of the order created above

        $ordersCaptureRequest = new OrdersCaptureRequest($request->token);
        $ordersCaptureRequest->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($ordersCaptureRequest);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if(Session::get('payment_data')['payment_type'] == 'package_payment'){
                $package_payment = new PackagePaymentController;
                return $package_payment->package_payment_done($request->session()->get('payment_data'), json_encode($response));
            }
            elseif (Session::get('payment_data')['payment_type'] == 'milestone_payment') {
                $milestone_payment = new MilestonePaymentController;
                return $milestone_payment->milestone_payment_done($request->session()->get('payment_data'), json_encode($response));
            }
            elseif (Session::get('payment_data')['payment_type'] == 'service_payment') {
                $package_payment = new ServicePaymentController;
                return $package_payment->service_package_payment_done(Session::get('payment_data'), json_encode($response));
            }
            elseif (Session::get('payment_data')['payment_type'] == 'wallet_payment') {

                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), json_encode($response));
            }
        }
        catch (HttpException $ex) {

        }
    }
}

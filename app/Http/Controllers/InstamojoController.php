<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use Session;
use Redirect;
use App\Models\SystemConfiguration;

use Auth;

class InstamojoController extends Controller
{
   public function pay($request){
       if(SystemConfiguration::where('type', 'instamojo_sandbox_checkbox')->first()->value == 1){
           // testing_url
           $endPoint = 'https://test.instamojo.com/api/1.1/';
       }
       else{
           // live_url
           $endPoint = 'https://www.instamojo.com/api/1.1/';
       }

       $api = new \Instamojo\Instamojo(
            env('INSTAMOJO_API_KEY'),
            env('INSTAMOJO_AUTH_TOKEN'),
            $endPoint
          );
          if(preg_match_all('/^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/im', "919007798519")){
            try {
                $response = $api->paymentRequestCreate(array(
                    "purpose" => ucfirst(str_replace('_', ' ', Session::get('payment_data')['payment_type'])),
                    "amount" => $request->session()->get('payment_data')['amount'],
                    "buyer_name" => Auth::user()->name,
                    "send_email" => true,
                    "email" => Auth::user()->email,
                    "phone" => "9007798519",
                    "redirect_url" => url('instamojo/payment/pay-success')
                ));

                return redirect($response['longurl']);

            }catch (Exception $e) {
                flash($e->getMessage())->error();
                return redirect()->route('dashboard');
            }
          }
          else{
              flash('Invalid phone number')->error();
              return redirect()->route('dashboard');
          }
   }

// success response method.
 public function success(Request $request){
     try {
         if(SystemConfiguration::where('type', 'instamojo_sandbox_checkbox')->first()->value == 1){
             $endPoint = 'https://test.instamojo.com/api/1.1/';
         }
         else{
             $endPoint = 'https://www.instamojo.com/api/1.1/';
         }

         $api = new \Instamojo\Instamojo(
             env('INSTAMOJO_API_KEY'),
             env('INSTAMOJO_AUTH_TOKEN'),
             $endPoint
         );

        $response = $api->paymentRequestStatus(request('payment_request_id'));

        if(!isset($response['payments'][0]['status']) ) {
            flash('Payment Failed')->error();
            return redirect()->route('dashboard');
        } else if($response['payments'][0]['status'] != 'Credit') {
            flash('Payment Failed')->error();
            return redirect()->route('dashboard');
        }
      }catch (\Exception $e) {
          flash('Payment Failed')->error();
          return redirect()->route('dashboard');
     }

    $payment = json_encode($response);

    if(Session::has('payment_data')){
        if(Session::get('payment_data')['payment_type'] == 'package_payment'){
            $package_payment = new PackagePaymentController;
            return $package_payment->package_payment_done($request->session()->get('payment_data'), $payment);
        }
        elseif(Session::get('payment_data')['payment_type'] == 'milestone_payment'){
            $milestone_payment = new MilestonePaymentController;
            return $milestone_payment->milestone_payment_done($request->session()->get('payment_data'), $payment);
        }
        elseif(Session::get('payment_data')['payment_type'] == 'service_payment'){
            $package_payment = new ServicePaymentController;
            return $package_payment->service_package_payment_done(Session::get('payment_data'), json_encode($payment));
        }
    }

  }

}

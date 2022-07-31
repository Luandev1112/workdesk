<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers;
session_start();

class PublicSslCommerzPaymentController extends Controller
{
    public function index(Request $request)
    {
            # Here you have to receive all the order data to initate the payment.
            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
            $post_data = array();
            $post_data['total_amount'] = $request->session()->get('payment_data')['amount']; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = substr(md5(Auth::user()->id), 0, 10); // tran_id must be unique

            #Start to save these value  in session to pick in success page.
            $_SESSION['payment_values']['tran_id']=$post_data['tran_id'];
            $_SESSION['payment_values']['payment_data']=$request->session()->get('payment_data');
            #End to save these value  in session to pick in success page.

            # CUSTOMER INFORMATION
            $user = Auth::user();
            $post_data['cus_name'] = $user->name;
            $post_data['cus_add1'] = $user->address;
            $post_data['cus_city'] = $user->city;
            $post_data['cus_postcode'] = $user->postal_code;
            $post_data['cus_country'] = $user->country;
            $post_data['cus_phone'] = $user->phone;

            $server_name=$request->root()."/";
            $post_data['success_url'] = $server_name . "sslcommerz/success";
            $post_data['fail_url'] = $server_name . "sslcommerz/fail";
            $post_data['cancel_url'] = $server_name . "sslcommerz/cancel";

            $payment_data = $request->session()->get('payment_data');
            // dd($payment_data);
            $post_data['value_a'] = $post_data['tran_id'];
            $post_data['value_b'] = $payment_data['service_package_id'];

            # SHIPMENT INFORMATION
            // $post_data['ship_name'] = 'ship_name';
            // $post_data['ship_add1 '] = 'Ship_add1';
            // $post_data['ship_add2'] = "";
            // $post_data['ship_city'] = "";
            // $post_data['ship_state'] = "";
            // $post_data['ship_postcode'] = "";
            // $post_data['ship_country'] = "Bangladesh";

            # OPTIONAL PARAMETERS
            // $post_data['value_a'] = "ref001";
            // $post_data['value_b'] = "ref002";
            // $post_data['value_c'] = "ref003";
            // $post_data['value_d'] = "ref004";

            $sslc = new SSLCommerz();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->initiate($post_data, false);

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }

    }

    public function success(Request $request)
    {
        //echo "Transaction is Successful";
        $payment_data = [];
        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $_SESSION['payment_values']['tran_id'];
        #End to received these value from session. which was saved in index function.
        $payment = json_encode($request->all());

        if(isset($_SESSION['payment_values']['payment_data'])){
            if($_SESSION['payment_values']['payment_data']['payment_type'] == 'package_payment'){
                $package_payment = new PackagePaymentController;
                return $package_payment->package_payment_done($_SESSION['payment_values']['payment_data'], $payment);
            }
            elseif ($_SESSION['payment_values']['payment_data']['payment_type'] == 'milestone_payment') {
                $milestone_payment = new MilestonePaymentController;
                return $milestone_payment->milestone_payment_done($_SESSION['payment_values']['payment_data'], $payment);
            } elseif ($_SESSION['payment_values']['payment_data']['payment_type'] == 'service_payment') {
                $package_payment = new ServicePaymentController;
                return $package_payment->service_package_payment_done($_SESSION['payment_values']['payment_data'], $payment);
            }
        }
    }

    public function fail(Request $request)
    {
        $request->session()->forget('payment_data');
        flash(translate('Payment Failed'))->success();
        return redirect()->url()->previous();
    }

     public function cancel(Request $request)
    {
        $request->session()->forget('payment_data');
        flash(translate('Payment cancelled'))->success();
    	return redirect()->url()->previous();
    }

     public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
      if($request->input('tran_id')) #Check transation id is posted or not.
      {

          $tran_id = $request->input('tran_id');

        #Check order status in order tabel against the transaction id or order id.
          $order = Order::findOrFail($request->session()->get('order_id'));

                if($order->payment_status =='Pending')
                {
                    $sslc = new SSLCommerz();
                    $validation = $sslc->orderValidate($tran_id, $order->grand_total, 'BDT', $request->all());
                    if($validation == TRUE)
                    {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Processing or Complete.
                        Here you can also sent sms or email for successfull transaction to customer
                        */
                        echo "Transaction is successfully Complete";
                    }
                    else
                    {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */

                        echo "validation Fail";
                    }

                }
        }
        else
        {
            echo "Inavalid Data";
        }
    }
}

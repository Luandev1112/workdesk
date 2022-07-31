<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\WalletPaymentController;
use App\Models\PackagePayment;
use App\Models\UserProfile;
use App\Models\Package;
use App\Models\UserPackage;
use Auth;
Use Session;

class PackagePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show package payments'])->only('admin_index');
    }
    //admin package payment history
    public function admin_index(Request $request)
    {
        $min_date = null;
        $max_date = null;
        $sort_search = null;

        $package_payments = PackagePayment::orderBy('created_at', 'desc');
        if ($request->date != null){
            $sort_search = $request->date;
            $var = explode(" / ", $request->date);
            $min_date = $var[0];
            $max_date = $var[1];
            $package_payments = $package_payments->whereBetween('created_at', [$min_date, $max_date])->paginate(12);
        }
        else {
            $package_payments = $package_payments->paginate(12);
        }

        return view('admin.default.package_payment.index', compact('package_payments', 'sort_search'));

    }

    //admin Offline package payment history
    public function manual_package_payments_history(Request $request)
    {
        $min_date = null;
        $max_date = null;
        $sort_search = null;

        $package_payments = PackagePayment::orderBy('created_at', 'desc')->where('offline_payment', 1);
        if ($request->date != null){
            $sort_search = $request->date;
            $var = explode(" / ", $request->date);
            $min_date = $var[0];
            $max_date = $var[1];
            $package_payments = $package_payments->whereBetween('created_at', [$min_date, $max_date])->paginate(12);
        }
        else {
            $package_payments = $package_payments->paginate(12);
        }

        return view('manual_payment.package_payments', compact('package_payments', 'sort_search'));

    }

    // Online Package Purchase
    public function purchase_package(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $data['package_id'] = $package->id;
        $data['payment_method'] = $request->payment_option;
        $data['amount'] = $package->price;
        $data['user_id'] = Auth::user()->id;
        $data['payment_type'] = 'package_payment';
        $request->session()->put('payment_data', $data);

        if($request->payment_option == 'paypal'){
            $paypal = new PayPalController;
            return $paypal->getCheckout();
        }
        elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->index();
        }
        elseif ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
        elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        }
        elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        }
        elseif ($request->payment_option == 'paytm') {
            $paytm = new PaytmController;
            return $paytm->index();
        }
    }

    public function package_payment_done($payment_data, $payment)
    {
        $package = Package::findOrFail(Session::get('payment_data')['package_id']);
        $package_payment = new PackagePayment;
        $package_payment->package_id = $package->id;
        $package_payment->package_type = $package->type;
        $package_payment->user_id = Auth::user()->id;
        $package_payment->amount = Session::get('payment_data')['amount'];
        $package_payment->payment_type = Session::get('payment_data')['payment_type'];
        $package_payment->payment_method = Session::get('payment_data')['payment_method'];
        $package_payment->payment_details = $payment;
        if ($package_payment->save()) {
            $userPackage = Auth::user()->userPackage;
            if($userPackage == null){
                $userPackage = new UserPackage;
                $userPackage->user_id = Auth::user()->id;
            }

            $userPackage->package_id = $package->id;
            if($package->number_of_days > 0){
                $userPackage->package_invalid_at = date('Y-m-d', strtotime('+ '.$package->number_of_days.'days'));
            }

            if ($userPackage->fixed_limit == null) {
                $userPackage->fixed_limit = $package->fixed_limit;
            }
            else {
                $userPackage->fixed_limit += $package->fixed_limit;
            }

            if ($userPackage->long_term_limit == null) {
                $userPackage->long_term_limit = $package->long_term_limit;
            }
            else {
                $userPackage->long_term_limit += $package->long_term_limit;
            }

            $userPackage->skill_add_limit = $package->skill_add_limit;
            $userPackage->portfolio_add_limit = $package->portfolio_add_limit;
            $userPackage->job_exp_limit = $package->job_exp_limit;
            $userPackage->bookmark_project_limit = $package->bookmark_project_limit;
            $userPackage->following_status = $package->following_status;
            $userPackage->bio_text_limit = $package->bio_text_limit;
            $userPackage->service_limit = $package->service_limit;

            $userPackage->save();

            //from freelancer/client to admin
            NotificationUtility::set_notification(
                "package_purchased",
                "A new package has been purchased by",
                route('package_payment_history_for_admin',[],false),
                0,
                Auth::user()->id,
                'admin'
            );

            EmailUtility::send_email(
                "A new package has been purchased",
                "A new package has been purchased by ". Auth::user()->name,
                system_email(),
                route('package_payment_history_for_admin')
            );

            Session::forget('payment_data');
            flash('Payment has been done successfully')->success();
            return redirect()->route('dashboard');
        }
    }

    // Offline Package Purchase
    public function purchase_package_offline(Request $request){
      $package = Package::findOrFail($request->package_id);
      $package_payment = new PackagePayment;
      $package_payment->package_id      = $package->id;
      $package_payment->package_type    = $package->type;
      $package_payment->user_id         = Auth::user()->id;
      $package_payment->amount          = $package->price;
      $package_payment->payment_type    = 'package_payment';
      $package_payment->payment_method  = $request->payment_option;
      $package_payment->payment_details = $request->trx_id;
      $package_payment->offline_payment = 1;
      $package_payment->receipt         = $request->photo;
      $package_payment->approval        = 0;
      $package_payment->save();
      flash(translate('Offline payment has been done. Please wait for admin approval.'))->success();
      return redirect()->route('freelancer.packages.history');
    }

    // Offline package payment approval
    public function approve_offline_package_payment($id)
    {
      $package_payment = PackagePayment::findOrFail($id);
      $package_payment->approval = 1;

        $userPackage = $package_payment->user->userPackage;
        if($userPackage == null){
            $userPackage          = new UserPackage;
            $userPackage->user_id = $package_payment->user_id;
        }

        $userPackage->package_id = $package_payment->package_id;
        if($package_payment->package->number_of_days > 0){
            $userPackage->package_invalid_at = date('Y-m-d', strtotime('+ '.$package_payment->package->number_of_days.'days'));
        }

        if ($userPackage->fixed_limit == null) {
            $userPackage->fixed_limit = $package_payment->package->fixed_limit;
        }
        else {
            $userPackage->fixed_limit += $package_payment->package->fixed_limit;
        }

        if ($userPackage->long_term_limit == null) {
            $userPackage->long_term_limit = $package_payment->package->long_term_limit;
        }
        else {
            $userPackage->long_term_limit += $package_payment->package->long_term_limit;
        }

        $userPackage->skill_add_limit         = $package_payment->package->skill_add_limit;
        $userPackage->portfolio_add_limit     = $package_payment->package->portfolio_add_limit;
        $userPackage->job_exp_limit           = $package_payment->package->job_exp_limit;
        $userPackage->bookmark_project_limit  = $package_payment->package->bookmark_project_limit;
        $userPackage->following_status        = $package_payment->package->following_status;
        $userPackage->bio_text_limit          = $package_payment->package->bio_text_limit;
        $userPackage->service_limit           = $package_payment->package->service_limit;

        if ($userPackage->save()) {
          $package_payment->save();
          flash(translate('Offline payment approved successfully.'))->success();
          return redirect()->route('offline_package_payments_history');
        }
        else {
          flash(translate('Something went wrong'))->error();
          return back();
        }

    }

    public function freelancer_package_purchase_history_index()
    {
        $package_payments = PackagePayment::where('user_id' , Auth::user()->id)->latest()->paginate(12);
        return view('frontend.default.user.packages.history', compact('package_payments'));
    }
}

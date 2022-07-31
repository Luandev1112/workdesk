<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ServicePackage;
use App\Models\ChatThread;
use App\Models\ServicePackagePayment;
use App\Models\UserProfile;
use Session;

class ServicePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show service payments'])->only('admin_index');
    }
    // Online Service payment history
    public function admin_index()
    {
        $service_payments = ServicePackagePayment::orderBy('id', 'desc')->paginate(12);
        return view('admin.default.service_payment_history.index', compact('service_payments'));
    }

    // Offline Service Payment history
    public function offline_service_payments_history(Request $request)
    {
        $min_date = null;
        $max_date = null;
        $sort_search = null;

        $service_payments = ServicePackagePayment::orderBy('created_at', 'desc')->where('offline_payment', 1);
        if ($request->date != null){
            $sort_search        = $request->date;
            $var                = explode(" / ", $request->date);
            $min_date           = $var[0];
            $max_date           = $var[1];
            $service_payments   = $service_payments->whereBetween('created_at', [$min_date, $max_date])->paginate(12);
        }
        else {
            $service_payments   = $service_payments->paginate(12);
        }

        return view('manual_payment.service_payments', compact('service_payments','sort_search'));

    }

    public function service_package_payment_done($payment_data, $payment)
    {
        $service_package_payment = new ServicePackagePayment;
        $service_package = ServicePackage::findOrFail($payment_data['service_package_id']);
        $userProfile = UserProfile::where('user_id', $service_package->service->user->id)->first();

        $service_package_payment->service_package_id = $service_package->id;
        $service_package_payment->service_package_type = $service_package->service_type;
        $service_package_payment->user_id = Auth::user()->id;
        $service_package_payment->amount = $payment_data["amount"];
        $service_package_payment->payment_method = $payment_data["payment_method"];
        $service_package_payment->service_owner_id = $service_package->service->user->id;

        $package = $service_package->service->user->userPackage->package;

        if ($package->commission_type == 'percent') {
            $service_package_payment->admin_profit = ($payment_data['amount'] * $package->commission)/100;
        } else {
            $service_package_payment->admin_profit = $package->commission;
        }

        $service_package_payment->freelancer_profit = $payment_data['amount'] - $service_package_payment->admin_profit;
        $userProfile->balance += $service_package_payment->freelancer_profit;

        $service_package_payment->payment_details = json_encode($payment);

        if($service_package_payment->save()) {
            if($userProfile->save()) {
                $existing_chat_thread = ChatThread::where('sender_user_id', Auth::user()->id)->where('receiver_user_id', $service_package->service->user->id)->first();
                if ($existing_chat_thread == null) {
                    $existing_chat_thread = new ChatThread;
                    $existing_chat_thread->thread_code = $service_package->service->user->id.date('Ymd').Auth::user()->id;
                    $existing_chat_thread->sender_user_id = Auth::user()->id;
                    $existing_chat_thread->receiver_user_id = $service_package->service->user->id;
                    $existing_chat_thread->save();
                }
            }

            flash('Payment has been done successfully')->success();
        } else {
            flash('The payment was done without saving the info.')->error();
        }

        Session::forget('payment_data');

        return redirect()->route('dashboard');
    }

    public function purchase_service_package_offline(Request $request)
    {
        $service_package    = ServicePackage::findOrFail($request->service_package_id);
        $package            = $service_package->service->user->userPackage->package;

        $service_package_payment                        = new ServicePackagePayment;
        $service_package_payment->service_package_id    = $service_package->id;
        $service_package_payment->service_package_type  = $service_package->service_type;
        $service_package_payment->user_id               = Auth::user()->id;
        $service_package_payment->service_owner_id      = $service_package->service->user->id;
        $service_package_payment->amount                = $service_package->service_price;
        $service_package_payment->payment_type          = 'service_payment';
        $service_package_payment->payment_method        = $request->payment_option;
        if ($package->commission_type == 'percent') {
            $service_package_payment->admin_profit      = ($service_package->service_price * $package->commission)/100;
        } else {
            $service_package_payment->admin_profit      = $package->commission;
        }
        $service_package_payment->freelancer_profit     = $service_package->service_price - $service_package_payment->admin_profit;
        $service_package_payment->payment_details       = $request->trx_id;
        $service_package_payment->offline_payment       = 1;
        $service_package_payment->receipt               = $request->photo;
        $service_package_payment->approval              = 0;

        $service_package_payment->save();
        flash('Offline Payment has been done successfully')->success();
        return redirect()->route('client.purchased.services');
    }

    public function approve_offline_service_payment($id)
    {
        $service_package_payment            = ServicePackagePayment::findOrFail($id);
        $service_package_payment->approval  = 1;

        if($service_package_payment->save())
        {
            $service_package = ServicePackage::findOrFail($service_package_payment->service_package_id);
            $userProfile = UserProfile::where('user_id', $service_package->service->user->id)->first();

            $userProfile->balance += $service_package_payment->freelancer_profit;
            if($userProfile->save()) {
                $existing_chat_thread = ChatThread::where('sender_user_id', $service_package_payment->user_id)->where('receiver_user_id', $service_package->service->user->id)->first();
                if ($existing_chat_thread == null) {
                    $existing_chat_thread = new ChatThread;
                    $existing_chat_thread->thread_code = $service_package->service->user->id.date('Ymd').$service_package_payment->user_id;
                    $existing_chat_thread->sender_user_id = $service_package_payment->user_id;
                    $existing_chat_thread->receiver_user_id = $service_package->service->user->id;
                    $existing_chat_thread->save();
                }
            }
            flash('Offline payment approved successfully.')->success();
            return redirect()->route('offline_service_payments_history');
        }
    }


}

@php
    $user = \App\Models\UserProfile::where('user_id', Auth::user()->id)->where('user_role_id', Session::get('role_id'))->first();
@endphp
<form class="form-horizontal" action="{{ route('milestone.pay_to_admin') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="milestone_request_id" value="{{ $milestone->id }}">
    <div class="form-group">
        <label class="form-label">
            {{translate('Sending Amount')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <input type="number" min="{{ $milestone->amount }}" max="{{ $milestone->amount }}" class="form-control" name="amount" value="{{ $milestone->amount }}" required readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">
            {{translate('Payment System')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <select class="form-control aiz-selectpicker" name="payment_option">
                @if(\App\Models\SystemConfiguration::where('type', 'paypal_activation_checkbox')->first()->value)
                    <option value="paypal">{{translate('PayPal')}}</option>
                @endif
                @if(\App\Models\SystemConfiguration::where('type', 'stripe_activation_checkbox')->first()->value)
                    <option value="stripe">{{translate('Stripe')}}</option>
                @endif
                @if(\App\Models\SystemConfiguration::where('type', 'sslcommerz_activation_checkbox')->first()->value)
                    <option value="sslcommerz">{{translate('SSlcommerz')}}</option>
                @endif
                @if(\App\Models\SystemConfiguration::where('type', 'paystack_activation_checkbox')->first()->value)
                    <option value="paystack">{{translate('PayStack')}}</option>
                @endif
                @if(\App\Models\SystemConfiguration::where('type', 'instamojo_activation_checkbox')->first()->value)
                    <option value="instamojo">{{translate('Instamojo')}}</option>
                @endif
                @if(\App\Models\SystemConfiguration::where('type', 'paytm_activation_checkbox')->first()->value)
                    <option value="paytm">{{translate('Paytm')}}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">{{ translate('Pay Now') }}</button>
    </div>
</form>

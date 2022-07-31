<h6>{{ ucfirst($service_package->service_type) }} ({{ single_price($service_package->service_price) }})</h6>
<form class="form-horizontal mt-2" action="{{ route('purchase_service_package') }}" method="POST">
    @csrf
    <input type="hidden" class="form-control form-control-sm" name="service_package_id" value="{{ $service_package->id }}">
    <div class="form-group">
        <label class="form-label">
            {{translate('Payment System')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <select class="form-control form-control-sm aiz-selectpicker" name="payment_option">
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
        <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{translate('Pay')}}</button>
    </div>
</form>

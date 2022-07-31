<div class="form-group">
    <div class="row">
        <div class="col-4">
            <label class="align-self-center" for="rtl">{{translate('Sandbox Activation')}}</label>
        </div>
        <div class="col-4">
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox"  onchange="updateSettings(this, 'stripe_sandbox')" @if (\App\Models\SystemConfiguration::where('type', 'stripe_sandbox')->first()->value == 1) checked @endif name="active">
                <span></span>
            </label>
        </div>
    </div>
</div>

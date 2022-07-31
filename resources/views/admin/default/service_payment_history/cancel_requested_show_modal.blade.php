
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Service Title') }}</label>
        <input type="text" disabled value="{{  $requested_cancel_service->servicePackage->service->title }}" class="form-control">
    </div>
</div>

<div>
    <div class="form-group mb-3">
        <label>{{ translate('Freelancer Name') }}</label>
        <input type="text" disabled value="{{ $requested_cancel_service->freelancer->name }}" class="form-control">
    </div>
</div>
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Request sent by') }}</label>
        <input type="text" disabled value="{{ $requested_cancel_service->user->name }}" class="form-control">
    </div>
</div>
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Freelancer Profit') }}</label>
        <input type="text" disabled value="{{ single_price($requested_cancel_service->freelancer_profit) }}" class="form-control">
    </div>
</div>


<div class="form-group mb-3">
    <label>{{ translate('Reason for cancellation') }}</label>
    <textarea class="form-control" rows="6" disabled>{{ $requested_cancel_service->cancel_reason }}</textarea>
</div>
@if($requested_cancel_service->cancel_status == 0)
<div>
    <form class="form-horizontal" action="{{ route('cancel-service-request.request_accepted') }}" method="POST">
        @csrf
        <input type="hidden" id="service_payment_id" name="service_payment_id" value="{{ $requested_cancel_service->id }}" required>
        <div class="form-group mb-3 text-right">
            <button type="submit" class="btn btn-primary">{{translate('Approve This Request')}}</button>
        </div>
    </form>
</div>
@endif

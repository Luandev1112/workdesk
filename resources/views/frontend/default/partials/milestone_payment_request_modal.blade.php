
<form class="form-horizontal" action="{{ route('partial_payment_request') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control form-control-sm" name="project_id" value="{{ $project_id }}">
    <input type="hidden" class="form-control form-control-sm" name="client_id" value="{{ $client_id }}">

    <div class="form-group">
        <label class="form-label">
            {{translate('Amount')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <input type="number" class="form-control" name="amount" value="" min="1" step="1">
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">
            {{translate('Message')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <textarea class="form-control" rows="3" name="message"></textarea>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">{{ translate('Send Request') }}</button>
    </div>
</form>

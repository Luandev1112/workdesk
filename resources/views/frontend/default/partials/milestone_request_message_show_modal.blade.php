<div class="form-group">
    <label class="form-label">
        {{translate('Requested Amount')}}
        <span class="text-danger">*</span>
    </label>
    <div class="form-group">
        <input type="number" min="0" step="0.01" class="form-control" value="{{ $milestone->amount }}" readonly>
    </div>
</div>
<div class="form-group">
    <label class="form-label">
        {{translate('Message')}}
        <span class="text-danger">*</span>
    </label>
    <div class="form-group">
        <textarea class="form-control resize-off" rows="6" readonly>{{ $milestone->message }}</textarea>
    </div>
</div>


<h5>{{ $project->name }} ({{ single_price($project->price) }})</h5>
<form class="form-horizontal" action="{{ route('bids.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control form-control-sm" name="project_id" value="{{ $project->id }}" placeholder="Enter project title">
    <div class="form-group">
        <label class="form-label">
            {{translate('Place Bid Price')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <input type="number" min="0" step="0.01" class="form-control form-control-sm" name="amount" placeholder="Enter your price" required>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">
            {{translate('Cover Letter')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <textarea class="form-control" rows="3" name="message" required></textarea>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Submit') }}</button>
    </div>
</form>

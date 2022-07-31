<form class="form-horizontal" action="{{ route('hiring_confirmation_store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label class="form-label">
            {{translate('Project')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <input type="text" class="form-control form-control-sm" name="project_name" value="{{ $chat_thread->project->name }}" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">
            {{translate('Amount')}}
            <span class="text-danger">*</span>
        </label>
        <div class="form-group">
            <input type="number" class="form-control form-control-sm" name="amount" value="{{ $bidder->amount }}" min="1" step="0.01">
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Hire Now') }}</button>
    </div>
</form>

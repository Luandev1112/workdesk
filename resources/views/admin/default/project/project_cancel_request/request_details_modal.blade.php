
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Project Name') }}</label>
        <input type="text" disabled value="{{ $cancel_project->project->name }}" class="form-control">
    </div>
</div>
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Client Name') }}</label>
        <input type="text" disabled value="{{ $cancel_project->project->client->name }}" class="form-control">
    </div>
</div>
<div>
    <div class="form-group mb-3">
        <label>{{ translate('Request sent by') }}</label>
        <input type="text" disabled value="{{ $cancel_project->requested_user->name }}" class="form-control">
    </div>
</div>
<div class="form-group mb-3">
    <label>{{ translate('Reason for cancellation') }}</label>
    <textarea class="form-control" rows="6" disabled>{{ $cancel_project->reason }}</textarea>
</div>
@if($cancel_project->project->cancel_status == 0)
<div>
    <form class="form-horizontal" action="{{ route('cancel-project-request.request_accepted') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="project_id" name="project_id" value="{{ $cancel_project->project_id }}" required>
        <input type="hidden" id="cancel_by_user_id" name="cancel_by_user_id" value="{{ $cancel_project->requested_user_id }}" required>
        <div class="form-group mb-3 text-right">
            <button type="submit" class="btn btn-primary">{{translate('Approve This Request')}}</button>
        </div>
    </form>
</div>
@endif

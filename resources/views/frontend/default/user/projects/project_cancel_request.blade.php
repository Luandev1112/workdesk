@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.client.inc.sidebar')
            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="h3">{{ translate('Cancel') }} - {{ $project->name }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-dark h6 fw-600 mb-0">{{ translate('Send Project Cancel Request') }}</h2>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('cancel-project-request.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <div class="form-group">
                                <label class="form-label">
                                    {{translate('Project Name')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" name="subject" value="{{ $project->name }}" placeholder="Enter ticket subject" required readonly="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    {{translate('Why do you want to Cancel?')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-sm editor" rows="3" name="reason" required data-buttons="bold,underline,italic,|,ul,ol,|,undo,redo"></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{translate('Send Request')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

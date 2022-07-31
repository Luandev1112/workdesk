@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.client.inc.sidebar')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Post A New Project') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Post A New Project') }}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Project title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Enter project title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label mb-2">
                                        {{ translate('Project type') }}
                                        <span class="text-danger">*</span>
                                    </div class="aiz-radio-inline">
                                    @if ($client_package->fixed_limit > 0)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="projectTypeFixed" name="projectType" class="custom-control-input" value="Fixed" checked>
                                            <label class="custom-control-label" for="projectTypeFixed">{{ translate('Fixed') }}</label>
                                        </div>
                                    @else
                                        <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                            {{ translate('Your fixed type project post limit is over.') }}
                                        </div>
                                    @endif
                                    @if ($client_package->long_term_limit > 0)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="projectTypeLong" name="projectType" class="custom-control-input" value="Long Term">
                                            <label class="custom-control-label" for="projectTypeLong">{{ translate('Long term') }}</label>
                                        </div>
                                    @else
                                        <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                            {{ translate('Your long term project post limit is over.') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Project budget') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" min="0" step="0.01" class="form-control" name="price" placeholder="Enter project budget">
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        {{ translate('Project category') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control aiz-selectpicker" id="category_id" name="category_id" data-live-search="true" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >
                                        {{ translate('Project summary') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="excerpt" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        {{ translate('Skills required') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select multiple class="form-control aiz-selectpicker" name="skills[]" required data-live-search="true" data-placeholder="Select required skills" data-selected-text-format="count">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group u-summernote-editor">
                                    <label>
                                        {{ translate('Project Details') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control aiz-text-editor" data-height="300" rows="3" name="description" required data-toolbar='[
                                        ["style", ["style"]],
                                        ["font", ["bold", "underline", "clear"]],
                                        ["fontsize", ["fontsize"]],
                                        ["para", ["ul", "ol", "paragraph"]]
                                    ]'>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="signinSrEmail">{{ translate('File attachment') }}</label>
                                    <div class="input-group" data-toggle="aizuploader" data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="attachments" class="selected-files">
                                    </div>
                                    <div class="file-preview"></div>
                                </div>
                                <div class="text-right">
                                    @if ($client_package->fixed_limit > 0 || $client_package->fixed_limit > 0)
                                        <button type="submit" class="btn btn-primary transition-3d-hover mr-1">{{ translate('Post Project') }}</button>
                                    @else
                                        <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                            {{ translate('Upgrade your Package.') }}
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

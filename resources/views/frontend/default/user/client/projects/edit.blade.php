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
                                <h1 class="h3">{{ translate('Edit Project') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Update project info') }}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('projects.update',$project->id) }}" method="POST" enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="PATCH">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Project title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" value="{{ $project->name }}" placeholder="Enter project title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label mb-2">
                                        {{ translate('Project type') }}
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="projectTypeFixed" name="projectType" class="custom-control-input" value="Fixed" @if ($project->type == 'Fixed') checked @endif>
                                        <label class="custom-control-label" for="projectTypeFixed">{{ translate('Fixed') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="projectTypeLong" name="projectType" class="custom-control-input" value="Long Term" @if ($project->type == 'Long Term') checked @endif>
                                        <label class="custom-control-label" for="projectTypeLong">{{ translate('Long term') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Project budget') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="number" min="0" step="1" class="form-control" name="price" value="{{ $project->price }}" placeholder="Enter project budget">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        {{ translate('Project category') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="category_id" required data-live-search="true">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if ($project->project_category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >
                                        {{ translate('Project summary') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="excerpt" required>{{ $project->excerpt }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        {{ translate('Skills required') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select multiple class="form-control aiz-selectpicker" name="skills[]" required data-placeholder="Select required skills" data-selected-text-format="count" data-live-search="true">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}" @if (in_array($skill->id, json_decode($project->skills))) selected @endif>{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group u-summernote-editor">
                                    <label>
                                        {{ translate('Project Details') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control aiz-text-editor js-summernote-editor" data-height="300" rows="3" name="description" required data-toolbar='[
                                        ["style", ["style"]],
                                        ["font", ["bold", "underline", "clear"]],
                                        ["fontsize", ["fontsize"]],
                                        ["para", ["ul", "ol", "paragraph"]]
                                    ]'>{{ $project->description }}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="signinSrEmail">{{ translate('File attachment') }}</label>
                                    <div class="input-group" data-toggle="aizuploader" data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="attachment" class="selected-files" value="{{ $project->attachment }}">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary transition-3d-hover mr-1">{{ translate('Update Project') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

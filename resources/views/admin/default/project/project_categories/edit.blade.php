@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Edit Category') }}</h5>
            </div>
            <div class="card-body">

                <form class="form-horizontal" action="{{ route('project-categories.update', $project_category->id) }}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{translate('Name')}}</label>
                        <input type="text" id="name" name="name" placeholder="{{ translate('Category Name') }}" value="{{ $project_category->name }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="parent_id">{{translate('Parent')}}</label>
                        <select class="select2 form-control aiz-selectpicker" name="parent_id" data-toggle="select2" data-placeholder="Choose ..."data-live-search="true">
                            <option value="0"@if ($project_category->parent_id == "0") selected @endif>{{ translate('No Parent') }}</option>
                            @foreach($project_categories as $project_cat)
                                <option value="{{$project_cat->id}}" @if ($project_cat->id == $project_category->parent_id) selected @endif>{{$project_cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">{{translate('Icon')}}</label>
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photo" class="selected-files" value="{{ $project_category->photo }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Update Category')}}</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row-->

@endsection

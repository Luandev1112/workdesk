@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('Update Badge')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('badges.update', $badge->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" required placeholder="{{ translate('Eg. Completed 100+ projects') }}" value="{{ $badge->name }}" class="form-control" required>
                        </div>
                        <input type="hidden" name="role_id" value="client">
                        <div class="form-group mb-3">
                            <label for="type">{{translate('Badge Type')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="type" id="type" data-show="selectShow" data-target=".min-num-type" data-placeholder="Choose ...">
                                <option value="project_badge" @if ($badge->type == "project_badge") selected @endif>{{translate('Project Badge')}}</option>
                                <option value="spent_badge" @if ($badge->type == "spent_badge") selected @endif>{{translate('Spent Badge')}}</option>
                                <option value="membership_badge" @if ($badge->type == "membership_badge") selected @endif>{{translate('Membership Badge')}}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="min_value" class="min-num-type">{{translate('Min number of ')}}
                                <span class="project_badge">{{translate('project')}}</span>
                                <span class="spent_badge d-none">{{translate('spent')}}</span>
                                <span class="membership_badge d-none">{{translate('account age - in days')}}</span>
                            </label>
                            <input type="number" id="value" name="value" min="0" step="0.01" placeholder="{{ translate('Eg. 100') }}" value="{{ $badge->value }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Badge Icon')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="icon" class="selected-files" value="{{ $badge->icon }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update Badge')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
@endsection

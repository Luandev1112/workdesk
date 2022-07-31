@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Edit Package') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('package.update',$package->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Package Name')}}</label>
                            <input type="text" id="name" name="name" value="{{ $package->name }}" required placeholder="{{ translate('Eg. Bronze Package') }}" class="form-control">
                        </div>
                        <input type="hidden" id="type" name="type" value="client" class="form-control">
                        <div class="form-group mb-3">
                            <label for="price">{{translate('Price')}}</label>
                            <input type="number" min="0" step="0.01" id="price" name="price" value="{{ $package->price }}" required placeholder="{{ translate('Eg. 25') }}" class="form-control">
                            <small class="form-text text-muted">{{ translate('Use 0 for free package') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Badge')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="badge" class="selected-files" value="{{ $package->badge }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Icon')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photo" class="selected-files" value="{{ $package->photo }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="number_of_days">{{translate('Validate For')}}</label>
                            <input type="number" min="0" step="1" id="number_of_days" name="number_of_days" value="{{ $package->number_of_days }}" required placeholder="{{ translate('Eg. 30') }}" class="form-control">
                            <small class="form-text text-muted">{{ translate('Number in days. Use 0 for life time') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fixed_limit">{{translate('Limitation for Fixed Project Posting')}}</label>
                            <input type="number" min="0" step="1" id="fixed_limit" name="fixed_limit" value="{{ $package->fixed_limit }}" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="long_term_limit">{{translate('Limitation for Long Term Project Posting')}}</label>
                            <input type="number" min="0" step="1" id="long_term_limit" name="long_term_limit" value="{{ $package->long_term_limit }}" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bio_text_limit">{{translate('Bio Word Limit')}}</label>
                            <input type="number" min="0" step="1" id="bio_text_limit" name="bio_text_limit" value="{{ $package->bio_text_limit }}" required placeholder="{{ translate('Eg. 120') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="following_status">{{translate('Enable Freelancer Following ?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox"  @if ($package->following_status == "1") checked @endif name="following_status">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Recommended ?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="recommended" @if ($package->recommended == "1") checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="active">{{translate('Publish Package?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" @if ($package->active == "1") checked @endif name="active">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update Package')}}</button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

@endsection

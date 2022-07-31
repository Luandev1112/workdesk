@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')
            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Work Experience Edit') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 font-weight-medium mb-0">{{ translate('Work Experience') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user_profile.work_experience_update', $work_exp->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Company Name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="company_name" value="{{ $work_exp->company_name }}" placeholder="Company Name" required>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Joining date') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="aiz-date-range form-control" name="start_date" placeholder="Select Date" data-single="true" data-show-dropdown="true" autocomplete="off" value="{{ $work_exp->start }}"/>
                            </div>
                            <div class="custom-control custom-checkbox form-group">
                                <input type="checkbox" class="custom-control-input" id="stylishCheckbox" name="present" @if ($work_exp->present == '1') checked @endif data-show="checkedShow" data-target=".leaving-date">
                                <label class="custom-control-label" for="stylishCheckbox">{{ translate('currently working here') }}</label>
                            </div>
                            <div class="form-group leaving-date">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Leaving date') }}
                                </label>
                                <input type="text" class="aiz-date-range form-control" name="end_date" placeholder="Select Date" data-single="true"  data-show-dropdown="true" autocomplete="off" value="{{ $work_exp->end }}"/>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Company Website') }}
                                </label>
                                <input type="text" class="form-control" name="company_website" value="{{ $work_exp->company_website }}" placeholder="Company Website">
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Designation') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="designation" value="{{ $work_exp->designation }}" placeholder="Designation" required>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Company Location') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="location" value="{{ $work_exp->location }}" placeholder="Company Location" required>
                            </div>
                            <div class="mt-2 text-right">
                                <!-- Buttons -->
                                <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Update Work Experience') }}</button>
                                <!-- End Buttons -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Content Section -->
@endsection

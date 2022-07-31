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
                            <h1 class="h3">{{ translate('Education Details Edit') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="h6 font-weight-medium mb-0">{{ translate('Education Details') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user_profile.education_info_update', $education->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('School Name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="school_name" value="{{ $education->school_name }}" placeholder="School Name" required>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Degree') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="degree" value="{{ $education->degree }}" placeholder="Ex. Bachelor of Science" required>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Passing Year') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div id="datepickerWrapperFrom" class="js-focus-state u-datepicker input-group">
                                    <input type="number" class="form-control" name="passing_year" value="{{ $education->passing_year }}" placeholder="Ex. 2008" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Country') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control aiz-selectpicker" id="country_id" name="country_id" required data-live-search="true">
                                    @foreach (\App\Models\Country::all() as $country)
                                        <option value="{{ $country->id }}" @if ($education->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2 text-right">
                                <!-- Buttons -->
                                <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Update') }}</button>
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

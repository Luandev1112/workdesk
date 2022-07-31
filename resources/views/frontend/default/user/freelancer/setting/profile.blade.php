
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
                                <h1 class="h3">{{ translate('Profile Settings') }}</h1>
                            </div>
                        </div>
                    </div>
                    @if ($verification == null)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="h6 font-weight-medium mb-0">{{ translate('Identity Verification') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user_profile.verification_store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Nid / Passport PDF') }}</label>
                                        <div class="input-group" data-toggle="aizuploader">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="verification_file" class="selected-files">
                                            <input type="hidden" name="verification_type" value="identity_verification">
                                        </div>
                                        <div class="file-preview box"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="file-preview"></div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <!-- Buttons -->
                                        <button type="submit" class="btn btn-primary">{{ translate('Save Changes') }}</button>
                                        <!-- End Buttons -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif ($verification != null && $verification->verified == 0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="h6 font-weight-medium mb-0">{{ translate('Identity Verification') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info" role="alert">
                                    {{ translate('Your identity verification has not been approved yet.') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">
                                <h4 class="h6 font-weight-medium mb-0">{{ translate('Identity Verification') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success" role="alert">
                                    {{ translate('Your identity verifed successfully.') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Account Info') }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Personal Info Form -->
                            <form class="js-validate" action="{{ route('user_profile.bio_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="js-form-message">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Username') }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div id="uname_response"></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username" name="username" @if ($user_profile->user->user_name != null) value="{{ $user_profile->user->user_name }}" @endif placeholder="Enter your username" aria-label="Enter your username" required aria-describedby="usernameLabel" data-msg="Please enter your username." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                </div>
                                <!-- Input -->
                                <div class="form-group">
                                    <label id="emailLabel" class="form-label">{{ translate('Email address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" @if ($user_profile->user->email != null) value="{{ $user_profile->user->email }}" @endif placeholder="Enter your email address" aria-label="Enter your email address" required aria-describedby="emailLabel" disabled>
                                        <div class="input-group-append">
                                            @if ($user_profile->user->email_verified_at == null)
                                                <a class="btn btn-secondary" href="{{ route('email.verification') }}">
                                                    {{ translate('Send Verification Link') }}
                                                </a>
                                            @else
                                                <span class="btn btn-success">
                                                    {{ translate('Verified') }}
                                                    <i class="las la-check"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($user_profile->user->email_verified_at == null)
                                        <span class="alert alert-danger d-block py-1 mt-1">{{ translate('Verify your email address') }}</span>
                                    @endif
                                </div>
                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">{{ translate('New Password') }}</label>
                                        <input type="password" class="form-control" name="new_password" placeholder="{{translate('New Password')}}" >
                                    </div>
                                </div>
                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">{{ translate('Confirm Password') }}</label>
                                        <input type="password" class="form-control" name="confirm_password" placeholder="{{translate('Confirm Password')}}">
                                    </div>
                                </div>
                                <!-- End Input -->
                                <div class="form-group">
                                    <label>{{ translate('Skill') }} <span class="text-danger">*</span> ({{ translate('Max') }} {{ $user_profile->user->userPackage->skill_add_limit }})</label>
                                    <select class="form-control aiz-selectpicker" multiple name="skills[]" data-live-search="true" data-selected-text-format="count" data-max-options="{{ $user_profile->user->userPackage->skill_add_limit }}">
                                        @if ($user_profile->skills != null)
                                            @foreach (\App\Models\Skill::all() as $key => $skill)
                                                <option value="{{ $skill->id }}" @if(in_array($skill->id, json_decode($user_profile->skills))) selected @endif>{{ $skill->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach (\App\Models\Skill::all() as $key => $skill)
                                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <hr class="mb-3 mt-4">
                                <!-- Title -->
                                <div class="mb-3">
                                    <h5 class="h6 mb-0">
                                        {{ translate('Bio') }}
                                        <span class="text-danger">*</span>
                                    </h5>
                                    <small class="form-text text-muted">{{ translate('Tell us about yourself in few sentences') }}..</small>
                                </div>
                                <!-- End Title -->
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="bio" required>{{ $user_profile->bio }}</textarea>
                                </div>
                                <div class="text-right mt-4">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </div>

                            </form>
                            <!-- End Personal Info Form -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Basic Info') }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Personal Info Form -->

                            <form class="js-validate" action="{{ route('user_profile.basic_info_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="name" value="{{ $user_profile->user->name }}" placeholder="Enter your name" aria-label="Enter your name" required aria-describedby="nameLabel" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success">
                                        <small class="form-text text-muted">{{ translate('Displayed on your public profile, notifications and other places') }}.</small>
                                    </div>
                                </div>
                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Specialist At') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control aiz-selectpicker" id="specialist" name="specialist" data-live-search="true" required>
                                            @foreach (\App\Models\ProjectCategory::all() as $category)
                                                <option value="{{ $category->id }}" @if ($user_profile->specialist == $category->id)
                                                    selected
                                                @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Hourly Rate') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" name="hourly_rate" value="{{ $user_profile->hourly_rate }}" placeholder="100" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Gender') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <!-- Input -->
                                    <select class="form-control aiz-selectpicker" name="gender" required data-minimum-results-for-search="Infinity" data-msg="Please select your gender." data-error-class="u-has-error" data-success-class="u-has-success">
                                        <option value="male" @if ($user_profile->gender == 'male') selected @endif>Male</option>
                                        <option value="female" @if ($user_profile->gender == 'female') selected @endif>Female</option>
                                        <option value="other" @if ($user_profile->gender == 'other') selected @endif>Other</option>
                                    </select>
                                    <!-- End Input -->
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label id="countryLabel" class="form-label">
                                            {{ translate('Country') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control aiz-selectpicker" id="country_id" name="country_id" data-live-search="true" required data-msg="Please select your country.">
                                            @foreach (\App\Models\Country::all() as $key => $country)
                                                @if ($user_profile->user->address->country_id != null)
                                                    <option value="{{ $country->id }}" @if ($user_profile->user->address->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="city" class="form-label" >{{translate('City')}}</label>
                                        <select class="form-control aiz-selectpicker" name="city_id" id="city_id" data-live-search="true" required>

                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="postal_code" class="form-label">{{translate('Postal Code')}}</label>
                                        <input type="text" id="postal_code" name="postal_code" @if ($user_profile->user->address->postal_code != null) value="{{ $user_profile->user->address->postal_code }}" @endif required placeholder="{{ translate('Eg. 1203') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="nameLabel" class="form-label">
                                        {{ translate('Address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="address" @if ($user_profile->user->address->street != null) value="{{ $user_profile->user->address->street }}" @endif placeholder="Enter your street address" required aria-describedby="nameLabel">
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Contact') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="phone" @if ($user_profile->user->address->phone != null) value="{{ $user_profile->user->address->phone }}" @endif placeholder="Enter your contact number" aria-label="Enter your contact number" required aria-describedby="nameLabel" data-msg="Enter your contact number." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                    <div class="col-md-6">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Nationality') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control aiz-selectpicker country-flag-select" id="nationality" name="nationality" required data-live-search="true">
                                            @foreach (\File::files(base_path('public/assets/frontend/default/img/flags')) as $path)
                                                <option
                                                    value="{{ pathinfo($path)['filename'] }}"
                                                    data-content="<div class=''><img src='{{ my_asset('assets/frontend/default/img/flags/'.pathinfo($path)['filename'].'.png') }}' height='11' class='mr-2'><span>{{ strtoupper(pathinfo($path) ['filename']) }}</span></div>"
                                                    @if ($user_profile->nationality == pathinfo($path)['filename']) selected @endif
                                                ></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Profile Images') }}</h4>
                        </div>
                        <form class="js-validate" action="{{ route('user_profile.photo_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">{{ translate('Profile Image') }}</label>
                                    <div class="input-group " data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="profile_photo" class="selected-files" value="{{ $user_profile->user->photo }}">
                                    </div>
                                    <div class="file-preview"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ translate('Cover Image') }}</label>
                                    <div class="input-group " data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="cover_photo" class="selected-files" value="{{ $user_profile->user->cover_photo }}">
                                    </div>
                                    <div class="file-preview"></div>
                                </div>

                                <div class="text-right mt-4">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Portfolio') }}</h4>
                        </div>
                        <div class="card-body">
                            @if (count($user_profile->user->userPortfolios) > 0)
                                <div class="border-bottom mb-4">
                                    <div class="row gutters-10">
                                        @foreach ($user_profile->user->userPortfolios as $key => $portfolio)
                                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                <div class="card mb-3 position-relative text-reset">
                                                    <img class="img-fit mw-100" src="{{ custom_asset($portfolio->photo) }}" height="240">
                                                    <div class="card-body border-top p-3">
                                                        <h2 class="h6 text-truncate">{{ $portfolio->name }}</h2>
                                                        <small class="d-block text-secondary">{{ $portfolio->type }}</small>
                                                    </div>
                                                    <div class="absolute-top-right pr-3 pt-3">
                                                        <a href="{{ route('user_profile.portfolio_edit', encrypt($portfolio->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-primary rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                            <span class="las la-pen"></span>
                                                        </a>
                                                        <a href="{{ route('user_profile.portfolio_destroy', encrypt($portfolio->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                            <span class="las la-trash"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    <!-- edit icon modal open -->
                                    </div>
                                </div>
                            @endif
                            @if ($user_profile->user->userPackage->portfolio_add_limit > count($user_profile->user->userPortfolios))
                            <form action="{{ route('user_profile.portfolio_add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="portfolio_name" placeholder="Portfolio title">
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Category') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="portfolio_category" placeholder="Portfolio category">
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Details') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="portfolio_details" required></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Image') }}</label>
                                        <div class="input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="portfolio_img" class="selected-files">
                                        </div>
                                        <div class="file-preview"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="file-preview">

                                        </div>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <!-- Buttons -->
                                        <button type="submit" class="btn btn-primary ">{{ translate('Add Portfolio') }}</button>
                                        <!-- End Buttons -->
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info" role="alert">
                                {{ translate('You have added maximum number of portfolio according to your package.') }}
                            </div>
                        @endif
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Work Experience') }}</h4>
                        </div>
                        <div class="card-body">

                            @if (count($user_profile->user->workExperiences) > 0)
                            <div class="border-bottom mb-4">
                                <div class="row gutters-10">
                                    @foreach ($user_profile->user->workExperiences as $key => $work_experience)
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="absolute-top-right pr-3 pt-3">
                                                        <a href="{{ route('user_profile.work_experience_edit', encrypt($work_experience->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-primary rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                            <span class="las la-pen"></span>
                                                        </a>
                                                        <a href="{{ route('user_profile.work_experience_destroy', encrypt($work_experience->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                            <span class="las la-trash"></span>
                                                        </a>
                                                    </div>
                                                    <h4 class="h6 mb-1">{{ $work_experience->designation }}</h4>
                                                    <ul class="list-unstyled text-secondary mb-0">
                                                        <li class="text-primary">{{ $work_experience->company_name }}</li>
                                                        @if ($work_experience->present == '1')
                                                            <li>{{ Carbon\Carbon::parse($work_experience->start)->toFormattedDateString() }} - {{ translate('Present') }}</li>
                                                        @else
                                                            <li>{{ Carbon\Carbon::parse($work_experience->start)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($work_experience->end)->toFormattedDateString() }}</li>
                                                        @endif
                                                        <li>{{ $work_experience->location }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($user_profile->user->userPackage->job_exp_limit > count($user_profile->user->workExperiences))
                            <form action="{{ route('user_profile.work_experience_add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Company Name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="company_name" placeholder="Company Name" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ translate('Joining date') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="aiz-date-range form-control" name="start_date" placeholder="Select Date" data-single="true" data-show-dropdown="true" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="present"> {{ translate('currently working here') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="form-group leaving-date">
                                    <label>{{ translate('Leaving date') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="aiz-date-range form-control" name="end_date" placeholder="Select Date" data-single="true"  data-show-dropdown="true" autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Company Website') }}
                                    </label>
                                    <input type="text" class="form-control" name="company_website" placeholder="Company Website">
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Designation') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="designation" placeholder="Designation" required>
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Company Location') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="location" placeholder="Company Location" required>
                                </div>
                                <div class="mt-2 text-right">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Add Work Experience') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </form>
                            @else
                                <div class="alert alert-info" role="alert">
                                    {{ translate('You have added maximum number of work experience according to your package.') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Education Information') }}</h4>
                        </div>
                        <div class="card-body">
                            @if (count($user_profile->user->education_details) > 0)
                                <div class="border-bottom mb-4">
                                    <div class="row gutters-10">
                                        @foreach ($user_profile->user->education_details as $key => $education)
                                            <div class="col-md-6">
                                                <li class="card">
                                                    <div class="card-body">
                                                        <div class="absolute-top-right pr-3 pt-3">
                                                            <a href="{{ route('user_profile.education_info_edit', encrypt($education->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-primary rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                                <span class="las la-pen btn-icontranslateinner"></span>
                                                            </a>
                                                            <a href="{{ route('user_profile.education_info_destroy', encrypt($education->id)) }}" type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                                <span class="las la-trash btn-icontranslateinner"></span>
                                                            </a>
                                                        </div>
                                                        <h4 class="h6">{{ $education->degree }}</h4>
                                                        <ul class="list-unstyled text-secondary mb-0">
                                                            <li>{{ translate('School Name') }}: {{ $education->school_name }}</li>
                                                            <li>{{ translate('Pasing Year') }}: {{ $education->passing_year }}</li>
                                                            <li>{{ translate('Country') }}: {{ $education->country->name }}</li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('user_profile.education_info_add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('School Name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="school_name" placeholder="School Name" required>
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Degree') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="degree" placeholder="Ex. Bachelor of Science" required>
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Passing Year') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div id="datepickerWrapperFrom" class="js-focus-state u-datepicker input-group">
                                        <input type="number" class="form-control" name="passing_year" placeholder="Ex. 2008" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="usernameLabel" class="form-label">
                                        {{ translate('Country') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control aiz-selectpicker" id="school_country_id" name="country_id" required data-live-search="true">
                                        @foreach (\App\Models\Country::all() as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-2 text-right">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Add Education Information') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

<script type="text/javascript">

    function get_city_by_country(){
        var country_id = $('#country_id').val();
        $.post('{{ route('cities.get_city_by_country') }}',{_token:'{{ csrf_token() }}', country_id:country_id}, function(data){
            $('#city_id').html(null);
            for (var i = 0; i < data.length; i++) {
                $('#city_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
		    $("#city_id > option").each(function() {
		        if(this.value == '{{$user_profile->user->address->city_id}}'){
		            $("#city_id").val(this.value).change();
		        }
            });

        });
    }

    $(document).ready(function(){
        get_city_by_country();
    });

    $('#country_id').on('change', function() {
        get_city_by_country();
    });

    $("#username").keyup(function(){
        var username = $("#username").val().trim();
        if(username != '')
        {
            $.post('{{ route('user_name_check') }}',{_token:'{{ csrf_token() }}', username:username}, function(data){
                $('#uname_response').html(data);
            });
        }
    });


</script>

@endsection

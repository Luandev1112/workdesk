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
                                <h1 class="h3">{{ translate('Profile Setting') }}</h1>
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
                                    <label id="usernameLabel" class="form-label">{{ translate('Username') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" @if ($user_profile->user->user_name != null) value="{{ $user_profile->user->user_name }}" @endif placeholder="Enter your username" aria-label="Enter your username" required aria-describedby="usernameLabel" data-msg="Please enter your username." data-error-class="u-has-error" data-success-class="u-has-success">
                                        <small class="form-text text-muted">{{ translate('Only a-z, numbers, hypen allowed') }}</small>
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
                                <div class="form-group">
                                    <label id="emailLabel" class="form-label">{{ translate('New Password') }}</label>
                                    <input type="password" class="form-control" name="new_password"  placeholder="{{translate('New Password')}}" >
                                </div>
                                <div class="form-group">
                                    <label id="emailLabel" class="form-label">{{ translate('Confirm Password') }}</label>
                                    <input type="password" class="form-control" name="confirm_password"  placeholder="{{translate('Confirm Password')}}">
                                </div>
                                <!-- End Input -->
                                <hr class="mb-3 mt-4">
                                <!-- Title -->
                                <div class="mb-3">
                                    <h5 class="h6 mb-0">
                                        {{ translate('Bio') }}
                                        <span class="text-danger">*</span>
                                    </h5>
                                    <small class="form-text text-muted">{{ translate('Tell us about yourself in few sentences') }}.</small>
                                </div>
                                <!-- End Title -->
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" maxlength="{{ $user_profile->user->userPackage->bio_text_limit }}" name="bio" required>{{ $user_profile->bio }}</textarea>
                                </div>

                                <div class="text-right mt-4">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary">{{ translate('Save Changes') }}</button>
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
                            <form action="{{ route('user_profile.basic_info_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div div class="row">
                                    <div class="form-group col-md-6">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="name" value="{{ $user_profile->user->name }}" placeholder="Enter your name">
                                        <small class="form-text text-muted">{{ translate('Displayed on your public profile, notifications and other places') }}.</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">
                                            {{ translate('Gender') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <!-- Input -->
                                        <select class="form-control aiz-selectpicker" name="gender" required>
                                            <option value="male" @if ($user_profile->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if ($user_profile->gender == 'female') selected @endif>Female</option>
                                            <option value="other" @if ($user_profile->gender == 'other') selected @endif>Other</option>
                                        </select>
                                        <!-- End Input -->
                                    </div>
                                </div>


                                <!-- Input -->
                                <div class="js-form-message">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label id="locationLabel" class="form-label">
                                                {{ translate('Country') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control aiz-selectpicker" name="country_id" id="country_id" required data-live-search="true">
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
                                            <label for="country" class="form-label" >{{translate('City')}}</label>
                                            <select class="form-control aiz-selectpicker" name="city_id" id="city_id" required data-msg="Please select your city." data-live-search="true">

                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="postal_code" class="form-label">{{translate('Postal Code')}}</label>
                                            <input type="text" id="postal_code" name="postal_code" @if ($user_profile->user->address->postal_code != null) value="{{ $user_profile->user->address->postal_code }}" @endif required placeholder="{{ translate('Eg. 1203') }}" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="js-form-message">
                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Address') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="address" @if ($user_profile->user->address->street != null) value="{{ $user_profile->user->address->street }}" @endif placeholder="Enter your street address"  required>
                                    </div>
                                </div>

                                <div class="js-form-message">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Phone') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="phone" @if ($user_profile->user->address->phone != null) value="{{ $user_profile->user->address->phone }}" @endif placeholder="Enter your contact number" required >
                                        </div>
                                        <div class="col-md-6">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Nationality') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control aiz-selectpicker" name="nationality" required data-live-search="true">
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
                                </div>

                                <div class="text-right mt-4">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary">{{ translate('Save Changes') }}</button>
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
                                    <label class="form-label" >{{ translate('Profile Image') }}</label>
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="profile_photo" class="selected-files" value="{{ $user_profile->user->photo }}">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ translate('Cover Image') }}</label>
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="cover_photo" class="selected-files" value="{{ $user_profile->user->cover_photo }}">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                </div>

                                <div class="text-right mt-4">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary ">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

<script type="text/javascript">

    function get_state_by_city(){
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
            AIZ.plugins.bootstrapSelect('refresh');
        });
    }

    $(document).ready(function(){
        get_state_by_city();
    });

    $('#country_id').on('change', function() {
        get_state_by_city();
    });

</script>

@endsection

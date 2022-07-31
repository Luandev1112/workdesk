@extends('admin.default.layouts.app')

@section('content')
<section cl>
    <div class="container">
        <div class="col-xl-6 col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('Update Your Profile')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin_profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" placeholder="{{ translate('Name') }}" value="{{ $user->name }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">{{translate('Email')}}</label>
                            <input type="email" id="email" name="email" placeholder="{{ translate('Email') }}" value="{{ $user->email }}" class="form-control" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password">{{translate('New Password')}}</label>
                            <input type="password" id="new_password" name="new_password" placeholder="{{ translate('New Password') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirm_password">{{translate('Confirm Password')}}</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="{{ translate('Confirm Password') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="signinSrEmail">{{ translate('Profile Image') }}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="profile_photo" class="selected-files" value="{{ $user->photo }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update Profile')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

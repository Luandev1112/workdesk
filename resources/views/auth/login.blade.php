@extends('admin.default.layouts.blank')

@section('content')
<div class="h-100 bg-cover bg-center py-5 d-flex align-items-center" style="background-image: url({{ custom_asset(\App\Utility\SettingsUtility::get_settings_value('admin_login_background')) }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-4 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <img src="{{ custom_asset(\App\Utility\SettingsUtility::get_settings_value('system_logo_black')) }}" class="mw-100 mb-4" height="40">
                            <h1 class="h3 text-primary mb-0">{{ translate('Welcome to') }} {{ env('APP_NAME') }}</h1>
                            <p>{{ translate('Login to your account.') }}</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="needs-validation">
                            @csrf
                            <div class="form-group">
                                <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" id="email" name="email" autocomplete="off" required >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="********" id="password" name="password" autocomplete="off" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--begin::Action-->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('password.request') }}" class="text-secondary">
                                    {{ translate('Forgot Password') }} ?
                                </a>
                                <button type="submit" class="btn btn-primary">{{ translate('Sign In') }}</button>
                            </div>
                            <!--end::Action-->
                        </form>
                        @if (env('DEMO_MODE') == 'On')
                            <div class="d-flex justify-content-between align-items-center mt-4 border p-3">
                                <a href="#" class="text-secondary">
                                    admin@example.com  -  123456
                                </a>
                                <button class="btn btn-sm btn-outline-info" onclick="autoFill()">copy</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer justify-content-center">
                        <p class="mb-0">&copy; {{ env('APP_NAME') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        function autoFill(){
            $('#email').val('admin@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection

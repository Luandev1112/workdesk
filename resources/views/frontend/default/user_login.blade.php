@extends('frontend.default.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-md-7 mx-auto">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-5 text-center">
                            <h1 class="h3 text-primary mb-0">{{ translate('Welcome back') }}</h1>
                            <p>{{ translate('Login to manage your account') }}.</p>
                        </div>

                        <form class="" method="POST" action="{{ route('login') }}">
                        @csrf

                            <div class="form-group">
                                <label class="form-label" for="email">{{ translate('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email address" required >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">{{ translate('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 text-right">
                                <a class="link-muted text-capitalize font-weight-normal" href="{{ route('password.request') }}">{{ translate('Forgot Password?') }}</a>
                            </div>


                            <div class="mb-5">
                                <button type="submit" class="btn btn-block btn-primary">{{ translate('Login to your Account') }}</button>
                            </div>

                            @if(\App\Utility\SettingsUtility::get_settings_value('facebook_login_activation_checkbox') == 1 || \App\Utility\SettingsUtility::get_settings_value('twitter_login_activation_checkbox') == 1 || \App\Utility\SettingsUtility::get_settings_value('google_login_activation_checkbox') == 1 || \App\Utility\SettingsUtility::get_settings_value('linkedin_login_activation_checkbox') == 1)
                            <div class="mb-5">
                                <div class="separator mb-3">
                                    <span class="bg-white px-3">Or Login With</span>
                                </div>

                                <ul class="list-inline social colored text-center">
                                    @if (\App\Utility\SettingsUtility::get_settings_value('facebook_login_activation_checkbox') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook" title="Facebook"><i class="lab la-facebook-f"></i></a>
                                        </li>
                                    @endif
                                    @if (\App\Utility\SettingsUtility::get_settings_value('twitter_login_activation_checkbox') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter" title="Twitter"><i class="lab la-twitter"></i></a>
                                        </li>
                                    @endif
                                    @if (\App\Utility\SettingsUtility::get_settings_value('google_login_activation_checkbox') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google" title="Google"><i class="lab la-google"></i></a>
                                        </li>
                                    @endif
                                    @if (\App\Utility\SettingsUtility::get_settings_value('linkedin_login_activation_checkbox') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'linkedin']) }}" class="linkedin" title="Linkedin"><i class="lab la-linkedin-in"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            @endif

                            <div class="text-center">
                                <p class="text-muted mb-0">{{ translate("Don't have an account?") }}</p>
                                <a href="{{ route('register') }}">{{ translate('Create an account') }}</a>
                            </div>

                        </form>
                    </div>
                </div>

                @if (env('DEMO_MODE') == 'On')
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-centered mb-0 table-responsive">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>freelancer@example.com</td>
                                        <td>123456</td>
                                        <td class="text-right">
                                            <button class="btn btn-outline-info btn-xs" onclick="autoFill()">copy</button>
                                        </td >
                                    </tr>
                                    <tr>
                                        <td>client@example.com</td>
                                        <td>123456</td>
                                        <td class="text-right">
                                            <button class="btn btn-outline-info btn-xs" onclick="autoFill2()">copy</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <script type="text/javascript">
        function autoFill(){
            $('#email').val('freelancer@example.com');
            $('#password').val('123456');
        }
        function autoFill2(){
            $('#email').val('client@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection

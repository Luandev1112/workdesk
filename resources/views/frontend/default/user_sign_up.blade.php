@extends('frontend.default.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-md-7 mx-auto">
				<div class="card">
					<div class="card-body">

						<div class="mb-5 text-center">
							<h1 class="h3 text-primary mb-0">{{ translate('Join with us') }}</h1>
							<p>{{ translate('Fill out the form to get started') }}.</p>
						</div>
						<form class="" id="reg-form" method="POST" action="{{ route('register') }}">
							@csrf

							<div class="form-group">
								<label class="form-label" for="name">{{ translate('Full Name') }}</label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Full Name"  required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
							</div>

							<div class="form-group">
								<label class="form-label" for="email">{{ translate('Email address') }}</label>
								<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="Email address"  required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
							</div>

							<div class="form-group">
								<label class="form-label" for="password">{{ translate('Password') }}</label>
								<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" aria-label="********" required>
								<small>{{ translate('Minimun 6 characters') }}</small>
								@error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
							</div>

							<div class="form-group">
								<label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
								<input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="********" required>
								<small>{{ translate('Minimun 6 characters') }}</small>
							</div>

							<div class="form-group mb-4">
								<div class="aiz-radio-inline">
									<label class="aiz-radio">
										<input type="radio" name="user_types[]" value="freelancer" checked="checked"> {{ translate('As A Freelancer') }}
										<span class="aiz-rounded-check"></span>
									</label>
									<label class="aiz-radio">
										<input type="radio" name="user_types[]" value="client"> {{ translate('As A Client') }}
										<span class="aiz-rounded-check"></span>
									</label>
								</div>
							</div>

							@if(get_setting('google_recaptcha_activation_checkbox') == 1)
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                </div>
                            @endif

							<div class="form-group">
								<div class="aiz-checkbox-list">
									<label class="aiz-checkbox">
										<input type="checkbox" name="condition" required>
											<span class="fs-13">{{ translate('By signing up you agree to our terms and conditions') }}.</span>
										<span class="aiz-square-check"></span>
									</label>
								</div>
							</div>


							<div class="mb-5">
                                <button type="submit" class="btn btn-block btn-primary">{{ translate('Join With Us') }}</button>
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
                                <p class="text-muted mb-0">{{ translate("Already have an account?") }}</p>
                                <a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@if(get_setting('google_recaptcha_activation_checkbox') == 1)
	<script src="https://www.google.com/recaptcha/api.js" async defer>
		$(document).ready(function(){
			$("#reg-form").on("submit", function(evt)
			{
				var response = grecaptcha.getResponse();
				if(response.length == 0)
				{
				//reCaptcha not verified
					alert("please verify you are humann!");
					evt.preventDefault();
					return false;
				}
				//captcha verified
				//do the rest of your validations here
				$("#reg-form").submit();
			});
		});
	</script>
@endif
@endsection

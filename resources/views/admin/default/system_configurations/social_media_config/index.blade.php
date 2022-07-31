@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            <div class="pb-4 d-flex">
                <h4 class="mr-3 h6">{{translate('Social Media & Other 3rd Party Configuration')}}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Facebook Login")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="facebook_login">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" @if (get_setting('facebook_login_activation_checkbox') == 1) checked @endif name="facebook_login_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('APP ID')}}</label>
                            <input type="hidden" name="types[]" value="FACEBOOK_APP_ID">
                            <input type="text" name="FACEBOOK_APP_ID" class="form-control"
                                   value="{{env('FACEBOOK_APP_ID')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('APP SECRET')}}</label>
                            <input type="hidden" name="types[]" value="FACEBOOK_APP_SECRET">
                            <input type="text" name="FACEBOOK_APP_SECRET" class="form-control"
                                   value="{{env('FACEBOOK_APP_SECRET')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Google Login")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="google_login">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('google_login_activation_checkbox') == 1) checked @endif name="google_login_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('GOOGLE CLIENT ID')}}</label>
                            <input type="hidden" name="types[]" value="GOOGLE_CLIENT_ID">
                            <input type="text" name="GOOGLE_CLIENT_ID" class="form-control"
                                   value="{{env('GOOGLE_CLIENT_ID')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('GOOGLE CLIENT SECRET')}}</label>
                            <input type="hidden" name="types[]" value="GOOGLE_CLIENT_SECRET">
                            <input type="text" name="GOOGLE_CLIENT_SECRET" class="form-control"
                                   value="{{env('GOOGLE_CLIENT_SECRET')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Twitter Login")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="twitter_login">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('twitter_login_activation_checkbox') == 1) checked @endif name="twitter_login_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('TWITTER CLIENT ID')}}</label>
                            <input type="hidden" name="types[]" value="TWITTER_CLIENT_ID">
                            <input type="text" name="TWITTER_CLIENT_ID" class="form-control"
                                   value="{{env('TWITTER_CLIENT_ID')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('TWITTER CLIENT SECRET')}}</label>
                            <input type="hidden" name="types[]" value="TWITTER_CLIENT_SECRET">
                            <input type="text" name="TWITTER_CLIENT_SECRET" class="form-control"
                                   value="{{env('TWITTER_CLIENT_SECRET')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("LinkedIn Login")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="linkedin_login">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('linkedin_login_activation_checkbox') == 1) checked @endif name="linkedin_login_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('LINKEDIN CLIENT ID')}}</label>
                            <input type="hidden" name="types[]" value="LINKEDIN_CLIENT_ID">
                            <input type="text" name="LINKEDIN_CLIENT_ID" class="form-control"
                                   value="{{env('LINKEDIN_CLIENT_ID')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('LINKEDIN CLIENT SECRET')}}</label>
                            <input type="hidden" name="types[]" value="LINKEDIN_CLIENT_SECRET">
                            <input type="text" name="LINKEDIN_CLIENT_SECRET" class="form-control"
                                   value="{{env('LINKEDIN_CLIENT_SECRET')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end card-body -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Facebook Pixel")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="fb_pixel">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('fb_pixel_activation_checkbox') == 1) checked @endif name="fb_pixel_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('Pixel ID')}}</label>
                            <input type="hidden" name="types[]" value="FACEBOOK_PIXEL_ID">
                            <input type="text" name="FACEBOOK_PIXEL_ID" class="form-control"
                                   value="{{env('FACEBOOK_PIXEL_ID')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Facebook Chat")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="facebook_chat">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('facebook_chat_activation_checkbox') == 1) checked @endif name="facebook_chat_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('FACEBOOK PAGE ID')}}</label>
                            <input type="hidden" name="types[]" value="FACEBOOK_PAGE_ID">
                            <input type="text" name="FACEBOOK_PAGE_ID" class="form-control"
                                   value="{{env('FACEBOOK_PAGE_ID')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Google Analytics")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="google_analytics">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('google_analytics_activation_checkbox') == 1) checked @endif name="google_analytics_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('TRACKING ID')}}</label>
                            <input type="hidden" name="types[]" value="GOOGLE_ANALYTICS_TRACKING_ID">
                            <input type="text" name="GOOGLE_ANALYTICS_TRACKING_ID" class="form-control"
                                   value="{{env('GOOGLE_ANALYTICS_TRACKING_ID')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end card-body -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Google reCAPTCHA")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('social-media-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="social_media_type" value="google_recaptcha">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <label class="align-self-center" for="rtl">{{translate('Activation')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox"  @if (get_setting('google_recaptcha_activation_checkbox') == 1) checked @endif name="google_recaptcha_activation_checkbox">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('Site KEY')}}</label>
                            <input type="hidden" name="types[]" value="CAPTCHA_KEY">
                            <input type="text" name="CAPTCHA_KEY" class="form-control"
                                   value="{{env('CAPTCHA_KEY')}}">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

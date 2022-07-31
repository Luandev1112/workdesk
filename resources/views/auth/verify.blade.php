@extends('frontend.default.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-md-7 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ translate('Verify Your Email Address') }}</h6>
                    </div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ translate('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ translate('Before proceeding, please check your email for a verification link.') }}
                        {{ translate('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ translate('click here to request another') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

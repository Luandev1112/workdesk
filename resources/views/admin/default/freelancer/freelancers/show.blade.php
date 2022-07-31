@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body text-center">
                <span class="avatar avatar-xxl mb-3">
                    @if ($user->photo != null)
                        <img src="{{ custom_asset($user->photo)}}">
                    @else
                        <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                    @endif
                    <span class="badge badge-dot badge-circle badge-success badge-status badge-md"></span>
                </span>
                <div class="rating rating-sm">
                    {{ renderStarRating(getAverageRating($user->id)) }}
                </div>
                <h1 class="h5 mb-1">{{ $user->name }}</h1>
                <h5 class="mb-3 fs-12 opacity-60">{{ '@' . $user->user_name }}</h5>
                <div class="text-center">
                    @if ($user_profile->package != null)
                    <span class="avatar avatar-square avatar-xxs" title="{{ $user_profile->package->name }}">
                        <img src="{{ custom_asset($user_profile->package->badge) }}">
                    </span>
                    @endif
                    @foreach ($user->badges as $key => $user_badge)
                        @if ($user_badge->badge != null)
                            <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ my_asset($user_badge->badge->icon) }}"></span>
                        @endif
                    @endforeach
                </div>
                <div class="mt-5 text-left">
                    <h6 class="separator mb-4 text-left"><span class="bg-white pr-3">{{ translate('Verification') }}</span></h6>
                    <p class="text-muted text-capitalize">
                        <span>{{ translate('Email Verification') }} :</span>
                        @if ($user->email_verified_at != null)
                            <span class="badge badge-sm float-right badge-circle badge-success"> <i class="las la-check"></i> </span>
                        @else
                            <span class="badge badge-sm float-right badge-circle badge-secondary"> <i class="las la-times"></i> </span>
                        @endif
                    </p>

                    @if ($user->verifications != null)
                        @foreach ($user->verifications as $key => $verification)
                            <p class="text-muted text-capitalize"><span>{{ str_replace('_', ' ', $verification->type) }} :</span>
                                @if ($verification->verified != 0)
                                    @if ($verification->type == 'identity_verification')
                                        <span class="badge badge-sm float-right badge-circle badge-success"> <i class="las la-check"></i> </span>
                                    @else
                                        <span class="badge badge-sm float-right badge-circle badge-success"> <i class="las la-check"></i> </span>
                                    @endif
                                @else
                                    @if ($verification->type == 'identity_verification')
                                        <span class="badge badge-sm float-right badge-circle badge-secondary"> <i class="las la-times"></i> </span>
                                    @else
                                        <span class="badge badge-sm float-right badge-circle badge-secondary"> <i class="las la-times"></i> </span>
                                    @endif
                                @endif
                            </p>
                        @endforeach
                    @endif
                </div>
                <div class="text-left mt-5">
                    <h6 class="separator mb-4 text-left"><span class="bg-white pr-3">{{ translate('Account Information') }}</span></h6>

                    <p class="text-muted">
                        <strong>{{ translate('Full Name') }} :</strong>
                        <span class="ml-2">{{ $user->name }}</span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Gender') }} :</strong>
                        <span class="ml-2">{{ $user_profile->gender }}</span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Mobile') }} :</strong>
                        <span class="ml-2">{{ $user->address->phone }}</span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Email') }} :</strong>
                        <span class="ml-2">{{ $user->email }}</span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Location') }} :</strong>
                        <span class="ml-2">
                            @if ($user->address->street != null) {{ $user->address->street }} @endif
                            @if ($user->address->city != null) {{ $user->address->city->name }} @endif
                            @if ($user->address->country != null) {{ $user->address->country->name }} @endif
                        </span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Postal Code') }} :</strong>
                        <span class="ml-2">
                            @if ($user->address->postal_code != null) {{ $user->address->postal_code }} @endif
                        </span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Skills') }} :</strong>
                        <span class="ml-2">
                            @if ($user_profile->skills != null)
                                @foreach (json_decode($user_profile->skills) as $key => $skill_id)
                                    @php
                                        $skill = \App\Models\Skill::find($skill_id);
                                    @endphp
                                    @if ($skill != null)
                                        <span class="badge badge-inline badge-secondary">{{ $skill->name }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </span>
                    </p>
                    <p class="text-muted">
                        <strong>{{ translate('Running Package') }} :</strong>
                        <span class="ml-2">
                            @if ($user_profile->user->userPackage != null && $user_profile->user->userPackage->package != null)
                                {{$user_profile->user->userPackage->package->name}}
                            @else
                                {{translate('Package Removed')}}
                            @endif
                        </span>
                    </p>
                    <p class="text-muted"><strong>{{ translate('Balance') }} :</strong>
                        <span class="ml-2">
                            {{ single_price($user_profile->balance) }}
                        </span>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">

        @if ($user_profile->bio != null)
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Bio') }}</h6>
            </div>
            <div class="card-body">
                {{ $user_profile->bio }}
            </div>
        </div>
        @endif
        @if ($user_account != null)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ $user->name }} {{ translate('Account Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-left">
                        <p class="text-muted"><strong>{{ translate('Bank Name') }} :</strong> <span class="ml-2">{{ $user_account->bank_name }}</span></p>

                        <p class="text-muted"><strong>{{ translate('Bank Account Name') }} :</strong><span class="ml-2">{{ $user_account->bank_acc_name }}</span></p>

                        <p class="text-muted"><strong>{{ translate('Bank Account Number') }} :</strong><span class="ml-2">{{ $user_account->bank_acc_no }}</span></p>

                        <p class="text-muted"><strong>{{ translate('Paypal Account') }} :</strong> <span class="ml-2">{{ $user_account->paypal_acc_name }}</span></p>

                        <p class="text-muted"><strong>{{ translate('Paypal Email') }} :</strong> <span class="ml-2">{{ $user_account->paypal_email }}</span></p>

                    </div>
                </div>
            </div>
        @endif
        @if ($user->workExperiences != null)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Work experiences') }}</h5>
                </div>
                <div class="card-body">
                    @foreach ($user->workExperiences as $key => $user_work_exp)
                        <div class="text-left">
                            <p class="text-muted text-capitalize"><strong>{{ translate('Company Name') }} :</strong>
                                <span class="ml-2">{{ $user_work_exp->company_name }}</span>
                            </p>
                            <p class="text-muted text-capitalize"><strong>{{ translate('Company Website') }} :</strong>
                                <span class="ml-0"><a href="{{ $user_work_exp->company_website }}" target="_blank">{{ $user_work_exp->company_website }}</a></span>
                            </p>
                            <p class="text-muted text-capitalize"><strong>{{ translate('Designation') }} :</strong>
                                <span class="ml-2">{{ $user_work_exp->designation }}</span>
                            </p>
                            <p class="text-muted text-capitalize"><strong>{{ translate('Location') }} :</strong>
                                <span class="ml-2">{{ $user_work_exp->location }}</span>
                            </p>
                            <p class="text-muted text-capitalize"><strong>{{ translate('Joining Date') }} :</strong>
                                <span class="ml-2">{{ $user_work_exp->start }}</span>
                            </p>
                            @if ($user_work_exp->present == '1')
                                <p class="text-muted text-capitalize"><strong>{{ translate('Leaving Date') }} :</strong>
                                    <span class="ml-2">{{ translate('Present') }}</span>
                                </p>
                            @else
                                <p class="text-muted text-capitalize"><strong>{{ translate('Leaving Date') }} :</strong>
                                    <span class="ml-2">{{ $user_work_exp->end }}</span>
                                </p>
                            @endif
                            <hr/>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

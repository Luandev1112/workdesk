@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Verification Details')}}</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body text-center">
                <span class="avatar avatar-xxl mb-3">
                    @if($user->photo != null)
                        <img src="{{ custom_asset($user->photo) }}">
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
                    @if ($user->userPackage != null && $user->userPackage->package != null)
                    <span class="avatar avatar-square avatar-xxs" title="{{ $user->userPackage->package->name }}">
                        <img src="{{ custom_asset($user->userPackage->package->badge) }}">
                    </span>
                    @endif
                    @foreach ($user->badges as $key => $user_badge)
                        @if ($user_badge->badge != null)
                            <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ custom_asset($user_badge->badge->icon) }}"></span>
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
                        <span class="ml-2">{{ $user->profile->gender }}</span>
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
                            @if ($user->profile->skills != null)
                                @foreach (json_decode($user->profile->skills) as $key => $skill_id)
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
                            @if ($user->profile->package != null)
                                {{ $profile->package->name }}
                            @else
                                {{ translate('Package has been deleted.') }}
                            @endif
                        </span>
                    </p>
                    <p class="text-muted"><strong>{{ translate('Wallet Balance') }} :</strong>
                        <span class="ml-2">
                            {{ single_price($user->profile->wallet_balance) }}
                        </span>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        @if ($user->profile->bio != null)
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Bio') }}</h6>
            </div>
            <div class="card-body">
                {{ $user->profile->bio }}
            </div>
        </div>
        @endif
        @if ($user->userVerifications != null)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ $user->name }} {{ translate('Verification Information') }}</h5>
            </div>
            <div class="card-body">

                @foreach ($user->userVerifications as $key => $verification_request)
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted text-capitalize fw-600">
                                {{ str_replace('_', ' ', $verification_request->type) }} :
                            </p>

                            @if ($verification_request->verified == 1)
                                <a onclick="reject('{{ $verification_request->id }}')" class="btn btn-sm btn-outline-danger">{{translate('Reject')}}</a>
                            @else
                                <a onclick="accept('{{ $verification_request->id }}')" class="btn btn-sm btn-outline-primary">{{translate('Accept')}}</a>
                                <a onclick="reject('{{ $verification_request->id }}')" class="btn btn-sm btn-outline-danger">{{translate('Reject')}}</a>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="file-preview">
                                @php
                                    $attachment = \App\Upload::find($verification_request->attachment);
                                @endphp
                                @if ($attachment != null)
                                <a class="d-flex justify-content-between align-items-center mt-2 file-preview-item text-reset" href="{{ my_asset($attachment->file_name)}}" target="_blank" download>
                                    <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                        @if ($attachment->type == 'document')
                                            <i class="la la-file-text"></i>
                                        @elseif ($attachment->type == 'image')
                                            <img src="{{ my_asset($attachment->file_name) }}" class="img-fit">
                                        @endif
                                    </div>
                                    <div class="col body">
                                        <h6 class="d-flex">
                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                            <span class="ext">.{{ $attachment->extension }}</span>
                                        </h6>
                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                    </div>
                                    <div class="remove">
                                        <i class="la la-cloud-download"></i>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
    function accept(id){
        $.post('{{ route('verififaction_accept') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
            if (data == 1) {
                location.reload();
                AIZ.plugins.notify('success', 'Request Accepted');
            }
            else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }
    function reject(id){
        $.post('{{ route('verififaction_reject') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
            if (data == 1) {
                location.reload();
                AIZ.plugins.notify('success', 'Request Rejected');
            }
            else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }
    </script>
@endsection

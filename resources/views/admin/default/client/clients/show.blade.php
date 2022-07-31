@extends('admin.default.layouts.app')

@section('content')
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
                    @if ($user_profile->package != null)
                    <span class="avatar avatar-square avatar-xxs" title="{{ $user_profile->package->name }}">
                        <img src="{{ my_asset($user_profile->package->badge) }}">
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
                        <strong>{{ translate('Running Package') }} :</strong>
                        <span class="ml-2">
                            @if ($user->userPackage != null && $user->userPackage->package != null)
                                {{ $user->userPackage->package->name }}
                            @else
                                {{ translate('Package Removed.') }}
                            @endif
                        </span>
                    </p>
                    <p class="text-muted"><strong>{{ translate('Total Spent') }} :</strong>
                        <span class="ml-2">
                            {{ single_price(\App\Models\MilestonePayment::where('client_user_id', $user->id)->where('paid_status', 1)->sum('amount')) }}
                        </span>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ $user->name }} {{ translate('Projects') }}</h6>
            </div>
            <div class="card-body">
                <table class="aiz-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Type') }}</th>
                            <th>{{ translate('Budget') }}</th>
                            <th>{{ translate('Hired at') }}</th>
                            <th>{{ translate('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                        <tr>
                            <td>{{ ($key+1) + ($projects->currentPage() - 1)*$projects->perPage() }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->type }}</td>
                            <td>{{ single_price($project->price) }}</td>
                            <td>{{ single_price($project->budget) }}</td>
                            <td>
                                @if( $project->cancel_status == 1)
                                    <span class="badge badge-inline badge-danger">{{ translate('Canceled') }}</span>
                                @elseif( $project->closed == 1)
                                    <span class="badge badge-inline badge-success">{{ translate('Completed') }}</span>

                                @elseif( $project->biddable == 0)
                                    <span class="badge badge-inline badge-success">{{ translate('Running') }}</span>
                                @else
                                    <span class="badge badge-inline badge-secondary">{{ translate('Open') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

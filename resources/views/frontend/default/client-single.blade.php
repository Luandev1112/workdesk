@extends('frontend.default.layouts.app')

@section('content')
<div class="h-250px">
    @if ($client->cover_photo != null)
        <img src="{{ custom_asset($client->cover_photo) }}" alt="{{ $client->name }}"class="img-fit h-250px">
    @else
        <img src="{{ my_asset('assets/frontend/default/img/cover-place.jpg') }}" alt="{{ $client->name }}"class="img-fit h-250px">
    @endif
</div>
<div class="mt-n5">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="media align-items-center d-block d-md-flex">
                    <div class="mr-5 text-center text-md-left mb-4 mb-md-0">
                        <span class="avatar avatar-xxl">
                            @if($client->photo != null)
                                <img src="{{ custom_asset($client->photo) }}">
                            @else
                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                            @endif
                            <span class="badge badge-dot badge-circle badge-success badge-status badge-md"></span>
                        </span>
                    </div>
                    <div class="media-body d-lg-flex justify-content-between align-items-center">
                        <div class="mr-3 mb-4 mb-lg-0 text-center text-md-left">
                            <h1 class="h5 mb-2 fw-700">{{ $client->name }}</h1>

                            <div class="d-flex justify-content-center justify-content-md-between text-secondary fs-12 mb-3">
                                <div class="mr-2">
                                    @if( !empty(getAverageRating($client->id)))
                                        <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                            {{ formatRating(getAverageRating($client->id)) }}
                                        </span>
                                    @else
                                        <span class="bg-secondary rounded text-white px-1 mr-1 fs-10">
                                            {{ formatRating(getAverageRating($client->id)) }}
                                        </span>
                                    @endif

                                    <span class="rating rating-sm">
                                        {{ renderStarRating(getAverageRating($client->id)) }}
                                    </span>
                                    <span>
                                        ({{ getNumberOfReview($client->id) }} {{ translate('Reviews') }})
                                    </span>
                                </div>
                                <div>
                                    <i class="las la-map-marker opacity-50"></i>
                                    @if ($client->address != null && $client->address->city != null && $client->address->country != null)
                                        <span>{{ $client->address->city->name }}, {{ $client->address->city->country->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-lg-right text-center">
                            @if (Auth::check() && ($bookmarked_client = \App\Models\BookmarkedClient::where('user_id', auth()->user()->id)->where('client_user_id', $client->id)->first()) != null)
                                <a class="btn btn-secondary confirm-alert" href="javascript:void(0)" data-href="{{ route('bookmarked-clients.destroy', $bookmarked_client->id) }}" data-target="#unfollow-modal">Unfollow</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('bookmarked-clients.store', encrypt($client->id)) }}">{{ translate('Follow') }}</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="container">
        <div class="row">

            <div class="col-xxl-9 col-lg-8 order-1 order-lg-0">

                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 fw-600 mb-0">{{ $client->name }}'s {{ translate('Bio') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="opacity-70 lh-1-8 fs-15">{{ $client->profile->bio }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 fw-600 mb-0">{{ $client->name }}'s {{ translate('Open Projects') }}</h4>
                    </div>
                    <div class="card-body">

                        @if (count($open_projects) > 0)
                        <div class="mb-4">
                            <ul class="list-group list-group-flush">
                                @foreach ($open_projects as $key => $open_project)
                                <li class="list-group-item px-0 py-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="fs-14 fw-600 lh-1-5">
                                                <a href="{{ route('project.details', $open_project->slug) }}" class="text-inherit">{{ $open_project->name }}</a>
                                            </h5>
                                            <ul class="list-inline opacity-70 fs-12">
                                                <li class="list-inline-item">
                                                    <i class="las la-clock opacity-40"></i>
                                                    <span>{{ Carbon\Carbon::parse($open_project->created_at)->diffForHumans() }} </span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-stream opacity-40"></i>
                                                    <span>{{ $open_project->project_category->name }}</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-handshake"></i>
                                                    <span>{{ $open_project->type }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="h5">{{ single_price($open_project->price) }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @else

                            <div class="text-center">
                                {{ translate('No Open Project') }}
                            </div>

                        @endif

                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 fw-600 mb-0">{{ $client->name }}'s {{ translate('Reviews') }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">{{ translate('Showing') }} {{ getNumberOfReview($client->id) }} {{ translate('reviews') }}</p>

                        <div class="mb-4">
                            <ul class="list-group list-group-flush">
                                @foreach (\App\Models\Review::where('published', 1)->where('reviewed_user_id', $client->id)->get() as $key => $review)
                                    <li class="list-group-item px-0">
                                        <div class="media">
                                            <div class="mr-3">
                                                <span class="avatar avatar-md m-3">
                                                    <img src="{{ custom_asset(\App\User::find($review->reviewer_user_id)->photo) }}">
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        @if ($review->project != null)
                                                            <h4 class="fw-600 fs-14 mb-1 lh-1-6">{{ $review->project->name }}</h4>
                                                        @endif
                                                        <div class="">
                                                            <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                                {{ $review->rating }}
                                                            </span>
                                                            <span class="rating rating-sm">
                                                                {{ renderStarRating($review->rating) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ml-4">
                                                        <span class="text-muted ml-2">{{ Carbon\Carbon::parse($review->created_at)->toFormattedDateString() }}</span>
                                                    </div>
                                                </div>
                                                <p class="font-italic">
                                                    "{{ $review->review }}"
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xxl-3 col-lg-4">
                <div class="card">
                    <div class="card-body">

                        @if ($client->badges != null)
                        <div class="mb-5">
                            <h6 class="separator text-left mb-4 fw-600"><span class="bg-white pr-3">{{ translate('Badges') }}</span></h6>
                            <div class="">
                                @foreach ($client->badges as $key => $user_badge)
                                    @if ($user_badge->badge != null)
                                        <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ custom_asset($user_badge->badge->icon) }}"></span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="">
                            <h6 class="separator text-left mb-4 fw-600"><span class="bg-white pr-3">{{ translate('Verifications') }}</span></h6>
                            <div>
                                <ul class="list-unstyled">
                                    @php
                                        $verification = \App\Models\Verification::where('user_id', $client->id)->where('type', 'identity_verification')->first();
                                    @endphp
                                    @if ($verification == null || !$verification->verified)
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="las la-user text-secondary la-2x mr-2"></i>
                                            <span class="fs-13">{{ translate('Identity Verification') }}</span>
                                            <i class="las la-ellipsis-h text-secondary la-2x ml-auto"></i>
                                        </li>
                                    @else
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="las la-user text-success la-2x mr-2"></i>
                                            <span class="fs-13">{{ translate('Identity Verified') }}</span>
                                            <i class="las la-check text-success la-2x ml-auto"></i>
                                        </li>
                                    @endif
                                    @if ($client->email_verified_at == null)
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="las la-envelope text-secondary la-2x mr-2"></i>
                                            <span class="fs-13">{{ translate('Email Verification') }}</span>
                                            <i class="las la-ellipsis-h text-secondary la-2x ml-auto"></i>
                                        </li>
                                    @else
                                        <li class="d-flex align-items-center mb-3">
                                            <i class="las la-envelope text-success la-2x mr-2"></i>
                                            <span class="fs-13">{{ translate('Email Verified') }}</span>
                                            <i class="las la-check text-success la-2x ml-auto"></i>
                                        </li>
                                    @endif
                                    {{-- <li class="d-flex align-items-center mb-3">
                                        <i class="lab la-facebook text-success la-2x mr-2"></i>
                                        <span class="fs-13">Facebook Connected</span>
                                        <i class="las la-check text-success la-2x ml-auto"></i>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="lab la-google text-secondary la-2x mr-2"></i>
                                        <span class="fs-13">Google Connected</span>
                                        <i class="las la-ellipsis-h text-secondary la-2x ml-auto"></i>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="lab la-twitter text-secondary la-2x mr-2"></i>
                                        <span class="fs-13">Twitter Connected</span>
                                        <i class="las la-ellipsis-h text-secondary la-2x ml-auto"></i>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="lab la-linkedin-in text-secondary la-2x mr-2"></i>
                                        <span class="fs-13">Linkedin Connected</span>
                                        <i class="las la-ellipsis-h text-secondary la-2x ml-auto"></i>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('frontend.default.partials.unfollow_modal')
@endsection

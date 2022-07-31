@extends('frontend.default.layouts.app')

@section('content')
<section class="py-4 py-lg-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')
            <div class="aiz-user-panel">
                <h6 class="mb-4">{{ translate('Following Clients') }}</h6>

                <div class="row gutters-10">
                    @forelse ($bookmarked_clients as $key => $bookmarked_client)
                        @if ($bookmarked_client->client != null)
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="absolute-top-right p-2">
                                        <a class="d-inline-block confirm-alert" href="javascript:void(0)" data-href="{{ route('bookmarked-clients.destroy', $bookmarked_client->id) }}" data-toggle="tooltip" title="{{ translate('Remove from bookmark') }}" data-target="#unfollow-modal">
                                            <i class="las la-bookmark la-2x"></i>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('client.details', $bookmarked_client->client->user_name) }}" class="text-inherit">
                                           <div class="px-4 text-center mb-3">
                                                <span class="avatar avatar-md mb-3">
                                                    @if($bookmarked_client->client->photo != null)
                                                        <img src="{{ custom_asset($bookmarked_client->client->photo) }}">
                                                    @else
                                                        <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                    @endif
                                                    <span class="badge badge-dot badge-secondary badge-circle badge-status"></span>
                                                </span>
                                                <div class="text-secondary fs-10 mb-1">
                                                    <i class="las la-star text-rating"></i>
                                                    <span class="fw-600">
                                                        {{ formatRating(getAverageRating($bookmarked_client->client->id)) }}
                                                    </span>
                                                    <span>
                                                        ({{ getNumberOfReview($bookmarked_client->client->id) }} {{ translate('Reviews') }})
                                                    </span>
                                                </div>
                                                <h4 class="h5 mb-2 fw-600">{{ $bookmarked_client->client->name }}</h4>
                                                <div class="text-center">
                                                    @foreach ($bookmarked_client->client->badges as $key => $user_badge)
                                                        @if ($user_badge->badge != null)
                                                            <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ custom_asset($user_badge->badge->icon) }}"></span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </a>

                                        <div class="">
                                            <div class="media mb-3">
                                                <div class="text-center text-primary mt-1 mr-3">
                                                    <i class="las la-map-marked la-2x"></i>
                                                </div>
                                                <div class="media-body pt-2">
                                                    @if ($bookmarked_client->client != null && $bookmarked_client->client->address != null && $bookmarked_client->client->address->city != null && $bookmarked_client->client->address->country != null)
                                                        <span class="d-block font-weight-medium">{{ $bookmarked_client->client->address->city->name }}, {{ $bookmarked_client->client->address->country->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="media mb-3">
                                                <div class="text-center text-primary mt-1 mr-3">
                                                    <i class="las la-briefcase la-2x"></i>
                                                </div>
                                                <div class="media-body pt-2">
                                                    <span class="d-block font-weight-medium">{{ count($bookmarked_client->client->number_of_projects) }} {{ translate('jobs posted') }}</span>
                                                </div>
                                            </div>
                                            <div class="media">
                                                <div class="text-center text-primary mt-1 mr-3">
                                                    <i class="las la-money-check-alt la-2x"></i>
                                                </div>
                                                <div class="media-body pt-2">
                                                    <span class="d-block font-weight-medium">{{ single_price(\App\Models\MilestonePayment::where('client_user_id', $bookmarked_client->client_user_id)->where('paid_status', 1)->sum('amount')) }} {{ translate('total spent') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="card flex-grow-1">
                            <div class="card-body text-center">
                                <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                <h4>{{ translate('Nothing Found') }}</h4>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="aiz-pagination mt-4">
                    {{ $bookmarked_clients->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('modal')
    @include('frontend.default.partials.unfollow_modal')
@endsection

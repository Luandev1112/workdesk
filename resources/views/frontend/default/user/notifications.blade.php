@extends('frontend.default.layouts.app')

@section('content')
    <section class="py-4 py-lg-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @if (isClient())
                    @include('frontend.default.user.client.inc.sidebar')
                @else
                    @include('frontend.default.user.freelancer.inc.sidebar')
                @endif
                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h6>{{ translate('Notifications') }}</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-raw">
                                @if(!$notifications->isEmpty())
                                    @foreach($notifications as $notification)
                                        <li class="list-group-item d-flex justify-content-between align-items-start hov-bg-soft-primary">
                                            <a href="{{ url($notification->link) }}" class="media text-inherit">
                                                <span class="avatar avatar-sm mr-3">
                                                    <img src="{{ $notification->sender->photo > 0 ? custom_asset($notification->sender->photo) : my_asset('assets/backend/default/img/avatar-place.png') }}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="mb-1">{{ $notification->message }} {{ $notification->sender_id > 0 ? $notification->sender->name : '' }}</p>
                                                    <small class="text-muted">{{ Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                            @if(!$notification->seen_by_receiver == 1)
                                            <button class="btn p-0" data-toggle="tooltip" data-title="{{ translate('New') }}">
                                                <span class="badge badge-md  badge-dot badge-circle badge-primary"></span>
                                            </button>
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">
                                        <div class="text-center">
                                            <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                            <h4>{{ translate('Nothing Found') }}</h4>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            <div class="aiz-pagination aiz-pagination-center">
                                {{ $notifications->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

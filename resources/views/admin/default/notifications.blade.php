@extends('admin.default.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
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
                                                <img src="{{ $notification->sender != null ? custom_asset($notification->sender->photo) : my_asset('assets/backend/default/img/avatar-place.png') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="mb-1">{{ $notification->message }} {{ $notification->sender != null ? $notification->sender->name : '' }}</p>
                                                <small class="text-muted">{{ Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                        <button class="btn p-0" data-toggle="tooltip" data-title="@if($notification->seen_by_receiver == 1) {{ translate('Seen') }} @else {{ translate('Mark as read') }} @endif">
                                            <span class="badge badge-md @if(!$notification->seen_by_receiver == 1) badge-dot  @endif badge-circle badge-primary"></span>
                                        </button>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="aiz-pagination">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

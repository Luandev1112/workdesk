@extends('admin.default.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">{{ translate('Chats Between') }} {{ $chat_thread->sender->name }} & {{ $chat_thread->receiver->name }}</h6>
    </div>
    <div class="card-body">
        <div class="border-0 shadow-none aiz-chat">
            <div class="chat-list-wrap c-scrollbar-light scroll-to-btm" style="height: calc(100vh - 250px);max-height: calc(100vh - 250px);">
                <div class="chat-coversation-load text-center">
                    <button class="btn btn-link" type="button">{{ translate('Load More') }}</button>
                </div>
                <div class="chat-list">
                    @foreach ($chats as $key => $chat)
                        @if ( $chat->sender_user_id == $chat_thread->sender_user_id)
                            @if ($chat->message != null)
                                <div class="chat-coversation d-inline-flex">
                                    <div class="media">
                                        <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{ $chat->sender->name }}">
                                            @if ($chat->sender->photo != null)
                                                <img src="{{ custom_asset($chat->sender->photo)}}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                        </span>
                                        <div class="media-body">
                                            <div class="text">{{$chat->message}}</div>
                                            <div>
                                                <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($chat->attachment != null)
                                <div class="chat-coversation d-inline-flex">
                                    <div class="media">
                                        <span class="avatar avatar-xs flex-shrink-0">
                                            @if ($chat->sender->photo != null)
                                                <img src="{{ custom_asset($chat->sender->photo)}}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                        </span>
                                        <div class="media-body">
                                            <div class="file-preview box sm pl-2 pt-2 bg-light rounded">
                                                @foreach (json_decode($chat->attachment) as $key => $attachment_id)
                                                    @php
                                                        $attachment = \App\Upload::find($attachment_id);
                                                    @endphp
                                                    @if ($attachment != null)
                                                        @if ($attachment->type == 'image')
                                                            <div class="mb-2 file-preview-item" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">
                                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                                    <div class="thumb">
                                                                        <img src="{{ my_asset($attachment->file_name) }}" class="img-fit">
                                                                    </div>
                                                                    <div class="body">
                                                                        <h6 class="d-flex">
                                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                                        </h6>
                                                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="mb-2 file-preview-item" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">
                                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                                    <div class="thumb">
                                                                        <i class="la la-file-text"></i>
                                                                    </div>
                                                                    <div class="body">
                                                                        <h6 class="d-flex">
                                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                                        </h6>
                                                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-secondary" role="alert">
                                                            {{ translate('Attachment Removed') }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if ($chat->message != null)
                                <div class="chat-coversation right">
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="text">{{$chat->message}}</div>
                                            <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans()}}</span>
                                        </div>
                                        <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{$chat->sender->name}}">
                                            @if ($chat->sender->photo != null)
                                                <img src="{{ custom_asset($chat->sender->photo)}}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @if ($chat->attachment != null)
                                <div class="chat-coversation right">
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="file-preview box sm pr-2 pt-2 bg-primary rounded">
                                                @foreach (json_decode($chat->attachment) as $key => $attachment_id)
                                                    @php
                                                        $attachment = \App\Upload::find($attachment_id);
                                                    @endphp
                                                    @if ($attachment != null)
                                                        @if ($attachment->type == 'image')
                                                            <div class="mb-2 mr-0 ml-2 file-preview-item border-soft-dark" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">
                                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block text-white">
                                                                    <div class="thumb">
                                                                        <img src="{{ my_asset($attachment->file_name) }}" class="img-fit">
                                                                    </div>
                                                                    <div class="body">
                                                                        <h6 class="d-flex">
                                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                                        </h6>
                                                                        <p class="text-light">{{formatBytes($attachment->file_size)}}</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="mb-2 mr-0 ml-2 file-preview-item border-soft-dark" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">
                                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block text-white">
                                                                    <div class="thumb">
                                                                        <i class="la la-file-text"></i>
                                                                    </div>
                                                                    <div class="body">
                                                                        <h6 class="d-flex">
                                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                                        </h6>
                                                                        <p class="text-light">{{formatBytes($attachment->file_size)}}</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-secondary" role="alert">
                                                            {{ translate('Attachment Removed') }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans()}}</span>
                                        </div>
                                        <span class="avatar avatar-xs flex-shrink-0" data-toggle="tooltip" title="{{$chat->sender->name}}">
                                            @if ($chat->sender->photo != null)
                                                <img src="{{ custom_asset($chat->sender->photo)}}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

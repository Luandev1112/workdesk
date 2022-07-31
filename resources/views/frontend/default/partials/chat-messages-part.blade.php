@foreach ($chats->reverse() as $chat)
    @if ($chat->sender_user_id == Auth::user()->id)
        @if ($chat->message != null)
            <div class="chat-coversation right">
                <div class="media">
                    <div class="media-body">
                        <div class="text bg-soft-primary text-dark">{{ $chat->message }}</div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                    <span class="avatar avatar-xs flex-shrink-0">
                        <img @if ($chat->sender->photo != null) src="{{ custom_asset(($chat->sender->photo))}}" @endif>
                    </span>
                </div>
            </div>
        @endif
        @if ($chat->attachment != null)
            <div class="chat-coversation right">
                <div class="media">
                    <div class="media-body">
                        <div class="file-preview box sm">
                            @foreach (json_decode($chat->attachment) as $key => $attachment_id)
                                @php
                                    $attachment = \App\Upload::find($attachment_id);
                                @endphp
                                @if ($attachment != null)
                                    @if ($attachment->type == 'image')
                                        <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
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
                                        <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
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
                                        {{ translate('No attachment') }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                    <span class="avatar avatar-xs flex-shrink-0">
                        <img @if ($chat->sender->photo != null) src="{{ custom_asset(($chat->sender->photo))}}" @endif>
                    </span>
                </div>
            </div>
        @endif
    @else
        @if ($chat->message != null)
            <div class="chat-coversation">
                <div class="media">
                    <span class="avatar avatar-xs flex-shrink-0">
                        <img @if ($chat->sender->photo != null) src="{{ custom_asset(($chat->sender->photo))}}" @endif>
                    </span>
                    <div class="media-body">
                        <div class="text">{{ $chat->message }}</div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if ($chat->attachment != null)
            <div class="chat-coversation">
                <div class="media">
                    <span class="avatar avatar-xs flex-shrink-0">
                        <img @if ($chat->sender->photo != null) src="{{ custom_asset(($chat->sender->photo))}}" @endif>
                    </span>
                    <div class="media-body">
                        <div class="file-preview box sm">
                            @foreach (json_decode($chat->attachment) as $key => $attachment_id)
                                @php
                                    $attachment = \App\Upload::find($attachment_id);
                                @endphp
                                @if ($attachment != null)
                                    @if ($attachment->type == 'image')
                                        <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
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
                                        <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
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
                                        {{ translate('No attachment') }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endforeach

@extends('frontend.default.layouts.app')

@section('content')

    @if (\App\Models\Role::find(Session::get('role_id'))->name == 'Client')
        @include('frontend.default.user.client.inc.sidebar')
    @elseif (\App\Models\Role::find(Session::get('role_id'))->name == 'Freelancer')
        @include('frontend.default.user.freelancer.inc.sidebar')
    @endif

<div class="bg-light">
    <div class="container space-2">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="h6">{{ $support_ticket->subject }}</h4>
                        <ul class="list-inline small text-muted mb-0">
                            <li class="list-inline-item">{{ $support_ticket->ticket_id }}</li>
                            <li class="list-inline-item text-muted">•</li>
                            <li class="list-inline-item">{{ $support_ticket->created_at }}</li>
                            <li class="list-inline-item text-muted">•</li>
                            <li class="list-inline-item">
                                @if ($support_ticket->status == '1')
                                    <span class="badge badge-success">{{translate('Solved')}}</span>
                                @else
                                    <span class="badge badge-danger">{{translate('Pending')}}</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="bg-soft-secondary p-3">
                            <form  class="form-horizontal" action="{{ route('support-ticket.user_reply') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="support_ticket_id" value="{{ $support_ticket->id }}">
                                <div class="">
                                    <textarea class="form-control form-control-sm editor" rows="4" name="reply" placeholder="Type your message here" data-buttons="bold,underline,italic,|,ul,ol,|,undo,redo" required></textarea>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="form-group d-flex">
                                            <div class="align-self-baseline input-group-sm" data-toggle="aizuploader" data-multiple="true">
                                                <button type="button" class="btn btn-secondary btn-sm">
                                                    <i class="la la-paperclip"></i>
                                                </button>
                                                <input type="hidden" name="attachments[]" class="selected-files">
                                            </div>
                                            <div class="file-preview box sm flex-grow-1 ml-3"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="list-group list-group-flush mb-0 px-4">
                            @foreach ($support_replies as $key => $support_reply)
                                @php
                                    $user = \App\User::where('id', $support_reply->replied_user_id)->first();
                                @endphp
                                <li class="list-group-item py-5">
                                    <div class="media">
                                        <div class="u-avatar mr-3">
                                            <img class="img-fluid rounded-circle" src="{{ asset($user->photo) }}" alt="Image Description">
                                        </div>
                                        <div class="media-body">
                                            <div class="mb-3 mb-sm-0">
                                                <div class="mb-2">
                                                    <h4 class="d-inline-block mb-0">
                                                        <a class="d-block h6 mb-0">{{ $user->name }}</a>
                                                    </h4>
                                                    <small class="d-block text-muted">{{ Carbon\Carbon::parse($support_reply->created_at)->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <div>@php echo $support_reply->reply @endphp></div>
                                            <div class="file-preview box clearfix">
                                                @foreach (json_decode($support_reply->attachment) as $attachment_id)
                                                    @php
                                                        $attachment = \App\Upload::find($attachment_id);
                                                    @endphp
                                                     @if ($attachment != null)
                                                        <div class="mt-2 file-preview-item" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">
                                                            <a href="{{ asset($attachment->file_name) }}" target="_blank" download="{{ $attachment->file_original_name }}.{{ $attachment->extension }}" class="d-block">
                                                                <div class="thumb">
                                                                    @if($attachment->type == 'image')
                                                                        <img src="{{ asset($attachment->file_name) }}" class="img-fit">
                                                                    @else
                                                                        <i class="la la-file-text"></i>
                                                                    @endif
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
                                                            <div class="mt-2 file-preview-item">
                                                                {{ translate('No Attchment') }}
                                                            </div>
                                                        @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @php
                                $sender = \App\User::where('id', $support_ticket->sender_user_id)->first();
                            @endphp
                            <li class="list-group-item py-5">
                                <div class="media">
                                    <div class="u-avatar mr-3">
                                        <img class="img-fluid rounded-circle" src="{{ asset($sender->photo) }}" alt="Image Description">
                                    </div>
                                    <div class="media-body">
                                        <div class="mb-3 mb-sm-0">
                                            <div class="mb-2">
                                                <h4 class="d-inline-block mb-0">
                                                    <a class="d-block h6 mb-0">{{$sender->name}}</a>
                                                </h4>

                                                <small class="d-block text-muted">{{ Carbon\Carbon::parse($support_ticket->created_at)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div>@php echo $support_ticket->description  @endphp></div>

                                        <div class="file-preview box clearfix">
                                        @foreach (json_decode($support_ticket->attachment_id) as $attachment_id)
                                            @php
                                                $attachment = \App\Upload::find($attachment_id);
                                            @endphp
                                            @if ($attachment != null)
                                                <div class="mt-2 file-preview-item" title="{{ $attachment->file_original_name }}.{{ $attachment->extension }}">

                                                    <a href="{{ asset($attachment->file_name) }}" target="_blank" download="{{ $attachment->file_original_name }}.{{ $attachment->extension }}" class="d-block">
                                                        <div class="thumb">
                                                            @if($attachment->type == 'image')
                                                                <img src="{{ asset($attachment->file_name) }}" class="img-fit">
                                                            @else
                                                                <i class="la la-file-text"></i>
                                                            @endif
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
                                                <div class="mt-2 file-preview-item">
                                                    {{ translate('No Attchment') }}
                                                </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





@if (\App\Addon::where('unique_identifier', 'support_tickets')->first() != null && \App\Addon::where('unique_identifier', 'support_tickets')->first()->activated == 1)
    <li class="aiz-side-nav-item">
        <a href="#" class="aiz-side-nav-link">
            <i class="las la-people-carry aiz-side-nav-icon"></i>
            <span class="aiz-side-nav-text">{{translate('Support Ticket')}}</span>
            <span class="aiz-side-nav-arrow"></span>
        </a>
        <ul class="aiz-side-nav-list level-2">
            <li class="aiz-side-nav-item">
                <a href="{{ route('support-tickets.active_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.edit'])}}">
                    <span class="aiz-side-nav-text">{{translate('Active Tickets')}}</span>
                </a>
            </li>
            <li class="aiz-side-nav-item">
                <a href="{{ route('support-tickets.my_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.show'])}}">
                    <span class="aiz-side-nav-text">{{translate('My tickets')}}</span>
                </a>
            </li>
            <li class="aiz-side-nav-item">
                <a href="{{ route('support-tickets.solved_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.show'])}}">
                    <span class="aiz-side-nav-text">{{translate('Solved tickets')}}</span>
                </a>
            </li>
            <li class="aiz-side-nav-item">
                <a href="#" class="aiz-side-nav-link">
                    <span class="aiz-side-nav-text">{{translate('Support Settings')}}</span>
                    <span class="aiz-side-nav-arrow"></span>
                </a>

                <ul class="aiz-side-nav-list level-3">
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('support-categories.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-categories.index', 'support-categories.edit'])}}">
                            <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('support-tickets.default_agent') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('Default Asssigned Agent')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
@endif

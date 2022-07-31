<div class="chat-box-wrap h-100">
    <div class="attached-top bg-white border-bottom chat-header d-flex justify-content-between align-items-center p-3 shadow-sm">
        <div class="media align-items-center">
            @if (isClient())
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->receiver->photo != null)
                        <img src="{{ custom_asset($chat_thread->receiver->photo) }}">
                    @else
                        <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->receiver->name }}
                        @if(Cache::has('user-is-online-' . $chat_thread->receiver->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
            @else
                <span class="avatar avatar-sm mr-3 flex-shrink-0">
                    @if ($chat_thread->sender->photo != null)
                        <img src="{{ custom_asset($chat_thread->sender->photo) }}">
                    @else
                        <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                    @endif
                </span>
                <div class="media-body">
                    <h6 class="fs-15 mb-1">
                        {{ $chat_thread->sender->name }}
                        @if(Cache::has('user-is-online-' . $chat_thread->sender->id))
                            <span class="badge badge-dot badge-success badge-circle"></span>
                        @else
                            <span class="badge badge-dot badge-secondary badge-circle"></span>
                        @endif
                    </h6>
                </div>
            @endif
        </div>
        <div class="d-flex align-items-center">
            <button class="aiz-mobile-toggler d-lg-none aiz-all-chat-toggler mr-2" data-toggle="class-toggle" data-target=".chat-user-list-wrap">
                <span></span>
            </button>
            <button class="btn btn-icon btn-circle btn-soft-primary chat-info" data-toggle="class-toggle" data-target=".chat-info-wrap"><i class="las la-info-circle"></i></button>
        </div>
    </div>
    <div class="chat-list-wrap c-scrollbar-light scroll-to-btm" id="parentDiv">
        @if (count($chats) > 0)
            <div class="chat-coversation-load text-center">
                <button class="btn btn-link load-more-btn" data-first="{{ $chats->last()->id }}" type="button">{{ translate('Load More') }}</button>
            </div>
        @endif
        <div class="chat-list px-4" id="chat-messages">
            @include('frontend.default.partials.chat-messages-part',['chats' => $chats])
        </div>
    </div>
    <div class="chat-footer border-top p-3 attached-bottom bg-white">
        <form id="send-mesaage">
            <div class="input-group">
                <input type="hidden" id="chat_thread_id" name="chat_thread_id" value="{{ $chat_thread->id }}">
                <input type="text" class="form-control" name="message" id="message" placeholder="Your Message.." autocomplete="off">
                <input type="hidden" class="" name="attachment" id="attachment">
                <div class="input-group-append">
                    <button class="btn btn-circle btn-icon chat-attachment" type="button">
                        <i class="las la-paperclip"></i>
                    </button>
                    <button class="btn btn-primary btn-circle btn-icon" onclick="send_reply()" type="button">
                        <i class="las la-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="chat-info-wrap">
        <div class="overlay dark c-pointer" data-toggle="class-toggle" data-target=".chat-info-wrap" data-same=".chat-info"></div>
        @if (isClient())
            <div class="chat-info c-scrollbar-light p-4 z-1">
                <div class="px-4 text-center mb-3">
                    <span class="avatar avatar-md mb-3">
                        @if ($chat_thread->receiver->photo != null)
                            <img src="{{ custom_asset($chat_thread->receiver->photo) }}">
                        @else
                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                        @endif
                        <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                    </span>
                    <div class="text-secondary fs-10 mb-1">
                        <i class="las la-star text-warning"></i>
                        <span class="fw-600">
                            {{ formatRating(getAverageRating($chat_thread->receiver->id)) }}
                        </span>
                        <span>
                            ({{ getNumberOfReview($chat_thread->receiver->id) }} {{ translate('Reviews') }})
                        </span>
                    </div>
                    <h4 class="h5 mb-2 fw-600">{{ $chat_thread->receiver->name }}</h4>
                    <div class="text-center">
                        @foreach ($chat_thread->receiver->badges as $key => $user_badge)
                            @if ($user_badge->badge != null)
                                <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ my_asset($user_badge->badge->icon) }}"></span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if($chat_thread->receiver->profile->skills != null)
                <div class="mb-3 text-center">
                    @foreach (json_decode($chat_thread->receiver->profile->skills, true) as $key => $skill_id)
                        @php
                            $skill = \App\Models\Skill::find($skill_id);
                        @endphp
                        @if ($skill)
                            <span class="btn btn-light btn-xs mb-1">{{ $skill->name }}</span>
                        @endif
                    @endforeach
                </div>
                @endif
                <div class="separator my-4"><span class="bg-white px-3 text-black-50">{{ translate('Running Projects With You') }}</span></div>
                <div class="">
                    <ul class="list-group">
                        @php
                            $running_projects = DB::table('projects')
                                                ->where('projects.client_user_id', auth()->user()->id)
                                                ->where('projects.biddable', 0)
                                                ->where('projects.closed', 0)
                                                ->where('projects.cancel_status', 0)
                                                ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                                                ->where('project_users.user_id', $chat_thread->receiver_user_id)
                                                ->select('project_users.id')
                                                ->get();
                        @endphp
                        @foreach ($running_projects as $key => $running_project_id)
                            @php
                                $project_user = \App\Models\ProjectUser::find($running_project_id->id);
                            @endphp
                            @if ($project_user->project != null)
                                <li class="list-group-item">
                                    <a href="{{ route('project.details', $project_user->project->slug) }}" target="_blank" class="text-body">{{ $project_user->project->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="separator my-4"><span class="bg-white px-3 text-black-50">{{ translate('Completed Projects With You') }}</span></div>
                <div class="">
                    <ul class="list-group">
                        @php
                            $completed_projects = DB::table('projects')
                                                ->where('projects.client_user_id', auth()->user()->id)
                                                ->where('projects.biddable', 0)
                                                ->where('projects.closed', 1)
                                                ->where('projects.cancel_status', 0)
                                                ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                                                ->where('project_users.user_id', $chat_thread->receiver_user_id)
                                                ->select('project_users.id')
                                                ->get();
                        @endphp
                        @foreach ($completed_projects as $key => $completed_project_id)
                            @php
                                $project_user = \App\Models\ProjectUser::find($completed_project_id->id);
                            @endphp
                            @if ($project_user->project != null)
                                <li class="list-group-item">
                                    <a href="{{ route('project.details', $project_user->project->slug) }}" target="_blank" class="text-body">{{ $project_user->project->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="chat-info c-scrollbar-light p-4 z-1">
                <div class="px-4 text-center mb-3">
                    <span class="avatar avatar-md mb-3">
                        @if ($chat_thread->sender->photo != null)
                            <img src="{{ custom_asset($chat_thread->sender->photo) }}">
                        @else
                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                        @endif
                        <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                    </span>
                    <div class="text-secondary fs-10 mb-1">
                        <i class="las la-star text-warning"></i>
                        <span class="fw-600">
                            {{ formatRating(getAverageRating($chat_thread->sender->id)) }}
                        </span>
                        <span>
                            ({{ getNumberOfReview($chat_thread->receiver->id) }} {{ translate('Reviews') }})
                        </span>
                    </div>
                    <h4 class="h5 mb-2 fw-600">{{ $chat_thread->sender->name }}</h4>
                    <div class="text-center">
                        @foreach ($chat_thread->sender->badges as $key => $user_badge)
                            @if ($user_badge->badge != null)
                                <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ my_asset($user_badge->badge->icon) }}"></span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="separator my-4"><span class="bg-white px-3 text-black-50">{{ translate('Running Projects With You') }}</span></div>
                <div class="">
                    <ul class="list-group">
                        @php
                            $running_projects = DB::table('projects')
                                                ->where('projects.client_user_id', $chat_thread->sender_user_id)
                                                ->where('projects.biddable', 0)
                                                ->where('projects.closed', 0)
                                                ->where('projects.cancel_status', 0)
                                                ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                                                ->where('project_users.user_id', auth()->user()->id)
                                                ->select('project_users.id')
                                                ->get();
                        @endphp
                        @foreach ($running_projects as $key => $running_project_id)
                            @php
                                $project_user = \App\Models\ProjectUser::find($running_project_id->id);
                            @endphp
                            @if ($project_user->project != null)
                                <li class="list-group-item">
                                    <a href="{{ route('project.details', $project_user->project->slug) }}" target="_blank" class="text-body">{{ $project_user->project->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="separator my-4"><span class="bg-white px-3 text-black-50">{{ translate('Completed Projects With You') }}</span></div>
                <div class="">
                    <ul class="list-group">
                        @php
                            $completed_projects = DB::table('projects')
                                                ->where('projects.client_user_id', $chat_thread->sender_user_id)
                                                ->where('projects.biddable', 0)
                                                ->where('projects.closed', 1)
                                                ->where('projects.cancel_status', 0)
                                                ->join('project_users', 'projects.id', '=', 'project_users.project_id')
                                                ->where('project_users.user_id', auth()->user()->id)
                                                ->select('project_users.id')
                                                ->get();
                        @endphp
                        @foreach ($completed_projects as $key => $completed_project_id)
                            @php
                                $project_user = \App\Models\ProjectUser::find($completed_project_id->id);
                            @endphp
                            @if ($project_user->project != null)
                                <li class="list-group-item">
                                    <a href="{{ route('project.details', $project_user->project->slug) }}" target="_blank" class="text-body">{{ $project_user->project->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="aiz-user-sidenav-wrap pt-4 sticky-top c-scrollbar-light position-relative z-1">
    <div class="absolute-top-left d-xl-none">
        <button class="btn btn-sm p-2" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb">
            <i class="las la-times la-2x"></i>
        </button>
    </div>
    <div class="aiz-user-sidenav rounded overflow-hidden">
        <div class="px-4 text-center mb-4">
            <span class="avatar avatar-md mb-3">
                @if (Auth::user()->photo != null)
                <img src="{{ custom_asset(Auth::user()->photo) }}">
                @else
                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                @endif
                @if(Cache::has('user-is-online-' . Auth::user()->id))
                    <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                @else
                    <span class="badge badge-dot badge-secondary badge-circle badge-status"></span>
                @endif
            </span>
            <h4 class="h5 fw-600">{{ Auth::user()->name }}</h4>
            <div class="text-center  mb-2">
                @foreach (Auth::user()->badges as $key => $user_badge)
                    @if ($user_badge->badge != null)
                        <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ custom_asset($user_badge->badge->icon) }}"></span>
                    @endif
                @endforeach
            </div>
            <div>
                <span class="rating rating-sm">
                    {{ renderStarRating(getAverageRating(Auth::user()->id)) }}
                </span>
            </div>
            <div class="mb-1">
                @php
                    $profile = \App\Models\UserProfile::where('user_id', Auth::user()->id)->where('user_role_id', 2)->first();
                @endphp
                <span class="fw-600">
                    {{ formatRating(getAverageRating(Auth::user()->id)) }}
                </span>
                <span>
                    ({{ getNumberOfReview(Auth::user()->id) }} {{ translate('Reviews') }})
                </span>
            </div>
        </div>

        <div class="sidemnenu mb-3">
            <ul class="aiz-side-nav-list" data-toggle="aiz-side-menu">

                <li class="aiz-side-nav-item">
                    <a href="{{ route('dashboard') }}" class="aiz-side-nav-link {{ areActiveRoutes(['dashboard'])}}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-file-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Services') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('client.purchased.services') }}" class="aiz-side-nav-link {{ areActiveRoutes(['client.purchased.services'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Purchased Services') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('client.services.cancelled') }}" class="aiz-side-nav-link {{ areActiveRoutes(['client.services.cancelled'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Cancelled Services') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('client.services.cancel.requests') }}" class="aiz-side-nav-link {{ areActiveRoutes(['client.services.cancel.requests'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Service Cancel Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-file-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Projects') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('projects.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['projects.index', 'projects.create','projects.edit'])}}">
                                <span class="aiz-side-nav-text">{{ translate('All Projects') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('projects.my_open_project') }}" class="aiz-side-nav-link {{ areActiveRoutes(['projects.my_open_project', 'call_for_interview', 'project.bids'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Open Projects') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('projects.my_running_project') }}" class="aiz-side-nav-link {{ areActiveRoutes(['projects.my_running_project'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Running') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('projects.my_completed_project') }}" class="aiz-side-nav-link {{ areActiveRoutes(['projects.my_completed_project'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Completed') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('projects.my_cancelled_project') }}" class="aiz-side-nav-link {{ areActiveRoutes(['projects.my_cancelled_project'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Cancelled') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user()->userPackage != null && Auth::user()->userPackage->following_status)
                <li class="aiz-side-nav-item">
                    <a href="{{ route('bookmarked-freelancers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['bookmarked-freelancers.index'])}}">
                        <i class="las la-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Bookmarked Freelancers') }}</span>
                    </a>
                </li>
                @endif
                @php
                    $total_mile_request = count(\App\Models\MilestonePayment::where('client_user_id', Auth::user()->id)->where('client_seen', 0)->get());
                @endphp
                <li class="aiz-side-nav-item">
                    <a href="{{ route('milestone-requests.all') }}" class="aiz-side-nav-link {{ areActiveRoutes(['milestone-requests.all'])}}">
                        <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Milestone Request') }}</span>
                        @if ($total_mile_request > 0)
                            <span class="badge badge-primary badge-circle">{{$total_mile_request}}</span>
                        @endif
                    </a>
                </li>
                @php
                    $unseen_chat_threads = chat_threads();
                    $unseen_chat_thread_count = count($unseen_chat_threads);
                @endphp
                <li class="aiz-side-nav-item">
                    <a href="{{ route('all.messages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['all.messages', 'chat_view'])}}">
                        <i class="las la-comment-dots aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Message') }}</span>
                        <span class="badge badge-primary badge-circle">{{ $unseen_chat_thread_count }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('user_review', 'client') }}" class="aiz-side-nav-link {{ areActiveRoutes(['select_package'])}}">
                        <i class="lar la-star aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Reviews') }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Packages') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('select_package') }}" class="aiz-side-nav-link {{ areActiveRoutes(['select_package'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Upgrade/Downgrade') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('client.packages.history') }}" class="aiz-side-nav-link {{ areActiveRoutes(['client.packages.history'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Packages History') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (\App\Addon::where('unique_identifier', 'support_tickets')->first() != null && \App\Addon::where('unique_identifier', 'support_tickets')->first()->activated == 1)
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('support-tickets.user_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.user_index','support-tickets.user_ticket_create'])}}">
                            <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Support Ticket') }}</span>
                        </a>
                    </li>
                @endif
                <li class="aiz-side-nav-item">
                    <a href="{{ route('user.profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user.profile'])}}">
                        <i class="las la-cog aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Profile Setting') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <a href="{{ route('logout') }}" class="btn btn-block btn-soft-danger rounded-0">
                <i class="las la-sign-out-alt"></i>
                {{ translate('Logout') }}
            </a>
        </div>
    </div>
</div>

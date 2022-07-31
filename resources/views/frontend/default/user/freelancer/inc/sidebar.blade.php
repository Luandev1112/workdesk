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
                    $profile = \App\Models\UserProfile::where('user_id', Auth::user()->id)->first();
                @endphp
                <span class="fw-600">
                    {{ formatRating(getAverageRating(Auth::user()->id)) }}
                </span>
                <span>
                    ({{ getNumberOfReview(Auth::user()->id) }} {{ translate('Reviews') }})
                </span>
            </div>
        </div>
        <div class="text-center mb-3 px-3">
            <a href="{{ route('freelancer.details', Auth::user()->user_name) }}" class="btn btn-block btn-soft-primary" target="_blank">{{ translate('Public Profile') }}</a>
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
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Services') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('service.freelancer_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['service', 'service.edit'])}}">
                                <span class="aiz-side-nav-text">{{ translate('All Services') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('service.sold') }}" class="aiz-side-nav-link {{ areActiveRoutes(['service.sold'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Sold Services') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Projects') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('bidded_projects') }}" class="aiz-side-nav-link {{ areActiveRoutes(['bidded_projects'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Bidded') }}</span>
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
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('private_projects') }}" class="aiz-side-nav-link {{ areActiveRoutes(['private_projects'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Project Proposal') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Earnings') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('recieved_milestone_payment_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['recieved_milestone_payment_index'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Earnings History') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('send_withdrawal_request_to_admin') }}" class="aiz-side-nav-link {{ areActiveRoutes(['send_withdrawal_request_to_admin'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Withdraw Request') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('withdrawal_history_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['withdrawal_history_index'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Withdraw History') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('sent-milestone-requests.all') }}" class="aiz-side-nav-link {{ areActiveRoutes(['sent-milestone-requests.all'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Milestone Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('bookmarked-projects.index') }}" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Bookmarked Projects') }}</span>
                    </a>
                </li>
                @if (Auth::user()->userPackage != null && Auth::user()->userPackage->following_status)
                <li class="aiz-side-nav-item">
                    <a href="{{ route('bookmarked-clients.index') }}" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Following Clients') }}</span>
                    </a>
                </li>
                @endif
                @php
                    $unseen_chat_threads = chat_threads();
                    $unseen_chat_thread_count = count($unseen_chat_threads);
                @endphp
                <li class="aiz-side-nav-item">
                    <a href="{{ route('all.messages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['all.messages', 'chat_view'])}}">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Message') }}</span>
                        <span class="badge badge-primary badge-circle">{{ $unseen_chat_thread_count }}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('user_review', 'freelancer') }}" class="aiz-side-nav-link {{ areActiveRoutes(['select_package'])}}">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
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
                            <a href="{{ route('freelancer.packages.history') }}" class="aiz-side-nav-link {{ areActiveRoutes(['freelancer.packages.history'])}}">
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
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Setting') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('user.account') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user.account'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Account Setting') }}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('user.profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user.profile'])}}">
                                <span class="aiz-side-nav-text">{{ translate('Profile Setting') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="bg-primary text-white text-center py-5 position-relative">
            <svg class="absolute-full" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" fill="rgba(255,255,255,0.1)" fill-opacity="1" xml:space="preserve">
                <path d="M318.5,267.4c-0.1,0-0.1,0-0.2-0.1c-24.6-9.9-38.9-15-51.6-19.3V64.4c59.7,3.9,106.7,40.5,106.7,85 c0,5.9,4.8,10.7,10.7,10.7s10.7-4.8,10.7-10.7c0-56-56.5-102.1-128-106.4V10.7C266.7,4.8,261.9,0,256,0s-10.7,4.8-10.7,10.7V43 c-71.5,4.2-128,50.3-128,106.4c0,40.5,29.1,77,75.9,95.2c0.1,0,0.2,0.1,0.3,0.1c24.8,9.6,39.1,14.5,51.8,18.7v184.3 c-59.7-3.9-106.7-40.5-106.7-85c0-5.9-4.8-10.7-10.7-10.7s-10.7,4.8-10.7,10.7c0,56,56.5,102.1,128,106.4v32.3 c0,5.9,4.8,10.7,10.7,10.7s10.7-4.8,10.7-10.7V469c71.5-4.2,128-50.3,128-106.4C394.7,322.1,365.5,285.5,318.5,267.4z  M201.7,225 c-0.2-0.1-0.3-0.1-0.5-0.2c-38.6-15-62.6-43.9-62.6-75.4c0-44.4,47-81,106.7-85v176.6C234.4,237.2,221.5,232.7,201.7,225z M266.7,447.6V270.5c10.9,3.8,24,8.6,44,16.7c0,0,0.1,0,0.1,0c0.1,0.1,0.3,0.1,0.4,0.1c38.4,15,62.2,43.8,62.2,75.3 C373.3,407.1,326.4,443.7,266.7,447.6z"/>
            </svg>
            <p class="text-uppercase opacity-60 mb-1 fs-11">{{ translate('Balance') }}</p>
            <h3 class="fw-700">{{single_price($profile->balance)}}</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" class="btn btn-block hov-bg-danger hov-text-white rounded-0">
                <i class="las la-sign-out-alt"></i>
                {{ translate('Logout') }}
            </a>
        </div>
    </div>
</div>

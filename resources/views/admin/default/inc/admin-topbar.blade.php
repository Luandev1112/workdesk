<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-xl-none d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
        <div class="aiz-topbar-logo-wrap d-flex align-items-center justify-content-start">
            <a href="index.html" class="d-block">
                <img src="{{ custom_asset(\App\Utility\SettingsUtility::get_settings_value('system_logo_black')) }}" class="img-fluid" height="45">
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-none d-md-flex justify-content-around align-items-center align-items-stretch">
            <div class="aiz-topbar-item">
                <div class="d-flex align-items-center">
                    <a class="btn btn-icon btn-circle btn-light" href="{{ route('home')}}" target="_blank" title="{{ translate('Browse Website') }}">
                        <i class="las la-globe"></i>
                    </a>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-1 position-relative">
                            <i class="las la-bell la-2x"></i>
                            <span class="badge badge-circle badge-primary position-absolute absolute-top-right">
                                {{--get numbers of unseen notification --}}
                                {{  \App\Utility\NotificationUtility::get_my_notifications(10,true,true) }}
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                        </div>
                        <ul class="list-group list-group-raw c-scrollbar-light overflow-auto" style="max-height:300px;">
                            {{--get 10 unseen notifications as array --}}
                            @php $notification_list = \App\Utility\NotificationUtility::get_my_notifications(10,true,false,false); @endphp
                            @foreach ($notification_list as $notification_item)
                            <li class="list-group-item d-flex justify-content-between align-items-start hov-bg-soft-primary">
                                <a href="{{ $notification_item['link'] }}" class="media text-inherit">
                                    <span class="avatar avatar-sm mr-3">
                                        <img src="{{ $notification_item['sender_photo'] }}">
                                    </span>
                                    <div class="media-body">
                                        <p class="mb-1">{{ $notification_item['message'].' '.$notification_item['sender_name'] }}</p>
                                        <small class="text-muted">{{ $notification_item['date']  }}</small>
                                    </div>
                                </a>
                                <button class="btn p-0" data-toggle="tooltip" data-title="@if($notification_item['seen'] == true) {{ translate('Seen') }} @else {{ translate('Mark as read') }} @endif">
                                    <span class="badge badge-md @if($notification_item['seen'] == false) badge-dot  @endif badge-circle badge-primary"></span>
                                </button>
                            </li>
                            @endforeach
                        </ul>
                        <div class="border-top">
                            <a href="{{ route('admin.notifications') }}" class="btn btn-link btn-block">{{ translate('View All Notifications') }}</a>
                        </div>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->

            @php
                if(Session::has('locale')){
                    $locale = Session::get('locale', Config::get('app.locale'));
                }
                else{
                    $locale = env('DEFAULT_LANGUAGE');
                }
            @endphp
            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon">
                            <img src="{{ my_asset('assets/frontend/default/img/flags/'.$locale.'.png') }}" height="11">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">
                        @foreach (\App\Models\Language::where('enable',1)->get() as $key => $language)
                            <a href="{{ route('language.change',$language->code) }}" class="dropdown-item">
                                <img src="{{ my_asset('assets/frontend/default/img/flags/'.$language->code.'.png') }}" height="11">
                                <span class="ml-2">{{ $language->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2 border">
                                @if (Auth::user()->photo != null)
                                    <img src="{{custom_asset(Auth::user()->photo)}}">
                                @else
                                    <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                @endif
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{Auth::user()->name}}</span>
                                <span class="d-block small opacity-60">{{Auth::user()->user_type}}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{translate('My Account')}}</span>
                        </a>

                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{translate('Logout')}}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->

@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('General Settings')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('general-config.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="types">{{translate('System Name')}}</label>
                            <input type="text" name="site_name" class="form-control" value="{{ get_setting('site_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="types">{{translate('System Logo - White')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                <input type="hidden" name="system_logo_white" value="{{ get_setting('system_logo_white') }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small>{{ translate('Will be used in admin panel side menu') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="types">{{translate('System Logo - Black')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                <input type="hidden" name="system_logo_black" value="{{ get_setting('system_logo_black') }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small>{{ translate('Will be used in admin panel topbar in mobile + Admin login page') }}</small>
                        </div>
                        <div class="form-group">
                            <label>{{translate('System Timezone')}}</label>
                            <select name="timezone" class="form-control aiz-selectpicker" data-live-search="true">
                                @foreach (timezones() as $key => $value)
                                    <option value="{{ $value }}" @if (app_timezone() == $value)
                                        selected
                                    @endif>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{translate('Admin login page background')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                <input type="hidden" name="admin_login_background" value="{{\App\Utility\SettingsUtility::get_settings_value('admin_login_background')}}" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end card-body -->
    </div> <!-- end card-->

@endsection

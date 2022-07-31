@extends('admin.default.layouts.blank')
@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mar-ver pad-btm text-center">
                            <h1 class="h3">{{ translate('Active Workdesk Update Process') }}</h1>
                            <p>{{ translate('You will need to know the following items before
                            proceeding') }}.</p>
                        </div>
                        <ol class="list-group">
                            <li class="list-group-item text-semibold"><i class="fa fa-check"></i> {{ translate('Codecanyon purchase code') }}</li>
                            <li class="list-group-item text-semibold"><i class="fa fa-check"></i> {{ translate('Database Name') }}</li>
                            <li class="list-group-item text-semibold"><i class="fa fa-check"></i> {{ translate('Database Username') }}</li>
                            <li class="list-group-item text-semibold"><i class="fa fa-check"></i> {{ translate('Database Password') }}</li>
                            <li class="list-group-item text-semibold"><i class="fa fa-check"></i> {{ translate('Database Hostname') }}</li>
                        </ol>
                        <br>
                        <div class="text-center">
                            <a href="{{ route('step1') }}" class="btn btn-primary text-light">
                                {{ translate('Update Now') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

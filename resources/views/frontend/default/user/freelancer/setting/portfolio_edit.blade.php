

@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex">
                @include('frontend.default.user.freelancer.inc.sidebar')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Portfolio Edit') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                    <div class="card-header">
                        <h4 class="h6 font-weight-medium mb-0">{{ translate('Portfolio') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user_profile.portfolio_update', $user_portfolio->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="portfolio_name" value="{{ $user_portfolio->name }}" placeholder="Portfolio title">
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Category') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="portfolio_category" value="{{ $user_portfolio->type }}" placeholder="Portfolio category">
                            </div>
                            <div class="form-group">
                                <label id="usernameLabel" class="form-label">
                                    {{ translate('Details') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" rows="3" name="portfolio_details" required>{{ $user_portfolio->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <label class="form-label" for="signinSrEmail">{{ translate('Image') }}</label>
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="portfolio_img" class="selected-files" value="{{ $user_portfolio->photo }}">
                                    </div>
                                    <div class="file-preview"></div>
                                </div>
                                <div class="mt-2 text-right">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Update Portfolio') }}</button>
                                    <!-- End Buttons -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
@endsection

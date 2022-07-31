@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')

            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Edit Service') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 font-weight-medium mb-0">{{ translate('Service Info') }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="js-validate" action="{{ route('service.update', $service->slug) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="js-form-message">
                                <div class="form-group">
                                    <label id="nameLabel" class="form-label">
                                        {{ translate('Title of Service') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="title" placeholder="Enter your service title" value="{{ $service->title }}" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter title." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ translate('Service Image') }}</label>
                                    <div class="input-group " data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="service_photo" class="selected-files" value="{{ $service->image }}">
                                    </div>
                                    <div class="file-preview"></div>
                                </div>


                                <div class="form-group">
                                    <label id="clientLabel" class="form-label">
                                        Client Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="client_name" placeholder="Enter client name" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success" value="{{ $service->client_name }}">
                                </div>

                                <div class="form-group">
                                    <label id="serverLabel" class="form-label">
                                        Site Url
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="site_url" placeholder="Enter server url" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success" value="{{ $service->site_url }}">
                                </div>


                                <div class="form-group">
                                    <label>{{ translate('About Service') }}</label>
                                    <textarea class="aiz-text-editor form-control" name="about_service"
                                                data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]'
                                                placeholder="Type.." data-min-height="150">{{ $service->about_service }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{ translate('Select Category') }}</label>
                                    <select class="form-control aiz-selectpicker" name="category_id">
                                        @foreach(\App\Models\ProjectCategory::all() as $category)
                                            <option value="{{ $category->id }}" @if($category->id == $service->project_cat_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">{{ translate('Please select a category.') }}</small>
                                </div>
                            </div>
                            <h5>{{ translate('Packages') }}</h5>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($service_packages as $service_package)
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->iteration == 1) active @endif" id="{{ $service_package->service_type }}-tab" data-toggle="tab" href="#{{ $service_package->service_type }}" role="tab" aria-controls="{{ $service_package->service_type }}" aria-selected="@if($loop->iteration == 1) true @else false @endif">{{ ucfirst($service_package->service_type) }}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                @foreach($service_packages as $service_package)
                                <div class="tab-pane show @if($loop->iteration == 1) active @endif" id="{{ $service_package->service_type }}" role="tabpanel" aria-labelledby="{{ $service_package->service_type }}-tab">
                                    <h5 class="mt-3">{{ ucfirst($service_package->service_type) }} Package</h5>
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Price') }}</label>
                                        <input type="text" class="form-control " name="{{ $service_package->service_type }}_price" placeholder="Enter Basic Package Price" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success" value="{{ $service_package->service_price }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Devilery Within') }}</label>
                                        <input type="text" class="form-control " name="{{ $service_package->service_type }}_delivery_time" placeholder="Enter Basic Package Price" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success" value="{{ $service_package->delivery_time }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Revision Limit') }}</label>
                                        <input type="text" class="form-control " name="{{ $service_package->service_type }}_revision_limit" placeholder="Enter Basic Package Price" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success"  value="{{ $service_package->revision_limit }}">
                                    </div>

                                    <div class="whats-included-{{ $service_package->service_type }}">
                                        <div class="form-group">
                                            <label class="form-label">{{ translate('What is included section') }}</label>
                                            @if ($service_package->feature_description != null)
                                                @foreach (json_decode($service_package->feature_description) as $key => $value)
                                                <div class="row gutters-5">
                                                    <div class="col">
                                                        <div class="form-group d-flex">
                                                            <input id="include_description" type="text" class="form-control" value="{{ $value }}" placeholder="http://" name="{{ $service_package->service_type }}_included_description[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-soft-secondary btn-sm"
                                        data-toggle="add-more"
                                        data-content='<div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group d-flex">
                                                    <input id="include_description" type="text" class="form-control" placeholder="" name="{{ $service_package->service_type }}_included_description[]">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>'
                                        data-target=".whats-included-{{ $service_package->service_type }}">
                                        {{ translate('Add New') }}
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary transition-3d-hover mr-1">{{ translate('Update Service') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

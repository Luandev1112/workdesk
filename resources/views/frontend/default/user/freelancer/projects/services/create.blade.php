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
                            <h1 class="h3">{{ translate('Create new service') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="h6 font-weight-medium mb-0">{{ translate('Service Info') }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="js-validate" action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="js-form-message">
                                <div class="form-group">
                                    <label id="nameLabel" class="form-label">
                                        {{ translate('Title of Service') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="title" placeholder="{{ translate('Enter your service title') }}" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ translate('Service Image') }}</label>
                                    <div class="input-group " data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="service_photo" class="selected-files" required>
                                    </div>
                                    <div class="file-preview"></div>
                                </div>

                                <div class="form-group">
                                    <label id="clientLabel" class="form-label">
                                        Client Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="client_name" placeholder="Enter client name" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>

                                <div class="form-group">
                                    <label id="serverLabel" class="form-label">
                                        Site Url
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control " name="site_url" placeholder="Enter server url" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>

                                <div class="form-group">
                                    <label>{{ translate('About Service') }}</label>
                                    <textarea class="aiz-text-editor form-control" name="about_service" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="{{ translate('Type') }}.." data-min-height="150"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select class="form-control aiz-selectpicker" name="category_id">
                                        @foreach(\App\Models\ProjectCategory::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Please select a category.</small>
                                </div>
                            </div>
                            <h5>Packages</h5>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Standard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Premium</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="mt-3">{{ translate('Basic Package') }}</h5>
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Price') }}</label>
                                        <input type="text" class="form-control " name="basic_price" placeholder="{{ translate('Enter Price') }}" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Devilery Within') }}</label>
                                        <input type="text" class="form-control " name="basic_delivery_time" placeholder="{{ translate('Enter Delivery Time') }}" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Revision Limit') }}</label>
                                        <input type="text" class="form-control " name="basic_revision_limit" placeholder="{{ translate('Enter Revision Limit') }}" aria-label="Enter Basic Package Price" required aria-describedby="nameLabel" data-msg="Enter Basic Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="whats-included-basic">
                                        <div class="form-group">
                                            <label class="form-label">{{ translate('What is included section') }}</label>
                                            <div class="row gutters-5">
                                                <div class="col">
                                                    <div class="form-group d-flex">
                                                        <input id="include_description" type="text" class="form-control" placeholder="" name="basic_included_description[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-soft-secondary btn-sm"
                                        data-toggle="add-more"
                                        data-content='<div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group d-flex">
                                                    <input id="include_description" type="text" class="form-control" placeholder="" name="basic_included_description[]">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>'
                                        data-target=".whats-included-basic">
                                        {{ translate('Add New') }}
                                    </button>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <h5 class="mt-3">{{ translate('Standard Package') }}</h5>
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Price') }}</label>
                                        <input type="text" class="form-control " name="standard_price" placeholder="{{ translate('Enter Price') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Devilery Within') }}</label>
                                        <input type="text" class="form-control " name="standard_delivery_time" placeholder="{{ translate('Enter Delivery Time') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Revision Limit') }}</label>
                                        <input type="text" class="form-control " name="standard_revision_limit" placeholder="{{ translate('Enter Revision Limit') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="whats-included-standard">
                                        <div class="form-group">
                                            <label class="form-label">{{ translate('What is included section') }}</label>
                                            <div class="row gutters-5">
                                                <div class="col">
                                                    <div class="form-group d-flex">
                                                        <input id="include_description" type="text" class="form-control" placeholder="" name="standard_included_description[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-soft-secondary btn-sm"
                                        data-toggle="add-more"
                                        data-content='<div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group d-flex">
                                                    <input id="include_description" type="text" class="form-control" placeholder="" name="standard_included_description[]">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>'
                                        data-target=".whats-included-standard">
                                        {{ translate('Add New') }}
                                    </button>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <h5 class="mt-3">{{ translate('PREMIUM Package') }}</h5>
                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Price') }}</label>
                                        <input type="text" class="form-control " name="premium_price" placeholder="{{ translate('Enter Price') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Devilery Within') }}</label>
                                        <input type="text" class="form-control " name="premium_delivery_time" placeholder="{{ translate('Enter Delivery Time') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">{{ translate('Revision Limit') }}</label>
                                        <input type="text" class="form-control " name="premium_revision_limit" placeholder="{{ translate('Enter Revision Limit') }}" aria-label="Enter Standard Package Price" required aria-describedby="nameLabel" data-msg="Enter Standard Package Price" data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>

                                    <div class="whats-included-premium">
                                        <div class="form-group">
                                            <label class="form-label">{{ translate('What is included section') }}</label>
                                            <div class="row gutters-5">
                                                <div class="col">
                                                    <div class="form-group d-flex">
                                                        <input id="include_description" type="text" class="form-control" placeholder="" name="premium_included_description[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-soft-secondary btn-sm"
                                        data-toggle="add-more"
                                        data-content='<div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group d-flex">
                                                    <input id="include_description" type="text" class="form-control" placeholder="" name="premium_included_description[]">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>'
                                        data-target=".whats-included-premium">
                                        {{ translate('Add New') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary transition-3d-hover mr-1">{{ translate('Post Service') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="aiz-pagination aiz-pagination-center">

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

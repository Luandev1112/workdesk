@extends('frontend.default.layouts.app')

@section('content')
<div class="h-250px">
    @if ($freelancer->cover_photo != null)
        <img src="{{ custom_asset($freelancer->cover_photo) }}" alt="{{ $freelancer->name }}"class="img-fit h-250px">
    @else
        <img src="{{ my_asset('assets/frontend/default/img/cover-place.jpg') }}" alt="{{ $freelancer->name }}"class="img-fit h-250px">
    @endif
</div>
<div class="mt-n5">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="media align-items-center d-block d-md-flex">
                    <div class="mr-5 text-center text-md-left mb-4 mb-md-0">
                        <span class="avatar avatar-xxl">
                            @if($freelancer->photo != null)
                                <img src="{{ custom_asset($freelancer->photo) }}">
                            @else
                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                            @endif
                            @if(Cache::has('user-is-online-' . $freelancer->id))
                                <span class="badge badge-dot badge-circle badge-success badge-status badge-md"></span>
                            @else
                                <span class="badge badge-dot badge-circle badge-secondary badge-status badge-md"></span>
                            @endif
                        </span>
                    </div>
                    <div class="media-body d-lg-flex justify-content-between align-items-center">
                        <div class="mr-3 mb-4 mb-lg-0 text-center text-md-left">
                            <h1 class="h5 mb-1 fw-700">{{ $freelancer->name }}</h1>
                            <p class="opacity-60">{{ $freelancer->profile->specialist }}</p>

                            <div class="d-flex justify-content-center justify-content-md-between text-secondary fs-12 mb-3">
                                <div class="mr-2">
                                    <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                        {{ formatRating(getAverageRating($freelancer->id)) }}
                                    </span>
                                    <span class="rating rating-sm">
                                        {{ renderStarRating(getAverageRating($freelancer->id)) }}
                                    </span>
                                    <span>
                                        ({{ getNumberOfReview($freelancer->id) }} Reviews)
                                    </span>
                                </div>
                                <div>
                                    <i class="las la-map-marker opacity-50"></i>
                                      @if($freelancer->address != null && $freelancer->address->city != null && $freelancer->address->country != null)
                                          <span>{{ $freelancer->address->city->name }}, {{ $freelancer->address->country->name }}</span>
                                      @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-lg-right d-flex justify-content-between align-items-end d-lg-block">
                            <div class="mb-lg-4">
                                <h4 class="mb-0">{{ single_price($freelancer->profile->hourly_rate) }}</h4>
                                <div class="small text-secondary">
                                    <span>per Hour</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container space-2">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-dark h5 mb-0">{{ translate('Send invitation for a private project') }}</h2>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('invition_for_hire_freelancer_sent') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">
                            <div class="form-group">
                                <label class="form-label">
                                    Project title
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control " name="name" placeholder="Enter project title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label mb-2">
                                    Project type
                                    <span class="text-danger">*</span>
                                </div>
                                @if ($client_package->fixed_limit > 0)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="projectTypeFixed" name="projectType" class="custom-control-input" value="Fixed" checked>
                                        <label class="custom-control-label" for="projectTypeFixed">Fixed</label>
                                    </div>
                                @else
                                    <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                        {{ translate('Your fixed type project post limit is over.') }}
                                    </div>
                                @endif
                                @if ($client_package->long_term_limit > 0)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="projectTypeLong" name="projectType" class="custom-control-input" value="Long Term">
                                        <label class="custom-control-label" for="projectTypeLong">Long term</label>
                                    </div>
                                @else
                                    <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                        {{ translate('Your long term project post limit is over.') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Project budget offer
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="number" min="0" step="0.01" class="form-control " name="price" placeholder="Enter project budget" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    Project category
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control aiz-selectpicker" data-live-search="true" id="category_id" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label >
                                    Project summary
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" rows="3" name="excerpt" required></textarea>
                            </div>
                            <div class="form-group u-summernote-editor">
                                <label>
                                    Project Details
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control aiz-text-editor" data-height="300" rows="3" name="description" required data-toolbar='[
                                    ["style", ["style"]],
                                    ["font", ["bold", "underline", "clear"]],
                                    ["fontsize", ["fontsize"]],
                                    ["para", ["ul", "ol", "paragraph"]]
                                ]'>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signinSrEmail">File attachment</label>
                                <div class="input-group" data-toggle="aizuploader" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="attachment" class="selected-files">
                                </div>
                                <div class="file-preview box"></div>
                            </div>
                            @if ($client_package->long_term_limit > 0|| $client_package->fixed_limit > 0)
                                <button type="submit" class="btn btn-primary transition-3d-hover mr-1">Send Invitation</button>
                            @else
                                <div class="alert alert-info custom-control-inline mb-0" role="alert">
                                    {{ translate('Upgrade your Package.') }}
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content Section -->
@endsection

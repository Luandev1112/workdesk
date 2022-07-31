@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('Create New Package')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('package.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Package Name')}}</label>
                            <input type="text" id="name" name="name" required placeholder="{{ translate('Eg. Bronze Package') }}" class="form-control">
                        </div>
                        <input type="hidden" id="type" name="type" value="freelancer" class="form-control">
                        <div class="form-group mb-3">
                            <label for="price">{{translate('Price')}}</label>
                            <input type="number" min="0" step="0.01" id="price" name="price" required placeholder="{{ translate('Eg. 25') }}" class="form-control">
                            <small class="form-text text-muted">{{ translate('Use 0 for free package') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Badge')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="badge" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Icon')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photo" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="number_of_days">{{translate('Validate For')}}</label>
                            <input type="number" min="0" step="1" id="number_of_days" name="number_of_days" required placeholder="{{ translate('Eg. 30') }}" class="form-control">
                            <small class="form-text text-muted">{{ translate('Number in days. Use 0 for life time') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="commission">{{translate('Commision')}}</label>
                            <input type="number" min="1" step="1" id="commission" name="commission" required placeholder="{{ translate('Eg. 5') }}" class="form-control">
                            <small class="form-text text-muted">{{ translate('Amount will be deducted from project payment. Use 0 for no deduction') }}</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="commission_type">{{translate('Commision Type')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="commission_type" id="commission_type" data-toggle="select2" data-placeholder="Choose ...">
                                <option value="percent">{{ translate('Percent') }}</option>
                                <option value="amount">{{ translate('Flat Rate') }}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fixed_limit">{{translate('Bid Limitation for Fixed Projects')}}</label>
                            <input type="number" min="0" step="1" id="fixed_limit" name="fixed_limit" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="long_term_limit">{{translate('Bid Limitation for Long Term Projects')}}</label>
                            <input type="number" min="0" step="1" id="long_term_limit" name="long_term_limit" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="skill_add_limit">{{translate('Skill Adding Limit')}}</label>
                            <input type="number" min="0" step="1" id="skill_add_limit" name="skill_add_limit" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="portfolio_add_limit">{{translate('Portfolio Adding Limit')}}</label>
                            <input type="number" min="0" step="1" id="portfolio_add_limit" name="portfolio_add_limit" required placeholder="{{ translate('Eg. 10') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bio_text_limit">{{translate('Bio Word Limit')}}</label>
                            <input type="number" min="0" step="1" id="bio_text_limit" name="bio_text_limit" required placeholder="{{ translate('Eg. 120') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="project_bookmark_limit">{{translate('Project Bookmark Limit')}}</label>
                            <input type="number" min="0" step="1" id="project_bookmark_limit" name="project_bookmark_limit" required placeholder="{{ translate('Eg. 8') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="job_experience_limit">{{translate('Job Experience Limit')}}</label>
                            <input type="number" min="0" step="1" id="job_experience_limit" name="job_experience_limit" required placeholder="{{ translate('Eg. 2') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="service_limit">{{translate('Service Limit')}}</label>
                            <input type="number" min="0" step="1" id="service_limit" name="service_limit" required placeholder="{{ translate('Eg. 5') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Enable Client Following ?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" checked="checked" name="following_status">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Recommended ?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" checked="checked" name="recommended">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Publish Package?')}}</label>
                            <div>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" checked="checked" name="active">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Create New Package')}}</button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
@endsection

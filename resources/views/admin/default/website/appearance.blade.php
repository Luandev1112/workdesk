@extends('admin.default.layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-8 mx-auto">
		<div class="card">
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('General') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('general-config.store') }}" method="POST">
					@csrf
					<div class="form-group">
	                    <label for="types">{{translate('Frontend Website Name')}}</label>
	                    <input type="text" name="website_name" class="form-control" placeholder="Workdesk" value="{{ get_setting('website_name') }}">
	                </div>
	                <div class="form-group">
	                    <label for="types">{{translate('Site Motto')}}</label>
	                    <input type="text" name="site_motto" class="form-control" placeholder="Best Freelance Marketplace" value="{{  get_setting('site_motto') }}">
	                </div>
					<div class="form-group">
						<label class="form-label" for="signinSrEmail">{{ translate('Site Icon') }}</label>
						<div class="input-group " data-toggle="aizuploader" data-type="image">
							<div class="input-group-prepend">
								<div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
							</div>
							<div class="form-control file-amount">{{ translate('Choose File') }}</div>
							<input type="hidden" name="site_icon" value="{{ get_setting('site_icon') }}" class="selected-files">
						</div>
						<div class="file-preview box"></div>
						<small class="text-muted">{{ translate('Website favicon. 32x32 .png') }}</small>
					</div>
	                <div class="form-group">
	                    <label for="types">{{translate('Website Base Color')}}</label>
	                    <input type="text" name="base_color" class="form-control" placeholder="#377dff" value="{{ get_setting('base_color') }}">
						<small class="text-muted">{{ translate('Hex Color Code') }}</small>
	                </div>
	                <div class="form-group">
	                    <label for="types">{{translate('Website Base Hover Color')}}</label>
	                    <input type="text" name="base_hov_color" class="form-control" placeholder="#377dff" value="{{  get_setting('base_hov_color') }}">
						<small class="text-muted">{{ translate('Hex Color Code') }}</small>
	                </div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
                </form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Global Seo') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Meta Title') }}</label>
						<input type="hidden" name="types[]" value="meta_title">
						<input type="text" class="form-control" placeholder="Title" name="meta_title" value="{{ get_setting('meta_title') }}">
					</div>
					<div class="form-group">
						<label>{{ translate('Meta description') }}</label>
						<input type="hidden" name="types[]" value="meta_description">
						<textarea class="resize-off form-control" placeholder="Description" name="meta_description">{{  get_setting('meta_description') }}</textarea>
					</div>
					<div class="form-group">
						<label>{{ translate('Keywords') }}</label>
						<input type="hidden" name="types[]" value="meta_keywords">
						<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="meta_keywords">{{ get_setting('meta_keywords') }}</textarea>
						<small class="text-muted">{{ translate('Separate with coma') }}</small>
					</div>
					<div class="form-group">
						<label class="form-label" for="signinSrEmail">{{ translate('Meta Image') }}</label>
						<div class="input-group " data-toggle="aizuploader" data-type="image">
							<div class="input-group-prepend">
								<div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
							</div>
							<div class="form-control file-amount">{{ translate('Choose File') }}</div>
							<input type="hidden" name="types[]" value="meta_image">
							<input type="hidden" name="meta_image" value="{{ get_setting('meta_image') }}" class="selected-files">
						</div>
						<div class="file-preview box"></div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Website Home') }}</h1>
		</div>
	</div>
</div>
<div class="">

	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Sliders Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="slider_section_show">
						<input type="checkbox" name="slider_section_show" @if( App\Models\SystemConfiguration::where('type', 'slider_section_show')->first()->value == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>Title</label>
					<input type="hidden" name="types[]" value="slider_section_title">
					<input type="text" class="form-control" placeholder="title" value="{{ App\Models\SystemConfiguration::where('type', 'slider_section_title')->first()->value }}" name="slider_section_title">
				</div>
				<div class="form-group">
					<label>Sub title</label>
					<input type="hidden" name="types[]" value="slider_section_subtitle">
					<textarea class="aiz-text-editor form-control" data-buttons='[["font", ["bold", "underline", "italic"]],["insert", ["link"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150"
					name="slider_section_subtitle">
						@php
							echo App\Models\SystemConfiguration::where('type', 'slider_section_subtitle')->first()->value
						@endphp
					</textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="signinSrEmail">{{ translate('Slider Images') }} <small class="text-muted">({{ translate('Recommended size') }} 1920x1080)</small></label>
					<div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
						</div>
						<div class="form-control file-amount">{{ translate('Choose Files') }}</div>
						<input type="hidden" name="types[]" value="sliders">
						<input type="hidden" name="sliders" value="{{ App\Models\SystemConfiguration::where('type', 'sliders')->first()->value }}" class="selected-files">
					</div>
					<div class="file-preview box"></div>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Clients Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="client_logo_show">
						<input type="checkbox" name="client_logo_show" @if( App\Models\SystemConfiguration::where('type', 'client_logo_show')->first()->value == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="form-label" for="signinSrEmail">{{ translate('Clients Logos') }} <small class="text-muted">({{ translate('Recommended size') }} 190x80)</small></label>
					<div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
						</div>
						<div class="form-control file-amount">{{ translate('Choose Files') }}</div>
						<input type="hidden" name="types[]" value="client_logos">
						<input type="hidden" name="client_logos" value="{{ App\Models\SystemConfiguration::where('type', 'client_logos')->first()->value }}" class="selected-files">
					</div>
					<div class="file-preview box sm"></div>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('How it Works Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="how_it_works_show">
						<input type="checkbox"  name="how_it_works_show"  @if( App\Models\SystemConfiguration::where('type', 'how_it_works_show')->first()->value == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>{{ translate('Title') }}</label>
					<input type="hidden" name="types[]" value="how_it_works_title">
					<input type="text" class="form-control" placeholder="title" name="how_it_works_title" value="{{ App\Models\SystemConfiguration::where('type', 'how_it_works_title')->first()->value }}">
				</div>
				<div class="form-group">
					<label>{{ translate('Sub title') }}</label>
					<input type="hidden" name="types[]" value="how_it_works_subtitle">
					<textarea class="form-control resize-off" placeholder="Type.." name="how_it_works_subtitle">@php
							echo get_setting('how_it_works_subtitle');
						@endphp
					</textarea>
				</div>
				<div class="card bg-light shadow-none">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Step 1') }}</h6>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-label">{{ translate('Image') }}</label>
							<div class="input-group" data-toggle="aizuploader" data-type="image">
								<div class="input-group-prepend">
									<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
								</div>
								<div class="form-control file-amount">{{ translate('Choose File') }}</div>
								<input type="hidden" name="types[]" value="how_it_works_banner_1">
								<input type="hidden" name="how_it_works_banner_1" value="{{ get_setting('how_it_works_banner_1') }}" class="selected-files">
							</div>
							<div class="file-preview"></div>
						</div>
						<div class="form-group">
							<label>{{ translate('About description') }}</label>
							<input type="hidden" name="types[]" value="how_it_works_description_1">
							<textarea class="aiz-text-editor form-control" name="how_it_works_description_1" placeholder="Type.." data-min-height="150">
								@php
									echo get_setting('how_it_works_description_1');
								@endphp
							</textarea>
						</div>
					</div>
				</div>
				<div class="card bg-light shadow-none">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Step 2') }}</h6>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-label">{{ translate('Image') }}</label>
							<div class="input-group" data-toggle="aizuploader" data-type="image">
								<div class="input-group-prepend">
									<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
								</div>
								<div class="form-control file-amount">{{ translate('Choose File') }}</div>
								<input type="hidden" name="types[]" value="how_it_works_banner_2">
								<input type="hidden" name="how_it_works_banner_2" value="{{ get_setting('how_it_works_banner_2') }}" class="selected-files">
							</div>
							<div class="file-preview box"></div>
						</div>
						<div class="form-group">
							<label>{{ translate('About description') }}</label>
							<input type="hidden" name="types[]" value="how_it_works_description_2">
							<textarea class="aiz-text-editor form-control" name="how_it_works_description_2" placeholder="Type.." data-min-height="150">
								@php
									echo get_setting('how_it_works_description_2');
								@endphp
							</textarea>
						</div>
					</div>
				</div>
				<div class="card bg-light shadow-none">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Step 3') }}</h6>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-label">{{ translate('Image') }}</label>
							<div class="input-group" data-toggle="aizuploader" data-type="image">
								<div class="input-group-prepend">
									<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
								</div>
								<div class="form-control file-amount">{{ translate('Choose File') }}</div>
								<input type="hidden" name="types[]" value="how_it_works_banner_3">
								<input type="hidden" name="how_it_works_banner_3" value="{{ get_setting('how_it_works_banner_3') }}" class="selected-files">
							</div>
							<div class="file-preview box"></div>
						</div>
						<div class="form-group">
							<label>{{ translate('About description') }}</label>
							<input type="hidden" name="types[]" value="how_it_works_description_3">
							<textarea class="aiz-text-editor form-control" name="how_it_works_description_3" placeholder="Type.." data-min-height="150">
								@php
									echo get_setting('how_it_works_description_3');
								@endphp
							</textarea>
						</div>
					</div>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Latest Project Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="latest_project_show">
						<input type="checkbox"  name="latest_project_show"  @if( get_setting('latest_project_show') == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>{{ translate('Title') }}</label>
					<input type="hidden" name="types[]" value="latest_project_title">
					<input type="text" class="form-control" placeholder="title" name="latest_project_title" value="{{ App\Models\SystemConfiguration::where('type', 'latest_project_title')->first()->value }}">
				</div>
				<div class="form-group">
					<label>{{ translate('Sub title') }}</label>
					<input type="hidden" name="types[]" value="latest_project_subtitle">
					<textarea class="form-control resize-off" placeholder="Type.." name="latest_project_subtitle">@php
							echo get_setting('latest_project_subtitle');
						@endphp
					</textarea>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Featured Category Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="featured_category_show">
						<input type="checkbox"  name="featured_category_show"  @if( App\Models\SystemConfiguration::where('type', 'featured_category_show')->first()->value == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>{{ translate('Title') }}</label>
					<input type="hidden" name="types[]" value="featured_category_title">
					<input type="text" class="form-control" placeholder="title" name="featured_category_title" value="{{ App\Models\SystemConfiguration::where('type', 'featured_category_title')->first()->value }}">
				</div>
				<div class="form-group">
					<label>{{ translate('Sub title') }}</label>
					<input type="hidden" name="types[]" value="featured_category_subtitle">
					<textarea class="form-control resize-off" placeholder="Type.." name="featured_category_subtitle">@php
							echo get_setting('featured_category_subtitle');
						@endphp</textarea>
				</div>
				<div class="form-group">
					<label>{{ translate('Select Categories') }}</label>
					<input type="hidden" name="types[]" value="featured_category_list">
					<select class="form-control aiz-selectpicker" multiple name="featured_category_list[]" data-live-search="true" data-selected-text-format="count">
						@php $featured_category_list = json_decode(get_setting('featured_category_list'), true); @endphp 
						@foreach (App\Models\ProjectCategory::latest()->get() as $key => $value)
							<option value="{{ $value->id }}" @if(is_array($featured_category_list) && in_array($value->id,$featured_category_list)) selected @endif>{{ $value->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label class="form-label">{{ translate('Left Banner') }}</label>
					<div class="input-group" data-toggle="aizuploader" data-type="image">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
						</div>
						<div class="form-control file-amount">{{ translate('Choose File') }}</div>
						<input type="hidden" name="types[]" value="featured_category_left_banner">
						<input type="hidden" name="featured_category_left_banner" value="{{ App\Models\SystemConfiguration::where('type', 'featured_category_left_banner')->first()->value }}" class="selected-files">
					</div>
					@php
						$value = App\Models\SystemConfiguration::where('type', 'featured_category_left_banner')->first()->value;
					@endphp
					<div class="file-preview box"></div>
				</div>
				<div class="form-group">
					<label class="form-label">{{ translate('Right Banner') }}</label>
					<div class="input-group" data-toggle="aizuploader" data-type="image">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary ">{{ translate('Browse') }}</div>
						</div>
						<div class="form-control file-amount">{{ translate('Choose File') }}</div>
						<input type="hidden" name="types[]" value="featured_category_right_banner">
						<input type="hidden" name="featured_category_right_banner" value="{{ App\Models\SystemConfiguration::where('type', 'featured_category_right_banner')->first()->value }}" class="selected-files">
					</div>
					<div class="file-preview box"></div>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('CTA Section') }}</h6>
				<div>
					<label class="aiz-switch mb-0">
						<input type="hidden" name="types[]" value="cta_section_show">
						<input type="checkbox"  name="cta_section_show" @if(App\Models\SystemConfiguration::where('type', 'cta_section_show')->first()->value == 'on') checked @endif>
						<span></span>
					</label>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>{{ translate('Title') }}</label>
					<input type="hidden" name="types[]" value="cta_section_title">
					<input type="text" class="form-control" placeholder="title" name="cta_section_title" value="{{ App\Models\SystemConfiguration::where('type', 'cta_section_title')->first()->value }}">
				</div>
				<div class="form-group">
					<label>{{ translate('Sub title') }}</label>
					<input type="hidden" name="types[]" value="cta_section_subtitle">
					<textarea class="form-control resize-off" placeholder="Type.." name="cta_section_subtitle">@php
							echo App\Models\SystemConfiguration::where('type', 'cta_section_subtitle')->first()->value;
						@endphp</textarea>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>

	<div class="card">
		<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ translate('Seo Fields') }}</h6>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>{{ translate('Meta Title') }}</label>
					<input type="hidden" name="types[]" value="meta_title">
					<input type="text" class="form-control" placeholder="Title" name="meta_title" value="{{ App\Models\SystemConfiguration::where('type', 'meta_title')->first()->value }}">
				</div>
				<div class="form-group">
					<label>{{ translate('Meta description') }}</label>
					<input type="hidden" name="types[]" value="meta_description">
					<textarea class="resize-off form-control" placeholder="Description" name="meta_description">@php
							echo App\Models\SystemConfiguration::where('type', 'meta_description')->first()->value;
						@endphp</textarea>
				</div>
				<div class="form-group">
					<label>Keywords</label>
					<input type="hidden" name="types[]" value="meta_keywords">
					<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="meta_keywords">@php
							echo App\Models\SystemConfiguration::where('type', 'meta_keywords')->first()->value;
						@endphp</textarea>
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
						<input type="hidden" name="meta_image" value="{{ App\Models\SystemConfiguration::where('type', 'meta_image')->first()->value }}" class="selected-files">
					</div>
					<div class="file-preview box"></div>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
				</div>
			</div>
		</form>
	</div>

</div>
@endsection

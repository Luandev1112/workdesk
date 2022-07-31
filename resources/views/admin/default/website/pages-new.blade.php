@extends('admin.default.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Add New Page') }}</h1>
		</div>
	</div>
</div>
<div class="card">
	<form action="{{ route('custom-pages.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card-header">
			<h6 class="fw-600 mb-0">{{ translate('Page Content') }}</h6>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label>{{ translate('Title') }}</label>
				<input type="text" class="form-control" placeholder="Title" name="title">
			</div>
			<div class="form-group ">
				<label>{{ translate('Link') }}</label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">{{ route('home') }}/</span></div>
					<input type="text" class="form-control" placeholder="page-title" name="slug">
				</div>
				<small class="form-text text-muted">{{ translate('Use character, number, hypen only') }}</small>
			</div>
			<div class="form-group">
				<label>{{ translate('Add Content') }}</label>
				<textarea class="aiz-text-editor form-control" placeholder="Content.." data-min-height="400" name="content"></textarea>
			</div>
		</div>

		<div class="card-header">
			<h6 class="fw-600 mb-0">{{ translate('Seo Fields') }}</h6>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label>{{ translate('Meta Title') }}</label>
				<input type="text" class="form-control" placeholder="Title" name="meta_title">
			</div>
			<div class="form-group">
				<label>{{ translate('Meta description') }}</label>
				<textarea class="resize-off form-control" placeholder="Description" name="meta_description"></textarea>
			</div>
			<div class="form-group">
				<label>{{ translate('Keywords') }}</label>
				<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="keywords"></textarea>
				<small class="text-muted">{{ translate('Separate with coma') }}</small>
			</div>
			<div class="form-group">
                <label class="form-label" for="signinSrEmail">{{ translate('Meta Image') }}</label>
                <div class="input-group " data-toggle="aizuploader" data-type="image">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                    </div>
                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                    <input type="hidden" name="meta_image" class="selected-files">
                </div>
                <div class="file-preview"></div>
            </div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary">{{ translate('Add Page') }}</button>
			</div>
		</div>
	</form>
</div>
@endsection

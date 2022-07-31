@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Website Header') }}</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Header Setting') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('system_configuration.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
	                    <label class="form-label" for="signinSrEmail">{{ translate('Header Logo') }}</label>
	                    <div class="input-group " data-toggle="aizuploader" data-type="image">
	                        <div class="input-group-prepend">
	                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
	                        </div>
	                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
							<input type="hidden" name="types[]" value="header_logo">
	                        <input type="hidden" name="header_logo" class="selected-files" value="{{ App\Models\SystemConfiguration::where('type', 'header_logo')->first()->value }}">
	                    </div>
	                    <div class="file-preview"></div>
	                </div>
	                <div class="form-group">
						<label>{{ translate('Enable stikcy header?') }}</label>
						<div>
							<label class="aiz-switch mb-0">
								<input type="hidden" name="types[]" value="header_stikcy">
								<input type="checkbox" name="header_stikcy" @if( App\Models\SystemConfiguration::where('type', 'header_stikcy')->first()->value == 'on') checked @endif>
								<span></span>
							</label>
						</div>
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

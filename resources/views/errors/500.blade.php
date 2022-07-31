@extends('frontend.default.layouts.app')

@section('content')
<section class="pt-7 pb-6">
	<div class="container text-center">
		<div class="row">
			<div class="col-lg-6 mx-auto">
				<h1 class="display-1 fw-700 text-danger">{{ translate('500') }}</h1>
				<h2 class="h1 fw-600">{{ translate('Internal Server Error') }}.</h2>
				<p class="lead mb-5">{{ translate('We\'re experinecing an internal server problem') }}.<br>{{ translate('Please try again later') }}.</p>
				<a href="{{route('home')}}" class="btn btn-primary mb-5">
					<i class="la la-arrow-left mr-2"></i>
					<span>{{ translate('Back to Homepage') }}</span>
				</a>
				<img src="{{ my_asset('assets/frontend/default/img/500.svg') }}" class="img-fluid w-75">
			</div>
		</div>
	</div>
</section>
@endsection

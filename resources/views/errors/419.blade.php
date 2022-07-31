@extends('frontend.default.layouts.app')

@section('content')
<section class="pt-7 pb-6">
	<div class="container text-center">
		<div class="row">
			<div class="col-lg-6 mx-auto text-center">
				<img src="{{ my_asset('assets/frontend/default/img/419.svg') }}" class="mx-auto mw-100 mb-5" height="180">
				<h1 class="fw-700">{{ translate('Your session has expired') }}</h1>
				<p class="lead mb-5">{{ translate('Please refresh the page') }}</p>
				<a href="{{route('home')}}" class="btn btn-primary mb-5">
					<i class="la la-arrow-left mr-2"></i>
					<span>{{ translate('Back to Homepage') }}</span>
				</a>
			</div>
		</div>
	</div>
</section>
@endsection

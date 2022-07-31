@extends('frontend.default.layouts.app')

@section('content')
<section class="pt-7 pb-6">
	<div class="container text-center">
		<div class="row">
			<div class="col-lg-6 mx-auto">
				<img src="{{ my_asset('assets/frontend/default/img/404.svg') }}" class="img-fluid mb-5 w-75">
				<h1 class="display-1 fw-700 text-danger">{{ translate('404') }}</h1>
				<h2 class="h1 fw-600">{{ translate('Looks like you\'re lost') }}.</h2>
				<p class="lead mb-5">{{ translate('The page you\'re looking for is not available') }}</p>
				<a href="{{route('home')}}" class="btn btn-primary">
					<i class="la la-arrow-left mr-2"></i>
					<span>{{ translate('Back to Homepage') }}</span>
				</a>
			</div>
		</div>
	</div>
</section>
@endsection

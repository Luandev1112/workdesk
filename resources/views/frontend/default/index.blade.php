@extends('frontend.default.layouts.app')

@section('content')
    @if ( get_setting('slider_section_show') == 'on')
        <section class="position-relative py-10 overflow-hidden">
        	<div class="absolute-full">
    			<div class="aiz-carousel aiz-carousel-full h-100" data-fade='true' data-infinite='true' data-autoplay='true'>
    				@if (get_setting('sliders') != null)
                        @foreach (explode(',', get_setting('sliders')) as $key => $value)
                            <img class="img-fit" src="{{ custom_asset($value) }}">
                        @endforeach
                    @endif
    			</div>
        	</div>
        	<div class="container">
        		<div class="row">
        			<div class="col-xl-6 col-lg-8">
    		    		<h1 class="fw-700 mb-3 display-4">{{ get_setting('slider_section_title') }}</h1>
    		    		<p class="lead mb-5">
                            @php
                                echo get_setting('slider_section_subtitle');
                            @endphp
                        </p>
    		    		<div>
    		    			<a href="{{ route('register') }}" class="btn btn-primary">{{ translate('I want to Hire') }}</a>
    		    			<a href="{{ route('register') }}" class="btn btn-outline-primary">{{ translate('I want to Work') }}</a>
    		    		</div>
        			</div>
        		</div>
        	</div>
        </section>
    @endif
    @if( get_setting('client_logo_show') == 'on')
        <section class="py-4 bg-white border-bottom">
        	<div class="container">
        		<div class="row align-items-center">
    				<div class="aiz-carousel gutters-5" data-autoplay='true' data-items="7" data-xl-items="6" data-lg-items="5" data-md-items="4" data-sm-items="3" data-xs-items="2" data-infinite='true'>
                        @if (get_setting('client_logos') != null)
                            @foreach (explode(',', get_setting('client_logos')) as $key => $value)
                                <div class="caorusel-box">
            						<img class="img-fluid" src="{{ custom_asset($value) }}">
            					</div>
                            @endforeach
                        @endif
    				</div>
        		</div>
        	</div>
        </section>
    @endif
    @if( get_setting('how_it_works_show') == 'on')
        <section class="pt-7 pb-4 bg-white">
    	<div class="container">
    		<div class="text-center mb-5 w-xl-50 w-lg-75 mx-auto">
    			<h2 class="fw-700">{{ get_setting('how_it_works_title') }}</h2>
    			<p class="fs-15 text-secondary">{{ get_setting('how_it_works_subtitle') }}</p>
    		</div>
    		<div class="row justify-content-center">
    			<div class="col-xl-4 col-md-6">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_1') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
    						@php
                                echo get_setting('how_it_works_description_1')
                            @endphp
    					</div>
    				</div>
    			</div>
    			<div class="col-xl-4 col-md-6">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_2') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
                            @php
                                echo get_setting('how_it_works_description_2')
                            @endphp
    					</div>
    				</div>
    			</div>
    			<div class="col-xl-4 col-md-6">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_3') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
                            @php
                                echo get_setting('how_it_works_description_3')
                            @endphp
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
    @endif
    @if( get_setting('latest_project_show') == 'on')
        <section class="py-7">
    	<div class="container">
    		<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto">
    			<h2 class="fw-700">{{ get_setting('latest_project_title') }}</h2>
    			<p class="fs-15 text-secondary">{{ get_setting('latest_project_subtitle') }}</p>
    		</div>
    		<div class="row">
    			<div class="col-xl-10 mx-auto">
                    @if(\App\Models\SystemConfiguration::where('type', 'project_approval')->first()->value == 1)
                        @php $projects = \App\Models\Project::biddable()->notcancel()->open()->where('project_approval', 1)->latest()->get()->take(3); @endphp
                    @else
                        @php $projects = \App\Models\Project::biddable()->notcancel()->open()->latest()->get()->take(3); @endphp
                    @endif
    				@foreach ($projects as $key => $project)
                        <a href="{{ route('project.details', $project->slug )}}" class="d-block card-project card p-4 text-inherit mb-0">
        					<div class="row">
                                <div class="col-8">
                                    <h5 class="h6 fw-600 lh-1-5">
                                        {{ $project->name }}
                                    </h5>
                                    <ul class="list-inline opacity-70 fs-12 mb-0">
                                        <li class="list-inline-item">
                                            <i class="las la-clock opacity-40"></i>
                                            <span>{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="las la-stream opacity-40"></i>
                                            <span>{{ $project->project_category->name }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="las la-handshake"></i>
                                            <span>{{ $project->type }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="h5">{{ single_price($project->price) }}</span>
                                </div>
                            </div>
        				</a>
                    @endforeach
    			</div>
    		</div>
    		<div class="text-center pt-5">
    			<a href="{{ route('search') }}?keyword=&type=project" class="btn btn btn-outline-primary">{{ translate('Check All Projects') }}</a>
    		</div>
    	</div>
    </section>
    @endif
    @if ( get_setting('featured_category_show') == 'on')
        <section class="pt-7 pb-5 bg-white">
        	<div class="container">
        		<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto">
        			<h2 class="fw-700">{{ get_setting('featured_category_title') }}</h2>
        			<p class="fs-15 text-secondary">{{ get_setting('featured_category_subtitle') }}</p>
        		</div>
        		<div class="row gutters-10">
        			@if (get_setting('featured_category_list') != null)
                        @foreach (json_decode(get_setting('featured_category_list'), true) as $key => $category_id)
                            @if (($category = \App\Models\ProjectCategory::find($category_id)) != null)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    				<a class="text-center py-3 px-2 d-block card text-inherit shadow-none bg-light" href="{{ route('projects.category', $category->slug) }}">
                    					<img src="{{ custom_asset($category->photo) }}" class="mw-100 h-50px mb-2">
                    					<p class="mb-0 text-truncate">{{ $category->name }}</p>
                    				</a>
                    			</div>
                            @endif
                        @endforeach
                    @endif
        		</div>
        		<div class="row mt-5 gutters-10">
        			<div class="col-lg-6">
        				<img src="{{ custom_asset( get_setting('featured_category_left_banner') ) }}" class="img-fluid">
        			</div>
        			<div class="col-lg-6">
        				<img src="{{ custom_asset( get_setting('featured_category_right_banner')) }}" class="img-fluid">
        			</div>
        		</div>
        	</div>
        </section>
    @endif
    @if ( get_setting('cta_section_show') == 'on')
        <section class="py-8">
        	<div class="container">
        		<div class="row">
    	    		<div class="col-xl-6 col-md-8 mx-auto">
    	    			<div class="text-center">
    		    			<h2 class="fw-700 mb-2">{{ get_setting('cta_section_title') }}</h2>
    		    			<p class="fs-15 opacity-70 mb-4">{{ get_setting('cta_section_subtitle') }}</p>
    	    				<a href="{{ route('register') }}" class="btn btn-primary">{{ translate('Join With Us') }}</a>
    	    			</div>
    	    		</div>
        		</div>
        	</div>
        </section>
    @endif
@endsection

@section('modal')
	@if((Session::has('new_user') && Session::get('new_user') == true) || (auth()->check() && auth()->user()->user_type == null))
		<div class="modal fade" id="show_new_user_modal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">{{ translate('Choose your account Type') }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="show_modal_body">
						<form action="{{ route('user.account.type') }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="user_type">User Type</label>
								<select name="user_type" id="user_type" class="form-control aiz-selectpicker">
									<option value="client">Client</option>
									<option value="freelancer">Freelancer</option>
								</select>
							</div>

							<div class="form-group text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Proceed') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

@section('script')
	<script>
		@if((Session::has('new_user') && Session::get('new_user') == true) || (auth()->check() && auth()->user()->user_type == null))
			$('#show_new_user_modal').modal({show:true});
		@endif
	</script>
@endsection

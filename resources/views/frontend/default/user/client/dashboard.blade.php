@extends('frontend.default.layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.client.inc.sidebar')
            <div class="aiz-user-panel">
            	<div class="mb-3">
                    @php
                        $verification = \App\Models\Verification::where('user_id', Auth::user()->id)->where('type', 'identity_verification')->first();
                    @endphp
            		@if ($verification == null || !$verification->verified)
                        <div class="alert alert-danger">
    						{{ translate('Please verify your identity') }}. <a href="{{ route('user.profile') }}" class="alert-link">{{ translate('Verify Now') }}</a>
    					</div>
                    @endif
                    @if (Auth::user()->email_verified_at == null)
                        <div class="alert alert-danger">
                            {{ translate('Please verify your Email') }}. <a href="{{ route('user.profile') }}" class="alert-link">{{ translate('Verify Now') }}</a>
                        </div>
                    @endif
                    @if(Auth::user()->userPackage->package_invalid_at != null && Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->userPackage->package_invalid_at), false) < 8)
                        <div class="alert alert-danger">
    						{{ translate('Please renew/upgrade your package. Your current package will expire soon') }}. <a href="{{ route('select_package') }}" class="alert-link">{{ translate('Upgrade Now') }}</a>
    					</div>
                    @endif
            	</div>
            	<div class="row gutters-10">
            		<div class="col-md-8">
            			<div class="card">
            				<div class="card-body">
            					<div class="row mb-4">
            						<div class="col">
            							<div class="">
				        					<div class="opacity-50">{{ translate('This Month Expense') }}</div>
				        					<div class="h4 fw-700 text-primary">{{ single_price(\App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount')) }}</div>
				        				</div>
            						</div>
            						<div class="col">
            							<div class="">
				        					<div class="opacity-50">{{ translate('Total Expense') }}</div>
				        					<div class="h4 fw-700 text-success">{{ single_price(\App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->sum('amount')) }}</div>
				        				</div>
            						</div>
            					</div>
            					<div>
            						<canvas id="graph-1" class="w-100" height="222"></canvas>
            					</div>
            				</div>
            			</div>
            		</div>
            		<div class="col-md-4">
            			<div class="card">
            				<div class="card-body">
            					<canvas id="pie-1" class="w-100" height="300"></canvas>
            				</div>
            			</div>
            		</div>
            	</div>
            	<div class="row gutters-10">
            		<div class="col-md-4">
            			<div class="bg-grad-1 text-white rounded-lg mb-4 overflow-hidden">
            				<div class="px-3 pt-3">
	        					<div class="opacity-50">{{ translate('Total Projects') }}</div>
	        					<div class="h3 fw-700">{{ count(Auth::user()->number_of_projects) }}</div>
            				</div>
        					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
								<path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,192L30,208C60,224,120,256,180,245.3C240,235,300,181,360,144C420,107,480,85,540,96C600,107,660,149,720,154.7C780,160,840,128,900,117.3C960,107,1020,117,1080,112C1140,107,1200,85,1260,74.7C1320,64,1380,64,1410,64L1440,64L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
							</svg>
            			</div>
            		</div>
            		<div class="col-md-4">
            			<div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
            				<div class="px-3 pt-3">
	        					<div class="opacity-50">{{ translate('Total Completed Projects') }}</div>
                                @php
                                    $completedProjects = 0;
                                    foreach (Auth::user()->number_of_projects as $key => $project) {
                                        if ($project->closed) {
                                            $completedProjects++;
                                        }
                                    }
                                @endphp
	        					<div class="h3 fw-700">{{ $completedProjects }}</div>
	        				</div>
        					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
								<path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
							</svg>
            			</div>
            		</div>
            		<div class="col-md-4">
            			<div class="bg-grad-3 text-white rounded-lg mb-4 overflow-hidden">
            				<div class="px-3 pt-3">
	        					<div class="opacity-50">{{ translate('Running Projects') }}</div>
                                @php
                                    $onGoingProjects = 0;
                                    foreach (Auth::user()->number_of_projects as $key => $project) {
                                        if (!$project->closed && \App\Models\ProjectUser::where('project_id', $project->id)->first() != null) {
                                            $onGoingProjects++;
                                        }
                                    }
                                @endphp
	        					<div class="h3 fw-700">{{ $onGoingProjects }}</div>
	        				</div>
        					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
								<path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,192L26.7,192C53.3,192,107,192,160,202.7C213.3,213,267,235,320,218.7C373.3,203,427,149,480,117.3C533.3,85,587,75,640,90.7C693.3,107,747,149,800,149.3C853.3,149,907,107,960,112C1013.3,117,1067,171,1120,202.7C1173.3,235,1227,245,1280,213.3C1333.3,181,1387,107,1413,69.3L1440,32L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path>
							</svg>
            			</div>
            		</div>
            	</div>
            	<div class="row gutters-10">
            		<div class="col-md-4">
            			<div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">{{ translate('Current Package') }}</h6>
                            </div>
            				<div class="card-body text-center">
            					<img src="{{ custom_asset(Auth::user()->userPackage->package->badge) }}" class="img-fluid mb-4 h-110px">
            					<h4 class="fw-600 mb-3 text-primary">{{ Auth::user()->userPackage->package->name }}</h4>
            					<p class="mb-1 text-muted">{{ translate('Remaining Fixed Projects') }} - {{ Auth::user()->userPackage->fixed_limit }}</p>
            					<p class="text-muted mb-4">{{ translate('Remaining Long Term Projects') }} - {{ Auth::user()->userPackage->long_term_limit }}</p>
            					<a href="{{ route('select_package') }}" class="btn btn-primary d-inline-block">{{ translate('Upgrade') }}</a>
            				</div>
            			</div>
            		</div>
            		<div class="col-md-4">
            			<div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">{{ translate('Current Package Summary') }}</h6>
                            </div>
            				<div class="card-body">
            					<ul class="list-unstyled mb-0">
            						<li class=" py-2">
                                        @if(Auth::user()->userPackage->package->fixed_limit > 0)
                                            <span class="mr-2 badge badge-circle badge-success badge-sm align-middle">
                								<i class="las la-check text-white"></i>
                							</span>
                                        @else
                                            <span class="mr-2 badge badge-circle badge-danger badge-sm align-middle">
                                                <i class="las la-times text-white"></i>
                                            </span>
                                        @endif
            							<span>{{ translate('Fixed Projects') }} - <span class="fw-700">{{ Auth::user()->userPackage->package->fixed_limit }}</span></span>
            						</li>
            						<li class=" py-2">
                                        @if(Auth::user()->userPackage->package->long_term_limit > 0)
                                            <span class="mr-2 badge badge-circle badge-success badge-sm align-middle">
                								<i class="las la-check text-white"></i>
                							</span>
                                        @else
                                            <span class="mr-2 badge badge-circle badge-danger badge-sm align-middle">
                                                <i class="las la-times text-white"></i>
                                            </span>
                                        @endif
            							<span>{{ translate('Long Term Projects') }} - <span class="fw-700">{{ Auth::user()->userPackage->package->long_term_limit }}</span></span>
            						</li>
                                    <li class=" py-2">
                                        @if(Auth::user()->userPackage->package->bio_text_limit > 0)
                                            <span class="mr-2 badge badge-circle badge-success badge-sm align-middle">
                                                <i class="las la-check text-white"></i>
                                            </span>
                                        @else
                                            <span class="mr-2 badge badge-circle badge-danger badge-sm align-middle">
                                                <i class="las la-times text-white"></i>
                                            </span>
                                        @endif
                                        <span>{{ translate('Bio Word Limit') }} - <span class="fw-700">{{ Auth::user()->userPackage->package->bio_text_limit }}</span></span>
                                    </li>
                                    <li class=" py-2">
                                        @if (Auth::user()->userPackage->package->following_status)
                                            <span class="mr-2 badge badge-circle badge-success badge-sm align-middle">
                                                <i class="las la-check text-white"></i>
                                            </span>
                                        @else
                                            <span class="mr-2 badge badge-circle badge-danger badge-sm align-middle">
                                                <i class="las la-times text-white"></i>
                                            </span>
                                        @endif
                                        <span>{{ translate('Freelancer Bookmark option') }}</span>
                                    </li>
            					</ul>
            				</div>
            			</div>
            		</div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">{{ translate('Suggested Package') }}</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group ">
                                    @foreach (\App\Models\Package::client()->active()->get()->except(Auth::user()->profile->package_id) as $key => $package)
                                        <li class="list-group-item">
                                            <a href="{{ route('select_package') }}" class="d-flex align-items-center text-inherit">
                                                <img src="{{ custom_asset($package->badge) }}" class="img-fluid mr-4 h-70px">
                                                <span class="">
                                                    <h4 class="h6 mb-0">{{ $package->name }}</h4>
                                                    <span class=" fs-15 fw-700 text-primary">{{ single_price($package->price) }}</span>
                                                    <span class="fs-10 text-secondary">/{{ $package->number_of_days }} {{ translate('days') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
            	</div>
            	<div class="row gutters-10">
	            	<div class="col-md-5">
	            		<div class="card">
	            			<div class="card-header">
	            				<h6 class="mb-0 fs-15 fw-600">{{ translate('Running Projects') }}</h6>
	            			</div>
	            			<div class="c-scrollbar-light card-body overflow-auto" style="max-height: 365px">
	            				<ul class="list-group list-group-flush">
                                    @foreach (Auth::user()->number_of_projects as $key => $project)
                                        @if(!$project->closed && \App\Models\ProjectUser::where('project_id', $project->id)->first() != null)
                                            <li class="list-group-item px-0">
        	            						<a href="{{ route('project.details', $project->slug) }}" class="text-inherit d-flex align-items-center">
                    								<span class="avatar avatar-sm flex-shrink-0 bg-soft-primary mr-3">
                                                        @if($project->client->photo != null)
                                                            <img src="{{ custom_asset($project->client->photo) }}">
                                                        @else
                                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                        @endif
        	                                        </span>
        		            						<span class="flex-grow-1 text-truncate-2">{{ $project->name }}</span>
        		            					</a>
        	            					</li>
                                        @endif
                                    @endforeach
	            				</ul>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="col-md-7">
	            		<div class="card">
	            			<div class="card-header">
	            				<h6 class="mb-0 fs-15 fw-600">{{ translate('Suggested Freelancers') }}</h6>
	            			</div>
	            			<div class="card-body px-0">
	            				<div class="aiz-auto-scroll c-scrollbar-light px-3" style="max-height: 340px;overflow-y: scroll;">
		            				<ul class="list-group list-group-flush">
		            					@foreach (\App\Models\UserProfile::where('user_role_id', 2)->inRandomOrder()->limit(10)->get(); as $key => $userProfile)
                                            @if($userProfile->user != null)
                                                <li class="list-group-item px-0">
        		            						<a href="{{ route('freelancer.details', $userProfile->user->user_name) }}" class="text-inherit d-flex align-items-center">
        	            								<span class="avatar avatar-sm flex-shrink-0 bg-soft-primary mr-3">
                                                            @if($userProfile->user->photo != null)
                                                                <img src="{{ custom_asset($userProfile->user->photo) }}">
                                                            @else
                                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                            @endif
        		                                        </span>
        			            						<span class="flex-grow-1 text-truncate-2">{{ $userProfile->user->name }}</span>
        			            						<span class="flex-shrink-0 ml-3">
        			            							<span class="d-block opacity-50 fs-10">{{ translate('Hourly Rate') }}</span>
        			            							<span class="fs-15">{{ single_price($userProfile->hourly_rate) }}</span>
        			            						</span>
        			            					</a>
        		            					</li>
                                            @endif
                                        @endforeach
		            				</ul>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script type="text/javascript">
    AIZ.plugins.chart('#pie-1',{
    	type: 'doughnut',
        data: {
            labels: [
                "Total Project",
                "Completed Project",
                "Running Project",
            ],
            datasets: [
                {
                    data: [{{ count(Auth::user()->number_of_projects) }}, {{ $completedProjects }}, {{ $onGoingProjects }}],
                    backgroundColor: [
                        "#fd3995",
                        "#34bfa3",
                        "#5d78ff",
                    ]
                }
            ]
        },
        options: {
        	cutoutPercentage: 70,
        	legend: {
	            labels: {
	                fontFamily: 'Montserrat',
	                boxWidth: 10,
	                usePointStyle: true
	            },
	            onClick: function () {
	            	return '';
	            },
	            position: 'bottom'
	        }
	    }
    });
    AIZ.plugins.chart('#graph-1',{
    	type: 'line',
        data: {
            labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
            datasets: [
                {
                	fill: true,
                	borderColor: '#377dff',
                	backgroundColor: 'rgba(55, 125, 255,.1)',
                	label: 'Expense',
                    data: [ {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                            {{ \App\Models\MilestonePayment::where('paid_status', 1)->where('client_user_id', Auth::user()->id)->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', date('Y'))->sum('amount') }}
                    ],

                }
            ]
        },
        options: {
        	legend:{
	            display: false
        	},
		    scales: {
	            yAxes: [{
	            	gridLines: {
				        color: '#f2f3f8',
				        zeroLineColor: '#f2f3f8'
				    },
	                ticks: {
	                    fontColor: "#8b8b8b",
	                	fontFamily: 'Montserrat',
                		fontSize: 10
	                }
	            }],
	            xAxes: [{
	            	gridLines: {
				        color: '#f2f3f8'
				    },
	                ticks: {
	                    fontColor: "#8b8b8b",
	                	fontFamily: 'Montserrat',
                		fontSize: 10
	                }
	            }]
	        }
	    }
    });
</script>
@endsection

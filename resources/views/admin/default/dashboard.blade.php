@extends('admin.default.layouts.app')

@section('content')

<div class="row gutters-10">
    <div class="col-lg-6">
        <div class="row gutters-10">
            <div class="col-6">
                <div class="bg-grad-1 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total Earnings From') }}</span>
                            {{ translate('Client Subscription') }}
                        </div>
                        <div class="h3 fw-700 mb-3">{{ single_price(\App\Models\PackagePayment::client()->sum('amount')) }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total Earnings From') }}</span>
                            {{ translate('Freelancer Subscription') }}
                        </div>
                        <div class="h3 fw-700 mb-3">{{ single_price(\App\Models\PackagePayment::freelancer()->sum('amount')) }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-grad-3 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total Earnings From') }}</span>
                            {{ translate('Project Commission') }}
                        </div>
                        <div class="h3 fw-700 mb-3">{{ single_price(\App\Models\MilestonePayment::sum('admin_profit')) }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-grad-4 text-white rounded-lg mb-4 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                            <span class="fs-12 d-block">{{ translate('Total Earnings of') }}</span>
                            {{ translate('All Time') }}
                        </div>
                        <div class="h3 fw-700 mb-3">{{ single_price(\App\Models\PackagePayment::client()->sum('amount') + \App\Models\PackagePayment::freelancer()->sum('amount') + \App\Models\MilestonePayment::sum('admin_profit')) }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row gutters-10">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fs-14">{{ translate('Top Client Packages') }}</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="pie-1" class="w-100" height="280"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fs-14">{{ translate('Top Freelancer Packages') }}</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="pie-2" class="w-100" height="280"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gutters-10">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fs-14">{{ translate('Last Year Earnings') }}</h6>
            </div>
            <div class="card-body">
                <canvas id="graph-1" class="w-100" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-header border-soft-dark">
                <h6 class="mb-0">{{ translate('Last 30 Days Stat') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 pt-3 mb-3">
                        <span class="mb-2 d-block fs-13 opacity-60">{{ translate('New Clients') }}</span>
                        <h5 class="h1 fw-700">{{ count(\App\Models\UserProfile::where('user_role_id', 3)->where('created_at', '>', Carbon\Carbon::now()->subDays(30))->get()) }}</h5>
                    </div>
                    <div class="col-6 pt-3 mb-3">
                        <span class="mb-2 d-block fs-13 opacity-60">{{ translate('New Freelancers') }}</span>
                        <h5 class="h1 fw-700">{{ count(\App\Models\UserProfile::where('user_role_id', 2)->where('created_at', '>', Carbon\Carbon::now()->subDays(30))->get()) }}</h5>
                    </div>
                    <div class="col-6 pt-3 mb-3">
                        <span class="mb-2 d-block fs-13 opacity-60">{{ translate('Posted Projects') }}</span>
                        <h5 class="h1 fw-700">{{ count(\App\Models\Project::where('created_at', '>', Carbon\Carbon::now()->subDays(30))->get()) }}</h5>
                    </div>
                    <div class="col-6 pt-3 mb-3">
                        <span class="mb-2 d-block fs-13 opacity-60">{{ translate('Comppleted Projects') }}</span>
                        <h5 class="h1 fw-700">{{ count(\App\Models\Project::closed()->notCancel()->where('created_at', '>', Carbon\Carbon::now()->subDays(30))->get()) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">{{ translate('Top running Projects') }}</h6>
        <a href="{{ route('running_projects') }}">{{ translate('View All') }}</a>
    </div>
    <div class="card-body">
        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1" data-arrows='true'>
            @foreach (\App\Models\ProjectUser::latest()->limit(10)->get() as $key => $project_user)
                <div class="caorusel-box">
                    <a class="card text-inherit" href="{{ route('project.details', $project_user->project->slug) }}" target="_blank">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex mr-3 align-items-center text-inherit">
                                    <span class="avatar avatar-sm">
                                        @if($project_user->user->photo != null)
                                            <img class="img-fluid rounded-circle" src="{{ custom_asset($project_user->user->photo) }}">
                                        @else
                                            <img class="img-fluid rounded-circle" src="{{ my_asset('assets/backend/default/img/avatar-place.png') }}">
                                        @endif
                                    </span>
                                    <div class="pl-2">
                                        <h4 class="fs-14 mb-1">{{ $project_user->user->name }}</h4>
                                        <div class="text-secondary fs-10">
                                            <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                {{ formatRating(getAverageRating($project_user->user_id)) }}
                                            </span>
                                            <span>
                                                ({{ getNumberOfReview($project_user->user_id) }} {{ translate('Reviews') }})
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0 pl-3">
                                    <span class="small">Hired at</span>
                                    <h4 class="mb-0">{{ single_price($project_user->hired_at) }}</h4>
                                </div>
                            </div>
                            <h5 class="fs-14 fw-600 lh-1-5 text-truncate-2">
                                {{ $project_user->project->excerpt }}
                            </h5>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@php
    $freelancerPackageNames = \App\Models\Package::freelancer()->pluck('name');
    $freelancerPackageHistory = array();
    foreach (\App\Models\Package::freelancer()->get() as $key => $freelancerPackage) {
        array_push($freelancerPackageHistory, count($freelancerPackage->package_payments));
    }

    $clientPackageNames = \App\Models\Package::client()->pluck('name');
    $clientPackageHistory = array();
    foreach (\App\Models\Package::client()->get() as $key => $clientPackage) {
        array_push($clientPackageHistory, count($clientPackage->package_payments));
    }
@endphp

@endsection

@section('script')
<script type="text/javascript">
    AIZ.plugins.chart('#pie-1',{
        type: 'doughnut',
        data: {
            labels: @php echo $clientPackageNames @endphp,
            datasets: [
                {
                    data: @php echo json_encode($clientPackageHistory) @endphp,
                    backgroundColor: [
                        "#fd3995",
                        "#34bfa3",
                        "#5d78ff",
                        '#fdcb6e',
                        '#d35400',
                        '#8e44ad',
                        '#006442',
                        '#4D8FAC',
                        '#CA6924',
                        '#C91F37'
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
    AIZ.plugins.chart('#pie-2',{
        type: 'doughnut',
        data: {
            labels: @php echo $freelancerPackageNames @endphp,
            datasets: [
                {
                    data: @php echo json_encode($freelancerPackageHistory) @endphp,
                    backgroundColor: [
                        "#fd3995",
                        "#34bfa3",
                        "#5d78ff",
                        '#fdcb6e',
                        '#d35400',
                        '#8e44ad',
                        '#006442',
                        '#4D8FAC',
                        '#CA6924',
                        '#C91F37'
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
                    fill: false,
                    borderColor: '#377dff',
                    label: 'Freelancer Package',
                    data: [
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'freelancer')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                    ],

                },
                {
                    fill: false,
                    borderColor: '#fd3995',
                    label: 'Client Package',
                    data: [
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                        {{ \App\Models\PackagePayment::where('package_type', 'client')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', date('Y'))->sum('amount') }},
                    ],

                },
                {
                    fill: false,
                    borderColor: '#34bfa3',
                    label: 'Project Payment',
                    data: [
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                        {{ \App\Models\MilestonePayment::where('paid_status', '1')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', date('Y'))->sum('admin_profit') }},
                    ],

                }
            ]
        },
        options: {
            legend:{
                labels: {
                    fontFamily: 'Montserrat',
                    boxWidth: 10,
                    usePointStyle: true
                },
                onClick: function () {
                    return '';
                },
                position: 'bottom'
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

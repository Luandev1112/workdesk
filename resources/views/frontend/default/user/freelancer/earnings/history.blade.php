@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.freelancer.inc.sidebar')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Your earnings history') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Your earnings history') }}</h5>
                            </div>
                            <div class="card-body">

                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th data-breakpoints="">#</th>
                                            <th data-breakpoints="">{{ translate('Project Name') }}</th>
                                            <th data-breakpoints="">{{ translate('Paid Amount') }}</th>
                                            <th data-breakpoints="md">{{ translate('Your Earnings') }}</th>
                                            <th data-breakpoints="md">{{ translate('Paid at') }}</th>
                                            <th data-breakpoints="lg">{{ translate('Admin Charge') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($milestones as $key => $milestone)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="#" class="text-secondary">{{ $milestone->project->name }}</a></td>
                                                <td>{{ single_price($milestone->amount) }}</td>
                                                <td>{{ single_price($milestone->freelancer_profit) }}</td>
                                                <td>{{ $milestone->created_at }}</td>
                                                <td>{{ single_price($milestone->admin_profit) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $milestones->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

@endsection

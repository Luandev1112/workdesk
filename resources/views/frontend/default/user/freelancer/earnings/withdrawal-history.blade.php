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
                                <h1 class="h3">{{ translate('Your withdrawal history') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Your withdrawal history') }}</h5>
                            </div>
                            <div class="card-body">

                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th data-breakpoints="">#</th>
                                            <th data-breakpoints="">{{ translate('Requested Amount') }}</th>
                                            <th data-breakpoints="">{{ translate('Paid Amount') }}</th>
                                            <th data-breakpoints="md">{{ translate('Payment Method') }}</th>
                                            <th data-breakpoints="md">{{ translate('Date') }}</th>
                                            <th data-breakpoints="md">{{ translate('Reciept') }}</th>
                                            <th data-breakpoints="lg">{{ translate('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdraw_requests as $key => $withdraw_request)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ single_price($withdraw_request->requested_amount) }}</td>
                                                <td>{{ single_price($withdraw_request->paid_amount) }}</td>
                                                <td>{{ $withdraw_request->payment_method }}</td>
                                                <td>{{ $withdraw_request->created_at }}</td>
                                                <td>
                                                    @if ($withdraw_request->reciept != null)
                                                        <a href="{{ custom_asset($withdraw_request->reciept) }}" target="_blank" class="text-secondary">{{ translate('Show Reciept') }}</a>
                                                    @elseif(!$withdraw_request->paid_status)
                                                        <span class="badge badge-inline badge-info">{{ translate('N/A') }}</span>
                                                    @else
                                                        <span class="badge badge-inline badge-info">{{ translate('No Reciept') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($withdraw_request->paid_status != 0)
                                                        <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                                    @else
                                                        <span class="badge badge-inline badge-danger">{{ translate('Pending') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $withdraw_requests->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

@endsection

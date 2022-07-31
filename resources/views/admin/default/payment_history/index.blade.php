@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="project_payments" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Project Payments')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by project name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
                            <div class="input-group-append">
                                <button class="btn btn-light" type="submit">
                                    <i class="las la-search la-rotate-270"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Project') }}</th>
                            <th data-breakpoints="md">{{ translate('Client') }}</th>
                            <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('My Earnings') }}</th>
                            <th data-breakpoints="sm">{{ translate('Freelancer Earnings') }}</th>
                            <th data-breakpoints="sm">{{ translate('Payment Status') }}</th>
                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                              <th data-breakpoints="">{{ translate('Approval').' ( '.translate('For Manual Payment').' )'}}</th>
                            @endif
                            <th class="text-right">{{ translate('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($milestone_payments as $key => $milestone_payment_id)
                            @php
                                $milestone_payment = \App\Models\MilestonePayment::find($milestone_payment_id->id);
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $milestone_payment->project->name }}</td>
                                <td>{{ $milestone_payment->client->name }}</td>
                                <td>{{ $milestone_payment->freelancer->name }}</td>
                                <td>{{ single_price($milestone_payment->amount) }}</td>
                                <td>{{ single_price($milestone_payment->admin_profit) }}</td>
                                <td>{{ single_price($milestone_payment->freelancer_profit) }}</td>
                                <td>
                                    @if( $milestone_payment->paid_status == 1 )
                                        <span class="badge badge-inline badge-success">{{ translate('Paid via') }} {{ $milestone_payment->payment_method }}</span>
                                    @else
                                        <span class="badge badge-inline badge-secondary">{{ translate('Unpaid') }}</span>
                                    @endif
                                </td>
                                @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                    @if($milestone_payment->offline_payment == 1)
                                      <td>
                                          @if($milestone_payment->approval == 1)
                                            <span class="badge badge-inline badge-success">{{ translate('Approved') }}</span>
                                          @else
                                            <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                          @endif
                                      </td>
                                    @else
                                      <td></td>
                                    @endif
                                @endif
                                <td class="text-right">{{ $milestone_payment->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $milestone_payments->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="package_payments_history" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Package Payment History')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="aiz-date-range form-control" @isset($sort_search) value="{{ $sort_search }}" @endisset name="date" placeholder="Select time and Search" data-advanced-range="true" autocomplete="off"/>
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
                            <th>{{ translate('Package Name') }}</th>
                            <th data-breakpoints="sm">{{ translate('Package Type') }}</th>
                            <th data-breakpoints="sm">{{ translate('User') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('Payment Method') }}</th>
                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                              <th data-breakpoints="">{{ translate('Payment Type')}}</th>
                              <th data-breakpoints="md">{{ translate('Approval').' ( '.translate('For Manual Payment').' )'}}</th>
                            @endif
                            <th class="text-right">{{ translate('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $package_payments as $key => $payment )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @if ( $payment->package != null )
                                        {{ $payment->package->name }}
                                    @else
                                        {{ translate('Package Removed') }}
                                    @endif
                                </td>
                                <td>{{ $payment->package_type }}</td>
                                <td>
                                  @if ( $payment->user != null )
                                    {{ $payment->user->name }}
                                  @else
                                    {{translate('Not Found')}}
                                  @endif
                                <td>{{single_price($payment->amount)}}</td>
                                <td>
                                    <span class="badge badge-inline badge-success">
                                      {{ translate('Paid by') }} {{ $payment->payment_method }}
                                    </span>
                                </td>
                                @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                    <td>
                                      @if($payment->offline_payment == 1)
                                          <span class="badge badge-inline badge-info">{{ translate('Manual') }}</span>
                                      @else
                                          <span class="badge badge-inline badge-success">{{ translate('Online') }}</span>
                                      @endif
                                    </td>
                                    @if($payment->offline_payment == 1)
                                      <td>
                                          @if($payment->approval == 1)
                                            <span class="badge badge-inline badge-success">{{ translate('Approved') }}</span>
                                          @else
                                            <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                          @endif
                                      </td>
                                    @else
                                      <td></td>
                                    @endif
                                @endif

                                <td class="text-right">
                                    {{$payment->created_at}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $package_payments->appends(request()->input())->links() }}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

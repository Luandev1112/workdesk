@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="project_payments" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Service Cancelled Requests')}}</h5>
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
                            <th>{{ translate('Service') }}</th>
                            <th data-breakpoints="sm">{{ translate('Service Type') }}</th>
                            <th data-breakpoints="md">{{ translate('Client') }}</th>
                            <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('My Earnings') }}</th>
                            <th data-breakpoints="sm">{{ translate('Freelancer Earnings') }}</th>
                            <th>{{ translate('Payment Method') }}</th>
                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                              <th data-breakpoints="">{{ translate('Payment Type')}}</th>
                              <th data-breakpoints="md">{{ translate('Approval').' ( '.translate('For Manual Payment').' )'}}</th>
                            @endif
                            <th class="text-right">{{ translate('Date') }}</th>
                            <th class="text-right">{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service_payments as $key => $service_payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a target="_blank" href="{{ route('service.show', $service_payment->servicePackage->service->slug) }}">{{ $service_payment->servicePackage->service->title }}</a></td>
                                <td>{{ ucfirst($service_payment->servicePackage->service_type) }}</td>
                                <td>{{ $service_payment->user->name }}</td>
                                <td>{{ $service_payment->freelancer->name }}</td>
                                <td>{{ single_price($service_payment->amount) }}</td>
                                <td>{{ single_price($service_payment->admin_profit) }}</td>
                                <td>{{ single_price($service_payment->freelancer_profit) }}</td>
                                <td>
                                    <span class="badge badge-inline badge-success">{{ translate('Paid via') }} {{ $service_payment->payment_method }}</span>
                                </td>
                                @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                    <td>
                                      @if($service_payment->offline_payment == 1)
                                          <span class="badge badge-inline badge-info">{{ translate('Manual') }}</span>
                                      @else
                                          <span class="badge badge-inline badge-success">{{ translate('Online') }}</span>
                                      @endif
                                    </td>
                                    @if($service_payment->offline_payment == 1)
                                      <td>
                                          @if($service_payment->approval == 1)
                                            <span class="badge badge-inline badge-success">{{ translate('Approved') }}</span>
                                          @else
                                            <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                          @endif
                                      </td>
                                    @else
                                      <td></td>
                                    @endif
                                @endif
                                <td class="text-right">{{ $service_payment->created_at }}</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" onclick="show_cancel_request_modal('{{ $service_payment->id }}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{translate('Show')}}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('cancel-service-request.destroy', $service_payment->id) }}" title="{{translate('Delete')}}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $service_payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
    <!-- cancel Modal -->
    <div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{translate('Cancel Confirmation')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-center">
                    <p class="lead">{{translate('Are you sure to cancel this?')}}</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a id="cancel-link" class="btn btn-primary mt-2">{{translate('Confirm')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancel-service-request">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Cancel Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="cancel-service-request_body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    function show_cancel_request_modal(id){
        $.post('{{ route('cancel-service-request.show') }}', { _token: '{{ csrf_token() }}', id:id }, function(data){
            $('#cancel-service-request').modal('show');
            $('#cancel-service-request_body').html(data);
        })
    }
</script>
@endsection

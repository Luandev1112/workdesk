@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.client.inc.sidebar')

            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col d-flex justify-content-between">
                            <h1 class="h3">{{ translate('Purchased Services') }}</h1>
                        </div>
                    </div>
                </div>

                <div class="row gutters-10">
                    <div class="card w-100">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('List of srevices requested for cancellation') }}</h5>
                        </div>
                        <div class="card-body">

                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th data-breakpoints="">#</th>
                                        <th data-breakpoints="">{{ translate('Service Title') }}</th>
                                        <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                                        <th data-breakpoints="">{{ translate('Service Type') }}</th>
                                        <th data-breakpoints="md">{{ translate('Bought At') }}</th>
                                        @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                          <th data-breakpoints="">{{ translate('Payment Type')}}</th>
                                          <th data-breakpoints="" width="15%">{{ translate('Approval').' ( '.translate('For Manual Payment').' )'}}</th>
                                        @endif
                                        <th data-breakpoints="md">{{ translate('Purchased At') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchasedServices as $purchasedService)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a target="_blank" href="{{ route('service.show', $purchasedService->servicePackage->service->slug) }}">{{ \Illuminate\Support\Str::limit($purchasedService->servicePackage->service->title, 15, $end='...') }}</a></td>
                                        <td><a target="_blank" href="{{ route('freelancer.details', $purchasedService->freelancer->user_name) }}">{{ $purchasedService->freelancer->name }}</a></td>
                                        <td>{{ ucfirst($purchasedService->servicePackage->service_type) }}</td>
                                        <td>{{ single_price($purchasedService->amount) }}</td>
                                        @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                          <td>
                                                @if($purchasedService->offline_payment == 1)
                                                    <span class="badge badge-inline badge-info">{{ translate('Manual Payment') }}</span>
                                                @else
                                                    <span class="badge badge-inline badge-success">{{ translate('Online Payment') }}</span>
                                                @endif
                                          </td>
                                          @if($purchasedService->offline_payment == 1)
                                            <td>
                                                @if($purchasedService->approval == 1)
                                                  <span class="badge badge-inline badge-success">{{ translate('Approved') }}</span>
                                                @else
                                                  <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                                @endif
                                            </td>
                                          @else
                                              <td></td>
                                          @endif
                                        @endif
                                        <td>{{ $purchasedService->created_at }}</td>                                        
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="aiz-pagination aiz-pagination-center">
                    {{ $purchasedServices->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modal')
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

    @include('admin.default.partials.delete_modal')
@endsection

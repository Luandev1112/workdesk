@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.client.inc.sidebar')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Project Milestone Requests') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('All Requests') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th data-breakpoints="">#</th>
                                        <th data-breakpoints="" width="15%">{{ translate('Project') }}</th>
                                        <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                                        <th data-breakpoints="md">{{ translate('Time') }}</th>
                                        <th data-breakpoints="">{{ translate('Amount') }}</th>
                                        <th data-breakpoints="">{{ translate('Status') }}</th>
                                        @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                          <th data-breakpoints="md">{{ translate('Approval').' ( '.translate('For Manual Payment').' )'}}</th>
                                        @endif
                                        <th data-breakpoints="" class="text-right" width="20%">{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($milestones as $key => $milestone)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $milestone->project->name }}</td>
                                            <td>
                                                {{ $milestone->freelancer->name }}
                                            </td>
                                            <td>{{ $milestone->created_at }}</td>
                                            <td>
                                                {{ single_price($milestone->amount) }}
                                            </td>
                                            <td>
                                                @if($milestone->paid_status == 1)
                                                <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                                @else
                                                <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                                @endif
                                            </td>
                                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                                @if($milestone->offline_payment == 1)
                                                  <td>
                                                      @if($milestone->approval == 1)
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
                                                @if($milestone->paid_status != 1)
                                                    <button type="submit"
                                                        class="btn btn-xs btn-primary mr-2"
                                                        @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated )
                                                            onclick="select_payment_type({{ $milestone->id }})"
                                                        @else
                                                            onclick="show_online_payment_modal('{{ $milestone->id }}')"
                                                        @endif
                                                        >
                                                        {{ translate('Pay now') }}
                                                    </button>
                                                @endif
                                                <button type="submit" class="btn btn-sm btn-icon btn-circle btn-soft-info" onclick="request_message_show_modal('{{ $milestone->id }}')" title="View Message">
                                                    <i class="las la-eye"></i>
                                                </button>
                                            </td>
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
@section('script')
    <script type="text/javascript">
        function request_message_show_modal(id){
            $.post('{{ route('milestone_request_message_show_modal') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
                $('#request_message_show_modal').modal('show');
                $('#request_message_show_modal_body').html(data);
    		});
        }

        function select_payment_type(id) {
            $('input[name=milestone_payment_id]').val(id);
            $('#select_payment_type_modal').modal('show');
        }

        function payment_type(type) {
            var milestone_payment_id = $('#milestone_payment_id').val();
            if (type == 'online') {
                $("#select_type_cancel").click();
                show_online_payment_modal(milestone_payment_id);
            } else if (type == 'offline') {
                $("#select_type_cancel").click();
                $.post('{{ route('offline_milestone_payment_modal') }}', {
                    _token: '{{ csrf_token() }}',
                    milestone_payment_id: milestone_payment_id
                }, function (data) {
                    $('#offline_milestone_payment_modal_body').html(data);
                    $('#offline_milestone_payment_modal').modal('show');
                });
            }
        }

        function show_online_payment_modal(id){
            $.post('{{ route('show_payment_select_modal') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
                $('#show_online_payment_select_modal').modal('show');
                $('#show_online_payment_select_modal_body').html(data);
                $(".aiz-selectpicker").selectpicker();
    		});
        }
    </script>
@endsection

@section('modal')
<div class="modal fade" id="request_message_show_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Message Info') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="request_message_show_modal_body">

            </div>
        </div>
    </div>
</div>

<!-- Select Payment Type Modal -->
<div class="modal fade" id="select_payment_type_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select Payment Type') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="milestone_payment_id" name="milestone_payment_id" value="">
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Payment Type')}}</label>
                    </div>
                    <div class="col-md-10">
                        <div class="mb-3">
                            <select class="form-control aiz-selectpicker" onchange="payment_type(this.value)"
                                    data-minimum-results-for-search="Infinity">
                                <option value="">{{ translate('Select One')}}</option>
                                <option value="online">{{ translate('Online payment')}}</option>
                                <option value="offline">{{ translate('Offline payment')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-sm btn-primary transition-3d-hover mr-1" id="select_type_cancel" data-dismiss="modal">{{translate('Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Online payment Modal -->
<div class="modal fade" id="show_online_payment_select_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="show_online_payment_select_modal_body">

            </div>
        </div>
    </div>
</div>

<!-- offline payment Modal -->
<div class="modal fade" id="offline_milestone_payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Make offline milestone payment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="offline_milestone_payment_modal_body"></div>
        </div>
    </div>
</div>
@endsection

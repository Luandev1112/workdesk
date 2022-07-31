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
                                <h1 class="h3">{{ translate('Total Requests') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Total Requests') }}</h5>
                        </div>
                        <div class="card-body">

                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th data-breakpoints="">#</th>
                                        <th data-breakpoints="">{{ translate('Project Name') }}</th>
                                        <th data-breakpoints="">{{ translate('Client') }}</th>
                                        <th data-breakpoints="md">{{ translate('Sending date') }}</th>
                                        <th data-breakpoints="md">{{ translate('Requested Amount') }}</th>
                                        <th data-breakpoints="lg">{{ translate('Client Status') }}</th>
                                        <th data-breakpoints="lg">{{ translate('Payment Status') }}</th>
                                        <th data-breakpoints="">{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($milestones as $key => $milestone)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $milestone->project->name }}</td>
                                            <td>
                                                {{ $milestone->client->name }}
                                            </td>
                                            <td>{{ $milestone->created_at }}</td>
                                            <td>
                                                {{ single_price($milestone->amount) }}
                                            </td>
                                            <td>
                                                @if($milestone->client_seen == 1)
                                                    Seen
                                                @else
                                                    Unseen
                                                @endif
                                            </td>
                                            <td>
                                                @if($milestone->paid_status == 1)
                                                    <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                                @else
                                                    <span class="badge badge-inline badge-secondary">{{ translate('Pending') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-xs btn-primary transition-3d-hover" onclick="request_message_show_modal('{{ $milestone->id }}')">Show</button>
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
    </script>
@endsection

@section('modal')
<div class="modal fade" id="request_message_show_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="request_message_show_modal_body">

            </div>
        </div>
    </div>
</div>
@endsection

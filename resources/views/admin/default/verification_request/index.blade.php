@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_list" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Verification Lists')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="User Name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
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
                            <th>{{translate('Name')}}</th>
                            <th data-breakpoints="md">{{translate('Email')}}</th>
                            <th data-breakpoints="md">{{translate('User Type')}}</th>
                            <th>{{translate('Verification Status')}}</th>
                            <th class="text-right">{{translate('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ($key+1) + ($users->currentPage() - 1)*$users->perPage() }}</td>
                                @if ($user != null || !$user->isEmpty())
                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                @else
                                    <td>
                                        {{translate('Not Found')}}
                                    </td>
                                    <td>
                                        {{translate('Not Found')}}
                                    </td>
                                @endif
                                <td>
                                    {{$user->user_type}}
                                </td>
                                @php
                                    $verification = \App\Models\Verification::where('user_id', $user->id)->first();                                    
                                @endphp
                                <td>
                                    @if ($verification != null && $verification->verified != 0)
                                        <span class="badge badge-success badge-inline">{{ translate('Verified') }}</span>
                                    @elseif ($verification != null && $verification->verified == 0)
                                        <span class="badge badge-info badge-inline">{{ translate('New Request') }}</span>
                                    @else
                                        <span class="badge badge-secondary badge-inline">{{ translate('Not Recieved Yet') }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($user != null)
                                        @can ('single_verification_details')
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('verification_request_details', $user->user_name) }}" title="{{translate('View Details')}}">
                                                <i class="las la-eye"></i>
                                            </a>
                                        @endcan
                                    @endif
                                    @if ($verification != null)
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('verification_request_delete', $user->id) }}" title="{{translate('Delete')}}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
    <div class="modal fade" id="cancel-project-request">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Cancel Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="cancel-project-request_body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    function show_verification_request_modal(id){
        $.post('{{ route('cancel-project-request.show') }}', { _token: '{{ csrf_token() }}', id:id }, function(data){
            $('#cancel-project-request').modal('show');
            $('#cancel-project-request_body').html(data);
        })
    }}
</script>
@endsection

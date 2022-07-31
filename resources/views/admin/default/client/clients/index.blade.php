@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_clients" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Client Lists')}}</h5>
                    </div>
                    <div class="col-md-3 ml-auto">
                        <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_clients()">
                            <option value="">{{ translate('Sort by') }}</option>
                            <option value="created_at,asc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'asc') selected @endif @endisset>{{translate('Time (Old > New)')}}</option>
                            <option value="created_at,desc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'desc') selected @endif @endisset>{{translate('Time (New > Old)')}}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by Name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
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
                            <th>{{translate('Package')}}</th>
                            <th data-breakpoints="md">{{translate('Verification Status')}}</th>
                            <th>{{translate('Total Spent')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $key => $client)
                            @if ($client->user != null)
                                <tr>
                                    <td>{{ ($key+1) + ($clients->currentPage() - 1)*$clients->perPage() }}</td>
                                    <td>
                                        {{$client->user->name}}
                                    </td>
                                    <td>
                                        {{$client->user->email}}
                                    </td>
                                    <td>
                                        @if ($client->user->userPackage != null && $client->user->userPackage->package != null)
                                            {{$client->user->userPackage->package->name}}
                                        @else
                                            {{translate('Package Removed')}}
                                        @endif
                                    </td>
                                    @php
                                        $verification = \App\Models\Verification::where('user_id', $client->user_id)->where('role_id', '3')->first();
                                    @endphp
                                    <td>
                                        @if ($verification != null && $verification->verified != 0)
                                            <span class="badge badge-inline badge-success">{{ translate('Verified') }}</span>
                                        @elseif ($verification != null && $verification->verified == 0)
                                            <span class="badge badge-inline badge-primary">{{ translate('New Request') }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate('Not Recieved Yet') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ single_price(\App\Models\MilestonePayment::where('client_user_id', $client->user->id)->where('paid_status', 1)->sum('amount')) }}
                                    </td>
                                    <td class="text-right">
                                        @if ($client->user != null)
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('client_info_show', $client->user->user_name) }}" title="{{translate('View Details')}}">
                                                <i class="las la-eye"></i>
                                            </a>
                                        @endif
                                        @can ('freelancer_delete')
                                            @if ($client->user->banned)
                                                <a href="javascript:void(0)" class="btn btn-soft-succss btn-icon btn-circle btn-sm confirm-alert" data-target="#unban-modal" data-href="{{ route('user.ban', $client->user->id) }}" title="{{translate('Unban')}}">
                                                    <i class="las la-ban"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-alert" data-target="#ban-modal" data-href="{{ route('user.ban', $client->user->id) }}" title="{{translate('Ban')}}">
                                                    <i class="las la-ban"></i>
                                                </a>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $clients->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.ban_modal')
    @include('admin.default.partials.unban_modal')
@endsection
@section('script')
<script type="text/javascript">
    function sort_clients(el){
        $('#sort_clients').submit();
    }
</script>
@endsection

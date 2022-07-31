@extends('admin.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="" id="sort_withdraw_request_list" action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col text-center text-md-left">
                            <h5 class="mb-md-0 h6">{{translate('Withdraw Requests list')}}</h5>
                        </div>
                        <div class="col-md-3 ml-auto">
                            <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_withdraw_request_list()">
                                <option value="">{{ translate('Sort by options') }}</option>
                                <option value="created_at,asc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'asc') selected @endif @endisset>{{translate('Sort by Time (Old > New)')}}</option>
                                <option value="created_at,desc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'desc') selected @endif @endisset>{{translate('Sort by Time (New > Old)')}}</option>
                                <option value="requested_amount,desc" @isset($col_name , $query) @if($col_name == 'requested_amount' && $query == 'desc') selected @endif @endisset>{{translate('Sort by Request Amount (High > Low)')}}</option>
                                <option value="requested_amount,asc" @isset($col_name , $query) @if($col_name == 'requested_amount' && $query == 'asc') selected @endif @endisset>{{translate('Sort by Request Amount (Low > High)')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type and Hit Enter" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
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
                                <th>{{translate('User Name')}}</th>
                                <th data-breakpoints="md">{{translate('Requested Amount')}}</th>
                                <th >{{translate('Message')}}</th>
                                <th data-breakpoints="md">{{translate('Payment Method')}}</th>
                                <th data-breakpoints="md">{{translate('Paid-Status')}}</th>
                                <th class="text-right">{{translate('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdraw_requests as $key => $withdraw_request)
                                <tr>
                                    <td>{{ ($key+1) + ($withdraw_requests->currentPage() - 1)*$withdraw_requests->perPage() }}</td>
                                    @if ($withdraw_request->user != null)
                                        <td>
                                            {{$withdraw_request->user->name}}
                                        </td>
                                    @else
                                        <td>
                                            {{translate('Not Found')}}
                                        </td>
                                    @endif
                                    <td>
                                        {{single_price($withdraw_request->requested_amount)}}
                                    </td>
                                    <td>
                                        {{$withdraw_request->descriptions}}
                                    </td>
                                    <td>
                                        {{strtoupper($withdraw_request->payment_method)}}
                                    </td>
                                    <td>
                                        @if ($withdraw_request->paid_status != 0)
                                            <span class="badge badge-inline badge-primary">{{ translate('Paid') }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate('Non-Paid') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">

                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('pay_to_freelancer', encrypt($withdraw_request->id)) }}" title="{{translate('Pay Now')}}">
                                            <i class="las la-money-check"></i>
                                        </a>
                                        <a href="{{ route('pay_to_freelancer.cancel', encrypt($withdraw_request->id)) }}" class="btn btn-soft-danger btn-icon btn-circle btn-sm"  title="{{translate('Delete')}}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{ $withdraw_requests->appends(request()->input())->links() }}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    function sort_withdraw_request_list(el){
        $('#sort_withdraw_request_list').submit();
    }
</script>
@endsection

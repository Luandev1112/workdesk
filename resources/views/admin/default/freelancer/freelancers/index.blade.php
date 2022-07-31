@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_freelancers" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Freelancer Lists')}}</h5>
                    </div>
                    <div class="col-md-3 ml-auto">
                        <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_freelancers()">
                            <option value="">{{ translate('Sort by') }}</option>
                            <option value="created_at,asc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'asc') selected @endif @endisset>{{translate('Time (Old > New)')}}</option>
                            <option value="created_at,desc" @isset($col_name , $query) @if($col_name == 'created_at' && $query == 'desc') selected @endif @endisset>{{translate('Time (New > Old)')}}</option>
                            <option value="balance,desc" @isset($col_name , $query) @if($col_name == 'balance' && $query == 'desc') selected @endif @endisset>{{translate('Balance (High > Low)')}}</option>
                            <option value="balance,asc" @isset($col_name , $query) @if($col_name == 'balance' && $query == 'asc') selected @endif @endisset>{{translate('Balance (Low > High)')}}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search By Name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
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
                            <th data-breakpoints="md">{{translate('Package')}}</th>
                            <th data-breakpoints="md">{{translate('Verification Status')}}</th>
                            <th data-breakpoints="md">{{translate('Balance')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($freelancers as $key => $freelancer)
                            <tr>
                                <td>{{ ($key+1) + ($freelancers->currentPage() - 1)*$freelancers->perPage() }}</td>
                                @if ($freelancer->user != null)
                                    <td>
                                        {{$freelancer->user->name}}
                                    </td>
                                    <td>
                                        {{$freelancer->user->email}}
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
                                    @if ($freelancer->user->userPackage != null && $freelancer->user->userPackage->package != null)
                                        {{$freelancer->user->userPackage->package->name}}
                                    @else
                                        {{translate('Package Removed')}}
                                    @endif
                                </td>
                                @php
                                    $verification = \App\Models\Verification::where('user_id', $freelancer->user_id)->where('role_id', '2')->first();
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
                                    {{single_price($freelancer->balance)}}
                                </td>
                                <td class="text-right">
                                    @if ($freelancer->user != null)
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('freelancer_info_show', $freelancer->user->user_name) }}" title="{{translate('View Details')}}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    @endif
                                    @if ($freelancer->user->banned)
                                        <a href="javascript:void(0)" class="btn btn-soft-success btn-icon btn-circle btn-sm confirm-alert" data-href="{{ route('user.ban', $freelancer->user->id) }}" data-target="#unban-modal" title="{{translate('Unban')}}">
                                            <i class="las la-ban"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-alert" data-href="{{ route('user.ban', $freelancer->user->id) }}" data-target="#ban-modal" title="{{translate('Ban')}}">
                                            <i class="las la-ban"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $freelancers->appends(request()->input())->links() }}
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
    function sort_freelancers(el){
        $('#sort_freelancers').submit();
    }
</script>
@endsection

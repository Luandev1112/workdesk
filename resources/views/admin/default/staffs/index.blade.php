@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">All Staffs</h1>
        </div>
        <div class="col text-right">
        @can('show create staff')
            <a href="{{ route('staffs.create') }}" class="btn btn-circle btn-info">
                <span>Add Staff</span>
            </a>
        @endcan
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="project_payments" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Staff')}}</h5>
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
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Role') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $key => $staff)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $staff->user->name }}</td>                                
                                <td>{{ $staff->user->email }}</td>                            
                                <td>
                                    @if ($staff->role != null)
                                        {{$staff->role->name}}
                                    @endif
                                </td>                                
                                <td class="text-right">                                    
                                    <a href="{{ route('staffs.edit', encrypt($staff->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-href="{{route('staffs.destroy', $staff->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

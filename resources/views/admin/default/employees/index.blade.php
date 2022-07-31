@extends('admin.default.layouts.app')

@section('content')

    <div class="aiz-titlebar mt-2 mb-3">
    	<div class="row align-items-center">
    		<div class="col-md-6">
    			<h1 class="h3">{{translate('All')}} {{ $role->name }}</h1>
    		</div>
    		<div class="col-md-6 text-md-right">
    			<a href="{{ route('employees.create') }}" class="btn btn-primary">
    				<span>{{translate('Add New Employee')}}</span>
    			</a>
    		</div>
    	</div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ $role->name }}</h6>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{translate('Name')}}</th>
                                <th>{{translate('Designation')}}</th>
                                <th data-breakpoints="md">{{translate('Email')}}</th>
                                <th data-breakpoints="sm">{{translate('Phone')}}</th>
                                <th class="text-right">{{translate('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_roles as $key => $employee)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$employee->user->name}}</td>
                                    <td>{{$employee->role->name}}</td>
                                    <td>{{$employee->user->email}}</td>
                                    <td>{{$employee->user->phone}}</td>
                                    <td class="text-right">
                                        <!-- <a class="dropdown-item" href="{{ route('employees.set_permission', encrypt($employee->id)) }}">{{translate('Set Access Permission')}}</a> -->
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('employees.edit', encrypt($employee->user_id)) }}" title="{{translate('Edit')}}">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('employees.destroy', $employee->user_id)}}" title="{{translate('Delete')}}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $user_roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

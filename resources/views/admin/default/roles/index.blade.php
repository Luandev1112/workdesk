@extends('admin.default.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">All Roles</h1>
            </div>
            <div class="col text-right">
                @can('show create roles')
                <a href="{{ route('roles.create') }}" class="btn btn-circle btn-info">
                    <span>Add Role</span>
                </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('All Roles')}}</h1>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th data-breakpoints="">#</th>
                                <th data-breakpoints="">{{ translate('Name') }}</th>
                                <th data-breakpoints="" class="text-right">{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ ($key+1) + ($roles->currentPage() - 1)*$roles->perPage() }}</td>
                                <td>{{$role->name}}</td>
                                <td class="text-right">                                    
                                    <a href="{{ route('roles.edit', encrypt($role->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-href="{{route('roles.destroy', $role->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
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
    <div class="row">
        {{ $roles->links() }}
    </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

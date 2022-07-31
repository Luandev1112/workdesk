@extends('admin.default.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="mb-0 h6">{{ translate('Create new Role') }}</h1>
    </div>

    <div class="card-body">
        <form class="form-horizontal" action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">                            
                            <div class="col-sm-12">
                                <input type="text" placeholder="{{translate('Role Name')}}" id="name" name="name" value="{{ $role->name }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading bord-btm mt-2">
                    <h3 class="h6">{{ translate('Permissions') }}</h3>
                </div>
                <div class="row">
                    @foreach (\App\Models\Permission::all() as $key => $permission)
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0 h6 text-center">{{ ucfirst($permission->name) }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="clearfix">                                    
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @if ($role->hasPermissionTo($permission->name))
                                            checked
                                        @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    @endforeach
                </div>
            </div>
            <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
            </div>
        </form>
    </div>
</div>

@endsection
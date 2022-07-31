@extends('admin.default.layouts.app')

@section('content')

<div class="col-lg-12">
    <form action="{{ route('staffs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="added_by" value="admin">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Employee Information')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">{{translate('Employee Name')}} </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" placeholder="{{ translate('Employee Name') }}" required>
                    </div>
                </div>            

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">{{translate('Email')}} </label>
                    <div class="col-md-8">
                        <input type="email" lang="en" class="form-control" name="email" placeholder="Employee Email" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">{{translate('Passoword')}}</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>

                <div class="form-group row" id="role">
                    <label class="col-md-3 col-from-label">{{translate('Role')}} </label>
                    <div class="col-md-8">
                        <select class="form-control aiz-selectpicker" name="role_id" id="role_id" data-live-search="true" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>                        
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

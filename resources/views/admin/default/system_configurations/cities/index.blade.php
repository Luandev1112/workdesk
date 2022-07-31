@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{ translate('State List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('State Name')}}</th>
                                    <th>{{translate('Country')}}</th>
                                    <th class="text-center" width="10%">{{translate('Options')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $key => $city)
                                    <tr>
                                        <td>{{ ($key+1) + ($cities->currentPage() - 1)*$cities->perPage() }}</td>
                                        <td>{{$city->name}}</td>
                                        <td>{{$city->country->name}}</td>
                                        <td>
                                            <div class="btn-group mb-2">
                                                <div class="btn-group">
                                                    <button type="button" class="btn" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="la la-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('cities.edit', encrypt($city->id)) }}">{{translate('Edit')}}</a>
                                                        <a class="dropdown-item confirm-delete" data-href="{{route('cities.destroy', $city->id)}}">{{translate('Delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cities->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Add New State')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('State Name')}}</label>
                            <input type="text" id="name" name="name" placeholder="{{ translate('Eg. Demo') }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Country')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="country_id" id="country_id" data-toggle="select2" data-placeholder="Choose ...">
                                @foreach (\App\Models\Country::all() as $key => $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save New State')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

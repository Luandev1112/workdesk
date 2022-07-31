@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{ translate('Country List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Code')}}</th>
                                    <th>{{translate('Photo')}}</th>
                                    <th class="text-center" width="10%">{{translate('Options')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countries as $key => $country)
                                    <tr>
                                        <td>{{ ($key+1) + ($countries->currentPage() - 1)*$countries->perPage() }}</td>
                                        <td>{{$country->name}}</td>
                                        <td>{{$country->code}}</td>
                                        <td><img class="img-md" src="{{ my_asset($country->photo) }}" height="50px" alt="{{translate('icon')}}"></td>
                                        <td>
                                            <div class="btn-group mb-2">
                                                <div class="btn-group">
                                                    <button type="button" class="btn" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="la la-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ route('countries.edit', encrypt($country->id)) }}">{{translate('Edit')}}</a>
                                                        <a class="dropdown-item confirm-delete" data-href="{{route('countries.destroy', $country->id)}}">{{translate('Delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $countries->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Add New Country')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('countries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Country Name')}}</label>
                            <input type="text" id="name" name="name" placeholder="{{ translate('Eg. Australlia') }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Country Code')}}</label>
                            <input type="text" id="code" name="code" placeholder="{{ translate('Eg. AU') }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 custom-file">
                            <input type="file" class="custom-file-input"  id="icon" name="icon">
                            <label class="custom-file-label" for="icon">{{translate('Choose Icon')}}</label>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save New Country')}}</button>
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

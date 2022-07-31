@extends('admin.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Edit State Info')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('cities.update', $city->id) }}" method="post" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('State Name')}}</label>
                            <input type="text" id="name" name="name" value="{{ $city->name }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Country')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="country_id" id="country_id" data-toggle="select2" data-placeholder="Choose ...">
                                @foreach (\App\Models\Country::all() as $key => $country)
                                    <option value="{{ $country->id }}" @if ($city->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
@endsection

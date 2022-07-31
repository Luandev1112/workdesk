@extends('admin.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{translate('Add New Employee')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" required placeholder="{{ translate('Eg. Leom Jafex') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">{{translate('Email')}}</label>
                            <input type="email" id="email" name="email" required placeholder="{{ translate('Eg. email@example.com') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">{{translate('Password')}}</label>
                            <input type="password" id="password" name="password" required placeholder="{{ translate('Eg. ********') }}" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="country">{{translate('Country')}}</label>
                                    <select class="form-control aiz-selectpicker" name="country_id" id="country_id" data-live-search="true" data-placeholder="Choose ..." >
                                        @foreach (\App\Models\Country::all() as $key => $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="country">{{translate('City')}}</label>
                                    <select class="form-control aiz-selectpicker" name="city_id" id="city_id" data-live-search="true" data-placeholder="Choose ...">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="postal_code">{{translate('Postal Code')}}</label>
                                    <input type="number" id="postal_code" name="postal_code" required placeholder="{{ translate('Eg. 1203') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="street">{{translate('Address')}}</label>
                            <input type="text" id="street" name="street" required placeholder="{{ translate('Eg. Street') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">{{translate('Phone')}}</label>
                            <input type="text" id="phone" name="phone" required placeholder="{{ translate('Eg. 015XXXXXXXX') }}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="designation">{{translate('Designation')}}</label>
                            <select class="form-control aiz-selectpicker" name="designation" id="designation" data-placeholder="Choose ...">
                                @foreach (\App\Models\Role::all() as $key => $role)
                                    @if ($role->id != "1" && $role->id != "2" && $role->id != "3")
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="signinSrEmail">{{ translate('Profile Image') }}</label>
                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="avatar" class="selected-files">
                            </div>
                            <div class="file-preview"></div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add Employee')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
@endsection
@section('script')

<script type="text/javascript">

    function get_city_by_country(){
        var country_id = $('#country_id').val();
        $.post('{{ route('cities.get_city_by_country') }}',{_token:'{{ csrf_token() }}', country_id:country_id}, function(data){
            $('#city_id').html(null);
            for (var i = 0; i < data.length; i++) {
                $('#city_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
        });
    }

    $(document).ready(function(){
        get_city_by_country();
    });

    $('#country_id').on('change', function() {
        get_city_by_country();
    });

</script>

@endsection

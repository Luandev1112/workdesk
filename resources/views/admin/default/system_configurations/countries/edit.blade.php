@extends('admin.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Edit Country Info')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('countries.update', $country->id) }}" method="post" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" value="{{ $country->name }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Code')}}</label>
                            <input type="text" id="code" name="code" value="{{ $country->code }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 custom-file">
                            <input type="file" class="custom-file-input"  id="icon" name="icon">
                            <label class="custom-file-label" for="icon">{{translate('Choose Icon')}}</label>
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

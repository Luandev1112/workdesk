@extends('admin.default.layouts.app')

@section('content')

<div class="col-lg-7 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Install New Addon')}}</h5>
        </div>
        <form class="form-horizontal" action="{{ route('addons.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label mt-2" for="addon_zip">{{ translate('Zip File')}}</label>
                    <div class="col-sm-10 custom-file">
                        <label class="custom-file-label">
                            <input type="file" id="addon_zip" name="addon_zip"  class="custom-file-input" required>
                            <span class="custom-file-name">{{ translate('Choose file') }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Install')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

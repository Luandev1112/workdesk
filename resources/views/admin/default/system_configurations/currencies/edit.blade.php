@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Edit Currency')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('currencies.update', $currency->id) }}" method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Currency Name')}}</label>
                            <input type="text" id="name" name="name" value="{{ $currency->name }}" class="form-control" placeholder="Eg. US Dollar" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="symbol">{{translate('Currency Symbol')}}</label>
                            <input type="text" id="symbol" name="symbol" value="{{ $currency->symbol }}" class="form-control" placeholder="Eg. $" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Currency Code')}}</label>
                            <input type="text" id="code" name="code" value="{{ $currency->code }}" class="form-control" placeholder="Eg. USD" required>
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label for="exchange_rate">{{translate('Exchange rate')}}</label>
                            <input type="number" min="0" step="0.01" id="exchange_rate" name="exchange_rate" placeholder="Eg. 5" value="{{ $currency->exchange_rate }}" class="form-control" required>
                        </div> --}}
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn btn-primary">{{translate('Update Currency')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

@endsection

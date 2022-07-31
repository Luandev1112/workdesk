@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6 mb-0">{{translate('Create New Currency')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('currencies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Currency Name')}}</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Eg. US Dollar" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="symbol">{{translate('Currency Symbol')}}</label>
                            <input type="text" id="symbol" name="symbol" class="form-control" placeholder="Eg. $" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Currency Code')}}</label>
                            <input type="text" id="code" name="code" class="form-control" placeholder="Eg. USD" required>
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label for="exchange_rate">{{translate('Exchange rate')}} (1 USD = ?)</label>
                            <input type="number" min="0" step="0.01" id="exchange_rate" placeholder="Eg. 5" name="exchange_rate" class="form-control" required>
                        </div> --}}
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add New Currency')}}</button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
@endsection

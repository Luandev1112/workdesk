@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.freelancer.inc.sidebar')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <h1 class="h3 mb-0">{{ translate('Make a withdrawal') }}</h1>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row gutters-10 mb-4">
                                <div class="col-md-6">
                                    <div class="alert alert-info mb-0">
                                        {{ translate('Your available balance is') }} {{ single_price(optional($profile)->balance) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-info mb-0">
                                        {{ translate('Minimum withdrawal amount is') }} {{ single_price(\App\Models\SystemConfiguration::where('type', 'min_withdraw_amount')->first()->value) }}

                                        {{-- Paypal payment charge is {{ single_price(\App\Models\SystemConfiguration::where('type', 'paypal_charge')->first()->value) }},
                                        Bank payment charge is {{ single_price(\App\Models\SystemConfiguration::where('type', 'bank_charge')->first()->value) }} --}}
                                    </div>
                                </div>
                            </div>
                            <form class="form-horizontal" action="{{ route('store_withdrawal_request_to_admin') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Withdrawal amount') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="amount" min="{{ \App\Models\SystemConfiguration::where('type', 'min_withdraw_amount')->first()->value }}" max="{{ optional($profile)->balance }}" step="1" placeholder="Enter withdrawal amount" value="{{ optional($profile)->balance }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Payment method') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="payment_method" required data-placeholder="Select a payment method" required>
                                        <option value="bank">{{ translate('Bank') }}</option>
                                        <option value="paypal">{{ translate('Paypal') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ translate('Any message') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="descriptions" required></textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary transition-3d-hover mr-1">{{ translate('Request for withdraw') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Minimum Amount For Withdraw Request")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('freelancer_payment_config_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="min_withdraw_amount">
                        <div class="form-group">
							<label>{{ translate('Minimum Amount') }}</label>
							<input type="number" min="1" step="0.01" name="min_withdraw_amount" value="{{ \App\Models\SystemConfiguration::where('type', 'min_withdraw_amount')->first()->value }}" class="form-control" placeholder="Minimum Amount">
							<small class="form-text text-muted"></small>
						</div>
                        <div class="alert alert-info">
                            {{ translate("Freelancer need to have minimum this amount of balance in his account to make a withdrawal request.") }}
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Paypal Payment Charge")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('freelancer_payment_config_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="paypal_charge">
                        <div class="form-group">
							<label>Charge($)</label>
							<input type="number" min="0" step="0.01" name="paypal_charge" value="{{ \App\Models\SystemConfiguration::where('type', 'paypal_charge')->first()->value }}" class="form-control" placeholder="Paypal Payment Charge">
							{{-- <small class="form-text text-muted"></small> --}}
						</div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->

        <!-- <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate("Bank Payment Charge")}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('freelancer_payment_config_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="bank_charge">
                        <div class="form-group">
                            <label>Charge($)</label>
                            <input type="number" min="0" step="0.01" name="bank_charge" value="{{ \App\Models\SystemConfiguration::where('type', 'bank_charge')->first()->value }}" class="form-control" placeholder="Bank Payment Charge">
                            {{-- <small class="form-text text-muted"></small> --}}
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    </div> <!-- end card-->
@endsection

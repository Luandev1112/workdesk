@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $user->name }} {{ translate('Account Information') }}</h5>
            </div>
            <div class="card-body">
                @if ($user_account != null)
                    <p class="text-muted"><strong>{{ translate('Bank Name') }} :</strong> <span class="ml-2">{{ $user_account->bank_name }}</span></p>
                    <p class="text-muted"><strong>{{ translate('Bank Account Name') }} :</strong><span class="ml-2">{{ $user_account->bank_acc_name }}</span></p>
                    <p class="text-muted"><strong>{{ translate('Bank Account Number') }} :</strong><span class="ml-2">{{ $user_account->bank_acc_no }}</span></p>
                    <p class="text-muted"><strong>{{ translate('Bank Routing Number') }} :</strong><span class="ml-2">{{ $user_account->bank_routing_number }}</span></p>
                    <hr>
                    <p class="text-muted"><strong>{{ translate('Paypal Account') }} :</strong> <span class="ml-2">{{ $user_account->paypal_acc_name }}</span></p>
                    <p class="text-muted"><strong>{{ translate('Paypal Email') }} :</strong> <span class="ml-2">{{ $user_account->paypal_email }}</span></p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ translate('Pay to') }} {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('project_milestone_pay_from_admin') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $withdraw_request->id }}">
                    <div class="form-group mb-3">
                        <label for="total_amount">{{translate('Freelancer Balance')}}</label>
                        <input type="number" id="total_amount" name="total_amount" min="10" step="0.01" value="{{ $user_profile->balance }}" required class="form-control" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="total_amount">{{translate('Requested Amount')}}</label>
                        <input type="number" id="total_amount" name="total_amount" min="10" step="0.01" value="{{ $withdraw_request->requested_amount }}" required class="form-control" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount">{{translate('Pay Amount')}}</label>
                        <input type="number" id="amount" name="amount" min="{{ \App\Models\SystemConfiguration::where('type', 'min_withdraw_amount')->first()->value }}" value="{{ $withdraw_request->requested_amount }}" step="0.01" required class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="type">{{translate('Payment Type')}}</label>
                        <select class="form-control aiz-selectpicker" name="type" id="type" data-placeholder="Choose ...">
                            <option value="bank" @if ($withdraw_request->payment_method == 'bank')
                                selected
                            @endif>{{translate('Bank')}}</option>
                            <option value="paypal" @if ($withdraw_request->payment_method == 'paypal')
                                selected
                            @endif>{{translate('Paypal')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ translate('Payment Reciept') }}</label>
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="reciept" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Pay')}} {{ $user->name }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

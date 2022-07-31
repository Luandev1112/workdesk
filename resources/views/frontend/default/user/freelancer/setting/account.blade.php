@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.freelancer.inc.sidebar')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Account Settings') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Bank Info') }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($freelancer_account != null)
                                <form class="js-validate" action="{{ route('freelancer_account.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_name" value="{{ $freelancer_account->bank_name }}"  placeholder="Enter Bank Name" aria-label="Enter Bank Name" required aria-describedby="nameLabel" data-msg="Please Enter Bank Name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Account Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_account_name" value="{{ $freelancer_account->bank_account_name }}"  placeholder="Enter Bank Account Name" aria-label="Enter Bank Account Name" required aria-describedby="nameLabel" data-msg="Please Enter Bank Account Name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Account Number') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_account_number" value="{{ $freelancer_account->bank_account_number }}" placeholder="Enter Bank Account Number" aria-label="Enter Bank Account Number" required aria-describedby="nameLabel" data-msg="Please Enter Bank Account Number." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label id="nameLabel" class="form-label">
                                            {{ translate('Routing/IBAN/SWIFT/BIC number') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control " name="bank_routing_number" value="{{ $freelancer_account->bank_routing_number }}" placeholder="Enter Routing/IBAN/SWIFT/BIC number" aria-label="Enter Bank Account Number" required aria-describedby="nameLabel" data-msg="Please Enter Bank Account Number." data-error-class="u-has-error" data-success-class="u-has-success">

                                    </div>
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </form>
                            @else
                                <form class="js-validate" action="{{ route('freelancer_account.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_name" placeholder="Enter your Bank name" aria-label="Enter your Bank name" required aria-describedby="nameLabel" data-msg="Please Enter your Bank name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Account Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_account_name" placeholder="Enter Bank Account Name" aria-label="Enter Bank Account Name" required aria-describedby="nameLabel" data-msg="Please Enter Bank Account Name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Bank Account Number') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="bank_account_number" placeholder="Enter Bank Account Number" aria-label="Enter Bank Account Number" required aria-describedby="nameLabel" data-msg="Please Enter Bank Account Number." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-sm btn-primary transition-3d-hover">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h6 font-weight-medium mb-0">{{ translate('Paypal Info') }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($freelancer_account != null)
                                <form class="js-validate" action="{{ route('freelancer_account.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Account Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="paypal_acc_name" value="{{ $freelancer_account->paypal_acc_name }}" placeholder="Enter your name" aria-label="Enter your name" required aria-describedby="nameLabel" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Account Email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="paypal_acc_email" value="{{ $freelancer_account->paypal_email }}" placeholder="Enter your name" aria-label="Enter your name" required aria-describedby="nameLabel" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </form>
                            @else
                                <form class="js-validate" action="{{ route('freelancer_account.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Account Name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="paypal_acc_name" value="" placeholder="Enter your name" aria-label="Enter your name" required aria-describedby="nameLabel" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <div class="js-form-message">
                                        <div class="form-group">
                                            <label id="nameLabel" class="form-label">
                                                {{ translate('Account Email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="paypal_acc_email" value="" placeholder="Enter your name" aria-label="Enter your name" required aria-describedby="nameLabel" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success">

                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-primary transition-3d-hover">{{ translate('Save Changes') }}</button>
                                    <!-- End Buttons -->
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

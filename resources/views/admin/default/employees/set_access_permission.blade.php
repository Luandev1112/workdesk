@extends('admin.default.layouts.app')

@section('content')
    @php
        $permissions = json_decode($user_role->permissions);
    @endphp

    <div class="aiz-titlebar mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{('Set Access Permission')}}</h1>
            </div>
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('permissions.update', $user_role->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ $user_role->user->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
        						<label>{{ translate('Project Category') }}</label>
        						<div class="aiz-checkbox-inline">
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="88" @if (in_array(88, $permissions)) checked @endif> {{ translate('View') }}
        								<span class="aiz-square-check"></span>
        							</label>
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="1" @if (in_array(1, $permissions)) checked @endif> {{ translate('Create') }}
        								<span class="aiz-square-check"></span>
        							</label>
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="2" @if (in_array(2, $permissions)) checked @endif> {{ translate('Edit') }}
        								<span class="aiz-square-check"></span>
        							</label>
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="3" @if (in_array(3, $permissions)) checked @endif> {{ translate('Delete') }}
        								<span class="aiz-square-check"></span>
        							</label>
        						</div>
        					</div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
        						<label>{{ translate('Project Cancel Request') }}</label>
        						<div class="aiz-checkbox-inline">
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="4" @if (in_array(4, $permissions)) checked @endif> {{ translate('View') }}
        								<span class="aiz-square-check"></span>
        							</label>
                                    <label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="89" @if (in_array(89, $permissions)) checked @endif> {{ translate('View details') }}
        								<span class="aiz-square-check"></span>
        							</label>
                                    <label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="89" @if (in_array(90, $permissions)) checked @endif> {{ translate('Delete') }}
        								<span class="aiz-square-check"></span>
        							</label>
        						</div>
        					</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
        						<label>{{ translate('Verification Request') }}</label>
        						<div class="aiz-checkbox-inline">
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="5" @if (in_array(5, $permissions)) checked @endif> {{ translate('View') }}
        								<span class="aiz-square-check"></span>
        							</label>
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="6" @if (in_array(6, $permissions)) checked @endif> {{ translate('Details View') }}
        								<span class="aiz-square-check"></span>
        							</label>
        						</div>
        					</div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
        						<label>{{ translate('User Chat') }}</label>
        						<div class="aiz-checkbox-inline">
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="7" @if (in_array(7, $permissions)) checked @endif> {{ translate('View') }}
        								<span class="aiz-square-check"></span>
        							</label>
        							<label class="aiz-checkbox">
        								<input type="checkbox" name="permissions[]" value="8" @if (in_array(8, $permissions)) checked @endif> {{ translate('Details View') }}
        								<span class="aiz-square-check"></span>
        							</label>
        						</div>
        					</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer list') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="9" @if (in_array(9, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="10" @if (in_array(10, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="92" @if (in_array(92, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer package') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="11" @if (in_array(11, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="12" @if (in_array(12, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="13" @if (in_array(13, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="14" @if (in_array(14, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer skill') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="15" @if (in_array(15, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="16" @if (in_array(16, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="17" @if (in_array(17, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="18" @if (in_array(18, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer badge') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="19" @if (in_array(19, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="20" @if (in_array(20, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="21" @if (in_array(21, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="22" @if (in_array(22, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Withdraw request') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="23" @if (in_array(23, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="24" @if (in_array(24, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Client package') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="25" @if (in_array(25, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="26" @if (in_array(26, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="27" @if (in_array(27, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="28" @if (in_array(28, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Client badge') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="29" @if (in_array(29, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="30" @if (in_array(30, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="31" @if (in_array(31, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="32" @if (in_array(32, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Client list') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="33" @if (in_array(33, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="34" @if (in_array(34, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer review') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="35" @if (in_array(35, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="36" @if (in_array(36, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Client review') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="37" @if (in_array(37, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="38" @if (in_array(38, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Support Ticket Category') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="39" @if (in_array(39, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="40" @if (in_array(40, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="41" @if (in_array(41, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="42" @if (in_array(42, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Support default assigned') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="43" @if (in_array(43, $permissions)) checked @endif> {{ translate('Assign ticket') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Support ticket') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="44" @if (in_array(44, $permissions)) checked @endif> {{ translate('Active tickets View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="45" @if (in_array(45, $permissions)) checked @endif> {{ translate('Ticket Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('My Support ticket') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="46" @if (in_array(46, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="47" @if (in_array(47, $permissions)) checked @endif> {{ translate('Ticket Reply') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Solve support ticket') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="48" @if (in_array(48, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="49" @if (in_array(49, $permissions)) checked @endif> {{ translate('Ticket Reply') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Accounting summary') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="50" @if (in_array(50, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Project payment history') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="51" @if (in_array(51, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="52" @if (in_array(52, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Package payment history') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="53" @if (in_array(53, $permissions)) checked @endif> {{ translate('Client Package History') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="54" @if (in_array(54, $permissions)) checked @endif> {{ translate('Freelancer Package History') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Milestone payment request') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="55" @if (in_array(55, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="56" @if (in_array(56, $permissions)) checked @endif> {{ translate('Details View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Freelancer payment') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="57" @if (in_array(57, $permissions)) checked @endif> {{ translate('Payment History from Admin') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Wallet recharge') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="58" @if (in_array(58, $permissions)) checked @endif> {{ translate('Wallet recharge History') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Role') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="59" @if (in_array(59, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="60" @if (in_array(60, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="61" @if (in_array(61, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="62" @if (in_array(62, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Configuration') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="63" @if (in_array(63, $permissions)) checked @endif> {{ translate('System Configuration') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="64" @if (in_array(64, $permissions)) checked @endif> {{ translate('Activation configuration') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="65" @if (in_array(65, $permissions)) checked @endif> {{ translate('Payment Gateway Configuration') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="66" @if (in_array(66, $permissions)) checked @endif> {{ translate('Social Media And 3rd party') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Currency') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="67" @if (in_array(67, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="68" @if (in_array(68, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="69" @if (in_array(69, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="70" @if (in_array(70, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="71" @if (in_array(71, $permissions)) checked @endif> {{ translate('Currency Configuration') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Country') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="72" @if (in_array(72, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="73" @if (in_array(73, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="74" @if (in_array(74, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="75" @if (in_array(75, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('State') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="76" @if (in_array(76, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="77" @if (in_array(77, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="78" @if (in_array(78, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="79" @if (in_array(79, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Policy') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="80" @if (in_array(80, $permissions)) checked @endif> {{ translate('View') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="81" @if (in_array(81, $permissions)) checked @endif> {{ translate('Update') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Employee') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="85" @if (in_array(85, $permissions)) checked @endif> {{ translate('Create') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="86" @if (in_array(86, $permissions)) checked @endif> {{ translate('Edit') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="87" @if (in_array(87, $permissions)) checked @endif> {{ translate('Delete') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label>{{ translate('Pay to Freelancer') }}</label>
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="permissions[]" value="91" @if (in_array(91, $permissions)) checked @endif> {{ translate('Pay') }}
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group mb-3 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                </div>
            </div>
        </div>
    </form>



@endsection

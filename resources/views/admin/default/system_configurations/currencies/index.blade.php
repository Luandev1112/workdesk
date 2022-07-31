@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Currency List')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
            <a href="{{ route('currencies.create') }}" class="btn btn-primary" title="{{translate('Add New Currency')}}">
                {{ translate('Add New Currency') }}
            </a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h5 class="h6 mb-0">{{translate('System Default Currency')}}</h5>
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="{{ route('system_configuration.update') }}" method="POST">
					@csrf
					<div class="form-group mb-3">
						<input type="hidden" name="types[]" value="system_default_currency">
						<div class="row">
							<div class="offset-lg-1 col-md-8">
								<select class="form-control aiz-selectpicker" name="system_default_currency" data-live-search="true" data-placeholder="Choose ..." required>
									@foreach ($currencies as $key => $currency)
										<option value="{{ $currency->id }}" @if (\App\Models\SystemConfiguration::where('type', 'system_default_currency')->first()->value == $currency->id) selected @endif>{{ $currency->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="h6 mb-0">{{translate('Currency Formats')}}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('system_configuration.update') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-5">
								<input type="hidden" name="types[]" value="symbol_format">
                                <select class="form-control aiz-selectpicker" name="symbol_format" data-placeholder="Choose ..." required>
									<option value="1" @if(\App\Models\SystemConfiguration::where('type', 'symbol_format')->first()->value == 1) selected @endif>[Symbol] [Amount]</option>
                                	<option value="2" @if(\App\Models\SystemConfiguration::where('type', 'symbol_format')->first()->value == 2) selected @endif>[Amount] [Symbol]</option>
                                </select>
                            </div>
                            <div class="col-md-5">
								<input type="hidden" name="types[]" value="no_of_decimals">
                                <select class="form-control aiz-selectpicker" name="no_of_decimals" data-placeholder="Choose ..." required>
									<option value="0" @if(\App\Models\SystemConfiguration::where('type', 'no_of_decimals')->first()->value == 0) selected @endif>12345</option>
	                                <option value="1" @if(\App\Models\SystemConfiguration::where('type', 'no_of_decimals')->first()->value == 1) selected @endif>1234.5</option>
	                                <option value="2" @if(\App\Models\SystemConfiguration::where('type', 'no_of_decimals')->first()->value == 2) selected @endif>123.45</option>
	                                <option value="3" @if(\App\Models\SystemConfiguration::where('type', 'no_of_decimals')->first()->value == 3) selected @endif>12.345</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="h6 mb-0">{{translate('All Currencies')}}</h5>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Currency name')}}</th>
                            <th>{{translate('Currency symbol')}}</th>
                            <th>{{translate('Currency code')}}</th>
                            {{-- <th>{{translate('Exchange rate')}}(1 USD = ?)</th> --}}
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies as $key => $currency)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->code }}</td>
                                {{-- <td>{{ $currency->exchange_rate }}</td> --}}
                                <td class="text-right">
									@if($currency->id != 1)
	                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{route('currencies.edit',encrypt($currency->id))}}" title="{{translate('Edit')}}">
	                                        <i class="las la-pen"></i>
	                                    </a>
										@php
											$system_default_currency = \App\Utility\SettingsUtility::get_settings_value('system_default_currency');
										@endphp
										@if($system_default_currency != $currency->id)
		                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('currencies.destroy', $currency->id)}}" title="{{translate('Delete')}}">
		                                        <i class="las la-trash"></i>
		                                    </a>
										@endif
									@endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

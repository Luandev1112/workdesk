@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="" id="sort_freelancer_payment_list" action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col text-center text-md-left">
                            <h1 class="mb-0 h6">{{translate('Freelnacer Payments')}}</h1>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by Name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
                                <div class="input-group-append">
                                    <button class="btn btn-light" type="submit">
                                        <i class="las la-search la-rotate-270"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="aiz-date-range form-control" @isset($sort_search_by_date) value="{{ $sort_search_by_date }}" @endisset name="date" placeholder="Select time and Search" data-advanced-range="true" autocomplete="off"/>
                                <div class="input-group-append">
                                    <button class="btn btn-light" type="submit">
                                        <i class="las la-search la-rotate-270"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{translate('Payment By')}}</th>
                                <th>{{translate('Payment To')}}</th>
                                <th>{{translate('Paid Amount')}}</th>
                                <th data-breakpoints="md">{{translate('Paid Method')}}</th>
                                <th data-breakpoints="md">{{translate('Paid Status')}}</th>
                                <th data-breakpoints="md">{{translate('Paid At')}}</th>
                                <th data-breakpoints="md" class="text-right">{{translate('Reciept')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pay_to_freelancers as $key => $pay_to_freelancer)
                                <tr>
                                    <td>{{ ($key+1) + ($pay_to_freelancers->currentPage() - 1)*$pay_to_freelancers->perPage() }}</td>
                                    @if ($pay_to_freelancer->admin != null)
                                        <td>
                                            {{$pay_to_freelancer->admin->name}}
                                        </td>
                                    @else
                                        <td>
                                            {{translate('Not Found')}}
                                        </td>
                                    @endif
                                    <td>
                                        @if ($pay_to_freelancer->user != null)
                                            {{$pay_to_freelancer->user->name}}
                                        @else
                                            {{translate('Not Found')}}
                                        @endif
                                    </td>
                                    <td>
                                        {{single_price($pay_to_freelancer->paid_amount)}}
                                    </td>
                                    <td>
                                        {{strtoupper($pay_to_freelancer->payment_method)}}
                                    </td>
                                    <td>
                                        @if ($pay_to_freelancer->paid_status != 0)
                                            <span class="badge badge-inline badge-primary">{{ translate('Paid') }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate('Non-Paid') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$pay_to_freelancer->created_at}}
                                    </td>
                                    <td class="text-right">
                                        @if ($pay_to_freelancer->reciept != null)
                                            <a href="{{ custom_asset($pay_to_freelancer->reciept) }}" target="_blank" class="badge badge-inline badge-primary">{{ translate('Show Reciept') }}</a>
                                        @elseif(!$pay_to_freelancer->paid_status)
                                            <span class="badge badge-inline badge-secondary">N/A</span>
                                        @else
                                            <span class="badge badge-inline badge-secondary">{{ translate('No Reciept') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagimation">
                        {{ $pay_to_freelancers->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

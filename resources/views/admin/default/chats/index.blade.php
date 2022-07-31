@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="chat_list" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Chat Lists')}}</h5>
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
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Client')}}</th>
                            <th>{{translate('Freelancer')}}</th>
                            <!-- <th data-breakpoints="md">{{translate('Chat Status')}}</th> -->
                            <!-- <th data-breakpoints="md">{{translate('Blocked by')}}</th> -->
                            <th data-breakpoints="md">{{translate('Chat Started')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chat_threads as $key => $chat_thread)
                            <tr>
                                <td>{{ ($key+1) + ($chat_threads->currentPage() - 1)*$chat_threads->perPage() }}</td>
                                @if ($chat_thread->sender != null)
                                    <td>
                                        {{$chat_thread->sender->name}}
                                    </td>
                                @else
                                    <td>
                                        {{translate('Not Found')}}
                                    </td>
                                @endif

                                @if ($chat_thread->receiver != null)
                                    <td>
                                        {{$chat_thread->receiver->name}}
                                    </td>
                                @else
                                    <td>
                                        {{translate('Not Found')}}
                                    </td>
                                @endif
                                <!-- @if ($chat_thread->active != 0)
                                    <td>
                                        <span class="badge badge-primary badge-inline">{{translate('Active')}}</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge badge-danger badge-inline">{{translate('Blocked')}}</span>
                                    </td>
                                @endif -->
                                <!-- @if ($chat_thread->blocked_by_user != null)
                                    <td>
                                        {{$chat_thread->blocked_by->name}}
                                    </td>
                                @else
                                    <td>
                                        <span class="badge badge-secondary badge-inline">{{translate('Running')}}</span>
                                    </td>
                                @endif -->
                                <td>
                                    {{$chat_thread->created_at}}
                                </td>
                                <td class="text-right">
                                    @can ('single_user_chat_details')
                                        <a href="{{ route('chat_details_for_admin', encrypt($chat_thread->id)) }}" class="btn btn-sm btn-icon btn-circle btn-soft-primary" title="{{ translate('Edit') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $chat_threads->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

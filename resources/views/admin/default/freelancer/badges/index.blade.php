@extends('admin.default.layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h1 class="mb-0 h6">{{translate('Badges list')}}</h1>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Title')}}</th>
                            <th>{{translate('Type')}}</th>
                            <th>{{translate('Min number')}}</th>
                            <th>{{translate('Icon')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($badges as $key => $badge)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$badge->name}}</td>
                                <td class="text-capitalize">{{str_replace('_', ' ', $badge->type)}}</td>
                                <td>
                                    @if($badge->type == 'project_badge')
                                        {{$badge->value}} {{translate('Projects')}}
                                    @elseif($badge->type == 'earning_badge')
                                        {{single_price($badge->value)}} {{translate('Earnings')}}
                                    @else
                                        {{$badge->value}} {{translate('Days')}}
                                    @endif
                                </td>
                                <td>
                                    <span class="avatar avatar-square avatar-xs">
                                        <img src="{{ custom_asset($badge->icon) }}">
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('badges.edit', encrypt($badge->id)) }}" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('badges.destroy', $badge->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $badges->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h1 class="mb-0 h6">{{translate('Add New Badge')}}</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Title')}}</label>
                            <input type="text" id="name" name="name" required placeholder="{{ translate('Eg. Completed 100+ projects') }}" class="form-control" required>
                        </div>
                        <input type="hidden" name="role_id" value="freelancer">
                        <div class="form-group mb-3">
                            <label for="type">{{translate('Badge Type')}}</label>
                            <select class="select2 form-control aiz-selectpicker" name="type" id="type" data-show="selectShow" data-target=".min-num-type" data-placeholder="Choose ...">
                                <option value="project_badge">{{translate('Project Badge')}}</option>
                                <option value="earning_badge">{{translate('Earning Badge')}}</option>
                                <option value="membership_badge">{{translate('Membership Badge')}}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="min_value" class="min-num-type">{{translate('Min number of ')}}
                                <span class="project_badge">{{translate('project')}}</span>
                                <span class="earning_badge d-none">{{translate('earnings')}}</span>
                                <span class="membership_badge d-none">{{translate('account age - in days')}}</span>
                            </label>
                            <input type="number" id="value" name="value" min="0" step="1" placeholder="{{ translate('Eg. 100') }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{translate('Badge Icon')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="icon" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small class="form-text text-muted">.svg {{ translate('file recommended') }}</small>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add New Badge')}}</button>
                        </div>
                    </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

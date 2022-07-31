@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('Skill list')}}</h1>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{translate('Skill')}}</th>
                                <th class="text-right">{{translate('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skills as $key => $skill)
                                <tr>
                                    <td>{{ ($key+1) + ($skills->currentPage() - 1)*$skills->perPage() }}</td>
                                    <td>{{$skill->name}}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('skills.edit', encrypt($skill->id)) }}" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('skills.destroy', $skill->id)}}" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination aiz-pagination-center">
                        {{ $skills->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate(' Add New Skill')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('skills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" placeholder="{{ translate('Eg. wordpress') }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add New Skill')}}</button>
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

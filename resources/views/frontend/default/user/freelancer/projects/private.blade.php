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
                                <h1 class="h3"> {{ translate('Project Proposals') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        @forelse ($private_projects as $key => $private_project)
                            @if ($private_project->project != null)
                                <div class="card project-card">
                                    <div class="card-header border-bottom-0">
                                        <div>
                                            <span class="badge badge-primary badge-inline badge-md">{{ single_price($private_project->project->price) }}</span>
                                        </div>
                                        <div>
                                            <span class="badge badge-secondary badge-inline badge-md">{{ translate('Pending') }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body pt-1">
                                        <h5 class="h6 fw-600 lh-1-5">
                                            <a href="{{ route('project.details', $private_project->project->slug) }}" class="text-inherit" target="_blank">{{ $private_project->project->name }}</a>
                                        </h5>
                                        <ul class="list-inline opacity-70 fs-12">
                                            <li class="list-inline-item">
                                                <i class="las la-clock opacity-40"></i>
                                                <span>{{ Carbon\Carbon::parse($private_project->created_at)->diffForHumans() }}</span>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" target="_blank" class="text-inherit">
                                                    <i class="las la-stream opacity-40"></i>
                                                    <span>@if ($private_project->project->project_category != null) {{ $private_project->project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="las la-handshake"></i>
                                                <span>{{ $private_project->project->type }}</span>
                                            </li>
                                        </ul>
                                        <div class="text-muted lh-1-8">
                                            <p>{{ $private_project->project->excerpt }}</p>
                                        </div>
                                        <div>
                                            @foreach (json_decode($private_project->project->skills) as $key => $skill_id)
                                                @php
                                                    $skill = \App\Models\Skill::find($skill_id);
                                                @endphp
                                                @if ($skill != null)
                                                    <a href="" class="btn btn-light btn-xs">{{ $skill->name }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('client.details', $private_project->client->user_name) }}" class="d-flex mr-3 align-items-center text-reset">
                                            <span class="avatar avatar-xs overflow-hidden">
                                                <img class="img-fluid rounded-circle" src="{{ custom_asset($private_project->client->photo) }}">
                                            </span>
                                            <div class="pl-2">
                                                <h4 class="fs-14 mb-1">{{ $private_project->client->name }}</h4>
                                                <div class="text-secondary fs-10">
                                                    <i class="las la-star text-warning"></i>
                                                    <span class="fw-600">{{ formatRating(getAverageRating($private_project->client->id)) }}</span>
                                                    <span>({{ getNumberOfReview($private_project->client->id) }} {{ translate('reviews') }})</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div>
                                            <a href="{{ route('hiring.reject', encrypt($private_project->id)) }}" class="btn btn-danger btn-sm">{{ translate('Reject') }}</a>
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="hiring_modal('{{ $private_project->project->name }}',{{ $private_project->project->price }}, {{ $private_project->project->id }}, {{ Auth::user()->id }})">{{ translate('Accpet') }}</a>
                                            <a href="{{ route('all.messages') }}" class="btn btn-primary btn-sm">{{ translate('Chat With Client') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                    <h4>{{ translate('Nothing Found') }}</h4>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="aiz-pagination">
                        {{ $private_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script type="text/javascript">
        function hiring_modal(project_name,project_price, project_id, user_id){
            $('input[name=project_name]').val(project_name);
            $('input[name=amount]').val(project_price);
            $('input[name=project_id]').val(project_id);
            $('input[name=user_id]').val(user_id);
            $('#hiring_modal').modal('show');
        }
    </script>
@endsection

@section('modal')
<div class="modal fade" id="hiring_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Confirm Hiring') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="hiring_modal_body">
                <form class="form-horizontal" action="{{ route('hiring_confirmation_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="user_id" value="" required>
                    <input type="hidden" name="project_id" value="" required>

                    <div class="form-group">
                        <label class="form-label">
                            {{translate('Project')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="project_name" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            {{translate('Amount')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-sm" name="amount" value="" min="1" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

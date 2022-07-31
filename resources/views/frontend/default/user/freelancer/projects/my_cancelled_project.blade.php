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
                                <h1 class="h3">{{ translate('Cancelled Projects') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        @forelse ($cancelled_projects as $cancelled_project_id)
                            @php
                                $cancelled_project = \App\Models\Project::find($cancelled_project_id->id);
                            @endphp
                            <div class="card project-card">
                                <div class="card-header border-bottom-0">
                                    <div>
                                        <span class="badge badge-primary badge-inline badge-md">{{ single_price($cancelled_project->project_user->hired_at) }}</span>
                                    </div>
                                    <div>
                                        <span class="badge badge-danger badge-inline badge-md">{{ translate('Cancellled') }}</span>
                                    </div>
                                </div>
                                <div class="card-body pt-1">
                                    <h5 class="h6 fw-600 lh-1-5">
                                        <a href="{{ route('project.details', $cancelled_project->slug) }}" class="text-inherit" target="_blank">{{ $cancelled_project->name }}</a>
                                    </h5>
                                    <ul class="list-inline opacity-70 fs-12">
                                        <li class="list-inline-item">
                                            <i class="las la-clock opacity-40"></i>
                                            <span>{{ Carbon\Carbon::parse($cancelled_project->created_at)->diffForHumans() }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="" target="_blank" class="text-inherit">
                                                <i class="las la-stream opacity-40"></i>
                                                <span>@if ( $cancelled_project->project_category != null) {{ $cancelled_project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="las la-handshake"></i>
                                            <span>{{ $cancelled_project->type }}</span>
                                        </li>
                                    </ul>
                                    <div class="text-muted lh-1-8">
                                        <p>{{ $cancelled_project->excerpt }}</p>
                                    </div>
                                    <div>
                                        @foreach (json_decode($cancelled_project->skills) as $key => $skill_id)
                                            @php
                                                $skill = \App\Models\Skill::find($skill_id);
                                            @endphp
                                            @if ($skill != null)
                                                <span class="btn btn-light btn-xs mb-1">{{ $skill->name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('client.details', $cancelled_project->client->user_name) }}" class="d-flex mr-3 align-items-center text-reset">
                                            <span class="avatar avatar-xs overflow-hidden">
                                                <img class="img-fluid rounded-circle" src="{{ custom_asset($cancelled_project->client->photo) }}">
                                            </span>
                                            <div class="pl-2">
                                                <h4 class="fs-14 mb-1">{{ $cancelled_project->client->name }}</h4>
                                                <div class="">
                                                    <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                        {{ getAverageRating($cancelled_project->client->id) }}
                                                    </span>
                                                    <span class="opacity-50">
                                                        ({{ getNumberOfReview($cancelled_project->client->id) }} {{ translate('Reviews') }})
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <span class="badge badge-inline badge-soft-secondary">
                                        {{ translate('Cancelled By') }}
                                        @if ($cancelled_project != null && $cancelled_project->cancel_by_user != null)
                                            {{ $cancelled_project->cancel_by_user->name }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                    <h4>{{ translate('Nothing Found') }}</h4>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="aiz-pagination aiz-pagination-center">
                        {{ $cancelled_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

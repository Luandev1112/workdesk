@extends('frontend.default.layouts.app')

@section('content')
<section class="py-4 py-lg-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.freelancer.inc.sidebar')
            <div class="aiz-user-panel">
            	<h5 class="mb-4">{{ translate('Bookmarked Projects') }}</h5>
                <div class="row gutters-10">
                    @forelse ($bookmarked_projects as $key => $bookmarked_project)
                        @if (($project = $bookmarked_project->project) != null)
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-bottom-0 pt-4 pb-0 align-items-start minw-0">
                                        <h5 class="h6 fw-600 lh-1-5 text-truncate-2 h-45px">
                                            <a href="{{ route('project.details', $project->slug) }}" class="text-inherit" target="_blank" tabindex="0">{{ $project->name }}</a>
                                        </h5>
                                        <div class="text-right flex-shrink-0 pl-3">
                                            <span class="small">{{ translate('Budget') }}</span>
                                            <h4 class="mb-0">{{ single_price($project->price) }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-body pt-1">

                                        <ul class="list-inline opacity-70 fs-12">
                                            <li class="list-inline-item">
                                                <i class="las la-clock opacity-40"></i>
                                                <span>{{ Carbon::parse($project->created_at)->diffForHumans() }}</span>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" target="_blank" class="text-inherit" tabindex="0">
                                                    <i class="las la-stream opacity-40"></i>
                                                    <span> {{ $project->project_category->name }} </span>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="las la-handshake"></i>
                                                <span>{{ $project->type }}</span>
                                            </li>
                                        </ul>
                                        <div class="text-muted lh-1-8">
                                            <p class="text-truncate-2 h-50px mb-0">{{ $project->excerpt }}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('client.details', $project->client->user_name) }}" target="_blank" class="d-flex mr-3 align-items-center text-inherit" tabindex="0">
                                                <span class="avatar avatar-xs">
                                                    <img class="img-fluid rounded-circle" alt="Sheila Cochran" src="{{ custom_asset($project->client->photo) }}">
                                                </span>
                                                <div class="pl-2">
                                                    <h4 class="h6 mb-0">{{ $project->client->name }}</h4>
                                                    <div class="text-secondary fs-10">
                                                        <i class="las la-star text-rating"></i>
                                                        <span class="fw-600">
                                                            {{ formatRating(getAverageRating($project->client->id)) }}
                                                        </span>
                                                        <span>
                                                            ({{ getNumberOfReview($project->client->id) }} {{ translate('Reviews') }})
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div>
                                            <a class="d-inline-block confirm-alert" href="javascript:void(0)" data-href="{{ route('bookmarked-projects.destroy', $bookmarked_project->id) }}" data-toggle="tooltip" title="{{ translate('Remove from bookmark') }}" data-target="#bookmark-remove-modal">
                                                <i class="las la-bookmark la-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="card flex-grow-1">
                            <div class="card-body text-center">
                                <i class="las la-frown la-4x mb-4 opacity-40"></i>
                                <h4>{{ translate('Nothing Found') }}</h4>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="aiz-pagination mt-4">
                    {{ $bookmarked_projects->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('modal')
    @include('frontend.default.partials.bookmark_remove_modal')
@endsection

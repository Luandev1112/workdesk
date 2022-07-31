@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.default.user.client.inc.sidebar')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Open Projects') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        @forelse ($projects as $key => $project)
							<div class="card project-card">
								<div class="card-header border-bottom-0">
									<div>
										<span class="badge badge-primary badge-inline badge-md">{{ single_price($project->price) }}</span>
									</div>
									<div>
										@if($project->private == 1)
											<span class="badge badge-warning badge-inline badge-md">{{ translate('Private') }}</span>
										@else
											<span class="badge badge-success badge-inline badge-md">{{ translate('Published') }}</span>
										@endif
									</div>
								</div>
								<div class="card-body pt-1">
									<h5 class="h6 fw-600 lh-1-5">
										<a href="{{ route('project.details', $project->slug) }}" class="text-inherit" target="_blank">{{ $project->name }}</a>
									</h5>
									<ul class="list-inline opacity-70 fs-12">
										<li class="list-inline-item">
											<i class="las la-clock opacity-40"></i>
											<span>{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
										</li>
										<li class="list-inline-item">
											<a href="" target="_blank" class="text-inherit">
												<i class="las la-stream opacity-40"></i>
												<span>@if ($project->project_category != null) {{ $project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
											</a>
										</li>
										<li class="list-inline-item">
											<i class="las la-handshake"></i>
											<span>{{ $project->type }}</span>
										</li>
									</ul>
									<div class="text-muted lh-1-8">
										<p>{{ $project->excerpt }}</p>
									</div>
									<div>
                                        @foreach (json_decode($project->skills) as $key => $skill_id)
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
										<ul class="d-flex list-inline mb-0">
											<li>
				                                <span class="small text-secondary">{{ translate('Total Bids') }}</span>
                                                @if ($project->bids > 0)
                                                    <h4 class="mb-0 h6 fs-13">{{ $project->bids }} +</h4>
                                                @else
                                                    <h4 class="mb-0 h6 fs-13">{{ $project->bids }}</h4>
                                                @endif
											</li>
										</ul>
									</div>
									<div>
                                        <a href="javascript:void(0)" class="btn btn-secondary btn-sm fw-500 confirm-cancel" data-href="{{route('projects.cancel', $project->id)}}">{{ translate('Cancel Project') }}</a>

                                        @if($project->private != 1)
                                        	<a href="{{ route('project.bids', $project->slug) }}" class="btn btn-primary btn-sm fw-500">{{translate('See All Bidders')}}</a>
                                        @endif
									</div>
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
	                    {{ $projects->links() }}
	                </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('modal')
    @include('frontend.default.partials.cancel_modal')
@endsection

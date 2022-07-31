@extends('frontend.default.layouts.app')

@section('content')

    @php
        $profile = \App\Models\UserProfile::where('user_id', $project->client_user_id)->where('user_role_id', 3)->first();
    @endphp

    <section class="py-4 py-lg-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-xxl-9 col-xl-8 col-lg-7">
					<div class="card project-card">
						<div class="card-header d-block">
							<h5 class="my-3 lh-1-5">{{ $project->name }}</h5>

							<ul class="list-inline opacity-70 fs-13">
								<li class="list-inline-item">
									<i class="las la-clock opacity-40"></i>
									<span>{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
								</li>
								<li class="list-inline-item">
									<a href="" target="_blank" class="text-inherit">
										<i class="las la-stream opacity-40"></i>
										<span>@if ($project->project_category != null) {{ $project->project_category->name }} @endif</span>
									</a>
								</li>
								<li class="list-inline-item">
									<i class="las la-handshake"></i>
									<span>{{ $project->type }}</span>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="text-muted lh-2 mb-5">
								<div>
									@php echo $project->description; @endphp
								</div>
							</div>
							<h6 class="separator text-left mb-3"><span class="bg-white pr-3">{{ translate('Skills Required') }}</span></h6>
							<div class="mb-5">
                                @foreach (json_decode($project->skills) as $key => $skill_id)
                                    @php
                                        $skill = \App\Models\Skill::find($skill_id);
                                    @endphp
                                    @if ($skill != null)
                                        <a href="{{ route('search.skill', ['skill' => $skill_id, 'type' => 'projects']) }}" class="btn btn-light btn-xs mb-1">{{ $skill->name }}</a>
                                    @endif
                                @endforeach
							</div>
							<h6 class="separator text-left mb-3"><span class="bg-white pr-3">{{ translate('Attachments') }}</span></h6>
                            <div class="file-preview box">
                                @foreach (explode(',', $project->attachment) as $key => $attachment_id)
                                    @php
                                        $attachment = \App\Upload::find($attachment_id);
                                    @endphp
                                    @if ($attachment != null)
                                        @if ($attachment->type == 'image')
                                            <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                    <div class="thumb">
                                                        <img src="{{ my_asset($attachment->file_name) }}" class="img-fit">
                                                    </div>
                                                    <div class="body">
                                                        <h6 class="d-flex">
                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                        </h6>
                                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="mb-2 file-preview-item" title="{{ $attachment->file_name }}">
                                                <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block">
                                                    <div class="thumb">
                                                        <i class="la la-file-text"></i>
                                                    </div>
                                                    <div class="body">
                                                        <h6 class="d-flex">
                                                            <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                            <span class="ext">.{{ $attachment->extension }}</span>
                                                        </h6>
                                                        <p>{{formatBytes($attachment->file_size)}}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-secondary" role="alert">
                                            {{ translate('No attachment') }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <h6 class="separator text-left mb-3">Proposals</h6>

                            <div class="mb-5">
                                
                                @foreach ($bids->get() as $bid)
                                <textarea rows="20" style="width: 100%">{{ $bid->message }}</textarea>
                                <h3> ----------------------------------------- </h3> 
                                @endforeach

                            </div>
						</div>
					</div>
				</div>
				<div class="col-xxl-3 col-xl-4 col-lg-5">
					<div class="sticky-top z-3">
						<div class="card project-card">
							<div class="card-header py-4">
								<div>
									<span class="small">{{ translate('Budget') }}</span>
									<h4 class="mb-0 fw-900">{{ single_price($project->price) }}</h4>
								</div>
                                @if (!Auth::check())
                                    <div class="alert alert-info" role="alert">
                                        {{ translate('You need to login as a freelancer to bid the project.') }}
                                    </div>
                                @elseif (Auth::check() && auth()->user()->user_type == 'admin')
                                    <div class="alert alert-info" role="alert">
                                        {{ translate('You are visiting this details as an Admin. For place a bid you need to have a freelancer account.') }}
                                    </div>
                                @elseif (Auth::check() && isFreelancer() && !$project->private)
                                    @php
                                        $allow_for_bid = \App\Models\ProjectBid::where('project_id', $project->id)->where('bid_by_user_id', Auth::user()->id)->first();
                                    @endphp
                                    @if ($allow_for_bid == null)
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="bid_modal({{ $project->id }})">{{ translate('Place Bid') }}</a>
                                    @else
                                        <div class="alert alert-info m-2" role="alert">
                                            {{ translate('You have already submitted bid for this project.') }}
                                        </div>
                                    @endif
                                @endif
							</div>
							<div class="card-body">
								<div class="mb-5">
									<div class="d-flex justify-content-between mb-3">
										<span class="text-secondary">{{ translate('Posted') }} -</span>
										<span class="fw-600">{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
									</div>
									<div class="d-flex justify-content-between mb-3">
										<span class="text-secondary">{{ translate('Posted in') }} -</span>
										<span class="fw-600">@if ($project->project_category != null) {{ $project->project_category->name }} @endif</span>
									</div>
									<div class="d-flex justify-content-between mb-3">
										<span class="text-secondary">{{ translate('Project type') }} -</span>
										<span class="fw-600">{{ $project->type }}</span>
									</div>
								</div>
								<div>
									<h6 class="separator mb-4"><span class="bg-white px-3">{{ translate('About This Client') }}</span></h6>
                                    <a href="{{ route('client.details',$project->client->user_name) }}" class="text-inherit">
									   <div class="px-4 text-center mb-3">
    										<span class="avatar avatar-md mb-3">
                                                @if($project->client->photo != null)
                                                    <img src="{{ custom_asset($project->client->photo) }}">
                                                @else
                                                    <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                @endif
                                                @if(Cache::has('user-is-online-' . $project->client_user_id ))
                                                    <span class="badge badge-dot badge-success badge-circle badge-status"></span>
                                                @else
                                                    <span class="badge badge-dot badge-secondary badge-circle badge-status"></span>
                                                @endif
    										</span>
    										<div class="text-secondary fs-10 mb-1">
    											<i class="las la-star text-rating"></i>
                                                <span class="fw-600">
                                                    {{ formatRating(getAverageRating($project->client->id)) }}
                                                </span>
                                                <span>
                                                    ({{ getNumberOfReview($project->client->id) }} {{ translate('Reviews') }})
                                                </span>
    										</div>
    										<h4 class="h5 mb-2 fw-600">@if ($project->client != null) {{ $project->client->name }} @endif</h4>
    										<div class="text-center">
    											@foreach ($project->client->badges as $key => $user_badge)
                                                    @if ($user_badge->badge != null)
                                                        <span class="avatar avatar-square avatar-xxs" title="{{ $user_badge->badge->name }}"><img src="{{ custom_asset($user_badge->badge->icon) }}"></span>
                                                    @endif
                                                @endforeach
    				                        </div>
    									</div>
                                    </a>

									<div class="">
                                        <div class="media mb-3">
                                            <div class="text-center text-primary mt-1 mr-3">
                                                <i class="las la-map-marked la-2x"></i>
                                            </div>
                                            <div class="media-body pt-2">
                                                @if ($project->client != null && $project->client->address != null && $project->client->address->city != null && $project->client->address->country != null)
                                                    <span class="d-block font-weight-medium">{{ $project->client->address->city->name }}, {{ $project->client->address->country->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="media mb-3">
                                            <div class="text-center text-primary mt-1 mr-3">
                                                <i class="las la-briefcase la-2x"></i>
                                            </div>
                                            <div class="media-body pt-2">
                                                <span class="d-block font-weight-medium">{{ count($project->client->number_of_projects) }} {{ translate('jobs posted') }}</span>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="text-center text-primary mt-1 mr-3">
                                                <i class="las la-money-check-alt la-2x"></i>
                                            </div>
                                            <div class="media-body pt-2">
                                                <span class="d-block font-weight-medium">{{ single_price(\App\Models\MilestonePayment::where('client_user_id', $project->client_user_id)->where('paid_status', 1)->sum('amount')) }} {{ translate('total spent') }}</span>
                                            </div>
                                        </div>
			                        </div>
								</div>
							</div>
						</div>
                        <div>
                            @if (Auth::check() && ($bookmarked_project = \App\Models\BookmarkedProject::where('user_id', auth()->user()->id)->where('project_id', $project->id)->first()) != null)
                                <a class="btn btn-block btn-primary confirm-alert" href="javascript:void(0)" data-href="{{ route('bookmarked-projects.destroy', $bookmarked_project->id) }}" data-target="#bookmark-remove-modal">
                                    <i class="las la-bookmark"></i>
                                    <span>{{ translate('Remove Bookmark') }}</span>
                                </a>
                            @else
                                <a class="btn btn-block btn-outline-primary" href="{{ route('bookmarked-projects.store', encrypt($project->id)) }}">
                                    <i class="las la-bookmark"></i>
                                    <span>{{ translate('Bookmark Project') }}</span>
                                </a>
                            @endif
                        </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h5 class="mb-4">{{ translate('Similar Projects') }}</h5>
					<div class="aiz-carousel gutters-10 half-outside-arrow" data-items="3" data-xl-items="2" data-md-items="1" data-arrows='true'>

                        @foreach ($similar_types = \App\Models\Project::where('type', $project->type)->where('id', '!=' , $project->id)->where('closed', '!=', 1)->limit(4)->get() as $similar_type_project)
                            @if (count($similar_types) > 0)
        						<div class="caorusel-box">
        							<div class="card">
        								<div class="card-header border-bottom-0 pt-4 pb-0 align-items-start minw-0">
        									<h5 class="h6 fw-600 lh-1-5 text-truncate-2 h-45px">
        										<a href="{{ route('project.details', $similar_type_project->slug) }}" class="text-inherit" target="_blank">{{ $similar_type_project->name }}</a>
        									</h5>
        									<div class="text-right flex-shrink-0 pl-3">
        										<span class="small">{{ translate('Budget') }}</span>
        										<h4 class="mb-0">{{ single_price($similar_type_project->price) }}</h4>
        									</div>
        								</div>
        								<div class="card-body pt-1">

        									<ul class="list-inline opacity-70 fs-12">
        										<li class="list-inline-item">
        											<i class="las la-clock opacity-40"></i>
        											<span>{{ Carbon\Carbon::parse($similar_type_project->created_at)->diffForHumans() }}</span>
        										</li>
        										<li class="list-inline-item">
        											<a href="" target="_blank" class="text-inherit">
        												<i class="las la-stream opacity-40"></i>
        												<span>@if ($similar_type_project->project_category != null) {{ $similar_type_project->project_category->name }} @endif</span>
        											</a>
        										</li>
        										<li class="list-inline-item">
        											<i class="las la-handshake"></i>
        											<span>{{ $similar_type_project->type }}</span>
        										</li>
        									</ul>
        									<div class="text-muted lh-1-8">
        										<p class="text-truncate-2 h-50px mb-0">{{ $similar_type_project->excerpt }}</p>
        									</div>
        								</div>
        								<div class="card-footer">
        									<div class="d-flex align-items-center">
        										<a href="{{ route('client.details', $similar_type_project->client->user_name) }}" target="_blank" class="d-flex mr-3 align-items-center text-inherit">
        		                                    <span class="avatar avatar-xs">
                                                        @if($similar_type_project->client->photo != null)
                                                            <img src="{{ custom_asset($similar_type_project->client->photo) }}">
                                                        @else
                                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                        @endif
        		                                    </span>
        		                                    <div class="pl-2">
        		                                    	<h4 class="h6 mb-0">{{ $similar_type_project->client->name }}</h4>
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
        										<ul class="d-flex list-inline mb-0">
        											<li>
        				                                <span class="small text-secondary">{{ translate('Total Bids') }}</span>
                                                        @if ($similar_type_project->bids > 0)
                                                            <h4 class="mb-0 h6 fs-13">{{ $similar_type_project->bids }} +</h4>
                                                        @else
                                                            <h4 class="mb-0 h6 fs-13">{{ $similar_type_project->bids }}</h4>
                                                        @endif
        											</li>
        										</ul>
        									</div>
        								</div>
        							</div>
        						</div>
                            @endif
                        @endforeach
					</div>
				</div>
			</div>
		</div>
	</section>


@endsection
@section('script')
    <script type="text/javascript">
        function bid_modal(id){
            $.post('{{ route('get_bid_for_project_modal') }}', { _token: '{{ csrf_token() }}', id:id }, function(data){
                $('#bid_for_project').modal('show');
                $('#bid_for_modal_body').html(data);
            })
        }
    </script>
@endsection
@section('modal')
<div class="modal fade" id="bid_for_project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Bid For Project') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="bid_for_modal_body">

            </div>
        </div>
    </div>
</div>
@include('frontend.default.partials.bookmark_remove_modal')
@endsection

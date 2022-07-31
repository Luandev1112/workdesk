@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.default.user.client.inc.sidebar')
            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="h3">{{ translate('Bids for') }} {{ $project->name }}</h1>
                        </div>
                    </div>
                </div>
                <div class="">
                    @forelse ($bid_users as $key => $bid_user)
                        <div class="card">
                            <div class="card-body d-lg-flex">
                                <div class="flex-grow-1">
                                    <div class="d-flex">
                                        <a href="" target="_blank" class="avatar flex-shrink-0 mr-4">
                                            @if($bid_user->freelancer->photo != null)
                                                <img src="{{ custom_asset($bid_user->freelancer->photo) }}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                            @endif
                                            <span class="badge badge-dot badge-circle badge-secondary badge-status badge-md"></span>
                                        </a>
                                        <div class="flex-grow-1">
                                            <h5 class="fw-600 mb-1"><a href="" target="_blank" class="text-inherit">{{ $bid_user->freelancer->name }}</a></h5>
                                            @if($bid_user->freelancer->profile->specialist != null )
                                            <p class="opacity-50 mb-2">{{ $bid_user->freelancer->profile->specialistAt->name }}</p>
                                            @endif
                                            <div class="d-flex text-secondary fs-12 mb-3">
                                                <div class="mr-2">
                                                    <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                        {{ max(0, \App\Models\Review::where('published', 1)->where('reviewed_user_id', $bid_user->bid_by_user_id)->avg('rating')) }}
                                                    </span>
                                                    <span class="rating rating-sm">
                                                        {{ renderStarRating(max(0, \App\Models\Review::where('published', 1)->where('reviewed_user_id', $bid_user->bid_by_user_id)->avg('rating'))) }}
                                                    </span>
                                                    <span>
                                                        ({{ getNumberOfReview($bid_user->bid_by_user_id) }} {{ translate('Reviews') }})
                                                    </span>
                                                </div>
                                                <div>
                                                    <i class="las la-map-marker opacity-50"></i>
                                                        @if ($bid_user->freelancer->address != null && $bid_user->freelancer->address->city != null && $bid_user->freelancer->address->country != null)
                                                            <span>{{ $bid_user->freelancer->address->city->name }}, {{ $bid_user->freelancer->address->country->name }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-muted lh-1-8">
                                        <p class="">{{ $bid_user->message }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 pt-4 pt-xl-0 pl-xl-5 d-flex flex-row flex-xl-column justify-content-between">
                                    <div class="text-right">
                                        <h4 class="mb-0">{{ single_price($bid_user->amount) }}</h4>
                                        <div class="mt-xl-2 small text-secondary">
                                            <span>{{ translate('Bidded Amount') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($project->biddable == 1)
                                            <button onclick="hiring_modal({{ $project->id }}, {{ $bid_user->bid_by_user_id }})" type="button" class="btn btn-outline-secondary btn-sm btn-block">Hire now</button>
                                            <form class="mt-2" action="{{ route('call_for_interview') }}" method="post">
                                                @csrf
                                                <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                                                <input type="hidden" id="user_name" name="user_name" value="{{ $bid_user->freelancer->user_name }}">
                                                <button type="submit" class="btn btn-primary btn-sm btn-block">{{ translate('Call for Interview') }}</button>
                                            </form>
                                        @elseif($project->project_user != null && $project->project_user->user_id == $bid_user->bid_by_user_id)
                                            <button type="button" class="btn btn-primary btn-sm btn-block">{{ translate('Hired') }}</a>
                                        @endif
                                    </div>
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

                    <div class="aiz-pagination aiz-pagination-center mt-4">
                        {{ $bid_users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript">
        function hiring_modal(project_id, user_id){
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
                            <input type="text" class="form-control form-control-sm" name="project_name" value="{{ $project->name }}" disabled>
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
                        <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Hire Now') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

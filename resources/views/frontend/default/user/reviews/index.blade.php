@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">

                @if (isClient())
                @include('frontend.default.user.client.inc.sidebar')
                @elseif (isFreelancer())
                @include('frontend.default.user.freelancer.inc.sidebar')
                @endif
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">Reviews</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Reviews:</h5>
                            </div>
                            <div class="card-body">

                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th data-breakpoints="">#</th>
                                            <th data-breakpoints="">Project Name</th>
                                            <th data-breakpoints="">Reviewer Name</th>
                                            <th data-breakpoints="md">Reviews</th>
                                            <th data-breakpoints="md">Rating</th>
                                            <th data-breakpoints="md">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $key => $review)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                @if ($review->project != null)
                                                    <td>
                                                        {{$review->project->name}}
                                                    </td>
                                                @else
                                                    <td>
                                                        {{translate('Not Found')}}
                                                    </td>
                                                @endif
                                                @if ($review->reviewer != null)
                                                    <td>
                                                        {{$review->reviewer->name}}
                                                    </td>
                                                @else
                                                    <td>
                                                        {{translate('Not Found')}}
                                                    </td>
                                                @endif
                                                <td>{{ $review->review }}</td>
                                                <td>
                                                    <span class="rating rating-sm">
                                                        {{ renderStarRating($review->rating) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($review->published == 1)
                                                        <span class="badge badge-inline badge-success">{{translate('Published')}}</span>
                                                    @else
                                                        <span class="badge badge-inline badge-success">{{translate('Hidden')}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $reviews->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

@endsection

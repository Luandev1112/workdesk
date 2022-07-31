@extends('frontend.default.layouts.app')

@section('content')
<section class="py-4 py-lg-5">
    <div class="container">
        @if ($keyword != null)
            <div class="row">
                <div class="col-xl-8 offset-xl-2 text-center">
                    <h1 class="h5 mt-3 mt-lg-0 mb-5 fw-400">{{ translate('Total') }} <span class="fw-600">{{ $total }}</span> {{ translate('freelancers found for') }} <span class="fw-600">{{ $keyword }}</span></h1>
                </div>
            </div>
        @endif
        <form id="freelancer-filter-form" action="" method="GET">
            <div class="row gutters-10">
                <div class="col-xl-3 col-lg-4">
                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-lg z-1035">
                        <div class="card rounded-0 rounded-lg collapse-sidebar c-scrollbar-light">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Filter By') }}</h5>
                                <button class="btn btn-sm p-2 d-lg-none filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                        <i class="las la-times la-2x"></i>
                                    </button>
                            </div>
                            <div class="card-body">
                                {{-- <div class="mb-5">
                                    <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                        <span class="bg-white pr-3">{{ translate('Online Status') }}</span>
                                    </h6>
                                    <div class="aiz-radio-list">
                                        <label class="aiz-radio">
                                            <input type="radio" name="status" onchange="applyFilter()" @if ($status == 'on')
                                                checked
                                            @endif> {{ translate('Any status') }}
                                            <span class="aiz-square-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" checked="checked" name="status" onchange="applyFilter()" @if ($status == 'any')
                                                checked
                                            @endif> {{ translate('Online Only') }}
                                            <span class="aiz-square-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                    </div>
                                </div> --}}
                                <div class="">
                                    <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                        <span class="bg-white pr-3">{{ translate('Rating') }}</span>
                                    </h6>
                                    <div class="aiz-radio-list">
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="" onchange="applyFilter()" @if ($rating == '')
                                                checked
                                            @endif> {{ translate('Any rating') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="4+" onchange="applyFilter()" @if ($rating == '4+')
                                                checked
                                            @endif> {{ translate('4 star +') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="3-4" onchange="applyFilter()" @if ($rating == '3-4')
                                                checked
                                            @endif> {{ translate('3 to 4 star') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="2-3" onchange="applyFilter()" @if ($rating == '2-3')
                                                checked
                                            @endif> {{ translate('2 to 3 star') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="1-2" onchange="applyFilter()" @if ($rating == '1-2')
                                                checked
                                            @endif> {{ translate('1 to 2 star') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                        <label class="aiz-radio">
                                            <input type="radio" name="rating" value="0-1" onchange="applyFilter()" @if ($rating == '0-1')
                                                checked
                                            @endif> {{ translate('0 to 1 star') }}
                                            <span class="aiz-rounded-check"></span>
                                            <span class="float-right text-secondary fs-12"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="card mb-lg-0">
                        <input type="hidden" name="type" value="freelancer">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-icon btn-soft-secondary d-lg-none flex-shrink-0 mr-2" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                    <i class="las la-filter"></i>
                                </button>
                                <input type="text" class="form-control form-control-sm" placeholder="Search Keyword" name="keyword" value="{{ $keyword }}">
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @foreach ($freelancers as $key => $freelancer)
                                @if ($freelancer->user != null)
                                    <a href="{{ route('freelancer.details', $freelancer->user->user_name) }}" class="d-block d-xl-flex card-project text-inherit px-3 py-4">
                                        <span class="avatar flex-shrink-0 mr-4">
                                            @if ($freelancer->user->photo != null)
                                                <img src="{{ custom_asset($freelancer->user->photo) }}" alt="{{ $freelancer->user->name }}">
                                            @else
                                                <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}" alt="{{ $freelancer->user->name }}">
                                            @endif
                                            @if(Cache::has('user-is-online-' . $freelancer->user->id))
                                                <span class="badge badge-dot badge-circle badge-success badge-status badge-md"></span>
                                            @else
                                                <span class="badge badge-dot badge-circle badge-secondary badge-status badge-md"></span>
                                            @endif
                                        </span>
                                        <div class="flex-grow-1">
                                            <h5 class="fw-600 mb-1">{{ $freelancer->user->name }}</h5>
                                            @if ($freelancer->specialistAt != null)
                                                <p class="opacity-50">{{ $freelancer->specialistAt->name }}</p>
                                            @endif
                                            <div class="text-muted lh-1-8">
                                                <p class="text-truncate-3">{{ $freelancer->bio }}</p>
                                            </div>
                                            <div class="d-flex text-secondary fs-12 mb-3">
                                                <div class="mr-2">
                                                    <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                                        {{ formatRating(getAverageRating($freelancer->user->id)) }}
                                                    </span>
                                                    <span class="rating rating-sm">
                                                        {{ renderStarRating(getAverageRating($freelancer->user->id)) }}
                                                    </span>
                                                    <span>
                                                        ({{ count($freelancer->user->reviews) }} {{ translate('Reviews') }})
                                                    </span>
                                                </div>
                                                @if ($freelancer->user->address->city_id != null && $freelancer->user->address->country_id != null)
                                                    <div>
                                                        <i class="las la-map-marker opacity-50"></i>
                                                        <span>{{ $freelancer->user->address->city->name }}, {{ $freelancer->user->address->country->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($freelancer->skills != null)
                                                <div>
                                                    @foreach (json_decode($freelancer->skills) as $key => $skill_id)
                                                        @php
                                                            $skill = \App\Models\Skill::find($skill_id);
                                                        @endphp
                                                        @if ($skill != null)
                                                            <span class="btn btn-light btn-xs mb-1">{{ $skill->name }}</span>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0 pt-4 pt-xl-0 pl-xl-5 d-flex flex-row flex-xl-column justify-content-between align-items-center">
                                            <div class="text-right">
                                                <h4 class="mb-0">{{ single_price($freelancer->hourly_rate) }}</h4>
                                                <div class="mt-xl-2 small text-secondary">
                                                    <span>{{ translate('per Hour') }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="btn btn-primary btn-sm">{{ translate('Hire Me') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <div class="aiz-pagination aiz-pagination-center flex-grow-1">
                                <ul class="pagination">
                                    {{ $freelancers->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript">
        function applyFilter(){
            $('#freelancer-filter-form').submit();
        }
    </script>
@endsection

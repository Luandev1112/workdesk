@extends('frontend.default.layouts.app')

@section('content')
    <section class="py-4 py-lg-5">
        <div class="container">
            @if($keyword != null)
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 text-center">
                        <h1 class="h5 mt-3 mt-lg-0 mb-5 fw-400">{{ translate('Total') }} <span class="fw-600">{{ $total }}</span> {{ translate('projects found for') }} <span class="fw-600">{{ $keyword }}</span></h1>
                    </div>
                </div>
            @endif
            <form id="project-filter-form" action="" method="GET">
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
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Categories') }}</span>
                                        </h6>
                                        <div class="category-filter fs-14">
                                            <ul class="list-unstyled mb-0">
                                                @if (!isset($category_id))
                                                    @foreach (\App\Models\ProjectCategory::where('parent_id', 0)->get() as $category)
                                                        <li><a href="{{ route('projects.category', $category->slug) }}">{{ $category->name }}</a></li>
                                                    @endforeach
                                                @else
                                                    <li class="go-back"><a href="{{ route('search') }}">{{ translate('All Categories') }}</a></li>
                                                    @if (\App\Models\ProjectCategory::find($category_id)->parent_id != 0)
                                                        <li class="go-back"><a href="{{ route('projects.category', \App\Models\ProjectCategory::find(\App\Models\ProjectCategory::find($category_id)->parent_id)->slug) }}">{{ \App\Models\ProjectCategory::find(\App\Models\ProjectCategory::find($category_id)->parent_id)->name }}</a></li>
                                                    @endif
                                                    <li class="go-back"><a href="{{ route('projects.category', \App\Models\ProjectCategory::find($category_id)->slug) }}">{{ \App\Models\ProjectCategory::find($category_id)->name }}</a></li>
                                                    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                        <li><a href="{{ route('projects.category', \App\Models\ProjectCategory::find($id)->slug) }}">{{ \App\Models\ProjectCategory::find($id)->name }}</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Project Type') }}</span>
                                        </h6>
                                        <div class="aiz-checkbox-list">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="projectType[]" value="Fixed" @if (in_array('Fixed', $projectType))
                                                    checked
                                                @endif onchange="applyFilter()"> {{ translate('Fixed Price') }}
                                                <span class="aiz-square-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-checkbox">
                                                <input type="checkbox"  name="projectType[]" value="Long Term" @if (in_array('Long Term', $projectType))
                                                    checked
                                                @endif onchange="applyFilter()"> {{ translate('Long Term') }}
                                                <span class="aiz-square-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">{{ translate('Numbers of Bids') }}</span>
                                        </h6>
                                        <div class="aiz-radio-list">
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="" onchange="applyFilter()" @if ($bids == "")
                                                    checked
                                                @endif> {{ translate('Any Number of bids') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="0-5" onchange="applyFilter()" @if ($bids == "0-5")
                                                    checked
                                                @endif> {{ translate('0 to 5') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="5-10" onchange="applyFilter()" @if ($bids == "5-10")
                                                    checked
                                                @endif> {{ translate('5 to 10') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="10-20" onchange="applyFilter()" @if ($bids == "10-20")
                                                    checked
                                                @endif> {{ translate('10 to 20') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="20-30" onchange="applyFilter()" @if ($bids == "20-30")
                                                    checked
                                                @endif> {{ translate('20 to 30') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="bids" value="30+" onchange="applyFilter()" @if ($bids == "30+")
                                                    checked
                                                @endif> {{ translate('30+') }}
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12"></span>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <div class="">
                                        <h6 class="separator text-left mb-3 fs-12 text-uppercase text-secondary">
                                            <span class="bg-white pr-3">Client History</span>
                                        </h6>
                                        <div class="aiz-radio-list">
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3" checked="checked"> Any client history
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> No hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> 1 to 10 hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                            <label class="aiz-radio">
                                                <input type="radio" name="radio3"> 10+ hires
                                                <span class="aiz-rounded-check"></span>
                                                <span class="float-right text-secondary fs-12">(200)</span>
                                            </label>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="card mb-lg-0">
                            <input type="hidden" name="type" value="project">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-icon btn-soft-secondary d-lg-none flex-shrink-0 mr-2" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                        <i class="las la-filter"></i>
                                    </button>
                                    <input type="text" class="form-control form-control-sm" placeholder="Search Keyword" value="{{ $keyword }}" name="keyword">
                                </div>

                                <div class="w-200px">
                                    <select class="form-control form-control-sm aiz-selectpicker" name="sort" onchange="applyFilter()">
                                        <option value="1" @if($sort == '1') selected @endif>{{ translate('Newest first') }}</option>
                                        <option value="2" @if($sort == '2') selected @endif>{{ translate('Lowest budget first') }}</option>
                                        <option value="3" @if($sort == '3') selected @endif>{{ translate('Highest budget first') }}</option>
                                        <option value="4" @if($sort == '4') selected @endif>{{ translate('Lowest bids first') }}</option>
                                        <option value="5" @if($sort == '5') selected @endif>{{ translate('Highest bids first') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                @foreach ($projects as $key => $project)
                                    <a href="{{ route('project.details', $project->slug) }}" class="d-block d-xl-flex card-project text-inherit px-3 py-4">
                                        <div class="flex-grow-1">
                                            <h5 class="h6 fw-600 lh-1-5">{{ $project->name }}</h5>
                                            <div class="text-muted lh-1-8">
                                                <p>{{ $project->excerpt }}</p>
                                            </div>
                                            <ul class="list-inline opacity-70 fs-12">
                                                <li class="list-inline-item">
                                                    <i class="las la-clock opacity-40"></i>
                                                    <span>{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-stream opacity-40"></i>
                                                    <span>{{ translate('Project Category') }}</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="las la-handshake"></i>
                                                    <span>@if ($project->project_category != null) {{ $project->project_category->name }} @else {{ translate('Removed Category') }} @endif</span>
                                                </li>
                                            </ul>
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
                                        <div class="flex-shrink-0 pt-4 pt-xl-0 pl-xl-4 d-flex flex-row-reverse flex-xl-column justify-content-between align-items-center">
                                            <div class="text-right">
                                                <span class="small text-secondary">{{ translate('Budget') }}</span>
                                                <h4 class="mb-0">{{ single_price($project->price) }}</h4>
                                                <div class="mt-xl-2 small text-secondary">
                                                    @if ($project->bids > 0)
                                                        <span class="text-body mr-1">{{ $project->bids }}+</span>
                                                    @else
                                                        <span class="text-body mr-1">{{ $project->bids }}</span>
                                                    @endif
                                                    <span>Bids</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-xs">
                                                        @if($project->client->photo != null)
                                                            <img src="{{ custom_asset($project->client->photo) }}">
                                                        @else
                                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                        @endif
                                                    </span>
                                                    <div class="pl-2">
                                                        <h4 class="fs-14 mb-1">@if ( $project->client != null ) {{ $project->client->name }} @endif</h4>
                                                        <div class="text-secondary fs-10">
                                                            <i class="las la-star text-warning"></i>
                                                            <span class="fw-600">{{ formatRating(getAverageRating($project->client->id)) }}</span>
                                                            <span>({{ getNumberOfReview($project->client->id) }} {{ translate('reviews') }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                            <div class="card-footer">
                                <div class="aiz-pagination aiz-pagination-center flex-grow-1">
                                    <ul class="pagination">
                                        {{ $projects->links() }}
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
            $('#project-filter-form').submit();
        }
    </script>
@endsection

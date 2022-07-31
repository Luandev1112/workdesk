@extends('frontend.default.layouts.app')

@section('content')
<!-- Content Section -->
<div class="bg-light">
    <div class="container space-2">
        <div class="row justify-content-between align-items-center mb-4">
            <!-- Title -->
            <div class="col-sm-4 col-md-6 mb-3 mb-sm-0">
                <h2 class="h6 mb-0">{{ count($total_clients) }} {{ translate('members found') }}</h2>
            </div>
            <!-- End Title -->

            <!-- Filter -->
            <div class="col-sm-8 col-md-6 text-sm-right">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <!-- Select -->
                        <select class="js-select selectpicker dropdown-select" data-width="fit" data-style="btn-soft-primary btn-sm">
                            <option value="alphabeticalOrderSelect1" selected>{{ translate('A-to-Z') }}</option>
                            <option value="alphabeticalOrderSelect2">{{ translate('Z-to-A') }}</option>
                        </select>
                        <!-- End Select -->
                    </li>
                </ul>
            </div>
            <!-- End Filter -->
        </div>

        <div class="row">
            @if (count($total_clients) > 0)
                @foreach ($clients as $key => $client)
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="card text-center mb-5">
                            <div class="card-body px-3 py-4">
                                <!-- Team -->
                                <div class="mb-3">
                                    <div class="position-relative u-lg-avatar mx-auto mb-3">
                                        @if($client->user->photo != null)
                                            <img src="{{ custom_asset($client->user->photo) }}">
                                        @else
                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                        @endif
                                        <span class="badge badge-xs badge-outline-primary badge-pos badge-pos--bottom-left rounded-circle"></span>
                                    </div>

                                    <a class="btn btn-sm btn-icon btn-soft-warning btn-bg-transparent position-absolute top-0 right-0 rounded-circle m-3" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Add to favorites">
                                        <span class="far fa-bookmark btn-icontranslateinner text-secondary"></span>
                                    </a>

                                    <h2 class="h6 mb-0">
                                        <a href="{{ route('client.details', $client->user->user_name) }}">{{ $client->user->name }}</a>
                                    </h2>
                                    <span class="text-warning font-size-1">
                                        {{ renderStarRating(getAverageRating($client->user->id)) }}
                                    </span>
                                </div>
                                <!-- End Team -->

                                <!-- Rewards -->
                                <div class="mb-3">
                                    <img class="max-width-4 mr-1" src="{{ my_asset('assets/frontend/svg/illustrations/top-level-award.svg') }}" alt="Image Description" title="Top Seller">
                                    <img class="max-width-4 mx-1" src="{{ my_asset('assets/frontend/svg/illustrations/verified-user.svg') }}" alt="Image Description" title="Verified user">
                                    <img class="max-width-4 ml-1" src="{{ my_asset('assets/frontend/svg/illustrations/top-endorsed.svg') }}" alt="Image Description" title="Top Endorsed">
                                </div>
                                <!-- End Rewards -->

                                <a class="btn btn-sm btn-soft-primary transition-3d-hover" href="{{ route('client.details', $client->user->user_name) }}">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center">
            <nav aria-label="Page navigation">
                {{ $clients->links() }}
            </nav>
            <small class="d-none d-sm-inline-block text-secondary">{{ translate('Showing') }} {{ count($clients) }} {{ translate('out of') }} {{ count($total_clients) }}</small>
        </div>
        <!-- End Pagination -->
    </div>
</div>
<!-- End Content Section -->
@endsection

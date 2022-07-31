@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-4 py-lg-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-xxl-9 col-xl-8 col-lg-7">
                    <div class="card project-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between ">
                                <a href="" class="text-reset">{{ $service->category->name }}</a>
                            </div>
                            <h5 class="my-3 lh-1-5">{{ $service->title }}</h5>

                            <div class="row align-items-center no-gutters">
                                <img src="{{ custom_asset($service->user->photo)}}" alt="" height="35"
                                     class="rounded-circle">
                                <span class="ml-2">{{ $service->user->name }}</span>
                                <span class="ml-2 text-muted"> |</span>
                                <div class="ml-2 text-warning">
                                    @if( !empty(getAverageRating($service->user->id)) )
                                        <span class="bg-rating rounded text-white px-1 mr-1 fs-10">
                                            {{ formatRating(getAverageRating($service->user->id)) }}
                                        </span>
                                    @else
                                        <span class="bg-secondary rounded text-white px-1 mr-1 fs-10">
                                            {{ formatRating(getAverageRating($service->user->id)) }}
                                        </span>
                                    @endif
                                    <span class="rating rating-sm">
                                        {{ renderStarRating(getAverageRating($service->user->id)) }}
                                    </span>
                                    <span>
                                        ({{ getNumberOfReview($service->user->id) }} {{ translate('Reviews') }})
                                    </span>
                                </div>
                            </div>
                            <div class="service-image mt-3">
                                <img src="{{ custom_asset($service->image) }}" alt="" class="w-100">
                            </div>
                            <div class="about-service">
                                <h6 class="separator mb-4 mt-4"><span
                                        class="bg-white px-3">{{ translate('About This Service') }}</span></h6>
                                <div class="text-muted lh-2 mb-5 fw-200">
                                    {!! $service->about_service !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-3 col-xl-4 col-lg-5 service-packages">
                    <div class="sticky-top z-3">
                        <div class="card">
                            <div class="card-header p-0" style="min-height: 0px;">
                                <ul class="nav nav-pills nav-fill flex-grow-1" id="myTab" role="tablist">
                                    @foreach($service_packages as $service_package)
                                        <li class="nav-item">
                                            <a class="nav-link @if($loop->iteration == 1) active @endif p-3 rounded-0"
                                               id="{{ $service_package->service_type }}-tab" data-toggle="tab"
                                               href="#{{ $service_package->service_type }}" role="tab"
                                               aria-controls="{{ $service_package->service_type }}"
                                               aria-selected="@if($loop->iteration == 1) true @else false @endif">{{ ucfirst($service_package->service_type) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="myTabContent" class="card-body tab-content">
                                @foreach($service_packages as $service_package)
                                    <div class="tab-pane show @if($loop->iteration == 1) active @endif p-2"
                                         id="{{ $service_package->service_type }}" role="tabpanel"
                                         aria-labelledby="{{ $service_package->service_type }}-tab">
                                        <div class="d-flex justify-content-between">
                                            <span class="">
                                            @if($service_package->service_type == 'basic')
                                                    {{ translate('BASIC Package - Popular') }}
                                                @elseif($service_package->service_type == 'standard')
                                                    {{ translate('STANDARD Package - Recommended') }}
                                                @elseif($service_package->service_type == 'premium')
                                                    {{ translate('PREMIUM Package - Must for Pro') }}
                                                @endif
                                            </span>
                                            <span class="font-weight-bold">{{ single_price($service_package->service_price) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <span class="mr-3">
                                                <i class="la la-clock"></i>
                                                {{ $service_package->delivery_time }} {{ translate('Days Delivery') }}
                                            </span>

                                            <span>
                                                <i class="las la-sync-alt"></i>
                                                @if($service_package->revision_limit < 0)
                                                    {{ translate('Unlimited Revisions') }}
                                                @else
                                                    {{ $service_package->revision_limit }} {{ translate('Revisions') }}
                                                @endif
                                            </span>
                                        </div>
                                        <hr>
                                        <div class="mt-3">
                                            <h5 class="mb-0 d-flex justify-content-between c-pointer"
                                                data-toggle="collapse" data-target="#collapseBasic" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <button class="btn p-0 ">
                                                    {{ translate('Whats Included') }}
                                                </button>
                                            </h5>
                                            <ul class="list-unstyled ml-4 mt-3">
                                                @foreach(json_decode($service_package->feature_description) as $features)
                                                    <li class="mb-2">
                                                        <i class="la la-check text-success mr-2" aria-hidden="true"></i>
                                                        {{ $features }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @if(isClient())
                                            <button
                                                class="btn btn-primary btn-block mt-4"
                                                @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated )
                                                    onclick="select_payment_type({{ $service_package->id }})"
                                                @else
                                                    onclick="show_online_purchase_service_modal({{ $service_package->id }})"
                                                @endif
                                                >
                                                {{ translate('Continue') }} ({{ single_price($service_package->service_price) }})
                                            </button>
                                        @elseif (auth::check())
                                            <div class="alert alert-warning mt-4">
                                                {{ translate('You need be a client to order services') }}
                                            </div>
                                        @else
                                            <a href="{{ route('register') }}" class="btn btn-primary btn-block mt-4">{{ translate('Join to order this service') }}</a>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="tab-pane p-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="d-flex justify-content-between">
                                        <span class="">{{ translate('STANDARD Package - Recommended') }}</span>
                                        <span class="">{{ single_price($service_package->service_price) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-3 font-weight-bold">
                                        <span class="mr-3">
                                            <i class="la la-clock"></i>
                                            {{ $service_package->delivery_time }} {{ translate('Days Delivery') }}
                                        </span>

                                        <span>
                                            <i class="las la-sync-alt"></i>
                                            @if($service_package->revision_limit < 0)
                                                {{ translate('Unlimited Revisions') }}
                                            @else
                                                {{ $service_package->revision_limit }} {{ translate('Revisions') }}
                                            @endif
                                        </span>
                                    </div>
                                    <hr>
                                    <div class="mt-3">
                                        <h5 class="mb-0 d-flex justify-content-between c-pointer" data-toggle="collapse"
                                            data-target="#collapseBasic" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <button class="btn p-0">
                                                {{ translate('Whats Included') }}
                                            </button>

                                        </h5>
                                        <ul class="list-unstyled ml-4 mt-3">
                                            @foreach(json_decode($service_package->feature_description) as $features)
                                                <li class="mb-2">
                                                    <i class="la la-check text-success mr-2" aria-hidden="true"></i>
                                                    {{ $features }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <button class="btn btn-primary btn-block mt-4">{{ translate('Continue') }}
                                        ({{ single_price($service_package->service_price) }})
                                    </button>
                                </div>
                                <div class="tab-pane p-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="d-flex justify-content-between">
                                        <span class="font-weight-bold">{{ translate('PREMIUM Package - Must for PRO') }}</span>
                                        <span class="font-weight-bold">{{ single_price($service_package->service_price) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-3 font-weight-bold">
                                        <span class="mr-3">
                                            <i class="la la-clock"></i>
                                            {{ $service_package->delivery_time }} {{ translate('Days Delivery') }}
                                        </span>

                                        <span>
                                            <i class="las la-sync-alt"></i>
                                            @if($service_package->revision_limit < 0)
                                                {{ translate('Unlimited Revisions') }}
                                            @else
                                                {{ $service_package->revision_limit }} {{ translate('Revisions') }}
                                            @endif
                                        </span>
                                    </div>
                                    <hr>
                                    <div class="mt-3">
                                        <h5 class="mb-0 d-flex justify-content-between c-pointer" data-toggle="collapse"
                                            data-target="#collapseBasic" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <button class="btn p-0">
                                                {{ translate('Whats Included') }}
                                            </button>

                                        </h5>
                                        <ul class="list-unstyled ml-4 mt-3">
                                            @foreach(json_decode($service_package->feature_description) as $features)
                                                <li class="mb-2">
                                                    <i class="la la-check text-success mr-2" aria-hidden="true"></i>
                                                    {{ $features }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <button class="btn btn-primary btn-block mt-4">{{ translate('Continue') }}
                                        ({{ single_price($service_package->service_price) }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <!-- Select Payment Type Modal -->
    <div class="modal fade" id="select_payment_type_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select Payment Type') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="service_package_id" name="service_package_id" value="">
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{ translate('Payment Type')}}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="mb-3">
                                <select class="form-control aiz-selectpicker" onchange="payment_type(this.value)"
                                        data-minimum-results-for-search="Infinity">
                                    <option value="">{{ translate('Select One')}}</option>
                                    <option value="online">{{ translate('Online payment')}}</option>
                                    <option value="offline">{{ translate('Offline payment')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-sm btn-primary transition-3d-hover mr-1" id="select_type_cancel" data-dismiss="modal">{{translate('Cancel')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- online Payment Modal -->
    <div class="modal fade" id="online_purchase_service_package_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select a payment option') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="online_purchase_service_package_modal_body">

                </div>
            </div>
        </div>
    </div>

    <!-- offline payment Modal -->
    <div class="modal fade" id="offline_service_purchase_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Service Package Purchase by Offline Payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="offline_service_purchase_modal_body"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        function select_payment_type(id) {
            $('input[name=service_package_id]').val(id);
            $('#select_payment_type_modal').modal('show');
        }

        function payment_type(type) {
            var service_package_id = $('#service_package_id').val();
            if (type == 'online') {
                $("#select_type_cancel").click();
                show_online_purchase_service_modal(service_package_id);
            }
            else if (type == 'offline') {
                $("#select_type_cancel").click();
                $.post('{{ route('offline_service_package_purchase_modal') }}', {
                    _token: '{{ csrf_token() }}',
                    service_package_id: service_package_id
                }, function (data) {
                    $('#offline_service_purchase_modal_body').html(data);
                    $('#offline_service_purchase_modal').modal('show');
                });
            }
        }

        function show_online_purchase_service_modal(id) {
            $.post('{{ route('get_package_service_modal') }}', {_token: '{{ csrf_token() }}', id: id}, function (data) {
                $('#online_purchase_service_package_modal').modal('show');
                $('#online_purchase_service_package_modal_body').html(data);
                $(".aiz-selectpicker").selectpicker();
            })
        }
    </script>
@endsection

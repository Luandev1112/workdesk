@extends('frontend.default.layouts.app')

@section('content')
<section class="py-8 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto text-center">
                <h1 class="mb-0 fw-700">{{ translate('Choose Your Package') }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="py-4 py-lg-5">
    <div class="container">

        <div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 gutters-10 justify-content-center">
            @foreach ($packages as $key => $package)
                <div class="col">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            @if ($package->recommended != 0)
                            <span class="absolute-top-right recommended-ribbon bg-success">{{ translate('Recommended') }}</span>
                            @endif
                            <div class="text-center mb-4 mt-3">
                                <img class="mw-100 mx-auto mb-4" src="{{ custom_asset($package->photo) }}" height="100">
                                <h5 class="mb-3 h5 fw-600">{{$package->name}}</h5>
                            </div>
                            <ul class="list-group list-group-raw fs-15 mb-5">
                                <li class="list-group-item py-2">
                                    <i class="las la-check text-success mr-2"></i>
                                    {{ $package->fixed_limit }} {{translate('Fixed Projects')}}
                                </li>
                                <li class="list-group-item py-2">
                                    <i class="las la-check text-success mr-2"></i>
                                    {{ $package->long_term_limit }} {{translate('Long Term Projects')}}
                                </li>
                                <li class="list-group-item py-2">
                                    <i class="las la-check text-success mr-2"></i>
                                    {{ $package->bio_text_limit }} {{translate('Bio Word Limit')}}
                                </li>
                                <li class="list-group-item py-2">
                                    @if ($package->following_status == 0)
                                        <span class=" text-secondary">
                                            <i class="las la-times mr-2"></i>
                                            {{ translate('Freelancer Following') }}
                                        </span>
                                    @else
                                        <span class="">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ translate('Freelancer Following') }}
                                        </span>
                                    @endif
                                </li>
                            </ul>
                            <div class="mb-5 d-flex align-items-center justify-content-center">
                                @if ($package->price == '0.00')
                                    <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
                                @else
                                    <span class="display-4 fw-600 lh-1 mb-0">{{single_price($package->price)}}</span>
                                @endif
                                @if ($package->number_of_days == '0')
                                    <span class="text-secondary border-left ml-2 pl-2">{{translate('Life')}}<br>{{translate('Time')}}</span>
                                @else
                                    <span class="text-secondary border-left ml-2 pl-2">{{$package->number_of_days}}<br>{{translate('Days')}}</span>
                                @endif
                            </div>
                            <div class="text-center">
                                @if ($package->price == '0.00')
                                    <a
                                        href="{{ route('package_purchase_free', $package->id) }}"
                                        @if ($package->recommended == 0)
                                        class="btn btn-soft-primary"
                                        @else
                                        class="btn btn-primary"
                                        @endif
                                        >{{ translate('Start Free Trial') }}</a>
                                @else
                                    <button
                                        type="button"
                                        @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated )
                                            onclick="select_payment_type({{ $package->id }})"
                                        @else
                                            onclick="online_payment({{ $package->id }})"
                                        @endif
                                        @if ($package->recommended == 0)
                                        class="btn btn-soft-primary"
                                        @else
                                        class="btn btn-primary"
                                        @endif
                                        >{{translate('Purchase This Package')}}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('script')
    <script type="text/javascript">

        function select_payment_type(id) {
            $('input[name=package_id]').val(id);
            $('#select_payment_type_modal').modal('show');
        }

        function payment_type(type) {
            var package_id = $('#package_id').val();
            if (type == 'online') {
                $("#select_type_cancel").click();
                online_payment(package_id);
            } else if (type == 'offline') {
                $("#select_type_cancel").click();
                $.post('{{ route('offline_package_purchase_modal') }}', {
                    _token: '{{ csrf_token() }}',
                    package_id: package_id
                }, function (data) {
                    $('#offline_client_package_purchase_modal_body').html(data);
                    $('#offline_client_package_purchase_modal').modal('show');
                });
            }
        }

        function online_payment(id){
            $.post('{{ route('get_package_purchase_modal') }}', { _token: '{{ csrf_token() }}', id:id }, function(data){
                $('#purchase_package_modal').modal('show');
                $('#purchase_package_modal_body').html(data);
                $(".aiz-selectpicker").selectpicker();
            })
        }
    </script>
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
                    <input type="hidden" id="package_id" name="package_id" value="">
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

    <!-- Online Payment modal -->
    <div class="modal fade" id="purchase_package_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select a payment option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="purchase_package_modal_body">

                </div>
            </div>
        </div>
    </div>


    <!-- offline payment Modal -->
    <div class="modal fade" id="offline_client_package_purchase_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Package Purchase by Offline Payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="offline_client_package_purchase_modal_body"></div>
            </div>
        </div>
    </div>
@endsection

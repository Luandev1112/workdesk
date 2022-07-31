@extends('frontend.default.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">            

            <div class="aiz-user-panel">
                <div class="aiz-titlebar mt-2 mb-4">
                    <div class="row align-items-center">
                        <div class="col d-flex justify-content-between">
                            <h1 class="h3">{{ translate('Services') }}</h1>                            
                        </div>
                    </div>
                </div>
                
                <div class="row gutters-10">
                    @foreach($services as $service)
                        <div class="col-lg-3">
                            <div class="card">
                                <a href="{{ route('service.show', $service->slug) }}"><img src="{{ custom_asset($service->image) }}" class="card-img-top" alt="service_image" height="212"></a>
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <span class="mr-2"><img src="{{ custom_asset($service->user->photo) }}" alt="Hello" height="35" width="35" class="rounded-circle"></span>
                                        <span class="d-flex flex-column justify-content-center">
                                            <a href="{{ route('freelancer.details', $service->user->user_name) }}" class="text-dark"><span class="font-weight-bold">{{ $service->user->name }}</span></a>
                                        </span>
                                    </div>
                                    
                                   <a href="{{ route('service.show', $service->slug) }}" class="text-dark"><h5 class="card-title">{{ \Illuminate\Support\Str::limit($service->title, 40, $end='...') }}</h5></a>
                                </div>
                            </div>
                        </div> 
                    @endforeach                 
                </div>
                
                <div class="aiz-pagination aiz-pagination-center">
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
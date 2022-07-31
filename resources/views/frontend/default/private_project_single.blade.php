@extends('frontend.default.layouts.app')

@section('content')

<!-- Jobs Description Section -->
<div class="container">
    <div class="border-bottom space-2">
        <div class="row">
            <div class="col-lg-8 mb-9 mb-lg-0">
                <div class="card p-4 shadow-soft mb-5">
                    <div class="media mb-3 border-bottom">
                        <div class="media-body">
                            <h3 class="h5 mb-2">
                                {{ $project->name }}
                            </h3>
                            <ul class="list-inline font-size-1 text-muted">
                                <li class="list-inline-item">
                                    <small class="fas fa-calendar-alt text-secondary align-middle mr-1"></small>
                                    <span class="align-middle">{{ Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</span>
                                </li>
                                <li class="list-inline-item">
                                    <a href="" class="text-secondary">
                                        <small class="fas fa-calendar-alt align-middle mr-1"></small>
                                        <span class="align-middle">@if ($project->project_category != null) {{ $project->project_category->name }} @endif</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex ml-auto">
                            <!-- budget -->
                            <div class="position-relative d-inline-block mr-2">
                                <small class="fas fa-dollar-sign text-secondary align-middle mr-1"></small>
                                <span class="align-middle font-size-2 font-weight-medium">{{ single_price($project->price) }}</span>
                            </div>
                            <!-- End budget -->
                        </div>
                    </div>

                    <p class="mb-4">{{ $project->excerpt }}</p>

                    <div class="d-md-flex align-items-md-center">

                        <!-- Posted -->
                        <div class="u-ver-divider u-ver-divider--none-md pr-4 mb-3 mb-md-0 mr-4">
                            <h4 class="small text-secondary mb-0">{{ translate('Bids') }}</h4>
                            <small class="fas fa-users text-secondary align-middle mr-1"></small>
                            @if ($project->bids > 0)
                                <span class="align-middle">{{ $project->bids }} +</span>
                            @else
                                <span class="align-middle">{{ $project->bids }}</span>
                            @endif
                        </div>
                        <!-- End Posted -->

                        <!-- Posted -->
                        <div class="mb-3 mb-md-0">
                            <h4 class="small text-secondary mb-0">{{ translate('Project type') }}</h4>
                            <small class="fas fa-briefcase text-secondary align-middle mr-1"></small>
                            <span class="align-middle">{{ $project->type }}</span>
                        </div>
                        <!-- End Posted -->
                    </div>
                </div>
                <div class="card p-4 shadow-soft mb-5">
                    <div class="mb-3">
                        <h2 class="h5">{{ translate('Job Description') }}</h2>
                    </div>

                    <div class="">
                        <p>@php echo $project->description; @endphp</p>
                    </div>
                    <div class="mb-3 mt-4">
                        <h2 class="h5">{{ translate('Attachment') }}</h2>
                    </div>
                    <div class="file-preview">
                        @foreach (json_decode($project->attachment) as $key => $attachment_id)
                            @php
                                $attachment = \App\Upload::find($attachment_id);
                            @endphp
                            @if ($attachment != null)
                            <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="29" title="fsfhjllz_vegetables-banner.png">
                                <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                    @if ($attachment->type == 'document')
                                        <i class="la la-file-text"></i>
                                    @elseif ($attachment->type == 'image')
                                        <img src="{{ my_asset($attachment->file_name) }}" class="img-fit">
                                    @endif
                                </div>
                                <div class="col body">
                                    <h6 class="d-flex">
                                        <span class="text-truncate title">"{{ $attachment->file_original_name }}</span>
                                        <span class="ext">.{{ $attachment->extension }}</span>
                                    </h6>
                                    <p>{{formatBytes($attachment->file_size)}}</p>
                                </div>
                            </div>
                            @else
                                <div class="alert alert-info" role="alert">
                                    {{ translate('No attachment') }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="pl-lg-4">
                    @if ($project->client_user_id != Auth::user()->id)
                        <div class="mb-5 text-center">
                            <a class="btn btn-block btn-sm btn-primary transition-3d-hover" onclick="confirm_invite_modal({{ $project->id }})">{{ translate('Invitation Reply') }}</a>
                        </div>
                    @endif
                    @if ($chat_thread != null)
                        <div class="mb-5 text-center">
                            <a class="btn btn-block btn-sm btn-primary transition-3d-hover" href="{{ route('chat_view', $chat_thread->id) }}">{{ translate('Go for Chat') }}</a>
                        </div>
                    @endif
                    <!-- Sidebar Info -->
                    <div class="card shadow-soft shadow-sm mb-4">
                        <!-- Header -->
                        <header class="card-header p-0">
                            <div class="pt-5 px-5">
                                <h3 class="h6">{{ translate('About the client') }}</h3>
                            </div>
                        </header>
                        <!-- End Header -->

                        <!-- Content -->
                        <div class="card-body pt-1 px-5 pb-5">

                            <a href="{{ route('client.details', $project->client->user_name) }}" class="d-flex align-items-center py-4 text-dark">
                                <span class="u-avatar u-avatar--bordered rounded-circle">
                                    @if($project->client->photo != null)
                                        <img src="{{ custom_asset($project->client->photo) }}">
                                    @else
                                        <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                    @endif
                                </span>
                                <div class="ml-2">
                                    <span class="font-size-1 font-weight-semi-bold">{{ $project->client->name }}</span>
                                    <div class="">
                                        <span class="star-rating small">
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star half"></i>
                                        </span>
                                        <span class="font-weight-semi-bold ml-2">4.7</span>
                                        <small class="text-muted">({{ translate('39 reviews') }})</small>
                                    </div>
                                </div>
                            </a>

                            <!-- Icon Block -->
                            <div class="media mb-3">
                                <div class="min-width-4 text-center text-primary mt-1 mr-3">
                                    <span class="fas fa-map-marked-alt"></span>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-weight-medium">
                                        @if ($project->client->address->city != null)
                                            {{ $project->client->address->city->name }},
                                        @endif
                                        @if ($project->client->address->country != null)
                                            {{ $project->client->address->country->name }}
                                        @endif
                                    </span>
                                    <small class="d-block text-secondary">{{ translate('Location') }}</small>
                                </div>
                            </div>
                            <!-- End Icon Block -->

                            <!-- Icon Block -->
                            <div class="media mb-3">
                                <div class="min-width-4 text-center text-primary mt-1 mr-3">
                                    <span class="fas fa-clock"></span>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-weight-medium">{{ count(\App\Models\Project::where('client_user_id', $project->client_user_id)->get()) }} {{ translate('jobs posted') }}</span>
                                    <small class="d-block text-secondary">{{ translate('71% hire rate') }}</small>
                                </div>
                            </div>
                            <!-- End Icon Block -->

                            <!-- Icon Block -->
                            <div class="media mb-3">
                                <div class="min-width-4 text-center text-primary mt-1 mr-3">
                                    <span class="fas fa-business-time"></span>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-weight-medium">{{ translate('$5k+ total spent') }}</span>
                                    <small class="d-block text-secondary">{{ translate('19 hires, 2 active') }}</small>
                                </div>
                            </div>
                            <!-- End Icon Block -->

                            <!-- Icon Block -->
                            <div class="media mb-3">
                                <div class="min-width-4 text-center text-primary mt-1 mr-3">
                                    <span class="fas fa-money-bill-alt"></span>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-weight-medium">{{ translate('$30.91/hr avg hourly rate paid') }}</span>
                                    <small class="d-block text-secondary">{{ translate('22 hours') }}</small>
                                </div>
                            </div>
                            <!-- End Icon Block -->
                        </div>
                        <!-- End Content -->
                    </div>
                    <!-- Title -->
                    <!-- End Sidebar Info -->
                </div>
                <!-- End Subscribe -->
            </div>
        </div>
    </div>
</div>
<!-- End Jobs Description Section -->

@endsection
@section('script')
    <script type="text/javascript">
        function confirm_invite_modal(id){
            $.post('{{ route('get_invitation_reply_modal') }}', { _token: '{{ csrf_token() }}', id:id }, function(data){
                $('#invitation_reply').modal('show');
                $('#invitation_reply_modal_body').html(data);
            })
        }
    </script>
@endsection
@section('modal')
<div class="modal fade" id="invitation_reply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Reply Invitation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invitation_reply_modal_body">

            </div>
        </div>
    </div>
</div>
@endsection

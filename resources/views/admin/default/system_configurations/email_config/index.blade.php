@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate("Edit Configuration")}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL DRIVER')}}
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                      title="{{ translate("Select sendmail if you do not have smtp") }}">
                                    <i class="la la-question-circle"></i>
                                </span>
                            </label>
                            <input type="hidden" name="types[]" value="MAIL_DRIVER">
                            <select class="select2 form-control" name="MAIL_DRIVER" data-toggle="select2"
                                    data-placeholder="Choose ..." required>
                                <option value=""
                                        @if(env('MAIL_DRIVER') == '')  selected @endif >{{translate("Select mail driver")}}</option>
                                <option value="sendmail"
                                        @if(env('MAIL_DRIVER') == 'sendmail')  selected @endif >{{translate('Sendmail')}}</option>
                                <option value="smtp"
                                        @if(env('MAIL_DRIVER') == 'smtp')  selected @endif >{{translate('SMTP')}}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL HOST')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_HOST">
                            <input type="text" name="MAIL_HOST" class="form-control" value="{{env('MAIL_HOST')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL PORT')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_PORT">
                            <input type="text" name="MAIL_PORT" class="form-control" value="{{env('MAIL_PORT')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL USERNAME')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_USERNAME">
                            <input type="text" name="MAIL_USERNAME" class="form-control"
                                   value="{{env('MAIL_USERNAME')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL PASSWORD')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                            <input type="password" name="MAIL_PASSWORD" class="form-control"
                                   value="{{env('MAIL_PASSWORD')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL FROM ADDRESS')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                            <input type="text" name="MAIL_FROM_ADDRESS" class="form-control"
                                   value="{{env('MAIL_FROM_ADDRESS')}}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="types">{{translate('MAIL FROM NAME')}}</label>
                            <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                            <input type="text" name="MAIL_FROM_NAME" class="form-control"
                                   value="{{env('MAIL_FROM_NAME')}}" required>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div> <!-- end card-body -->
    </div> <!-- end card-->
@endsection

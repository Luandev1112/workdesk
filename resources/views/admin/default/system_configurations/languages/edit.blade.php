@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="h6mb-0">{{ translate('Edit Language Info') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('languages.update', $language->id) }}" method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" value="{{$language->name}}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="code">{{translate('Code')}}</label>
                            <select class="form-control aiz-selectpicker" name="code" id="code" data-live-search="true" data-placeholder="Choose ...">
                                @foreach (\File::files(base_path('public/assets/frontend/default/img/flags')) as $path)
                                    <option
                                                value="{{ pathinfo($path)['filename'] }}"
                                                data-content="<div class=''><img src='{{ my_asset('assets/frontend/default/img/flags/'.pathinfo($path)['filename'].'.png') }}' height='11' class='mr-2'><span>{{ strtoupper(pathinfo($path) ['filename']) }}</span></div>" @if( $language->code == pathinfo($path)['filename'] ) selected @endif></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label >{{translate('Is this language RTL?')}}</label>
                            <div class="">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="rtl"  @if($language->rtl == 1) checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Update Language Info')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

@endsection

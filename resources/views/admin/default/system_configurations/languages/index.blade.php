@extends('admin.default.layouts.app')

@section('content')

    <div class="aiz-titlebar mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{translate('System Language')}}</h1>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{translate('All Languages')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{translate('Name')}}</th>
                                        <th>{{translate('Code')}}</th>
                                        <th>{{translate('RTL')}}</th>
                                        <th>{{translate('Enabled')}}</th>
                                        <th class="text-right">{{translate('Options')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($languages as $key => $language)
                                        <tr>
                                            <td>{{ ($key+1) + ($languages->currentPage() - 1)*$languages->perPage() }}</td>
                                            <td>{{$language->name}}</td>
                                            <td>{{$language->code}}</td>
                                            <td>
                                                @if($language->rtl == 1)
                                                <span class="badge badge-inline badge-success">{{translate('On')}}</span>
                                                @else
                                                <span class="badge badge-inline badge-secondary">{{translate('Off')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox"  id="language_enable.{{ $key }}" onchange="update_language_status(this)" value="{{ $language->id }}" @if($language->enable == 1) checked @endif>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{route('languages.show', encrypt($language->id))}}" title="{{translate('Translate')}}">
                                                    <i class="las la-language"></i>
                                                </a>
                                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" href="{{ route('languages.edit', encrypt($language->id)) }}" title="{{translate('Edit')}}">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                @if($language->code != 'en')
                                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('languages.destroy', $language->id)}}" title="{{translate('Delete')}}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{ $languages->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate("Create New Language")}}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('languages.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name">{{translate('Name')}}</label>
                                    <input type="text" id="name" name="name" placeholder="{{ translate('Eg. English') }}" class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="code">{{translate('Code')}}</label>
                                    <select class="form-control aiz-selectpicker" name="code" id="code" title="Select a country code" data-live-search="true">
                                        @foreach (\File::files(base_path('public/assets/frontend/default/img/flags')) as $path)
                                            <option
                                                value="{{ pathinfo($path)['filename'] }}"
                                                data-content="<div class=''><img src='{{ my_asset('assets/frontend/default/img/flags/'.pathinfo($path)['filename'].'.png') }}' height='11' class='mr-2'><span>{{ strtoupper(pathinfo($path) ['filename']) }}</span></div>" ></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="align-self-center" for="rtl">{{translate('Is this language RTL?')}}</label>
                                    <div class="">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="rtl">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <button type="submit" class="btn btn-primary">{{translate('Create')}}</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Set Default Language for System')}}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="types[]" value="DEFAULT_LANGUAGE">
                                <div class="form-group mb-3">
                                    <label for="name">{{translate('Default Language')}}</label>
                                    <select class="select2 form-control aiz-selectpicker" name="DEFAULT_LANGUAGE" data-toggle="select2" data-placeholder="Choose ...">
                                        @foreach (\App\Models\Language::where('enable',1)->get() as $key => $language)
                                            <option value="{{ $language->code }}" @if(env('DEFAULT_LANGUAGE') == $language->code) selected @endif >{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <button type="submit" class="btn btn-primary">{{translate('Save Default Language')}}</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>

            </div>
        </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
@section('script')
    <script type="text/javascript">

        function update_language_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('languages.update_language_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', 'Status has been changed successfully.');
                }
                else if(data == 2){
                    AIZ.plugins.notify('danger', 'Must 1 language need to be enabled.');
                }
                else{
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection

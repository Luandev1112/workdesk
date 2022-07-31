@extends('admin.default.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Projects')}}</h1>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_projects" action="" method="GET">
                <div class="card-header row gutters-5">
        					<div class="col text-center text-md-left">
        						<h5 class="mb-md-0 h6">{{translate('All Projects')}}</h5>
        					</div>
                  <div class="col-md-3 ml-auto">
        						<select class="form-control aiz-selectpicker mb-2 mb-md-0" name="user_id" id="user_id" data-live-search="true" onchange="sort_projects()">
        							<option value="">{{ translate('Filter by Client') }}</option>
                        @foreach (App\User::where('user_type', 'client')->get() as $key => $client)
                            {{-- @if ($client->user != null) --}}
                                <option value="{{ $client->id }}" @if ($client->id == $client_id) selected @endif>{{ $client->name }}</option>
                            {{-- @endif --}}
                        @endforeach
        						</select>
	               </div>
        				<div class="col-md-3 ml-auto">
        					<select class="form-control aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_projects()">
        						<option value="">{{ translate('Sort by') }}</option>
                        <option value="project_category_id,asc" @isset($col_name , $query) @if($col_name == 'project_category_id' && $query == 'asc') selected @endif @endisset>Category ASC</option>
                        <option value="project_category_id,desc" @isset($col_name , $query) @if($col_name == 'project_category_id' && $query == 'desc') selected @endif @endisset>Category DESC</option>
                        <option value="price,desc" @isset($col_name , $query) @if($col_name == 'price' && $query == 'desc') selected @endif @endisset>{{translate('Price (High > Low)')}}</option>
                        <option value="price,asc" @isset($col_name , $query) @if($col_name == 'price' && $query == 'asc') selected @endif @endisset>{{translate('Price (Low > High)')}}</option>
        					</select>
        				</div>
          			<div class="col-md-3">
          				<div class="input-group">
          					<input type="text" class="form-control" placeholder="Type and Hit Enter" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
          					<div class="input-group-append">
          						<button class="btn btn-light" type="submit">
          							<i class="las la-search la-rotate-270"></i>
          						</button>
          					</div>
          				</div>
          			</div>
		           </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Title')}}</th>
                            <th data-breakpoints="md">{{translate('Project Category')}}</th>
                            <th data-breakpoints="md">{{translate('Type')}}</th>
                            <th data-breakpoints="md">{{translate('Client')}}</th>
                            <th>{{translate('Budget')}}</th>
                            @if(\App\Models\SystemConfiguration::where('type', 'project_approval')->first()->value == 1)
                                <th data-breakpoints="md">{{translate('Approval')}}</th>
                            @endif
                            <th data-breakpoints="md">{{translate('Posted at')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key => $project)
                            <tr>
                                <td>{{ ($key+1) + ($projects->currentPage() - 1)*$projects->perPage() }}</td>
                                <td><a href="{{ route('project.details', $project->slug) }}" target="_blank" class="text-reset">{{ $project->name }}</a></td>
                                <td>
                                  @if($project->project_category != null)
                                    {{$project->project_category->name}}
                                  @endif
                                </td>
                                <td>{{$project->type}}</td>
                                <td>
                                    @if ($project->client != null)
                                        {{$project->client->name}}
                                    @endif
                                </td>
                                <td>{{single_price($project->price)}}</td>
                                @if(\App\Models\SystemConfiguration::where('type', 'project_approval')->first()->value == 1)
                                    <td>
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox"  id="project_approval.{{ $key }}" onchange="project_approval(this)" value="{{ $project->id }}" @if($project->project_approval == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </td>
                                @endif
                                <td>{{Carbon\Carbon::parse($project->created_at)->diffForHumans()}}</td>
                                <td class="text-right">
                                    <a href="#" data-href="{{route('delete_project_by_admin', encrypt($project->id) )}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $projects->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
@section('script')
<script type="text/javascript">
    function sort_projects(el){
        $('#sort_projects').submit();
    }
    function project_approval(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('project_approval') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                AIZ.plugins.notify('success', 'Project has been approved successfully.');
            }
            else{
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }
</script>
@endsection

@extends('admin.default.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Website Pages') }}</h1>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h6 class="mb-0 fw-600">{{ translate('All Pages') }}</h6>
		<a href="{{ route('custom-pages.create') }}" class="btn btn-primary">{{ translate('Add New Page') }}</a>
	</div>
	<div class="card-body">
		<table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="md">{{translate('URL')}}</th>
                    <th class="text-right">{{translate('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
            	<tr>
            		<td>1</td>
            		<td><a href="{{ route('website.home') }}" class="text-reset">{{ translate('Home Page') }}</a></td>
            		<td>{{ route('home') }}</td>
            		<td class="text-right">
            			<a href="{{ route('website.home') }}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
							<i class="las la-pen"></i>
						</a>
            		</td>
            	</tr>
            	@foreach (\App\Models\Page::all() as $key => $page)
            	<tr>
            		<td>{{ $key+2 }}</td>
            		<td><a href="{{ route('custom-pages.show_custom_page', $page->slug) }}" class="text-reset">{{ $page->title }}</a></td>
            		<td>{{ route('home') }}/{{ $page->slug }}</td>
            		<td class="text-right">
            			<a href="{{ route('custom-pages.edit', $page->slug) }}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
							<i class="las la-pen"></i>
						</a>
						<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('custom-pages.destroy', $page->id)}} " title="{{ translate('Delete') }}">
							<i class="las la-trash"></i>
						</a>
            		</td>
            	</tr>
            	@endforeach
            </tbody>
        </table>
	</div>
</div>
@endsection

@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection

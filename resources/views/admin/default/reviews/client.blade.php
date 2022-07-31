@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_clients" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Client Reviews by Freelancers')}}</h5>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Client')}}</th>
                            <th>{{translate('Freelancer')}}</th>
                            <th>{{translate('Project')}}</th>
                            <th>{{translate('Rating')}}</th>
                            <th>{{translate('Comment')}}</th>
                            <th class="text-right">{{translate('Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $key => $review)
                            <tr>
                                <td>{{ ($key+1) + ($reviews->currentPage() - 1)*$reviews->perPage() }}</td>
                                <td>
                                    @if ($review->reviewed != null)
                                        {{$review->reviewed->name}}
                                    @endif
                                </td>
                                <td>
                                    @if ($review->reviewer != null)
                                        {{$review->reviewer->name}}
                                    @endif
                                </td>
                                <td>
                                    @if ($review->project != null)
                                        {{$review->project->name}}
                                    @endif
                                </td>
                                <td>
                                    <span class="rating rating-sm">
                                        {{ renderStarRating($review->rating) }}
                                    </span>
                                </td>
                                <td>{{ $review->review }}</td>
                                <td class="text-right">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" value="{{ $review->id }}" onchange="update_review_published(this)"
                                        @if ($review->published)
                                            checked
                                        @endif>
                                        <span></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
function update_review_published(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('reviews.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                AIZ.plugins.notify('success', 'Review status updated successfully');
            }
            else{
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }
</script>
@endsection

<!-- cancel Modal -->
<div class="modal fade" id="unfollow-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Unfollow Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <p class="lead">{{translate('Are you sure to unfollow?')}}</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a href="" id="comfirm-link" class="btn btn-primary mt-2 comfirm-link">{{translate('Confirm')}}</a>
            </div>
        </div>
    </div>
</div>
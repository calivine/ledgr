<div class="modal fade" id="refresh-token_modal" tabindex="-1" role="dialog" aria-labelledby="modalLayoutTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refresh API Token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to refresh your API token?</p>
                <div class="row">
                    <button type="button" class="btn btn-outline-primary m-4" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('account.refresh') }}"><button type="button" class="btn btn-primary m-4">Confirm</button></a>
                </div>

            </div>
        </div>
    </div>
</div>


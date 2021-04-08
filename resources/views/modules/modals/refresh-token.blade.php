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
                    <a href="{{ route('account.refresh') }}"><button type="button" class="btn btn-success">Confirm</button></a>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
</div>


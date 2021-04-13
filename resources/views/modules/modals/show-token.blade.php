<div class="modal fade" id="show-token_modal" tabindex="-1" role="dialog" aria-labelledby="modalLayoutTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">API Token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <button type="button" class="btn btn-info btn-block m-4" id="display-api-token">Never Share This
                        Token!
                    </button>
                    <button type="button" class="btn btn-warning btn-block m-4" id="hide-api-token">Hide</button>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p id="api-token">{{ $api_token }}</p>
                    </div>
                </div>

                <div class="row">
                    <button type="button" class="btn btn-outline-primary btn-block m-4" id="close_show-token_modal"
                            data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content {{ $theme }}">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">New Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modules.input-transaction', ['labels' => $labels])
            </div>
        </div>
    </div>
</div>

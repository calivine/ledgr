<!-- Modal -->
<div class="modal fade" id="plannedModalCenter" tabindex="-1" role="dialog" aria-labelledby="updatePlannedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePlannedModal">Update Planned Budget</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="budget_update">New Planned Budget:</label>
                <input type="number" step="0.01" class="update-input w-100" name="budget_update">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary btn-block budget-update" id="budget-update-submit">Save</button>
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

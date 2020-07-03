<!-- Modal -->
<div class="modal fade" id="plannedModalCenter" tabindex="-1" role="dialog" aria-labelledby="updatePlannedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content {{ auth::user()->theme }}">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePlannedModal">Update Planned Budget</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="w-100 mb-0" for="budget_update">New Planned Budget:</label>
                    <input type="number" step="0.01" class="update-input w-50"  name="budget_update" id="budget_update">
                </div>
                <input id="planned-input-slider" type="range" min="0" step="1">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary btn-block budget-update" id="budget-update-submit"><i class="material-icons icon md-18">save</i>Save</button>
            </div>
        </div>
    </div>
</div>

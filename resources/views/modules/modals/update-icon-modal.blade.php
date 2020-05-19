<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="updateIconModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateIconModal">Update Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="modal-label" for="icon">Select Icon:</label>
                    <select name='icon'>
                        <option value=''>Select</option>
                        @foreach($icons as $icon)
                            <option value='{{ $icon->text }}'>{{ $icon->text }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary btn-block" id="icon-update-submit"><i class="material-icons icon md-18">save</i>Save</button>
            </div>
        </div>
    </div>
</div>

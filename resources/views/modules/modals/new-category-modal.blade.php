<!-- Modal -->
<div class="modal fade" id="categoryModalCenter" tabindex="-1" role="dialog" aria-labelledby="newCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCategoryModal">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="mb-0" for="new-category-input">Category</label>
                <input id="new-category-input" class="new-category-form-input w-50" name="category" type="text" required>
                <label class="mb-0" for="new-planned-input">Planned Budget</label>
                <input id="new-planned-input" class="new-category-form-input" name="planned" type="text" autofocus>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" id="category-submit" type="submit">Save</button>
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

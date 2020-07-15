<!-- Modal -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUploadTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content {{ $theme }}">
            <div class="modal-header">
                <h5 class="modal-title">CSV Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Upload a csv file with one transaction per row.<br>The format of the columns should be:<br>Date, Amount, Description, Category.</p>
                @include('modules.file-upload')
            </div>
        </div>
    </div>
</div>

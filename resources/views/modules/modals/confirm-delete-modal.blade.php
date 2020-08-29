<!-- Modal -->
<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content {{ auth::user()->theme }}">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModal">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form id="modal-delete-form" action="" method="POST">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <button class="btn btn-block btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

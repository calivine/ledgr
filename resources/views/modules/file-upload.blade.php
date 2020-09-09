<form class="file-upload" action="{{ route('uploadCSV') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csvFile">
    <button type="submit" name="uploadBtn"><i class="material-icons icon md-18">save</i>Upload</button>
</form>

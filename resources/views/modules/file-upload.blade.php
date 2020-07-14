<form class="file-upload" action="{{ route(csv) }}" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvFile">
    <button type="submit" name="uploadBtn">Upload</button>
</form>

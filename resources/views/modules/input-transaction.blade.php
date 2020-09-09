<button type="button" class="btn btn-link" id="toggle-csv-upload" data-toggle="modal" data-target="#modalUpload">Mass upload via csv</button>
<fieldset class="shadow" id="manual-input-form">
    <div class="form-group">
        <div class="col-lg">
            <label for="amount-input">Amount $</label>
            <input type="number" step="0.01" class="manual-input {{ $theme }}" id="amount-input" required name="amount">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg">
            <label for="description-input">Transaction Description</label>
            <input type="text" class="manual-input {{ $theme }}" name="description" id="description-input" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg">
            <label for="manual-select-category">Budget Category</label>
            <select name="category" id="manual-select-category" required class="manual-input {{ $theme }}">
                <option value="">Select</option>
                @foreach($labels as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg">
            <label for="transaction-date-input">Transaction Date</label>
            <input type="date" class="manual-input {{ $theme }}" id="transaction-date-input" placeholder="YYYY-MM-DD" required name="transaction_date" value="{{ date('Y-m-d') }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg">
            <button class="manual-input btn btn-outline-success btn-block" id="manual-input-button" type="submit"><i class="material-icons icon md-18">save</i>Save</button>
        </div>
    </div>
</fieldset>

<fieldset class='shadow' id='manual-input-form'>
    <div class='form-group'>
        <div class='col-lg-4 offset-lg-4'>
            <label class='w-100 mb-0' for='description-input'>Transaction Description:</label>
            <input type='text' class='manual-input' name='description' id='description-input'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg-4 offset-lg-4'>
            <label for='amount-input'>Amount $:</label>
            <input type='number' step='0.01' class='manual-input' id='amount-input' name='amount'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg-4 offset-lg-4'>
            <label for='manual-select-category'>Category</label>
            <select name='category' id='manual-select-category' class='manual-input'>
                <option value=''>Select</option>
                @foreach($categories as $category)
                    <option value='{{ $category }}'>{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg-4 offset-lg-4'>
            <label for='transaction-date-input'>Transaction Date:</label>
            <input type='date' class='manual-input' id='transaction-date-input' name='transaction_date' value='{{ date('Y-m-d') }}'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg-4 offset-lg-4'>
            <button class='manual-input btn btn-outline-success btn-block' id='manual-input-button' type='submit'>Save</button>
        </div>
    </div>
</fieldset>
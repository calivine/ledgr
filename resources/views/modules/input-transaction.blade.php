<fieldset class='shadow p-3' id='manual-input-form'>
    <div class='form-group'>
        <div class='col-lg'>
            <label for='amount-input'>Amount $</label>
            <input type='number' step='0.01' class='manual-input' id='amount-input' required name='amount'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg'>
            <label class='w-100 mb-0' for='description-input'>Transaction Description</label>
            <input type='text' class='manual-input' name='description' id='description-input' required>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg'>
            <label for='manual-select-category'>Budget Category</label>
            <select name='category' id='manual-select-category' required class='manual-input'>
                <option value=''>Select</option>
                @foreach($labels as $category)
                    <option value='{{ $category }}'>{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg'>
            <label for='transaction-date-input'>Transaction Date</label>
            <input type='date' class='manual-input' id='transaction-date-input' placeholder='YYYY-MM-DD' required name='transaction_date' value='{{ date('Y-m-d') }}'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-lg'>
            <button class='manual-input btn btn-outline-success btn-block' id='manual-input-button' type='submit'>Save</button>
        </div>
    </div>
</fieldset>

function changeCategoryForm(id) {

    let labelsLength = category_labels_array.length;
    let $categoryEdit = $('<td class="category-edit"></td>');
    let $label = $('<label id="category-edit-label">Change Category</label>');
    let $select = $('<select name="category" class="category-edit-select"></select>');
    $select.attr('id', id);
    let $buttons = $('<button class="category-edit-submit btn btn-success" type="submit">Save</button><button class="category-edit-cancel btn" type="submit">Cancel</button>');
    let i;
    for (i = 0; i < labelsLength; i++) {
        let $option = $('<option value="' + category_labels_array[i] + '">' + category_labels_array[i] + '</option>');
        $select.append($option);
    }
    $select.after($buttons);
    $label.after($select);
    $categoryEdit.prepend($label).append($select).append($buttons);
    return $categoryEdit;
}

function createTransactionRow(data) {
    let $newRow = $('<tr><td><i class="material-icons">' + data['new_transaction']['icon'] + '</i></td></tr>');
    let $dateCell = $('<td class="transaction_date"><small>' + data['new_transaction']['date'] + '</small></td>');
    let $descriptionCell = $('<td class="transaction-description">' + data['new_transaction']['description'] + '</td>');
    let $amountCell = $('<td class="transaction-amount">$' + data['new_transaction']['amount'] + '</td>');
    let $categoryCell = $('<td class="budget-category align-middle" id=' + data['new_transaction']['id'] + '>' + data['new_transaction']['category'] + '</td>');
    return $newRow.append($dateCell).append($descriptionCell).append($amountCell).append($categoryCell);
}

function reject() {
    $('li#length-requirement').css('color', 'red');
    $('li#length-requirement').css('text-decoration', 'none');

}

function minLength(s) {
    let str = s;
    return (str.length + 1) >= 8;
}

function pass() {
    $('li#length-requirement').css('color', 'green');
    $('li#length-requirement').css('text-decoration', 'line-through');
}

function resetSaveTransaction() {
    const now = new Date();
    const year = now.getFullYear();
    let month = String(now.getMonth()+1);
    month = month.length === 1 ? "0"+month : month;
    let day = String(now.getDate()).length === 1 ? "0"+String(now.getDate()) : String(now.getDate());

    const date = String(year) + "-" + month + "-" + day;
    $('input#description-input').val("");
    $('input#amount-input').val("");
    $('input#transaction-date-input').val(date);
    $('select#manual-select-category').val("");
}

function generateAlert(type = 'success', data='') {
    let $alert = $('<div id="alert-message-container"></div>');

    let $closeButton = $('<button></button>');
    let $x = $('<span>&times;</span>');
    $x.attr('aria-hidden', 'true');
    $closeButton
        .attr('type', 'button')
        .attr('aria-label', 'Close')
        .attr('data-dismiss', 'alert')
        .addClass('close')
        .prepend($x);
    if (type === 'success') {
        $alert
            .addClass('alert alert-primary')
            .attr('role', 'alert')
            .text('Saved New Transaction');
    }
    else if (type === 'fail') {
        let $errorMessages = $('<ul></ul>');
        data["errors"].forEach(function(error) {
            let $item = $('<li></li>');
            $item.append(error);
            $errorMessages.append($item);
        });
        $alert
            .addClass('alert alert-danger')
            .attr('role', 'alert')
            .text(data["message"])
            .append($errorMessages);
    }
    return $alert.prepend($closeButton);
}

function refreshProgressBar($element, data) {
    // Set Bar Background Color
    $bgColor = 'bg-' + data['color'];
    $element.removeClass().addClass('progress-bar ' + $bgColor);
    $element.attr('aria-valuenow', data['actual']);
    $element.attr('aria-valuemax', data['planned']);
    $element.text(data['percent'] + '%');

    $element.css({
        'width': data['percent'] + '%'
    });
}

function getPlannedTotal() {
    let total = 0;
    $('span.planned-value').each(function () {
        total += Number($(this).text());
    });
    $('td#planned-total').text(total);
};


function dateTest() {
    let today = new Date();
    console.log(today.getDate());
}

$('#toggle-style-change').on('click', function () {
    $('#dashboard-container').addClass('dark-mode');
    $('#transaction_body').addClass('dark-mode');
    $('footer').addClass('dark-mode');
    $('#collapseOne').addClass('dark-mode');
    $('body').addClass('dark-mode');
    $('.modal-content').addClass('dark-mode');
})

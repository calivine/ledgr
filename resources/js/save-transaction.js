function changeCategoryForm(id) {
    const labelsLength = labels_array.length;
    let $categoryEdit = $('<td class="category-edit"></td>');
    let $label = $('<label id="category-edit-label">Change Category</label>');
    let $select = $('<select name="category" class="category-edit-select"></select>');
    $select.attr('id', id);
    let $buttons = $('<button class="category-edit-submit btn btn-success" type="submit">Save</button><button class="category-edit-cancel btn" type="submit">Cancel</button>');
    let i;
    for (i = 0; i < labelsLength; i++) {
        let $option = $('<option value=' + labels_array[i] + '>' + labels_array[i] + '</option>');
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

let $inputForm = $('fieldset#manual-input-form');

$(function () {
    $('button#manual-input-button').bind('click', function () {
        $.post('/transaction', {
            description: $('input#description-input').val(),
            amount: $('input#amount-input').val(),
            category: $('select#manual-select-category').val(),
            transaction_date: $('input#transaction-date-input').val()
        }).done( function (data) {

            $('div#toggle-modal-row').before(generateAlert('success'));
            // Clear Form
            resetSaveTransaction();

            $('div#modalCenter').modal('hide');


            let $tbody = $('tbody#transaction_body');
            let $ch = changeCategoryForm(data['new_transaction']['id']);


            $tbody.prepend(createTransactionRow(data));


            // Update Monthly Total Progress Bar
            let $totalBar = $('div#total-spending-bar');
            let $totalBarLabel = $('p#bar-label-right');
            let totalData = data['monthly_total'];

            refreshProgressBar($totalBar, totalData);

            $totalBarLabel.text('$' + Math.round(data['monthly_total']['actual']) + ' of $' + data['monthly_total']['planned']);

            // Update Budget Category Total Progress Bars
            let i = 0;
            $('div.progress-bars.my-3').each(function() {
                let returnData = data['budget_totals'][i];
                if (returnData['planned'] > 0) {
                    // Get element for progress bar label
                    let barRightLabel = $(this).children().eq(1);
                    // Get element for progress bar
                    let $progressBar = $(this).children().eq(2).children().eq(0);

                    refreshProgressBar($progressBar, returnData);

                    // Update value for progress bar label
                    barRightLabel.text('$' + data['budget_totals'][i]['actual'] + ' of $' + data['budget_totals'][i]['planned']);
                }
                i++;
            });
        }).fail( function (data) {
            console.log(data.responseJSON.errors);
            let errorMessages = [];
            let errorResponse = {};
            if ("amount" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.amount[0]);
            }
            if ("transaction_date" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.transaction_date[0]);
            }
            if ("description" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.description[0]);
            }
            if ("category" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.category[0]);
            }
            errorResponse["message"] = data.responseJSON.message;
            errorResponse["errors"] = errorMessages;
            $inputForm.fadeOut()
                      .fadeIn()
                      .prepend(generateAlert('fail', errorResponse));
        });
        return false;
    });
});

function resetSaveTransaction() {
    const now = new Date();
    const year = now.getFullYear();
    let month = String(now.getMonth());
    month = month.length === 1 ? "0"+month : month;
    let day = String(now.getDay()).length === 1 ? "0"+String(now.getDay()) : String(now.getDay());

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

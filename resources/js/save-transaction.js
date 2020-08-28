

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
            $('div.progress-bars').each(function() {
                let bar = $(this);
                let label = $(this).children().eq(0)[0].innerHTML
                label = label.replace(':', '');
                data.budget_totals.forEach(function(d) {
                    console.log(d);
                    console.log(bar);
                    if (d.category == label) {
                        console.log('Updating progress bar...');
                        let returnData = d;

                        // Get element for progress bar label
                        let barRightLabel = bar.children().eq(1);

                        // Get element for progress bar
                        let $progressBar = bar.children().eq(2).children().eq(0);

                        refreshProgressBar($progressBar, returnData);

                        // Update value for progress bar label
                        barRightLabel.text('$' + d['actual'] + ' of $' + d['planned']);
                    }
                });
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

function createTransactionRow(data) {
    let $newRow = $('<tr><td><i class="material-icons">' + data['new_transaction']['icon'] + '</i></td></tr>');
    let $dateCell = $('<td class="transaction_date"><small>' + data['new_transaction']['date'] + '</small></td>');
    let $descriptionCell = $('<td class="transaction-description">' + data['new_transaction']['description'] + '</td>');
    let $amountCell = $('<td class="transaction-amount">$' + data['new_transaction']['amount'] + '</td>');
    let $categoryCell = $('<td class="budget-category align-middle" id=' + data['new_transaction']['id'] + '>' + data['new_transaction']['category'] + '</td>');
    return $newRow.append($dateCell).append($descriptionCell).append($amountCell).append($categoryCell);
}

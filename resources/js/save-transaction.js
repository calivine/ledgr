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
            const errorMessage = data.responseJSON.message;
            const errors = data.responseJSON.errors;
            $inputForm
                .fadeOut()
                .fadeIn()
                .prepend(generateAlert('fail',data=errorMessage));
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        });
        return false;
    });
});

function resetSaveTransaction() {
    $('input#description-input').val("");
    $('input#amount-input').val("");
    $('input#transaction-date-input').val("");
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
        $alert
            .addClass('alert alert-danger')
            .attr('role', 'alert')
            .text(data);
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

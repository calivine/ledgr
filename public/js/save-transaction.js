let $inputForm = $('fieldset#manual-input-form');

$(function () {
    $('button#manual-input-button').bind('click', function () {
        $.post('/transaction/new', {
            description: $('input#description-input').val(),
            amount: $('input#amount-input').val(),
            category: $('select#manual-select-category').val(),
            transaction_date: $('input#transaction-date-input').val()
        }).done( function () {
            $inputForm.fadeOut();
            // Clear Form
            resetSaveTransaction();
            $inputForm.fadeIn().prepend(generateAlert('success'));
            setTimeout(function() {
                        $('div#alert-message-container').fadeOut();
                    }, 5000);
            Location.reload();
        }).fail( function () {
            $inputForm.fadeOut().fadeIn().prepend(generateAlert('fail'));
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000)
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

function generateAlert(type = 'success') {
    let $alert = $('<div id="alert-message-container"></div>');
    let $closeButton = $('<button></button>');
    let $x = $('<span></span>');
    $x.attr('aria-hidden', 'true').text('close');
    $closeButton.attr('type', 'button')
        .attr('aria-label', 'Close')
        .attr('data-dismiss', 'alert')
        .addClass('close')
        .prepend($x);
    if (type === 'success') {
        $alert.addClass('alert alert-primary').attr('role', 'alert').text('Saved New Transaction');
    }
    else if (type === 'fail') {
        $alert.addClass('alert alert-danger').attr('role', 'alert').text('Whoops! Something Went Wrong.');
    }

    $alert.prepend($closeButton);
    return $alert;
}
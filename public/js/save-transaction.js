$(function () {
    $('button#manual-input-button').bind('click', function () {
        console.log($('input#description-input').val());
        $.post('/save_transaction', {
            description: $('input#description-input').val(),
            amount: $('input#amount-input').val(),
            category: $('select#manual-select-category').val(),
            transaction_date: $('input#transaction-date-input').val()
        }).done( function () {
            let $inputForm = $('fieldset#manual-input-form');
            let $successAlert = $('<div></div>');
            let $closeButton = $('<button></button>');
            let $x = $('<span></span>');
            $inputForm.fadeOut();
            $('input#description-input').val("");
            $('input#amount-input').val("");
            $('input#transaction-date-input').val("");
            $inputForm.fadeIn();
            $x.attr('aria-hidden', 'true').text('close');
            $closeButton.attr('type', 'button')
                .attr('aria-label', 'Close')
                .attr('data-dismiss', 'alert')
                .addClass('close')
                .prepend($x);
            // $closeButton.prepend($x);
            $successAlert.addClass('alert alert-primary').attr('role', 'alert').text('Saved New Transaction');
            $successAlert.prepend($closeButton);
            $inputForm.prepend($successAlert);
        }).fail( function () {
            $('fieldset#manual-input-form').fadeOut().fadeIn();
        });
        return false;
    });
});
$('td.transaction-delete').each(function () {
    $(this).on('click', function () {
        let id = $(this).prev().attr('id');
        $('form#modal-delete-form').attr('action', '/transaction/' + id + '/destroy');
        $('div#deleteModalCenter').modal('show');
    });
});

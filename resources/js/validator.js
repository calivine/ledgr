$(function () {
    $('input#password.form-control.w-50').on('change', function () {
        console.log($(this).val());
        let inputText = $(this).val();
        minLength(inputText) ? pass() : reject();
    });

    $('input#password.form-control.w-50').on('keypress', function () {

        console.log($(this).val());
        let inputText = $(this).val();
        console.log(inputText.length);
        minLength(inputText) ? pass() : reject();
    });
});

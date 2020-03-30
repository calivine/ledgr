$(function () {
    $('input#password.form-control.w-50').on('focus', function () {
        let password = $(this).val();
        console.log(password);
    });

    $('input#password.form-control.w-50').on('change', function () {
        console.log($(this).val());
    });

    $('input#password.form-control.w-50').on('keypress', function () {

        console.log($(this).val());
        let inputText = $(this).val();
        console.log(inputText.length);
        minLength(inputText) ? reqMet() : $('li#length-requirement').css('color', 'red');
    });
});

function minLength(s) {
    let str = s;
    return (str.length + 1) >= 8;
}

function reqMet() {
    $('li#length-requirement').css('color', 'green');

}

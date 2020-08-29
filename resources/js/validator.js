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

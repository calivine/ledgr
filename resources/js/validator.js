$(function () {
    let confirmInput = $('input#confirm.form-control');
    let passwordInput = $('input#password.form-control');
    let length = 'li#length-requirement';
    let number = 'li#number-requirement';
    let confirm = 'li#pwc-requirement';

    $(passwordInput).keyup(event, function (event) {
        let passwordText = $(this).val();

        minLength(passwordText) ? pass(length) : reject(length);
        numberCheck(passwordText) ? pass(number) : reject(number);
        //password_cofirmed(inputText, passConfirmText) ? pass('li#pwc-requirement') : reject('li#pwc-requirement');
    });

    $(confirmInput).keyup(event, function (event) {

        let passwordText = passwordInput.val();
        let confirmText = $(this).val();
        // Password confirm input text
        password_confirmed(passwordText, confirmText) ? pass('li#pwc-requirement') : reject('li#pwc-requirement');

    });

});

function reject(listItem) {
    $(listItem).addClass('rejected');
    $(listItem).removeClass('accepted');

}

function minLength(s) {
    let str = s;
    return (str.length + 1) >= 8;
}

function numberCheck(s) {
    let str = s;
    let re = /[0-9]/;
    return str.match(re);
}

function pass(listItem) {
    $(listItem).removeClass('rejected');
    $(listItem).addClass('accepted');

}

function password_confirmed(pw, pwc) {
    console.log(pw, pwc);
    if (pwc === '') return false;
    return pw === pwc;
}

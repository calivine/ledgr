$('button#hide-api-token').hide();

$('button#display-api-token').on('click', function (){
    $('p#api-token').show();
    $(this).hide();
    $('button#hide-api-token').show();
});

$('button#hide-api-token').on('click', function (){
    $('p#api-token').hide();
    $(this).hide();
    $('button#display-api-token').show();
});

$('button#close_show-token_modal').on('click', function () {
    $('p#api-token').hide();
    $('button#hide-api-token').hide();
    $('button#display-api-token').show();
});

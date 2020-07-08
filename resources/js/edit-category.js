
// $(function () {
//    $('td.category-edit').each(function () {
//        $(this).hide();
//    });
//});

$(function () {
    $('td.budget-category').each(function () {
        $(this).on('click', function () {
            $(this).after(changeCategoryForm($(this).attr('id')));
            // $(this).next().show();
            $(this).hide();
            $('button.category-edit-cancel').on('click', function () {
                $(this).parent().prev().show();
                $(this).parent().hide();
            });
            $('button.category-edit-submit').bind('click', function () {
                console.log($(this).prev());
                
                $.post('/transaction/category/update', {
                    update_name: $(this).prev().val(),
                    id: $(this).prev().attr('id')
                }, function (data) {
                    let updatedDescription = $('td[id=' + data.id + '][class="budget-category align-middle"]');
                    updatedDescription.text(data.category).show();
                    updatedDescription.next().hide();
                });
                return false;
            })
        });
    });
});

$(function () {
    $('button.category-edit-cancel').each(function () {
        $(this).on('click', function () {
            $(this).parent().prev().show();
            $(this).parent().hide();
        });
    });
});

$(function () {
    $('button.category-edit-submit').each(function () {
        $(this).bind('click', function () {
            $.post('/transaction/category/update', {
                update_name: $(this).prev().val(),
                id: $(this).prev().attr('id')
            }, function (data) {
                let updatedDescription = $('td[id=' + data.id + '][class="budget-category align-middle"]');
                updatedDescription.text(data.category).show();
                updatedDescription.next().hide();
            });
            return false;
        });
    });
});

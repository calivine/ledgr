$(function () {
    let worker = new BudgetWorker;
    // Tally total 'planned' budget
    worker.getPlannedTotal();
    // User can update planned value by clicking on the value itself
    $('.budget-category-planned').each(function () {
        $(this).on('click', function () {
            // Update Event Handler to show update budget modal
            // Send row ID to modal to use with update function


            const rowID = $(this).prev().attr('id');
            const oldPlanned = $(this).text();
            console.log(oldPlanned);
            $('input.update-input').val(oldPlanned);
            $('div#plannedModalCenter').modal('show');

            $('button#budget-update-submit').each(function () {
                $(this).on('click', function () {
                    $('div#plannedModalCenter').modal('hide');
                    worker.updateBudget($(this), worker, rowID);
                });
            });
            // $(this).hide();
            /*
            $(function () {
                $('button#budget-update-submit').each(function () {
                    $(this).on('click', function () {
                        worker.updateBudget($(this), worker, rowID);
                    });
                });
                $('button#budget-update-cancel').each(function () {
                    $(this).on('click', function () {
                        worker.cancel($(this));
                    });
                });
            });
            */
        });
    });
    $(function () {
        $('button#add-new-category').on('click', function () {
            worker.displayNewCategoryForm($(this));
            $('button#category-submit').on('click', function () {
                worker.saveNewCategory($(this));
            });
            $('button#category-cancel').each(function () {
                $(this).on('click', function () {
                    worker.categoryCancel($(this));
                    $('button#add-new-category').show();
                });
            });
        });
    });
});

$(function () {
    let worker = new BudgetWorker;
    // Tally total 'planned' budget
    worker.getPlannedTotal();
    // User can update planned value by clicking on the value itself
    $('.budget-category-planned').each(function () {
        $(this).on('click', function () {
            // const currentValueText = $(this).text();
            // let currentValue = initializeInput($(this).text());
            let currentValue = worker.budgetUpdateInput($(this).text());
            let inputAnchor = $(this).prev();
            inputAnchor.after(currentValue);
            $(this).hide();
            $(function () {
                $('button#budget-update-submit').each(function () {
                    $(this).on('click', function () {
                        worker.updateBudget($(this), worker);
                    });
                });
                $('button#budget-update-cancel').each(function () {
                    $(this).on('click', function () {
                        worker.cancel($(this));
                    });
                });
            });
        });
    });
    $(function () {
        $('button#add-new-category').on('click', function () {
            worker.displayNewCategoryForm($(this));
            $('button#category-submit').on('click', function () {
                worker.saveNewCategory($(this));
                $('button#add-new-category').show();
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
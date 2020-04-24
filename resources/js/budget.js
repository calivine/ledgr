$(function() {
    getPlannedTotal();

    let plannedBudgetValues = $('.budget-category-planned');

    let inputSlider = $('input#planned-input-slider');


    $('input#planned-input-slider').on('change', function () {
        console.log($('input#planned-input-slider').val());
        console.log($('input.update-input').val());
        $('input.update-input').val($('input#planned-input-slider').val());
    });


    plannedBudgetValues.each(function () {
        $(this).on('mouseover', function() {
            $(this).children().eq(1).show();
        });
    });

    $('.budget-category-planned').each(function () {
        $(this).on('mouseout', function () {
            $(this).children().eq(1).hide();
        });
    });

    $('span.planned-value').each(function () {
        $(this).on('click', function () {
            let rowID = $(this).parent().prev().attr('id');
            let category = $(this).parent().prev().text();
            $(this).attr('id', rowID);
            let oldPlanned = $(this).text();
            $('h5#updatePlannedModal').text("Update " + category + " Budget");
            $('input.update-input').val(oldPlanned);

            inputSlider.attr('max', Number(oldPlanned) * 2);
            inputSlider.attr('min', Number(oldPlanned) / 2);
            inputSlider.attr('value', oldPlanned);
            $('div#plannedModalCenter').modal('show');
            $('input.update-input').attr('id', rowID);
        })
    });

    $('button#budget-update-submit').each(function () {
        $(this).on('click', function () {
            $('div#plannedModalCenter').modal('hide');
            let new_budget = $('input.update-input').val();
            let budget_id = $('input.update-input').attr('id');
            let loadSpinner = $('<div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');
            let updateRow = 'span#' + budget_id + '.planned-value.px-2';
            let row = 'td#' + budget_id + '.budget-category-name.text-wrap';
            $(updateRow).hide();
            $(updateRow).before(loadSpinner);
            $.post('/budget/planned/update', {
                new_value: new_budget,
                id: budget_id
            }, function (data) {
                $(updateRow).show();
                $(updateRow).text(data.planned);
                loadSpinner.remove();
                self.getPlannedTotal();
            });
            return false;

        });
    });
    $('button#add-new-category').on('click', function () {
        // Display New Category Form
        $('div#categoryModalCenter').modal('show');
    });
});


function getPlannedTotal() {
    let total = 0;
    $('span.planned-value').each(function () {
        total += Number($(this).text());
    });
    $('td#planned-total').text(total);
};

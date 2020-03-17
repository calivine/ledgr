$(function() {
    getPlannedTotal();

    let plannedBudgetValues = $('.budget-category-planned');


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
            $(this).attr('id', rowID);
            let oldPlanned = $(this).text();

            $('input.update-input').val(oldPlanned);
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

    $('button#category-submit').on('click', function () {
        // Save New Category
        let loadSpinner = $('<div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');

        $('div#new-category-form').before(loadSpinner);

        $.post('/budget/category/new', {
            name: $('input#new-category-input').val(),
            planned: $('input#new-planned-input').val()

        }).done( function (data) {
            // Insert new category line after last category row already in table
            // .prepend() on <tr id='budget-totals'>
            let newRow = $('<tr class="budget-category"></tr>');
            let newCategoryName = '<td class="budget-category-name text-wrap">' + data.category + '</td>';
            let newCategoryPlanned = '<td class="budget-category-planned text-center"><span class="planned-value px-2">' + data.planned + '</span><i class="material-icons icon-edit md-14 position-absolute">edit</i></td><td class="text-center">0</td><td class="text-right">' + data.planned + '</td>';
            newRow.append(newCategoryName, newCategoryPlanned);
            console.log(newRow);
            $('div#categoryModalCenter').modal('hide');
            $('div.spinner-grow.text-success').remove();
            $('tr#budget-totals').before(newRow);
            $('div#new-category-form').remove();
            $('span#add-new-category').fadeIn();
            $('button#add-new-category').show();

            $('.budget-category-planned').each(function () {
                $(this).on('mouseover', function() {
                    $(this).children().eq(1).show();
                });
            });

            $('.budget-category-planned').each(function () {
                $(this).on('mouseout', function () {
                    $(this).children().eq(1).hide();
                });
            });

        }).fail( function () {
            // $('div#new-category-container').remove();
            $('div.spinner-grow.text-success').remove();
            $('button#add-new-category').parent().before(generateAlert('fail'));
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        });
        return false;

    });
});


function getPlannedTotal() {
    let total = 0;
    $('span.planned-value').each(function () {
        total += Number($(this).text());
    });
    $('td#planned-total').text(total);
};


function generateAlert(type = 'success') {
    let $alert = $('<div id="alert-message-container"></div>');
    let $closeButton = $('<button></button>');
    let $x = $('<span></span>');
    $x.attr('aria-hidden', 'true').text('close');
    $closeButton.attr('type', 'button')
        .attr('aria-label', 'Close')
        .attr('data-dismiss', 'alert')
        .addClass('close')
        .prepend($x);
    if (type === 'success') {
        $alert.addClass('alert alert-primary').attr('role', 'alert').text('Saved New Transaction');
    }
    else if (type === 'fail') {
        $alert.addClass('alert alert-danger').attr('role', 'alert').text('Whoops! Something Went Wrong.');
    }

    $alert.prepend($closeButton);
    return $alert;
}


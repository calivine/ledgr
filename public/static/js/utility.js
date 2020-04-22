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
            let newCategoryPlanned = '<td class="budget-category-planned text-center">$<span class="planned-value px-2">' + data.planned + '</span><i class="material-icons icon-edit md-14 position-absolute">edit</i></td><td class="text-center">0</td><td class="text-right">' + data.planned + '</td>';
            newRow.append(newCategoryName, newCategoryPlanned);
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


$(function () {
    $('td.category-edit').each(function () {
        $(this).hide();
    });
});

$(function () {
    $('td.budget-category').each(function () {
        $(this).on('click', function () {
            $(this).next().show();
            $(this).hide();
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

let $inputForm = $('fieldset#manual-input-form');

$(function () {
    $('button#manual-input-button').bind('click', function () {
        $.post('/transaction', {
            description: $('input#description-input').val(),
            amount: $('input#amount-input').val(),
            category: $('select#manual-select-category').val(),
            transaction_date: $('input#transaction-date-input').val()
        }).done( function (data) {

            $('div#toggle-modal-row').before(generateAlert('success'));
            // Clear Form
            resetSaveTransaction();

            $('div#modalCenter').modal('hide');

            // Update Monthly Total Progress Bar
            let $totalBar = $('div#total-spending-bar');
            let $totalBarLabel = $('p#bar-label-right');
            let totalData = data['monthly_total'];

            refreshProgressBar($totalBar, totalData);

            $totalBarLabel.text('$' + Math.round(data['monthly_total']['actual']) + ' of $' + data['monthly_total']['planned']);

            // Update Budget Category Total Progress Bars
            let i = 0;
            $('div.progress-bars.my-3').each(function() {
                let returnData = data['budget_totals'][i];
                if (returnData['planned'] > 0) {
                    // Get element for progress bar label
                    let barRightLabel = $(this).children().eq(1);
                    // Get element for progress bar
                    let $progressBar = $(this).children().eq(2).children().eq(0);

                    refreshProgressBar($progressBar, returnData);

                    // Update value for progress bar label
                    barRightLabel.text('$' + data['budget_totals'][i]['actual'] + ' of $' + data['budget_totals'][i]['planned']);
                }
                i++;
            });
        }).fail( function (data) {
            const errorMessage = data.responseJSON.message;
            const errors = data.responseJSON.errors;
            $inputForm
                .fadeOut()
                .fadeIn()
                .prepend(generateAlert('fail',data=errorMessage));
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        });
        return false;
    });
});

function resetSaveTransaction() {
    $('input#description-input').val("");
    $('input#amount-input').val("");
    $('input#transaction-date-input').val("");
    $('select#manual-select-category').val("");
}

function generateAlert(type = 'success', data='') {
    let $alert = $('<div id="alert-message-container"></div>');
    let $closeButton = $('<button></button>');
    let $x = $('<span>&times;</span>');
    $x.attr('aria-hidden', 'true');
    $closeButton
        .attr('type', 'button')
        .attr('aria-label', 'Close')
        .attr('data-dismiss', 'alert')
        .addClass('close')
        .prepend($x);
    if (type === 'success') {
        $alert
            .addClass('alert alert-primary')
            .attr('role', 'alert')
            .text('Saved New Transaction');
    }
    else if (type === 'fail') {
        $alert
            .addClass('alert alert-danger')
            .attr('role', 'alert')
            .text(data);
    }

    return $alert.prepend($closeButton);
}

function refreshProgressBar($element, data) {
    // Set Bar Background Color
    $bgColor = 'bg-' + data['color'];
    $element.removeClass().addClass('progress-bar ' + $bgColor);
    $element.attr('aria-valuenow', data['actual']);
    $element.attr('aria-valuemax', data['planned']);
    $element.text(data['percent'] + '%');

    $element.css({
        'width': data['percent'] + '%'
    });
}

$(function () {
    var compare = {
        name: function(a, b) {
            if (a < b) {
                return -1;
            }  else {
                return a > b ? 1 : 0;
            }
        },
        date: function (a, b) {
            a = new Date(a);
            b = new Date(b);

            return a - b;
        },
        amount: function (a, b) {
            a = a.replace(/^\$/g, '');
            b = b.replace(/^\$/g, '');
            return Number(a) - Number(b);
        }
    };

    $('.sortable').each(function () {
        // Store variables
        var $table = $(this);
        var $tbody = $table.find('tbody');
        var $controls = $table.find('th');
        var rows = $tbody.find('tr').toArray(); // Store array  containing rows

        $controls.on('click', function () {
            $('th').css('background-color', '#e6e6e6');
            var $header = $(this);
            var order = $header.data('sort');
            var column;
            $header.css('background-color', '#83EDEC');

            if ($header.is('.ascending') || $header.is('.descending')) {
                $header.toggleClass('ascending descending');
                $tbody.append(rows.reverse());
            } else {
                $header.addClass('ascending');
                $header.siblings().removeClass('ascending descending');
                if (compare.hasOwnProperty(order)) {
                    column = $controls.index(this);

                    rows.sort(function (a, b) {
                        a = $(a).find('td').eq(column).text();
                        b = $(b).find('td').eq(column).text();
                        return compare[order](a, b);
                    });

                    $tbody.append(rows);
                }
            }
        });
    });
});
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

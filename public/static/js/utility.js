function changeCategoryForm(id) {
    let labelsLength = category_labels_array.length;
    let $categoryEdit = $('<td class="category-edit"></td>');
    let $label = $('<label id="category-edit-label">Change Category</label>');
    let $select = $('<select name="category" class="category-edit-select"></select>');
    $select.attr('id', id);
    let $buttons = $('<button class="category-edit-submit btn btn-success" type="submit">Save</button><button class="category-edit-cancel btn btn-link" type="submit">Cancel</button>');
    let i;
    for (i = 0; i < labelsLength; i++) {
        let $option = $('<option value="' + category_labels_array[i] + '">' + category_labels_array[i] + '</option>');
        $select.append($option);
    }
    $select.after($buttons);
    $label.after($select);
    $categoryEdit.prepend($label).append($select).append($buttons);
    return $categoryEdit;
}


function dateTest() {
    let today = new Date();
    console.log(today.getDate());
}

function generateNewCategoryInput(num, part="label") {
    let nameFormGroup = $('<div class="form-group category" id="category"></div>');
    let categoryNameLabel = $('<label class="mb-0 w-100" for="new-category-input">Category</label>');
    let categoryNameInput = $('<input class="new-category-form-input w-50" name="category' + String(num) + '" type="text" placeholder="Category name" required>')
    categoryNameInput.attr('id', 'new-category-input' + String(num));

    let plannedFormGroup = $('<div class="form-group planned" id="planned"></div>');
    let categoryPlannedLabel = $('<label class="mb-0 w-100" for="new-planned-input">Planned Budget</label>');
    let categoryPlannedInput = $('<input class="new-category-form-input" name="planned' + String(num) + '" type="number" placeholder="$"  autofocus>')
    categoryPlannedInput.attr('id', 'new-planned-input' + String(num));

    nameFormGroup.append(categoryNameLabel).append(categoryNameInput);
    plannedFormGroup.append(categoryPlannedLabel).append(categoryPlannedInput);

    if (part === "planned") {
        return plannedFormGroup;
    }
    else if (part === "name") {
        return nameFormGroup;
    }
    else {
        return None;
    }


}

$(function () {
    let inputNum = 0;
    $('p#add-category').on('click', function () {
        console.log('clicked');
        $('div#newCategoryAnchor').after(generateNewCategoryInput(++inputNum, "planned"));
        $('div#newCategoryAnchor').after(generateNewCategoryInput(inputNum, "name"));
    });

})

class Form {
    constructor (input) {
        this.input = input;
    }

    /**
    Takes a string in the form: "rule1|rule2|rule3|etc..."
    **/
    validate (rules) {
        this.rules = rules.split("|");
        console.log(this.rules);
        let m = this.rules[0];
        if (this[m]()) {
            console.log('Passed validation');
        }
        else {
            console.log('Failed validation');
        }
    }

    min () {
        console.log('Calling min.');
        let str = this.input.val();
        console.log(str);
        return (str.length + 1) >= 8;
    }


}

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

    $('td.budget-icon').each(function () {
        $(this).on('click', function () {
            let bID = $(this).parent().attr('id');
            $('div.modal-header').attr('id', bID);
            $('div#iconModal').modal('show');
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
            let updateRow = 'span#' + budget_id + '.planned-value';
            let row = 'td#' + budget_id + '.budget-category-name';
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

    $('button#icon-update-submit').bind('click', function () {
        let new_icon = $('i#iconPreview').text();
        let bID = $('div.modal-header').attr('id');
        console.log(new_icon);
        console.log(bID);
        $.post('/budget/icon/update', {
            id: bID,
            icon: new_icon
        }, function (data) {
            $('div#iconModal').modal('hide');
        });
        return false;
    });
    $('button#add-new-category').on('click', function () {
        // Display New Category Form
        $('div#categoryModalCenter').modal('show');
    });

    $('select#iconSelect').on('change', function () {
        console.log($('div.modal-header').attr('id'));

        $('i#iconPreview').text($(this).val());
    });
});

function getPlannedTotal() {
    let total = 0;
    $('span.planned-value').each(function () {
        total += Number($(this).text());
    });
    $('td#planned-total').text(total);
};


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


            let $tbody = $('tbody#transaction-body');
            let $ch = changeCategoryForm(data['new_transaction']['id']);


            $tbody.prepend(createTransactionRow(data));


            // Update Monthly Total Progress Bar
            let $totalBar = $('div#total-spending-bar');
            let $totalBarLabel = $('p#bar-label-right');
            let totalData = data['monthly_total'];

            refreshProgressBar($totalBar, totalData);

            $totalBarLabel.text('$' + Math.round(data['monthly_total']['actual']) + ' of $' + data['monthly_total']['planned']);

            // Update Budget Category Total Progress Bars
            $('div.progress-bars').each(function() {
                let bar = $(this);
                let label = $(this).children().eq(0)[0].innerHTML
                label = label.replace(':', '');
                data.budget_totals.forEach(function(d) {
                    console.log(d);
                    console.log(bar);
                    if (d.category == label) {
                        console.log('Updating progress bar...');
                        let returnData = d;

                        // Get element for progress bar label
                        let barRightLabel = bar.children().eq(1);

                        // Get element for progress bar
                        let $progressBar = bar.children().eq(2).children().eq(0);

                        refreshProgressBar($progressBar, returnData);

                        // Update value for progress bar label
                        barRightLabel.text('$' + d['actual'] + ' of $' + d['planned']);
                    }
                });
            });
        }).fail( function (data) {
            console.log(data.responseJSON.errors);
            let errorMessages = [];
            let errorResponse = {};
            if ("amount" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.amount[0]);
            }
            if ("transaction_date" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.transaction_date[0]);
            }
            if ("description" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.description[0]);
            }
            if ("category" in data.responseJSON.errors)
            {
                errorMessages.push(data.responseJSON.errors.category[0]);
            }
            errorResponse["message"] = data.responseJSON.message;
            errorResponse["errors"] = errorMessages;
            $inputForm.fadeOut()
                      .fadeIn()
                      .prepend(generateAlert('fail', errorResponse));
        });
        return false;
    });
});

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

function resetSaveTransaction() {
    const now = new Date();
    const year = now.getFullYear();
    let month = String(now.getMonth()+1);
    month = month.length === 1 ? "0"+month : month;
    let day = String(now.getDate()).length === 1 ? "0"+String(now.getDate()) : String(now.getDate());

    const date = String(year) + "-" + month + "-" + day;
    $('input#description-input').val("");
    $('input#amount-input').val("");
    $('input#transaction-date-input').val(date);
    $('select#manual-select-category').val("");
}

function createTransactionRow(data) {
    let $newRow = $('<tr><td><i class="material-icons">' + data['new_transaction']['icon'] + '</i></td></tr>');
    let $dateCell = $('<td class="transaction_date"><small>' + data['new_transaction']['date'] + '</small></td>');
    let $descriptionCell = $('<td class="transaction-description">' + data['new_transaction']['description'] + '</td>');
    let $amountCell = $('<td class="transaction-amount">$' + data['new_transaction']['amount'] + '</td>');
    let $categoryCell = $('<td class="budget-category align-middle" id=' + data['new_transaction']['id'] + '>' + data['new_transaction']['category'] + '</td>');
    return $newRow.append($dateCell).append($descriptionCell).append($amountCell).append($categoryCell);
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
        let $errorMessages = $('<ul></ul>');
        data["errors"].forEach(function(error) {
            let $item = $('<li></li>');
            $item.append(error);
            $errorMessages.append($item);
        });
        $alert
            .addClass('alert alert-danger')
            .attr('role', 'alert')
            .text(data["message"])
            .append($errorMessages);
    }
    return $alert.prepend($closeButton);
}

// Close transaction modal after opening csv upload.
$('#toggle-csv-upload').on('click', function() {
    $('#modalCenter').modal('hide');
});

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
            $('th').removeClass('selected');
            // $('th').css('background-color', '#1C1F2B');
            var $header = $(this);
            var order = $header.data('sort');
            var column;
            // $header.css('background-color', '#38c172');
            $header.addClass('selected');

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

$('td.transaction-delete').each(function () {
    $(this).on('click', function () {
        let id = $(this).prev().attr('id');
        $('form#modal-delete-form').attr('action', '/transaction/' + id + '/destroy');
        $('div#deleteModalCenter').modal('show');
    });
});

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

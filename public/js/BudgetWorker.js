// BudgetWorker class
// purpose is to encapsulate all functionality that goes along with the budget table

function BudgetWorker() {
    this.getPlannedTotal = function () {
        let plannedTotal = 0;
        $('td.budget-category-planned').each(function () {
            plannedTotal += Number($(this).text());
        });
        $('td#planned-total').text(plannedTotal);
    };

    this.updateBudget = function (t, self, id) {
        const new_budget = $('input.update-input').val();
        const budget_id = id;
        const hiddenPlannedValue = $('td#' + budget_id).next();
        let loadSpinner = $('<div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');

        $.post('/budget/planned/update', {
            new_value: new_budget,
            id: budget_id
        }, function (data) {
            hiddenPlannedValue.text(data.planned);
            // Insert update planned budget value
            // updateForm.fadeOut();
            $('div.spinner-grow.text-success').remove();
            hiddenPlannedValue.fadeIn();
            // Remove update form

            self.getPlannedTotal();
        });
        return false;
    };

    // Cancel Add New Category
    this.categoryCancel = function (t) {
        this.anchor = t.parent().parent().next();
        this.updateForm = t.parent();
        this.updateForm.fadeOut();
        this.anchor.fadeIn();
        this.updateForm.parent().remove();
        this.updateForm.remove();
    };

    // Cancel Update Planned Budget
    this.cancel = function (t) {
        this.anchor = t.parent().next();
        this.updateForm = t.parent();
        this.updateForm.fadeOut();
        this.anchor.fadeIn();
        this.updateForm.remove();
    };

    this.budgetUpdateInput = function (value) {
        /*
        const updateBoxBG = $('<div class="update-box-bg"></div>');
        $('body').prepend(updateBoxBG);
        setTimeout(function() {
            $('div.update-box-bg').remove();
        }, 5000);
        */
        const submitButton = $('<button class="btn btn-outline-primary btn-block budget-update" id="budget-update-submit">Save</button>');
        const cancelButton = $('<button class="btn btn-outline-danger btn-block mt-0" id="budget-update-cancel">Cancel</button>');
        const inputBox = $('<input type="number" step="0.01" class="update-input w-100" name="budget_update" value=' + value + '>');

        let updateForm = $('<td class="budget-update-form"></td>');
        updateForm.append(inputBox, submitButton, cancelButton);
        return updateForm;

        //return '<td class="budget-update-form"><input type="number" step="0.01" class="update-input w-100" name="budget_update" value=' + value + '><button class="btn btn-outline-primary btn-block budget-update" id="budget-update-submit">Save</button><button class="btn btn-outline-danger btn-block" id="budget-update-cancel">Cancel</button></td>';
    };

    this.displayNewCategoryForm = function (t) {
        let newCategoryForm = $('<div id="new-category-form"></div>');
        this.categoryNameInput = '<label class="w-100 mb-0" for="new-category-input">Category</label><input id="new-category-input" class="new-category-form-input" name="category" type="text" required>';
        this.plannedBudget = '<label class="w-100 mb-0" for="new-planned-input">Planned Budget</label><input id="new-planned-input" class="new-category-form-input d-block" name=planned" type="text" autofocus><div class="d-block w-50"><button class="btn btn-outline-primary btn-small w-50" id="category-submit" type="submit">Save</button><button class="btn btn-outline-danger btn-small w-50" id="category-cancel" type="button">Cancel</button></div>';
        newCategoryForm.append(this.categoryNameInput);
        newCategoryForm.append(this.plannedBudget);
        this.newCategoryContainer = $('<div class="ml-4" id="new-category-container"></div>');
        this.newCategoryContainer.append(newCategoryForm);
        t.after(this.newCategoryContainer);
        t.hide();
    };

    this.saveNewCategory = function (t) {

        let loadSpinner = $('<div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');

        $('div#new-category-form').before(loadSpinner);
        setTimeout(function() {

        }, 5000);
        $.post('/budget/category/new', {
            name: $('input#new-category-input').val(),
            planned: $('input#new-planned-input').val()

        }).done( function (data) {
            // Insert new category line after last category row already in table
            // .prepend() on <tr id='budget-totals'>
            let newRow = $('<tr class="budget-category"></tr>');
            let newCategoryName = '<td class="budget-category-name">' + data.category + '</td>';
            let newCategoryPlanned = '<td class="budget-category-planned">' + data.planned + '</td><td>0</td><td>' + data.planned + '</td>';
            newRow.append(newCategoryName, newCategoryPlanned);
            console.log(newRow);
            $('div.spinner-grow.text-success').remove();
            $('tr#budget-totals').before(newRow);
            $('div#new-category-form').remove();
            $('span#add-new-category').fadeIn();
            $('button#add-new-category').show();
        }).fail( function () {
            // $('div#new-category-container').remove();
            $('div.spinner-grow.text-success').remove();
            $('button#add-new-category').parent().before(generateAlert('fail'));
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        });
        return false;
    }
}

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

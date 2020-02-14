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

    this.updateBudget = function (t, self) {
        let updateForm = t.parent();
        let hiddenPlannedValue = t.parent().next();
        $.post('/budget/planned/update', {
            new_value: $('input.update-input').val(),
            id: t.parent().prev().attr('id')
        }, function (data) {
            hiddenPlannedValue.text(data.planned);
            // Insert update planned budget value
            updateForm.fadeOut();
            hiddenPlannedValue.fadeIn();
            // Remove update form
            updateForm.remove();
            self.getPlannedTotal();
        });
        return false;
    };

    this.categoryCancel = function (t) {
        this.anchor = t.parent().parent().next();
        this.updateForm = t.parent();
        this.updateForm.fadeOut();
        this.anchor.fadeIn();
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
        return '<td class="budget-update-form"><input type="number" step="0.01" class="update-input w-100" name="budget_update" value=' + value + '><button class="btn-primary budget-update w-50" id="budget-update-submit">Save</button><button class="btn-secondary w-50" id="budget-update-cancel">Cancel</button></td>';
    };

    this.displayNewCategoryForm = function (t) {
        let newCategoryForm = $('<div id="new-category-form"></div>');
        this.categoryNameInput = '<label for="new-category-input">Category</label><input id="new-category-input" class="new-category-form-input" name="category" type="text" required>';
        this.plannedBudget = '<label for="new-planned-input">Planned Budget</label><input id="new-planned-input" class="new-category-form-input" name=planned" type="text"><button id="category-submit" type="submit">Save</button><button id="category-cancel" type="button">Cancel</button>';
        newCategoryForm.append(this.categoryNameInput);
        newCategoryForm.append(this.plannedBudget);
        this.newCategoryContainer = $('<div id="new-category-container"></div>');
        this.newCategoryContainer.append(newCategoryForm);
        return t.before(this.newCategoryContainer);
    };

    this.saveNewCategory = function (t) {
        $.post('/budget/category/new', {
            name: $('input#new-category-input').val(),
            planned: $('input#new-planned-input').val()

        }, function (data) {
            // Insert new category line after last category row already in table
            // .prepend() on <tr id='budget-totals'>
            let newRow = $('<tr class="budget-category"></tr>');
            let newCategoryName = '<td class="budget-category-name">' + data.category + '</td>';
            let newCategoryPlanned = '<td class="budget-category-planned">' + data.planned + '</td><td>0</td><td>' + data.planned + '</td>';
            newRow.append(newCategoryName, newCategoryPlanned);
            console.log(newRow);
            $('tr#budget-totals').before(newRow);
            $('div#new-category-form').remove();
            $('span#add-new-category').fadeIn();
        });
        return false;
    }
}
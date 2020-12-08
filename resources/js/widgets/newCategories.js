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

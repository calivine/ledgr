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

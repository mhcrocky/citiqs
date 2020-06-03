'use strict';
function cloneAndAppend(id) {
    let element = '';
    element +=      '<div class="form-group col-sm-12" style="max-width: 700px !important; margin-top:10px">';
    element +=          '<label>From:&nbsp</label>';
    element +=          '<input type="time" name="timeslots[from][]" required />';
    element +=          '<label>&nbspTo:&nbsp</label>';
    element +=          '<input type="time" name="timeslots[to][]" required />';
    element +=          '<label>&nbspPrice:&nbsp</label>';
    element +=          '<input type="number" min="0" step="0.01" name="timeslots[price][]" value="1" required />';
    element +=          '<button type="button" data-dismiss="alert" onclick="removeParent(this)">&times;</button>';
    element +=      '</div>';
    document.getElementById(id).insertAdjacentHTML('beforeend', element);
}
function removeParent(element) {
    let parent = element.parentElement;
    let ancestor = parent.parentElement;
    ancestor.removeChild(parent);
}
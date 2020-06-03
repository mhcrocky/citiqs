function uploadImage(element) {
    let imageId = element.dataset.imageId;
    let form = element.form;
    let url = globalVariables.ajax + 'labelImageUpload';
    sendFormAjaxRequest(form, url, 'labelImageUpload', changeImageSrc, [imageId]);
    form.reset();
    return false;
}
function changeImageSrc(imgId, src, bigImg) {
    let img = globalVariables.doc.getElementById(imgId);
    img.setAttribute('src', src);
    if ($('#' + imgId).parent().is('a')) {
        $('#' + imgId).unwrap();
    }
    $('#' + imgId).wrap('<a class="image-link" href="' + bigImg + '"></div>');
    $('.image-link').magnificPopup({type:'image'});
} 

function triger(inputId) {
    let input = globalVariables.doc.getElementById(inputId);
    input.onchange = function() {
        uploadImage(input);
    }
}
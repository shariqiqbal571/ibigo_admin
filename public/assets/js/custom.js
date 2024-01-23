$('.add-image').click(function() {
    var imgContainer = $(this).parent().parents('.images-container');
    // console.log('click' + imgContainer);
    var cloneItem = $(this).parent('div').siblings('.image').clone().eq(0);
    cloneItem.attr('style', 'display:flex !important;');
    cloneItem.append('<div style="margin:auto;cursor:pointer;border-radius:50%;padding: 5px 8px;" class="btn btn-danger" onclick="removeImage(this)"><i class="material-icons">cancel</i></div>');
    imgContainer.append(cloneItem);
});

function removeImage(e) {
    var image = e.parentElement;
    image.remove();
}
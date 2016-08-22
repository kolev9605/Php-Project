$(function() {
    $('#messages li').click(function() {
        $(this).fadeOut();
    });
    setTimeout(function() {
        $('#messages li.info').fadeOut();
    }, 3000);
});

function setFieldValue(fieldName, fieldValue) {
    let field = $("input[name='" + fieldName + "'], textarea[name='" + fieldName + "']");
    field.val(fieldValue);
}

function showValidationError(fieldName, errorMsg) {
    let field = $("input[name='" + fieldName + "'], textarea[name='" + fieldName + "']");
    field.after(
        $("<span class='validation-error'>").text(errorMsg)
    );
    field.focus();
}

$(function() {
	$(":file").filestyle({buttonText: "Find file"});
});

function showImage(imageContainerID, showButtonID, hideButtonID)
{
	window.open('posts', '_blank');
}

$.fn.scrollBottom = function() { 
  return $(document).height() - this.scrollTop() - this.height(); 
};
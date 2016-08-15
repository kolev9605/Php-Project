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
	if(document.getElementById("fileUpload"))
	{
		document.getElementById('fileUpload').onchange = function (evt) {
			var tgt = evt.target || window.event.srcElement,
				files = tgt.files;

			if (FileReader && files && files.length) {
				var fr = new FileReader();
				fr.onload = function () {
					document.getElementById('out-image').src = fr.result;
					document.getElementById('out-image').style.display = "block";
				}
				fr.readAsDataURL(files[0]);
			}

			else {
			
			}
		}
	}
});
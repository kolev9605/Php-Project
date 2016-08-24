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

function showImage(post)
{
	$.ajax({
	  type: "POST",
	  url: "posts",
	  data: { post: post }
	}).done(function( msg ) {
		var myWindow = window.open('posts', '_blank');
		myWindow.document.write(msg);
	});    
}

$.fn.scrollBottom = function() { 
  return $(document).height() - this.scrollTop() - this.height(); 
};

function vote(loggedIn, loginPage, post, loggedUser, isUpVote, voteNumberID)
{
	if(loggedIn)
	{
		$.ajax({
		  type: "POST",
		  url: "vote",
		  data:
		  {
			post: post,
			loggedUser: loggedUser,
			isUpVote: isUpVote
		  }
		}).done(function( msg ) {
			$("#" + voteNumberID).text(msg.substr(0, msg.indexOf('\n')));
		});
	}
	else {
		window.location.href = loginPage;
	}
}
const PIXELS_FROM_BOTTOM_BEFORE_MORE_POSTS = 500;

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

function showImage(postID, directoriesUp = 0)
{
	let url = "posts?" + postID;
	for(let i = 0; i < directoriesUp; i++)
	{
		url = "../" + url;
	}
	window.open(url);
}

$.fn.scrollBottom = function() { 
  return $(document).height() - this.scrollTop() - this.height(); 
};

function vote(loggedIn, loginPage, voteObject, loggedUser, isUpVote, voteNumberID, imagesFolder, index, url)
{
	if(loggedIn)
	{
		$.ajax({
		  type: "POST",
		  url: url,
		  data:
		  {
			voteObject: voteObject,
			loggedUser: loggedUser,
			isUpVote: isUpVote
		  }
		}).done(function( msg ) {
			$("#" + voteNumberID).text(msg.substr(0, msg.indexOf('\n')));
			if(isUpVote && $("#upArrow_" + index).attr("src") == imagesFolder + "upvote-arrow.png")
			{
				$("#upArrow_" + index).attr("src", imagesFolder + "arrow-rotated.png");
			}
			else if(!isUpVote && $("#downArrow_" + index).attr("src") == imagesFolder + "downvote-arrow.png")
			{
				$("#downArrow_" + index).attr("src", imagesFolder + "arrow.png");
			}
			else if(isUpVote)
			{
				$("#upArrow_" + index).attr("src", imagesFolder + "upvote-arrow.png");
				$("#downArrow_" + index).attr("src", imagesFolder + "arrow.png");
			}
			else
			{
				$("#upArrow_" + index).attr("src", imagesFolder + "arrow-rotated.png");
				$("#downArrow_" + index).attr("src", imagesFolder + "downvote-arrow.png");
			}
		});
	}
	else {
		window.location.href = loginPage;
	}
}

function addComment(post)
{
	var content=$('#commentContent').val();
	$.ajax({
		  type: "POST",
		  url: "comment",
		  data:
		  {
			post: post,
			content: content
		  }
		}).done(function( msg ) {
			location.reload();
		});
}

function showAllPosts(hiddenClassName, buttonID)
{
	$("." + hiddenClassName).css("display", "inline-block");
	$("#show-hidden-posts-button_" + buttonID).css("display", "none");
}

function showSearch(root)
{
	var content = $('#search').val();
	if(content)
	{
		let url = root + "/search?" + content;
		window.location.href = url;
	}
}

function followUser(followedUserId)
{
	$.ajax({
		  type: "POST",
		  url: "followUser",
		  data:
		  {
			followedUserId: followedUserId
		  }
		}).done(function( msg ) {
			location.reload();
		});
}

function unfollowUser(followedUserId)
{
	$.ajax({
		  type: "POST",
		  url: "unfollowUser",
		  data:
		  {
			followedUserId: followedUserId
		  }
		}).done(function( msg ) {
			location.reload();
		});
}

function addConversationComment(conversation)
{
	var content=$('#conversationCommentContent').val();
	$.ajax({
		  type: "POST",
		  url: "../conversationComment",
		  data:
		  {
			conversation: conversation,
			content: content
		  }
		}).done(function( msg ) {
			location.reload();
		});
}
$(document).ready(function () {
	$('#conversation-participants').on('input', function(e){
		if($(this).val().length >= 3)
		{
			$('#participent-dropdown-content').css("display", "inline-block");
			$.ajax({
				  type: "POST",
				  url: "users",
				  data:
				  {
					value: $(this).val()
				  }
		    }).done(function(msg) {
				result = msg.substr(0, msg.indexOf('<!DOCTYPE'));
				if(result == "")
				{
					$('#participent-dropdown-content').css("display", "none");
				}
				$("#participent-dropdown-content").empty();
				$("#participent-dropdown-content").append(result);
			});
		}
		else
		{
			$('#participent-dropdown-content').css("display", "none");
		}
	});
});
	
$('#conversation-participants').change(function(e){
	$('#participent-dropdown-content').css("display", "none");
});

function addUsername(username)
{
	
}
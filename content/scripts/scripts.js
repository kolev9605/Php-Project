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

let index = 0;
let startIndex = 0;
$( window ).scroll(function() {
	if($(window).scrollBottom() < PIXELS_FROM_BOTTOM_BEFORE_MORE_POSTS && $.active == 0)
	{
		showPosts(true);
	}
});

function showPosts(onScrollDown = false) {
	if(onScrollDown)
	{
		if(index == 0)
		{
			index = $(".indexDivValue").text();
		}
		if(startIndex == 0)
		{
			startIndex = $(".startIndexDivValue").text();
		}
		$.ajax({
				type: "POST",
				url: '',
				data: {
					index: index,
					startIndex: startIndex,
				},
				success: function( data ) {
					if (!(typeof $(data).find(".indexValue").attr("id") === "undefined")) {
						result = $(data).find(".postContainer");
						$("#articlePosts").append(result);
						index = $(data).find(".indexValue").attr("id");
						startIndex = $(data).find(".startIndexValue").attr("id");
					}
				}
			});
	}
}

function showImage(postID)
{
	let url = window.location.protocol + "//" + window.location.host + "/project/posts?" + postID;
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
			isUpVote: isUpVote,
			doNotRender: true
		  }
		}).done(function( msg ) {
			$("#" + voteNumberID).text(msg);
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
			content: content,
			doNotRender: true
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
	var username = $('#searchByUsername').val();
	if(content || username)
	{
		let url = root + "/search?searchTerm=" + content + "&searchUsername=" + username;
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
			followedUserId: followedUserId,
			doNotRender: true
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
			followedUserId: followedUserId,
			doNotRender: true
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
			content: content,
			doNotRender: true
		  }
		}).done(function( msg ) {
			location.reload();
		});
}

$(document).ready(function () {
	$('#conversation-participants').on('input', function(e){
		autocomplete($(this).val());
	});
	
	$('#conversation-participants').blur(function(){
		$('#participent-dropdown-content').fadeOut();
	});
	
	$('#conversation-participants').focus(function(){
		autocomplete($(this).val());
	});
});

function autocomplete(value)
{
	arrayOfNames = value.split(", ");
	currentName = arrayOfNames[arrayOfNames.length - 1];
	if(currentName.length >= 3)
	{
		$('#participent-dropdown-content').css("display", "inline-block");
		$.ajax({
			  type: "POST",
			  url: "users",
			  data:
			  {
				ignoredNames: arrayOfNames,
				value: currentName,
				doNotRender: true
			  }
		}).done(function(msg) {
			result = msg;
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
}

function addUsername(username)
{
	let arrayOfNames = $('#conversation-participants').val().split(", ");
	arrayOfNames[arrayOfNames.length - 1] = username;
	let allUsernames = "";
	for(let i = 0; i < arrayOfNames.length; i++)
	{
		allUsernames = allUsernames + arrayOfNames[i] + ", ";
	}
	
	$('#conversation-participants').val(allUsernames);
	$('#participent-dropdown-content').css("display", "none");
}

$(document).ready(function () {
	$('#searchByUsername').on('input', function(e){
		searchAutocomplete($(this).val());
	});
	
	$('#searchByUsername').blur(function(){
		$('#search-dropdown-content').fadeOut();
	});
	
	$('#searchByUsername').focus(function(){
		searchAutocomplete($(this).val());
	});
});

function searchAutocomplete(value) {
	currentName = value;
	arrayNames = [];
	arrayNames[0] = currentName;
	var baseUrl = window.location.protocol + "//" + window.location.host + "/project/";
	if(currentName.length >= 3)
	{
		$('#search-dropdown-content').css("display", "inline-block");
		$.ajax({
			  type: "POST",
			  url: baseUrl + "conversations/users",
			  data:
			  {
				ignoredNames: arrayNames,
				value: currentName,
				isSearch: true,
				doNotRender: true
			  }
		}).done(function(msg) {
			result = msg;
			if(result == "")
			{
				$('#search-dropdown-content').css("display", "none");
			}
			$("#search-dropdown-content").empty();
			$("#search-dropdown-content").append(result);
		});
	}
	else
	{
		$('#search-dropdown-content').css("display", "none");
	}
}

function addSearchUsername(username)
{
	$('#searchByUsername').val(username);
	$('#search-dropdown-content').css("display", "none");
}
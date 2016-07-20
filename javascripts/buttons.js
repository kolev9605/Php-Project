$(document).ready(function(){
    $('#register-form').submit(function(event) {        
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'controllers/UsersHandler.php',
		data :
		{
			'action': "register",
			'username': $('#register-username').val(),
			'password': $('#register-password').val(),
			'confirmedPassword': $('#confirmed-password').val(),
		},
		error: function(response){
			console.log("Error: " + JSON.stringify(response));
		},
		success: function(response){
			console.log("Success: " + JSON.stringify(response));
		},
	});
    });
});

$(document).ready(function(){
    $('#login-form').submit(function(event) {
	login(event);
    });
});

function login(event) {
    event.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'controllers/UsersHandler.php',
		data :
		{
			'action': "login",
			'username': $('#login-username').val(),
			'password': $('#login-password').val(),
		},
		error: function(response){
			console.log("Error: " + JSON.stringify(response));
		},
		success: function(response){
			window.location.replace("http://instacopy.cloudvps.bg/index.php");
			console.log("Success: " + JSON.stringify(response));
		},
	});
};
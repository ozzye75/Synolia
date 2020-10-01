
var actionurl = "https://sg-exotest.demo.sugarcrm.eu/rest/v11/oauth2/token";

// prepare a data for submit
var loginParams = {
	user_auth:{
		grant_type: "password",
		client_id: "melissa",
		client_secret: "passwordM$*",
		username: "melissa",
		password: "3s%oHgbXEShC8ViX"
	}
};
var dataToPost = {
	method: "login",
	input_type: "JSON",
	response_type: "JSON",
	rest_data: JSON.stringify(loginParams)
};

//do your own request an handle the results
$.ajax({
	url: actionurl,
	type: 'post',
	dataType: 'json',
	data: dataToPost,
	success: function(result) {
		if(result.id) {
				alert$("#loginResult").text("Sucessfully login. Your session ID is : " + result.id).show();
		} else {
			$("#loginResult").text("Error on login: "
				+ result.name
				+ " - "
				+ result.number
				+ " - "
				+ result.description).show();
		}
	},
	error: function(jqXHR, textStatus, errorThrown) {
		$("#loginResult").text("Errors occurred during the call to service.").show();
	}
});
return false;
});
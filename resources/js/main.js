$(document).ready(start);

var data = {};

function getDataFromHTMLForm(){
	data.nombre = $("#nombre").val();
	data.email = $("#email").val();
	data.direccion = $("#direccion").val();
};

function displayMessage(json){
	if(!json.error_status){
		$("#d-success").css("display","block");
		$("#d-success p.message").text(json.message);
	}else{
		$("#d-error").css("display","block");
		$("#d-error p.error_description").text(json.message);
	}
};

function clearInformationFromHTMLForm(){
	$("#nombre").val("");
	$("#email").val("");
	$("#direccion").val("");
	$("#nombre").focus();
};

function sendDataToServer(){
	$.ajax({
		type: "POST",
		url: 'resources/php/index.php',
		data: data,
		success: function(json_response,textStatus,jqXHR){
			var json = JSON.parse(json_response);
			displayMessage(json);
			clearInformationFromHTMLForm();
		},
		error: function(jqXHR, textStatus, errorThrown){

		}
	});
};

function start(){
	$("#contact-form").submit(function(event){
		getDataFromHTMLForm();
		sendDataToServer();
		event.preventDefault();
	});
};
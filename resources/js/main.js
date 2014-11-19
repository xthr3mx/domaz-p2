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

function showTable(){$("#people-container").css("display","block");}

function uploadInformation(){
	// remove all child nodes 
	$('#people-table tbody').empty();
	for(var persona in personas){
		console.log(personas[persona]);
		$(
			"<tr>"+
			"<td><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> <span class='id'>"+(personas[persona]).id+"</span></td>"+
			"<td>"+(personas[persona]).nombre+"</td>"+
			"<td>"+(personas[persona]).email+"</td>"+
			"<td>"+(personas[persona]).direccion+"</td>"+
			"</tr>"
		).appendTo($("#people-table tbody"));
	}
	//add event to tr elements 
	$("table").on('click','tr td span.id', function(e){
		//console.log(e.target.textContent);
		var id = parseInt(e.target.textContent);
		if(id>=1){
			$("#u-id").val(id);
			$("#u-d-error").css("display","none");
			$("#u-d-success").css("display","none");
			$("#m-update").modal('show');
		}else{console.log('NEVER GIVE UP!');}
	});
};

function logicForDisplayPeople(){
	$.ajax({
		type: 'GET',
		url: 'resources/php/information.php',
		data: {'name':'persona', 'id':null},
		success: function(json_response, textStatus, jqXHR){
			personas = JSON.parse(json_response);
			if(personas.length>=1){
				showTable();
				uploadInformation();
			}
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

	$("#update-form").submit(function(event){
		var	id = $("#u-id").val(),
			name = $("#u-nombre").val(),
			email = $("#u-email").val(),
			direction = $("#u-direccion").val();

		$.ajax({
			type: "POST",
			url: 'resources/php/update.php',
			data: {'id': id, 'name': name, 'email': email, 'direction': direction},
			success: function(json_response,textStatus,jqXHR){
				var json = JSON.parse(json_response);
				if(!json.error_status){

					$("#u-id").val("");
					$("#u-nombre").val("");
					$("#u-email").val("");
					$("#u-direccion").val("");

					$("#u-d-success").css("display","block");
					$("#u-d-success p.message").text(json.message);

					logicForDisplayPeople();

				}else{
					$("#u-d-error").css("display","block");
					$("#u-d-error p.error_description").text(json.message);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){

			}
		});

		event.preventDefault();
		//$("#m-update").modal('hide');
	});
};
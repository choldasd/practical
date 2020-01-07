$(document).ready(function(){
		
	function create_employee(formsel,url){
		var form = $(formsel)[0];
		var formData = new FormData(form);
		$.ajax({
			url: url,
			data: formData,
			type: "POST",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			contentType: false, 
			processData: false,
			success:function(response){
				console.log(response);
				if(response != ""){
					if(response.status === true){
						window.location.href = response.redirect;
					}else{
						$(".cust_error").html("");
						$.each( response.data, function(field, errors ) {
							var error_ht = "";
							$.each( errors, function(key, evalue ) {
								error_ht += evalue+'<br>';
							});
							console.log(error_ht);
							console.log(field);
							$("#error_"+field).append(error_ht).show();
						});
					}
				}
			},
			error: function(response){
				console.log(response);
			}
		});
	}
	
	$("#create_employee").submit(function(e){
		e.preventDefault();
		var url = $(this).attr("action");
		var formsel = $(this);
		create_employee(formsel,url);
		
	});
	
	$(document).on("submit","#edit_employee",function(e){
		e.preventDefault();
		var url = $(this).attr("action");
		var formsel = $(this);
		console.log(formsel);
		create_employee(formsel,url);
		
	});
		
	$(document).on("click",".edit",function(e){
		console.log($(this).attr("title"));
		var action = $(this).attr("action");
		$.ajax({
			url: action,
			type: "GET",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			cache: false, 
			success:function(response){
				if(response != ""){
					$("#editContent").html("");
					if(response.status === true){
						$("#editContent").html(response.data);
						$('#editModal').modal({
							keyboard: false
						});
					}else{
						console.log("Error! Unable to load record. error");
					}
				}
			},
			error: function(response){
				console.log("Error! Something went wrong. error");
			}
		});
		
	});
	
	
	
	
});
	
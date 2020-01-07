$(document).ready(function(){
	var url = window.location.pathname;
	function list(page,url){
		//var url = window.location.pathname;
		
		var keyword = $("#keyword").val();
		url += "?keyword="+keyword;
		
		/* var email = $("#email").val();
		if(email != ""){
			url += "&email="+email;
		} */
		
		var sort_type = $("#sort_type").val();
		if(sort_type != ""){
			url += "&sort_type="+sort_type;
		}
		
		var sort_by = $("#sort_by").val();
		if(sort_by != ""){
			url += "&sort_by="+sort_by;
		}
		
		if(page == 0){
			var page = $("#page").val();
			if(page != ""){
				url += "&page="+page;
			}
		}else{
			url += "&page="+page;
		}
			console.log(url);
			console.log(page);
		$.ajax({
			url: url,
			type: "GET",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			cache: false, 
			success:function(response){
				//console.log(response);
				$("#ajax_search").html(" ");
				if(response != ""){
					if(response.status === true){
						$("#ajax_search").html(response.data);
						//console.log(response.data);
					}else{
						
					}
				}
			},
			error: function(response){
				console.log(response);
			}
		});
	}
	
	list(0,url);
	
	$(document).on("click","#search_btn",function(){		
		list(1,url);
	});
	
	$(document).on("click",".delete",function(e){	
		var action = $(this).attr("action");
		swal({
			title: "Are you sure?",
			text: "You want to delete record. You will not be able to recover it again.",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes Delete it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false,
			showLoaderOnConfirm: true,
		}, function(isConfirm){
			if(isConfirm){
				destroy(e,action);
			}else{
				swal("Cancelled!","Action successfully cancelled.","error");
			}
		});
	});
		
	function destroy(e,action){
		var id = $(e.target).closest(".rowtr").attr("rowid");
		
		var data = "_method=DELETE";
		$.ajax({
			url: action,
			type: "POST",
			data: data,
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			cache: false, 
			success:function(response){
				//console.log(response);
				if(response != ""){
					if(response.status === true){
						$("#tr_"+id).remove();
						swal("Deleted!","Record successfully deleted.","success");
						var ttr = $(".del_tbody").find(".rowtr").length;
						if(ttr == 0){
							window.location.reload();
						}
					}else{
						swal("Error!","Unable to delete record.","error");
					}
				}
			},
			error: function(response){
				swal("Error!","Something went wrong.","error");
			}
		});
	}
	
	
	
	
	
	
});
	
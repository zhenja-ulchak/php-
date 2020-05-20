function getEmail(){
    var ajaxemail = $(".email").val();
    if(ajaxemail == "")
	 return false;
     $.ajax({
	 type:"GET",
	 url:"http://chat/index.php",
	 data:{"email":ajaxemail},
	 success:result
     });
     function result(data){
	 $(".errorEmail").html("<b>"+data+"</b>").css({'color':'red'});
	 return false;
     }
}


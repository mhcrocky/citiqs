
$('document').ready(function()
{ 
	$('#username').on('change', function(){
		$('#submit-btnx').prop('disabled', true);
		var username=$("#username").val();
		if(typeof(uid) != "undefined" && uid !== null){
			var data={username:username,uid:uid};
		}
		else{ var data={username:username}; }
		$.ajax({	
			type : 'POST',
			url  : 'index.php?login/ajax_validate_username',
			data: data,
			dataType: 'json',
			// beforeSend: function()
			// {	
			// 	$("#error").fadeOut();
			// 	$("#btn-login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; Processing!! &nbsp;Wait...');
			// },
			success :  function(response)
			   {	
			   		if(response.username_status=='exists'){
			   			$('.uname-error').html('<span class="parsley-error">Username already selected!</span>')	;
			   		}else{
			   		 $('.uname-error').html('');
			   		 $('#submit-btnx').prop('disabled', false);	
			   		}
			   }
			});
	});
});
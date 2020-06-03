
$('document').ready(function()
{ 
     /* validation */
	 $("#installd_form").validate({
      rules:
	  {
			db_username: {
			required: true,
			},
			db_password: {
            required: false            
            },
            db_name: {
            required: true            
            },
	   },
       messages:
	   {
            db_username:{
                      required: "please enter database Username"
                     },
            db_name: "please enter database name",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
		db_username=$("#db_username").val();
  		db_password=$("#db_password").val();
  		db_name=$("#db_name").val();

			$.ajax({
				
			type : 'POST',
			url  : 'index.php?install/check_db',
			data: "db_username="+db_username+"&db_password="+db_password+"&db_name="+db_name,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-check").html('<i class="fa-li fa fa-spinner fa-spin"></i>  &nbsp; Checking!! &nbsp;Wait...');
			},
			success :  function(response)

			   {	
			   var login = response.login_status;			   					
					if(login =="success"){									
						$("#result").html('<div class="alert alert-success"><strong>Well done!</strong> You successfully read this important alert message.</div>');
					}
					else{
									
						$("#result").fadeIn();						
						$("#result").html('<div class="alert alert-danger"><strong>Well done!</strong> You successfully read this important alert message.</div>');
									};
					}
			  }
			});
				return false;
		}
	   
});
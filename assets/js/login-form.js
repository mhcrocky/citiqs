
$('document').ready(function()
{ 
     /* validation */
	 $("#login_form").validate({
      rules:
	  {
			password: {
			required: true,
			},
			username: {
            required: true            
            },
	   },
       messages:
	   {
            password:{
                      required: "please enter your password"
                     },
            username: "please enter your email address",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
		username=$("#username").val();
  		password=$("#password").val();
  		user_role= $("input[name='user_role']:checked").val();
				
			$.ajax({
				
			type : 'POST',
			url  : 'index.php?login/ajax_login',
			data: "username="+username+"&password="+password+"&user_role="+user_role,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; Processing!! &nbsp;Wait...');
			},
			success :  function(response)

			   {	
			   var login = response.login_status;			   
			   var redirect = response.redirect_url;					
					if(login =="success"){									
						$.Notification.autoHideNotify('success', 'top right', 'Welcome!!Now you are loged in', "Now you are going to main panel...");
						setTimeout(' window.location.href = "'+redirect+'"; ',1000);
					}
					else if(login=='access-denied'){
					     $("#error").fadeIn(1000, function(){
						$.Notification.autoHideNotify('warning', 'top center', 'Access denied:', "Please contact administrator!!");		
						$("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; Sign In');
									});		
					}
					else{
									
						$("#error").fadeIn(1000, function(){
						$.Notification.autoHideNotify('error', 'top center', 'Opps Login Fail:', "Username and password not match.<br>Please try again!!");		
						$("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; Sign In');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});
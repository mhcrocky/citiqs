<?php 
	//-------------------------- You need to set these --------------------------//
	$sendy_installation_url = 'http://sendy.co/a'; //Your Sendy installation (without the trailing slash)
	$api_key = 'your_api_key'; //Can be retrieved from your Sendy's main settings
	$success_url = 'http://google.com'; //URL user will be redirected to if successfully subscribed
	//---------------------------------------------------------------------------//

	//POST variables
	$name = $_POST['name'];
	$email = $_POST['email'];
	$lists = $_POST['list'];
	$boolean = 'true';
	
	//Check fields
	if($name=='' || $email=='' || $lists=='')
	{
		echo 'All fields are required.';
		exit;
	}
	
	//Loop through the checkboxes and add them to Sendy if checked
	foreach ($lists as $list)
	{
        //-------- Subscribe --------//
        $postdata = http_build_query(
            array(
            'name' => $name,
		    'email' => $email,
		    'list' => $list,
		    'api_key' => $api_key,
		    'boolean' => 'true'
            )
        );
        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);
        $result = file_get_contents($sendy_installation_url.'/subscribe', false, $context);
        //-------- Subscribe --------//
	}
	
	//Redirect to success URL
	header("Location: $success_url");
?>
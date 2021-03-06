<?php
//Set the password required for the form to work. I recommend implementing a password to prevent spammers
$setpassword = 'YOUR PASSWORD';

//This function validates the user input to avoid SQL injecting
function secure($unsecure){
	$secure = mysqli_escape_string(htmlentities($unsecure));
	return $secure;
}

//Define a write function. This replaces "echo" so that if the user turns debug off they do not recieve debug messages
function write($message){
	global $debug;
	if($debug == true){
		echo $message;
	}
}

//See if the user has opted into Debug mode
if(isset($_POST['debug'])){
	if($_POST['debug'] == true){
		$debug = true;
	} else{
		$debug = false;
	}
}
	
write('Starting Debug:<br>');
write('Form Filled<br>');
	
//Define all of the filled form fields after sanitising them
$to = secure($_POST['to']);
$from = secure($_POST['from']);
$fromname = secure($_POST['fromname']);
$replyto = secure($_POST['replyto']);
$subject = secure($_POST['subject']);
$message = secure($_POST['message']);
write('Inputs sanitised<br>');
	
//Check if the password is correct
if($_POST['password'] == $setpassword){
write('Correct Password, ');
		
	//Write and prepare the email
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= 'From: '.$fromname.' <'.$from.'>' . "\r\n";
	$headers .= 'Reply-To: '. $replyto . "\r\n";
		
	//Send the Email
	$email = mail($to,$subject,$message,$headers);
	write('Email attempted <br>');
		
	//Check if the email was sent to the servers
	if($email){
		write('Email Successful<br>');
		$mail = '<div style="color:green">Email Delivered. 99% chance of being sent, but is out of our hands. Please allow a while for it to arrive</div>';
	} else {
		write('Email Failed<br>');
		$mail = '<div style="color:red">Error - Email was not sent. This is not a problem on our side but a problem with php. Please try again later</div>';
	}
} else{
	write('Password Failed<br>');
	$mail = '<div style="color:red">Incorrect Password. We use a password to prevent spamming or illegal usage</div>';
}
json_encode($mail);
?>

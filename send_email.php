<?php

// has the form been submitted

if(isset($_POST['submit'])) {

	$email_to = "enquiry@microsystemsresearch.ch"; // email to send to

	$feedback_message = ""; // alert (success or error) for form submition feedback


	// error function

	function died($error, $error_count) {

		$feedback_error = $error_text_1 = $error_text_2 = $error_text_3 = "";

		if ($error_count > 1) {

			$error_text_1 .= "there were errors";

			$error_text_2 .= "These errors appear";

			$error_text_3 .= "these errors";

		}
		else {

			$error_text_1 .= "there was an error";

			$error_text_2 .= "This error appears";

			$error_text_3 .= "this error";

		}

		$feedback_error .= "We are very sorry, but " . $error_text_1 . " found with the form you submitted. ";

		$feedback_error .= $error_text_2 . " below.</strong><br /><br />";

		$feedback_error .= "<ul>" . $error . "</ul>" . "<br />";

		$feedback_error .= "Please fix " . $error_text_3 . " to submit your message.<br />";


		$feedback_message = '<div class="col-md-12">
								<div class="alert alert-danger">
									<strong><span class="fa fa-exclamation-triangle"></span> Error! ' . $feedback_error . 
								'</div>
							</div>';


		include 'contact.html';

		die();

	} 

	// get visitor's ip

	function getVisitorIP() {
		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote = $_SERVER['REMOTE_ADDR'];

		if (filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} 
		else { 
			if (filter_var($forward, FILTER_VALIDATE_IP)) {
				$ip = $forward;
			} 
			else {
				$ip = $remote;
			}
		}

		return $ip;
	}



    // validation, check required fields exist

	if(!isset($_POST['name']) ||

		!isset($_POST['email']) ||

		!isset($_POST['subject']) ||

		!isset($_POST['message']) ||

		!isset($_POST['real'])) {

		died('We are sorry, but there appears to be a problem with the form you submitted.');       

}



	// set variables

    $name = $_POST['name']; // required

    $email = $_POST['email']; // required

    $subject = $_POST['subject']; // required

    $message = $_POST['message']; // required

    $find = $_POST['find']; // not required

    $real = $_POST['real']; // required

    // ip

    $visitor_ip = getVisitorIP();



    // set errors

    $error_message = "";
    $error_count = 0;

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp, $name) || strlen($name) < 2) {

    	$error_message .= '<li>The Name you entered does not appear to be valid.</li><br />';
    	$error_count++;

    }

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp, $email)) {

    	$error_message .= '<li>The Email Address you entered does not appear to be valid.</li><br />';
    	$error_count++;

    }

    if(!preg_match($string_exp, $subject) || strlen($subject) < 2) {

    	$error_message .= '<li>The Subject you entered does not appear to be valid.</li><br />';
    	$error_count++;

    }

    if(strlen($message) < 10) {

    	$error_message .= '<li>The Message you entered does not appear to be valid.</li><br />';
    	$error_count++;

    }

    if(!empty($find) && !preg_match($string_exp, $find) || !empty($find) && strlen($find) < 3) {

    	$error_message .= '<li>How you found us does not appear to be valid.</li><br />';
    	$error_count++;

    }

    if ($real != 7) {

    	$error_message .= '<li>The answer you entered for the spam checker is incorrect.</li><br />';
    	$error_count++;

    }

    if(strlen($error_message) > 0) {

    	died($error_message, $error_count);

    }



    $email_message = $name . " has contacted you through the website. Form details below.\n\n";



    function clean_string($string) {

    	$bad = array("content-type", "bcc:", "to:", "cc:", "href");

    	return str_replace($bad, "", $string);

    }



    // create email message

    $email_message .= "Name: " . clean_string($name) . "\n";

    $email_message .= "Email: " . clean_string($email) . "\n\n";

    $email_message .= "Subject: " . clean_string($subject) . "\n\n";

    $email_message .= "Message: \n\n" . clean_string($message) . "\n\n\n";

    $email_message .= "--------------------------\n\n";

    if (!empty($find)) {
    	$email_message .= $name . " found out about the website from: " . clean_string($find) . "\n\n";
    }

    $email_message .= "(Please don't reply to this email directly. Start a new conversation with " . $name . " via  " . $email . "  )\n\n";

    $email_message .= "Visitor's IP: " . clean_string($visitor_ip) . "\n";



  	// create email headers

    $headers = 'From: ' . $email . "\r\n" .

    'Reply-To: ' . $email . "\r\n" .

    'X-Mailer: PHP/' . phpversion();

    //@mail($email_to, $subject, $email_message, $headers);  



    // Success message

    $feedback_message = '<div class="col-md-12">
    						<div class="alert alert-success">
								<strong><span class="fa fa-send"></span> Success! Message sent.</strong>
						 	</div>
						 </div>';

    include 'contact.html';

}

?>
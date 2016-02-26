<?php

/**
* 	All logical processing comes here
*/
class sid_nsna_logic_pl3 extends sid_nsna_security_pl3
{
	public function contactUs_pl3($data)
	{
	    // get the posted data
	    $name = parent::sid_nsna_sanitize( $data["Name"] );
	    $email_address = parent::sid_nsna_sanitize( $data["Email"] );
	    $phone_num = parent::sid_nsna_sanitize( $data["Phone"] );
	    $messages = parent::sid_nsna_sanitize( $data["Description"] );
	    $username = parent::sid_nsna_sanitize( $data["username"] );
	    $admin_email = get_option( 'admin_email' );

	    $message = "Name: $name\n";
	    $message .= "Email Address: $email_address\n";
	    $message .= "Telephone: $phone_num\n";
	    $message .= "Message:\n$messages";

	    $subject = "Contact Us";

	    if( !empty($username) )
	    	return 500;
	    $status = wp_mail($admin_email, $subject, $message);
		if($status)
			return 200;
		return 500;
	}

	function uploadLogo_pl3( $data, $pldir )
	{
		$current_user = wp_get_current_user();
		$select = new sid_nsna_selectDb_pl3();
		$stamp = $select->getUsersStamp_pl3();

		$fileTmpLoc = $data["tmp_name"]; // File in the PHP tmp folder
		$fileType = $data["type"]; // The type of file it is
		$fileSize = $data["size"]; // File size in bytes
		$fileErrorMsg = $data["error"]; // 0 for false... and 1 for true
		$filePath = str_replace("\\", "/", $pldir."Assets/Vendors/$stamp/Logo_e.png");
		
		if ( !$fileTmpLoc || ( $fileSize == 0 && $fileErrorMsg == 0 ) ) { // if file not chosen
		    echo 500;
		    exit();
		}
		if( file_exists($filePath) ) // Delete logo in the dir if exists
			unlink($filePath);
		
		if( move_uploaded_file($fileTmpLoc, $filePath) ){
		    echo 200;
		} else {
		    echo $filePath;
		}
			
	}
			public function satitizeAppoData( $data )
			{
				$name = parent::sid_nsna_sanitize( $data["name"] );
			    $email_address = parent::sid_nsna_sanitize( $data["email"] );
			    $phone_num = parent::sid_nsna_sanitize( $data["phone"] );
			    $time = parent::sid_nsna_sanitize( $data["time"] );

			    $errors = [];
			
				if($this->sid_nsna_isEmptyString($name) || !$this->sid_nsna_isCrudFree($name) || !$this->sid_nsna_verifyName($name))
					array_push($errors, 'Error! Invalid Name.');
				if($this->sid_nsna_isEmptyString($email_address) || !$this->sid_nsna_isCrudFree($email_address) || !$this->sid_nsna_verifyEmail($email_address))
					array_push($errors, 'Error! Invalid Email.');
				if($this->sid_nsna_isEmptyString($phone_num) || !$this->sid_nsna_isCrudFree($phone_num) || !$this->sid_nsna_verifyFnNum($phone_num))
					array_push($errors, 'Error! Invalid Phone number.');
				if($this->sid_nsna_isEmptyString($time) || !$this->sid_nsna_isCrudFree($time) )
					array_push($errors, 'Error! Invalid Phone number.');

				return $errors;
			}

	public function gnerate_OTP_4_him( $data )
	{
		$errors = $this->satitizeAppoData( $data );
		if(empty($errors))
		{
			$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	      	$string_shuffled = str_shuffle($string);
	      	$otp = substr($string_shuffled, 1, 4);
	       	$ip = parent::sid_nsna_get_ThisSystem_public_ip_address();
	       // file_get_contents("http://login.smsgatewayhub.com/smsapi/pushsms.aspx?user=abc&pwd=$password&to=919898123456&sid=senderid&msg=test%20message&fl=0");       
	      	$select = new sid_nsna_insertDb_pl3();

	      	// $d=mktime(11, 14, 54, 8, 12, 2014);
			// echo "Created date is " . date("Y-m-d h:i:sa")
	       	if( $select->record_otpDB( $otp, $ip ) )
	       	{
			    $message = "Hola! ".$data['name']. " (". $data['email'] . ")\n";
			    $message .= "This is a system generated OTP ( One-Time-Password ).\n";
			    $message .= "Please make use of the given OTP before 6 minutes from ". date("Y-m-d h:i:sa") . "\n";
			    $message .= "\nYour OTP: $otp";

			    $subject = "HolaStylist OTP";

			    $status = wp_mail($data['email'], $subject, $message);
				if($status)
					return json_encode([
			       		'status' => 200,
			       		'msg' => 'An OTP has been sent to the given email and phone number. Please verify the given OTP below.'
			       	]);
				return json_encode([
					'status' => 500,
					'msg' => ['OTP generation failed.']
				]);
	       	}
		}
		else
			return json_encode([
				'status' => 500,
				'msg' => $errors
			]);
	}
}
?>
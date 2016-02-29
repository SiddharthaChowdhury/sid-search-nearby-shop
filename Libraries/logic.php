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
	      	
	      	$delete = new sid_nsna_deleteDb_pl3(); // delete previous OTP if any
	      	$delete->deltHisExistingOTP( $ip );

	      	$insert = new sid_nsna_insertDb_pl3(); // record new OTP

	       	if( $insert->record_otpDB( $otp, $ip ) )
	       	{
			    $message = "Hola! ".$data['name']. " (". $data['email'] . ")\n";
			    $message .= "This is a system generated OTP ( One-Time-Password ).\n";
			    $message .= "Please make use of the given OTP before 6 minutes from ". date("Y-m-d h:i:sa") . "\n";
			    $message .= "\nYour OTP: $otp";

			    $subject = "HolaStylist OTP";

			    $status = wp_mail($data['email'], $subject, $message);
				// if($status)
					return json_encode([
			       		'status' => 200,
			       		'msg' => 'An OTP has been sent to the given email and phone number. Please verify the given OTP below.'
			       	]);
				// return json_encode([
				// 	'status' => 500,
				// 	'msg' => ['OTP generation failed.']
				// ]);
	       	}
		}
		else
			return json_encode([
				'status' => 500,
				'msg' => $errors
			]);
	}
		//==-- HELPER FUNCTION
			public function satitizeAppoData( $data )
			{
				$name = parent::sid_nsna_sanitize( $data["name"] );
			    $email_address = parent::sid_nsna_sanitize( $data["email"] );
			    $phone_num = parent::sid_nsna_sanitize( $data["phone"] );
			    $time = parent::sid_nsna_sanitize( $data["time"] );

			    $s_eml = parent::sid_nsna_sanitize( $data["s_eml"] );

			    $errors = [];
			    $select = new sid_nsna_selectDb_pl3();
			    if( !$select->isRegistered_pl3( $s_eml ) )
			    	array_push($errors, 'Error! Invalid Vendor credentials.');
			    
			
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

	public function confirm_Appointment($data){
		$errors = $this->satitizeAppoDataFinal( $data );
		if( empty( $errors ) ){

			$select = new sid_nsna_selectDb_pl3();
			$ip = parent::sid_nsna_get_ThisSystem_public_ip_address();
			
			if( $select->verifyOTP( $ip , $data['d_otp'] ) > 0 ){
				$insert = new sid_nsna_insertDb_pl3();
				if( $insert->record_appointment($data) ) 
				{
					// delete used otp//
					$del = new sid_nsna_deleteDb_pl3();
					$del->del_OTP( $data['d_otp'] );
					$msg = [];

						//// send confirmation email to Client
						// $message = "Hola! ".$data['name']. " (". $data['email'] . ")\n";
					 //    $message .= "This is a system generated email.\n";
					 //    $message .= "The appointment details are as follows:";
					 //    $message .= "\nAppointment to: $data['s_nam']";
					 //    $message .= "\nAppointment for: $data['s_typ'] | $data['s_sub']" ;
					 //    $message .= "\nDate and Time: $data['time']";
					 //    $message .= "\nComplete address: $data['s_faddr']\n";
					 //    $subject = "HolaStylist Appontment Booking Confirmation.";
					    
					 //    $status1 = wp_mail($data['email'], $subject, $message);
						// if($status1)
							array_push($msg, 'Email was sent to '.$data['name']);

						// // send confirmation email to Shop
						// $message = "Hola! ".$data['s_nam']. " (". $data['s_eml'] . ")\n";
					 //    $message .= '<h3>'."Customer is waiting.\n".'</h3>';
					 //    $message .= "The appointment details are as follows:";
					 //    $message .= "\nAppointment from: $data['name'], email: $data['name'], phone: $data['phone']";
					 //    $message .= "\nAppointment for: $data['s_typ'] | $data['s_sub']" ;
					 //    $message .= "\nDate and Time: $data['time']\n\n";
					 //    $message .= "Please refresh your dashboard and respond back promptly.";
					 //    $subject = "HolaStylist NEW APPOINTMENT!";
					    
					 //    $status2 = wp_mail($data['email'], $subject, $message);
						// if($status2)
							array_push($msg, 'Email was sent to organization');

					array_push($msg, 'Appointment process complete final ACK');

					return json_encode([
						'status' => 200,
						'msg' => $msg
					]);
				}
				return json_encode([
					'status' => 500,
					'msg' => ['Sorry! Failed to record appointment.']
				]);
			}
			else
			{
				return json_encode([
					'status' => 500,
					'msg' => ['Sorry! Either your OTP has expired or your dynamic internet identity is changed. Please try again.']
				]);
			}
		}
		else
			return json_encode([
				'status' => 500,
				'msg' => $errors
			]);
	} 
		//==--  HELPER FUNCTION
			public function satitizeAppoDataFinal( $data )
			{
				$c_name = parent::sid_nsna_sanitize( $data["name"] );
			    $c_email = parent::sid_nsna_sanitize( $data["email"] );
			    $c_ph = parent::sid_nsna_sanitize( $data["phone"] );
			    $time = parent::sid_nsna_sanitize( $data["time"] );

			    $s_email = parent::sid_nsna_sanitize( $data["s_eml"] );
			    $s_idd = parent::sid_nsna_sanitize( $data["s_idd"] );
			    $s_sub = parent::sid_nsna_sanitize( $data["s_sub"] );
			    $s_typ = parent::sid_nsna_sanitize( $data["s_typ"] );

			    $otp = parent::sid_nsna_sanitize( $data["d_otp"] );


			    $errors = [];
			
				if($this->sid_nsna_isEmptyString($c_name) || !$this->sid_nsna_isCrudFree($c_name) || !$this->sid_nsna_verifyName($c_name))
					array_push($errors, 'Error! Invalid Name.');
				if($this->sid_nsna_isEmptyString($c_email) || !$this->sid_nsna_isCrudFree($c_email) || !$this->sid_nsna_verifyEmail($c_email))
					array_push($errors, 'Error! Invalid Email.');
				if($this->sid_nsna_isEmptyString($c_ph) || !$this->sid_nsna_isCrudFree($c_ph) || !$this->sid_nsna_verifyFnNum($c_ph))
					array_push($errors, 'Error! Invalid Phone number.');
				if($this->sid_nsna_isEmptyString($time) || !$this->sid_nsna_isCrudFree($time) )
					array_push($errors, 'Error! Invalid Phone number.');

				if($this->sid_nsna_isEmptyString($s_email) || !$this->sid_nsna_isCrudFree($s_email) || !$this->sid_nsna_verifyEmail($s_email))
					array_push($errors, 'Error! Invalid Shop Email.');
				if($this->sid_nsna_isEmptyString($s_typ) || !$this->sid_nsna_isCrudFree($s_typ) || !$this->sid_nsna_verifyName($s_typ))
					array_push($errors, 'Error! Invalid Category Name.');
				if($this->sid_nsna_isEmptyString($s_sub) || !$this->sid_nsna_isCrudFree($s_sub) || !$this->sid_nsna_verifyName($s_sub))
					array_push($errors, 'Error! Invalid Sub-Category Name.');

				if($this->sid_nsna_isEmptyString($otp) || !$this->sid_nsna_isCrudFree($otp) || !$this->sid_nsna_verifyOTP($otp))
					array_push($errors, 'Error! Invalid Sub-Category Name.');


				$select = new sid_nsna_selectDb_pl3();
				$cats = $select->is_valid_Cat($s_typ);
				$subs = $select->is_valid_Subcat($s_typ , $s_sub);

				if( !$cats )
					array_push($errors, 'Error! Hack attempt. Guest_System_info_level_0* recorded! ');
				if( !$subs )
					array_push($errors, 'Error! Hack attempt. Guest_System_info_level_1* recorded! ');

				return $errors;
			}

}
?>
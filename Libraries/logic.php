<?php

/**
* 
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
}
?>
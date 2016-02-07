<?php

class sid_nsna_security_pl3
{
	public function sid_nsna_isEmptyString($data)
	{
		if (empty($data)) 
			return true;
		return false;
	}
	
	public function sid_nsna_sanitize($data)// CALL THIS FUNCTION BEFORE CALLING ANY OTHER FUNCTION
	{
		$data = trim($data);
		$data = strip_tags($data);
		return $data;
	}
	public function sid_nsna_isCrudFree($data)
	{
		$flags = array("SELECT", "ALTER", "INSERT", "CREATE", "DROP", "TRUNCATE", "DELETE", "=", "GRANT");
		foreach ($flags as $key => $value) 
		{
			$x = stripos($data, $value);
			if ($x !== FALSE)  // find array elements in the given string
		        return false;
		    return true;
		}
	}

	public function sid_nsna_valid_pass($nm) {
	    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z._@#$%]{8,}$/', stripcslashes(trim($nm)))) 
	        return FALSE;
	    return TRUE;
	}
	public function sid_nsna_verifyMessage($ps)
	{
		if (!preg_match('%^[A-Za-z0-9"?!,-_+*:.\s]{3,250}$%', stripcslashes(trim($ps))))
				return false;
		return true;
	}
	public function sid_nsna_verifyMessageSubject($ps)
	{
		if (!preg_match('%^[A-Za-z0-9"?!,-_+*:.\s]{3,100}$%', stripcslashes(trim($ps))))
				return false;
		return true;
	}
	public function sid_nsna_verifyName($nm)
	{
		if (!preg_match('%^[A-Za-z. \s]{3,50}$%', stripcslashes(trim($nm))))
				return false;
		return true;		
	}
	public function sid_nsna_verifyEmail($em)
	{
		if (!preg_match('%^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%', stripcslashes(trim($em))))
				return false;
		return true;
	}
	public function sid_nsna_verifyStreet($street)
	{
		if (!preg_match('%^[A-Za-z0-9,.\s-_]{3,50}$%', stripcslashes(trim($street))))	
				return false;
		return true;
	}
	public function sid_nsna_verifyFnNum($fn)
	{
		if(!preg_match('%^[0-9]{9,12}$%', stripcslashes(trim($fn))))
			return false;
		return true;
	}
	public function sid_nsna_verifyState($state)
	{
		if (!preg_match('%^[A-Za-z.\s-_]{2,15}$%', stripcslashes(trim($state))))			
				return false;
		return true;
	}
	public function sid_nsna_hash_password($pass)
	{
		$newpassword = password_hash($password, PASSWORD_BCRYPT);
		$pass_len = strlen($pass);
		$pass = md5($pass);
		$pass = sha1($pass);
		$pass = crypt($pass_len,$pass);
		return $pass;
	}
	public function sid_nsna_verifyTitle($ps)
	{
		if (!preg_match('%^[A-Za-z0-9.\s]{3,100}$%', stripcslashes(trim($ps))))
				return false;
		return true;
	}
	/*
		May contain letter and numbers
		Must contain at least 1 number and 1 letter
		NO special characters
	*/
	public function sid_nsna_verifyPanNum($x)
	{
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{10,10}$/', stripcslashes(trim($x)))) 
	        return FALSE;
	    return TRUE;
	}
	public function sid_nsna_verifyIndianZip($x)
	{
		if(!preg_match('%^[0-9]{2,6}$%', stripcslashes(trim($x))))
			return false;
		return true;
	}
	public function sid_nsna_verifyPrice($x)
	{
		if(!preg_match('%^[0-9]{1,7}$%', stripcslashes(trim($x))))
			return false;
		return true;
	}

	public function sid_nsna_BankACno($x)
	{
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{9,18}$/', stripcslashes(trim($x)))) 
	        return FALSE;
	    return TRUE;
	}

	public function sid_nsna_BankName($ps)
	{
		if (!preg_match('%^[A-Za-z0-9,-.\s]{2,100}$%', stripcslashes(trim($ps))))
				return false;
		return true;
	}

	public function sid_nsna_getUniqueID( $user_email = NULL ){
		if($user_email == NULL)
			return md5(uniqid(rand(), true));
		else
			return md5(uniqid($user_email, true));
		// returns 32bit long string
	}
}
?>
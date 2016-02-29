<?php

class sid_nsna_insertDb_pl3
{
	
	// public function create_shop_pl3($data)
	// {
	// 	extract($data);
	// }

	public function createCategory_pl3($data)
	{
		global $wpdb;
		// check if category - parent combination exists
		// if exists send error say cat exists: else create and send a success message
		$cat = $data['cat'];
		$parent = $data['parent'];

		if ( empty($cat) || empty($parent) ) {
			return json_encode( [
   				'code' => 500,
   				'msg' => 'Cannot Empty'
   			]);
		}

		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
   		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename WHERE cat = '$cat' AND parentt = '$parent'" );
   		if ($user_count == 1)
   			return json_encode( [
   				'code' => 500,
   				'msg' => 'Category already exists with same parent'
   			]);
   		else{

   			// insert into DB
   			$to_db = array( 
				'cat' => $cat,
				'parentt' => $parent ,
				'level' => ( $parent == 'none' ) ? '0' : '1'
			);

			$resp2 = $wpdb->insert( $tablename, $to_db);
			
			if (!$resp2)
				return json_encode([
					"msg" => "Failed! to create new category.", 
					"code" => 404
				]); 
			else
				return json_encode([
					"msg" => "Success!", 
					"code" => 200
				]); 
   		} 
	}

	public function record_otpDB( $otp, $ip ){

		global $wpdb;
		$tablename = $wpdb->prefix.'sid_otps_pl3';
		
		$resp2 = $wpdb->query(
			"
			INSERT INTO $tablename (ottp, on_time, ip_addr)
			VALUES ('$otp', now(), '$ip') 
			"
		);

		if (!$resp2)
			return false; 
		else
			return true;
	}

	public function record_appointment( $data ){
		global $wpdb;
		$table_name5 = $wpdb->prefix . "sid_appointments_pl3";

		$isLgdin = 0;

		if ( is_user_logged_in() ) {
		     $current_user = wp_get_current_user();
		     if($current_user->user_email == $data["email"] ) 
		     	$isLgdin = 1;
		 }

		extract($data);

		$resp2 = $wpdb->query(
			"
			INSERT INTO $table_name5 (shop_id, shop_email, shop_name, by_ph, by_email, by_name, by_from, on_time, by_login)
			VALUES ('$s_idd', '$s_eml', '$s_nam', '$phone', '$email', '$name', '$s_faddr', now(), '$isLgdin') 
			"
		);
		if ($resp2) 
			return true;
		return false;

	}
}
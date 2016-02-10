<?php

class sid_nsna_selectDb_pl3
{

	public function getCatHierarchy_pl3()
	{
		global $wpdb;

		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
		$cat_detail = $wpdb->get_results( "SELECT cat, parentt, level FROM $tablename " );
		
		$cats = [];	// conversion of std obj to array 
		foreach ($cat_detail as $key => $value) {
			$cat = [];
			$cat['self'] = $value->cat;
			$cat['parent'] = $value->parentt;
			$cat['level'] = $value->level;

			if( $value->parentt != 'none' ){
				array_push($cats[ $value->parentt ]['child'], $cat);
			}
			else{
				$cats[$value->cat] = $cat;
				$cats[$value->cat]['child'] = [];
			}
		}

		return $cats;
	}

	public function getUsersStamp_pl3( $user = NULL ){
		if( $user == NULL ){
			$current_user = wp_get_current_user();
			$user = $current_user->user_email;
		}
		global $wpdb;
		$table_name0 = $wpdb->prefix . "sid_shops_pl3";
		$user_details = $wpdb->get_row( "SELECT operateStamp FROM $table_name0 WHERE email = '$user' LIMIT 1" );
		return $user_details->operateStamp;
	}

	public function getParentCats_pl3()
	{
		global $wpdb;

		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
		$cat_detail = $wpdb->get_results( "SELECT cat, parentt, level FROM $tablename WHERE parentt = 'none' " );
		
		$cats = [];	// conversion of std obj to array 
		foreach ($cat_detail as $key => $value) {
			$cats[$key] = [];
			foreach ($value as $key1 => $val) {
				$cats[$key][$key1] = $val;
			}
		}

		return $cats;
	}

	public function getSubcat_pl3($data){
		
		global $wpdb;
		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
		$tree = [];
		foreach ($data as $value) {
			$result = $wpdb->get_results( "SELECT cat FROM $tablename WHERE parentt = '$value' AND level = '1' " );
			if( !$result )
			{
				$tree[$value]['-'] = 'No Services';
			}
			else
				foreach ( $result as $key => $val ) {
					$tree[$value][$key] = $val;
				}
		}
		
		return json_encode($tree);
	}

	public function getHisSubcats_pl3($data){
		global $wpdb;
		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
		$tree = [];
		$cat = $data['cat'];
			$result = $wpdb->get_results( "SELECT cat FROM $tablename WHERE parentt = '$cat' AND level = '1' " );
			if( !$result )
			{
				$tree[] = 'null';
			}
			else
			foreach ( $result as $key => $val ) {
				array_push($tree, $val);
			}
		
		return json_encode($tree);
	}

	public function isRegistered_pl3(){

		global $user_email;  
		get_currentuserinfo();
		global $wpdb;
		$tablename = $wpdb->prefix.'sid_shopid_pl3';
   		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename WHERE email = '$user_email' " );
   		if ( $user_count )
   			return true;
   		return false;
	}

	public function isValid_Service_pl3($cat , $subcat = null){
		global $wpdb;
		$tablename = $wpdb->prefix.'sid_shopscat_pl3';
		if($subcat == null)
			$count = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename WHERE cat = '$subcat' AND level = '0' " );
		else	
   			$count = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename WHERE parentt = '$cat' AND cat = '$subcat' " );
   		if ( $count )
   			return true;
   		return false;
	} 

	public function get_PendingShopRequests_pl3(){

		$table_name0 = $wpdb->prefix . "sid_shopid_pl3";
		$user_details = $wpdb->get_results( "SELECT email, regat, activated FROM $table_name0 WHERE email = '$user' " );
		
	}

// ADMIN SINGLE SHOP 
	public function get_usersDetails_pl3($user = null){ 

		if($user == null)
		{
			global $user_email;  
			get_currentuserinfo(); 
			
			$user = $user_email;
		}
		global $wpdb;

		$details = [];
		$details['email'] = $user;
		// $details['name'] = $details;

		$table_name0 = $wpdb->prefix . "sid_shopid_pl3";
		$table_name1 = $wpdb->prefix . "sid_shops_pl3";
		// $table_name2 = $wpdb->prefix . "sid_shopsContacts_pl3";
		// $table_name3 = $wpdb->prefix . "sid_shopsBank_pl3";
		$user_details = $wpdb->get_row( "SELECT activated FROM $table_name0 WHERE email = '$user' " );
		$details['activated'] = ( $user_details->activated == '0' ? 'No' : 'Yes' );
		
		$user_details = $wpdb->get_results( "SELECT name, pin, type, subtype, address, operateStamp FROM $table_name1 WHERE email = '$user' " );
		foreach ( $user_details as $val ) 
		{
			$details['name'] = $val->name;
			$details['address'] = $val->address;
			$details['pin'] = $val->pin;
			$details['logo'] = $val->operateStamp;
			$details['types'][ $val->type] = [];
		}
		foreach ( $user_details as $val ) 
		{
			array_push( $details['types'][ $val->type] , $val->subtype);
		}
		return $details;

	}

	public function get_shopListings(){
		$active = [];
		$inactive = [];

		global $wpdb;
		$table_name0 = $wpdb->prefix . "sid_shopid_pl3";
		$user_details = $wpdb->get_results( "SELECT name, email, regat, address, activated FROM $table_name0 " );
		foreach ( $user_details as $val ) 
		{
			if( $val->activated == '1' ){
				$act = [];
				$act['name'] = $val->name;
				$act['email'] = $val->email;
				$act['regat'] = $val->regat;
				$act['address'] = $val->address;
				array_push($active, $act);
			}
			else
			{
				$inAct = [];
				$inAct['name'] = $val->name;
				$inAct['email'] = $val->email;
				$inAct['regat'] = $val->regat;
				$inAct['address'] = $val->address;
				array_push($inactive, $inAct);
			}
		}

		return [
			'active' => $active,
			'inactive' => $inactive
		];
	}

	public function get_AreaBounds($lat, $lng, $radius, $cat)
	{
		global $wpdb;

        //$sql = "SELECT id, name, email, pin, address, type, subtype, operateStamp, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM wp_sid_shops_pl3 WHERE type = '$cat' OR subtype = '$cat' HAVING distance < $radius ORDER BY distance LIMIT 0 , 20";	
		$table_name0 = $wpdb->prefix . "sid_shops_pl3";
		$table_name1 = $wpdb->prefix . "sid_shopscontacts_pl3";
		
		$sql = "SELECT $table_name1.phno, $table_name0.id, $table_name0.name, $table_name0.email, $table_name0.pin, $table_name0.address, $table_name0.type, $table_name0.subtype, $table_name0.operateStamp, ( 6371 * acos( cos( radians($lat) ) * cos( radians( $table_name0.lat ) ) * cos( radians( $table_name0.lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( $table_name0.lat ) ) ) ) 
		AS distance 
		FROM $table_name0, $table_name1
		WHERE ( $table_name0.type = '$cat' OR $table_name0.subtype = '$cat' )
		AND $table_name0.email = $table_name1.shopId
		HAVING distance < $radius 
		ORDER BY distance 
		LIMIT 0 , 20";

		// echo $sql.'<br><br>.......................';
		
		$det = $wpdb->get_results( $sql );
		return $det;
		// var_dump($det);
		// exit();


	}
}
<?php

class sid_nsna_insertDb_pl3{
	public function create_shop_pl3($data)
	{
		extract($data);
	}
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

		$tablename = $wpdb->prefix.'sid_shopsCat_pl3';
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
}
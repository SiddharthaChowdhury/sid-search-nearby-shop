<?php
	/**
	* 
	*/
	class sid_nsna_deleteDb_pl3 
	{
		
		public function deleteCat_pl3( $data ){
			global $wpdb;
			$id = $data['target'];
			$lvl = $data['level'];
			$tablename = $wpdb->prefix.'sid_shopsCat_pl3';

			if($lvl == 1)
				$res = $wpdb->delete( $tablename, array( 'cat' => $id ) );
			else
			{
				$res = $wpdb->delete( $tablename, array( 'cat' => $id ) );
				if($res)
					$res0 = $wpdb->delete( $tablename, array( 'parentt' => $id ) );
			}

			if( $res == false )
				return json_encode( [
   					'code' => 500,
   					'msg' => 'Failed'
   				]);
			return json_encode( [
   				'code' => 200,
   				'msg' => 'Success'
   			]);
			
		}
	}
?>
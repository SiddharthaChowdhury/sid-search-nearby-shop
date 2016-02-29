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
			$tablename = $wpdb->prefix.'sid_shopscat_pl3';

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

		public function deltHisExistingOTP( $ip )
		{
			global $wpdb;
			$table_name0 = $wpdb->prefix . "sid_otps_pl3";
			$res = $wpdb->delete( $table_name0, array( 'ip_addr' => $ip ) );
			return;
		}

		public function del_OTP( $otp )
		{
			global $wpdb;
			$table_name0 = $wpdb->prefix . "sid_otps_pl3";
			$res = $wpdb->delete( $table_name0, array( 'ottp' => $otp ) );
			return;
		}
		
	}
?>
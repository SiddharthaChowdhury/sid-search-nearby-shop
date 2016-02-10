<?php

require "Libraries/security.php";
class sid_nsna_ShopClass_pl3 extends sid_nsna_security_pl3{

	public $name;
	public $email;
	public $phns;
	public $cats;
	public $formattedAddress;
	public $zip;
	public $lat;
	public $lng;
	public $acct;
	public $bank;
	public $vat;
	public $tin;
	public $local;
	public $nonce;
	public $landmark;

	public function __construct(){
		$this->name = NULL;
		$this->email = NULL;
		$this->phns = NULL;
		$this->cats = [];
		$this->formattedAddress = NULL;
		$this->zip = NULL;
		$this->lat = NULL;
		$this->lng = NULL;
		$this->acct = NULL;
		$this->bank = NULL;
		$this->vat = NULL;
		$this->tin = NULL;
		$this->local = NULL;
		$this->nonce = NULL;
		$this->landmark = NULL;
	}
	public function sid_nsna_populate_pl3($data)
	{
		if(isset($data['Shop_Name']))
			$this->setName_pl3($data['Shop_Name']);

		if(isset($data['Email']))
			$this->setEmail_pl3($data['Email']);

		if(isset($data['Contact_Number']))
			$this->setPhones_pl3($data['Contact_Number']);

		if(isset($data['services']))
			$this->setCategories_pl3($data['services']);

		if(isset($data['bnkacct']))
			$this->setBankAcct_pl3($data['bnkacct']);

		if(isset($data['bnknm']))
			$this->setBankName_pl3($data['bnknm']);

		if(isset($data['landmark']))
			$this->setLandmark_pl3($data['landmark']);

		if(isset($data['lat_pl3']))
			$this->setLat_pl3($data['lat_pl3']);

		if(isset($data['lng_pl3']))
			$this->setLng_pl3($data['lng_pl3']);

		if(isset($data['nonce']))
			$this->setNonce_pl3($data['nonce']);

		if(isset($data['pan']))
			$this->setPan_pl3($data['pan']);

		if(isset($data['vat']))
			$this->setVat_pl3($data['vat']);

		if(isset($data['zip_pl3']))
			$this->setZip_pl3($data['zip_pl3']);

		if(isset($data['formatted_address']))
			$this->setFormattedAddress_pl3($data['formatted_address']);

	}
// ------------- Implementatiopns ------------- 
	public function sid_nsna_newShop_pl3()
	{
		$errors = [];
		$name = $this->sid_nsna_sanitize($this->getName_pl3());
		$email = $this->sid_nsna_sanitize($this->getEmail_pl3());
		$landmark = $this->getLandmark_pl3();
		$frmtedAddr = $this->sid_nsna_sanitize($this->getFormattedAddress_pl3());
		$zip = $this->sid_nsna_sanitize($this->getZip_pl3());
		$cats = $this->getCategories_pl3();
		$phns = $this->getPhones_pl3();
		$lat = $this->getLat_pl3();
		$lng = $this->getLng_pl3();

		if(!empty($landmark))
			array_push($errors, 'Error! Caught Robot.');
		if(!wp_verify_nonce($this->getNonce_pl3(), 'sid-nsna-nonce-pl3'))
			array_push($errors, 'Error! Sorry Something is wrong. Please try registering after 60 minutes from now.');
		if($this->sid_nsna_isEmptyString($name) || !$this->sid_nsna_isCrudFree($name) || !$this->sid_nsna_verifyTitle($name))
			array_push($errors, 'Error! Invalid Organization Name!');
		if($this->sid_nsna_isEmptyString($email) || !$this->sid_nsna_isCrudFree($email) || !$this->sid_nsna_verifyEmail($email))
			array_push($errors, 'Error! Invalid Organization Email.');
		if($this->sid_nsna_isEmptyString($frmtedAddr) )
			array_push($errors, 'Error! Formatted Address Cant Be Blank.');
		if($this->sid_nsna_isEmptyString($zip) || !$this->sid_nsna_isCrudFree($zip) || !$this->sid_nsna_verifyIndianZip($zip))
			array_push($errors, 'Error! Invalid Zip Code.');
		
		if($this->sid_nsna_isEmptyString($phns) || !$this->sid_nsna_isCrudFree($phns) || !$this->sid_nsna_verifyFnNum($phns))
			array_push($errors, 'Error! Invalid Phone Number Added.');

		if(empty($cats))
			array_push($errors, 'Error! No categories selected.');
		else
		{
			$check = new sid_nsna_selectDb_pl3();
			foreach( $cats as $key => $value )
			{
				if( !empty($value) )
				{
					foreach ( $value as $val ) 
					{
						if( ! $check->isValid_Service_pl3( $key, $val) ){
							array_push($errors, 'Error! Form manipulation encountered.');
						}
					}
				}else
				{
					if( ! $check->isValid_Service_pl3( $key) ){
						array_push($errors, 'Error! Form manipulation encountered.');
					}
				}	
			}
		}
		if(empty($errors))
		{

			/*---- creating directory for the user in plugin/Assets/Vendors*/
			$current_user = wp_get_current_user();
			$userstamp = parent::sid_nsna_getUniqueID( $current_user->user_email  );

			global $sid_nsna_base_dir;
			$filePath = str_replace("\\", "/", $sid_nsna_base_dir."Assets/Vendors/".$userstamp);

			if( !file_exists($filePath) ){
				if ( mkdir($filePath, 0744, true) ) {
				    mkdir($filePath.'/catalogue', 0744, true);
				}
				else
				{
					return json_encode(['status'=> 504, 'message' => "Sorry! It seems given credentials already exists. Please report us about this problem and try registering one more time."]);
				}
			}
			else
				return json_encode(['status'=> 504, 'message' => "Sorry! It seems given credentials already exists. Please report us about this problem and try registering one more time."]);

			global $wpdb;
			$table_name0 = $wpdb->prefix . "sid_shopid_pl3";
			$table_name1 = $wpdb->prefix . "sid_shops_pl3";
			$table_name2 = $wpdb->prefix . "sid_shopscontacts_pl3";
			$_checksum = '';
							// ========>  [  Record particular Shop  ]   <==========
			$resp = $wpdb->insert( 
				$table_name0, 
				array( 
					'email' => $email, 
					'name' => $name,
					'address' => $frmtedAddr,
					'regat' => date("Y-m-d H:i:s"), 
					'activated' => '0', 
					'certified' => '0'
				)
			);
			if($resp)
				$_checksum .='1';
			else
				$_checksum .='0';

							// ========>  [  Save Shop based on SERVICES  ]   <==========
			
			if(!strrchr($_checksum,'0'))
			{
				foreach ($cats as $cat => $value) 
				{
					if(!empty($value))
						foreach ($value as $subcat) {					
							$resp = $wpdb->insert( 
								$table_name1, 
								array( 
									'name' => $name, 
									'email' => $email, 
									'pin' => $zip, 
									'type' => $cat, 
									'subtype' => $subcat,
									'lat' => $lat, 
									'lng' => $lng, 
									'address' => $frmtedAddr, 
									'operateStamp' => $userstamp
								)
							);
							if($resp)
								$_checksum .='1';
							else
								$_checksum .='0';
						}
					else
					{
						$resp = $wpdb->insert( 
							$table_name1, 
							array( 
								'name' => $name, 
								'email' => $email, 
								'pin' => $zip, 
								'type' => $cat, 
								'subtype' => 'none',
								'lat' => $lat, 
								'lng' => $lng, 
								'address' => $frmtedAddr, 
								'operateStamp' => $userstamp
							)
						);
						if($resp)
							$_checksum .='1';
						else
							$_checksum .='0';
					}

				}
				
			}
			if(!strrchr($_checksum,'0')){
				$resp = $wpdb->insert( 
					$table_name2, 
					array( 
						'shopId' => $email, 
						'phno' => $phns
					)
				);

				if($resp)
					$_checksum .='1';
				else
					$_checksum .='0';

				return json_encode(['status'=> 200, 'message'=> ['All good']]);
			}
			return json_encode(['status'=> 504, 'message' => $errors]);
		}
		return json_encode(['status'=> 504, 'message' => $errors]);

	}


// ---------- GETTERS and SETTERS ------------
	public function getName_pl3()
	{
		return $this->name;
	}
	public function setName_pl3($data)
	{
		$this->name = $data;
	}

	public function getEmail_pl3()
	{
		return $this->email;
	}
	public function setEmail_pl3($data)
	{
		$this->email = $data;
	}

	public function getPhones_pl3()
	{
		return $this->phns;
	}
	public function setPhones_pl3($data)
	{
		$this->phns = $data;
	}

	public function getCategories_pl3()
	{
		return $this->cats;
	}
	public function setCategories_pl3($data)
	{
		$this->cats = $data;
	}

	public function getBankAcct_pl3()
	{
		return $this->acct;
	}
	public function setBankAcct_pl3($data)
	{
		$this->acct = $data;
	}

	public function getBankName_pl3()
	{
		return $this->bank;
	}
	public function setBankName_pl3($data)
	{
		$this->bank = $data;
	}

	public function getLandmark_pl3()
	{
		return $this->landmark;
	}
	public function setLandmark_pl3($data)
	{
		$this->landmark = $data;
	}

	public function getLat_pl3()
	{
		return (string)$this->lat;
	}
	public function setLat_pl3($data)
	{
		$this->lat = $data;
	}

	public function getLng_pl3()
	{
		return (string)$this->lng;
	}
	public function setLng_pl3($data)
	{
		$this->lng = $data;
	}

	public function getNonce_pl3()
	{
		return $this->nonce;
	}
	public function setNonce_pl3($data)
	{
		$this->nonce = $data;
	}

	public function getPan_pl3()
	{
		return $this->pan;
	}
	public function setPan_pl3($data)
	{
		$this->pan = $data;
	}

	public function getVat_pl3()
	{
		return $this->vat;
	}
	public function setVat_pl3($data)
	{
		$this->vat = $data;
	}

	public function getZip_pl3()
	{
		return $this->zip;
	}
	public function setZip_pl3($data)
	{
		$this->zip = $data;
	}

	public function getFormattedAddress_pl3()
	{
		return $this->formattedAddress;
	}
	public function setFormattedAddress_pl3($data)
	{
		$this->formattedAddress = $data;
	}

	// --------------- Implementations --------------
	
}
<?php

class sid_nsna_Dash_cls{
	
	public function sid_nsna_Dashboard_pl3(){

		if( isset($_GET['request']) )
		{
			switch ( $_GET['request'] ) 
			{
				case 'settings':
						add_filter('the_content','sid_nsna_SettingDashboard_pl3');
						return $this->sid_nsna_SettingDashboard_pl3();
						die();
					break;
				
				case 'help':
						add_filter('the_content','sid_nsna_HelpDashboard_pl3');
						return $this->sid_nsna_HelpDashboard_pl3();
						die();
					break;
					
				default:
						add_filter('the_content','sid_nsna_TheDashboard_pl3');
						return $this->sid_nsna_TheDashboard_pl3();
						die();
					break;
			}
		}
		else
		{
			add_filter('the_content','sid_nsna_TheDashboard_pl3');
			return $this->sid_nsna_TheDashboard_pl3();
			die();
		}

	}

	public function sid_nsna_TheDashboard_pl3(){
		
		require "dashboard_menu.php";
		$obj = new sid_nsna_selectDb_pl3();
		$shop_details = $obj->get_usersDetails_pl3();
		$stamp = $shop_details['logo'];
		global $sid_nsna_base_dir;
		global $sid_nsna_plugin_dir;

		$filePath = str_replace("\\", "/", $sid_nsna_base_dir."Assets/Vendors/".$stamp."/Logo_e.png");
		if( !file_exists($filePath) )
			$filePath = str_replace("/", "\\", $sid_nsna_plugin_dir."Assets/images/hola.png");
		else
			$filePath = str_replace("/", "\\", $sid_nsna_plugin_dir."Assets/Vendors/".$stamp."/Logo_e.png");
		ob_start(); 
		?>

		<div class="row">
			<h2>Upload your Logo</h2>
			<div class="col-md-12">
				<div class="col-md-4">
					<img id="imageDisplay" src="<?php echo $filePath; ?>" style="min-width:150px; border:2px dashed grey; min-height:150px; max-height:200px;" alt="Logo" ondragstart="return false;">
				</div>
				<div class="col-md-8 pull-left">
					<form id="upload_form" enctype="multipart/form-data" method="post">
						<progress id="progress_bar" value="0" max="100" style="width:300px;"></progress> <span id="onProcessStatus"></span>
						<input type="file" name="fileInput" id="fileInput"><br>
						<input type="button" value="Upload File" id="uploadBtn" />
						<h4 id="status"></h4>
					</form>
				</div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}

	public function sid_nsna_SettingDashboard_pl3(){
		ob_start(); 
		require "dashboard_menu.php"; ?>

		<div class="row">
			Settings
		</div>

		<?php
		return ob_get_clean();
	}

	public function sid_nsna_HelpDashboard_pl3(){
		ob_start(); 
		require "dashboard_menu.php"; ?>

		<div class="row">
			HelpDesk
		</div>

		<?php
		return ob_get_clean();
	}

}

?>
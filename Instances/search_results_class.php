<?php
class sid_nsna_searchResults_cls{

	private $results;

	function __construct($data){
		if( !empty($data) )
		{
			$this->results = $data;
		}
		else
			$this->results = false;
	}

	public function throw_searchResults(){
		if( $this->results )
        {
      //   	var_dump($this->results);
		    // exit();
        	global $sid_nsna_base_dir;
			global $sid_nsna_plugin_dir;
            ob_start();
            ?>
            <div class="row">
            	<div class="col-md-3"> <!-- Search Filters -->
            		<div style="background-color:grey; width:100%; min-height: 400px;">
            			
            		</div>
            	</div>
            	<div class="col-md-9"> <!-- Search Results -->
            		<?php
		            foreach ($this->results as $value) 
		            {
		            	$filePath = str_replace("\\", "/", $sid_nsna_base_dir."Assets/Vendors/".$value->operateStamp."/Logo_e.png");
						if( !file_exists($filePath) )
							$filePath = str_replace("/", "\\", $sid_nsna_plugin_dir."Assets/images/hola.png");
						else
							$filePath = str_replace("/", "\\", $sid_nsna_plugin_dir."Assets/Vendors/".$value->operateStamp."/Logo_e.png");
		                ?>
		                	<div class="row sid_singleResult_pl3">
		                		<div class="col-md-3 col-xs-4 text-center">
		                			<img alt="logo missing" src="<?php echo $filePath; ?>" class="sid_singleResultLogo_pl3" ondragstart="return false;">
		                		</div>
		                		<div class="col-md-8 col-xs-8">
		                			<h3 style="color:#FF0066;"><?php echo $value->name; ?>&nbsp; &nbsp;<small>&nbsp; <?php echo substr($value->distance, 0, 4)." km"; ?></small></h3>
		                			<h5><i class="kt-icon-tags"></i> &nbsp; <?php echo $value->type; ?> &nbsp; | &nbsp; <span class="nsna_subCat_pl3"><?php echo $value->subtype; ?></span></h5>
		                			<small>
			                			<span class="kt-icon-star4"></span>
			                			<span class="kt-icon-star4"></span>
			                			<span class="kt-icon-star4"></span>
			                			<span class="kt-icon-star3"></span>
			                			<span class="kt-icon-star2"></span>
			                			<span>(12)</span>
			                		</small>
			                		<br>
		                			<p>
		                				<i class="kt-icon-location3"></i> &nbsp; <?php echo $value->address; ?>
		                			</p>
		                			<div class="col-md-12 col-xs-12 nsna_contactDet">
		                				<a href="#" class="nsna_getappo pull-left">Get Appointment</a>
		                				<small><i class="kt-icon-mail-send"></i> &nbsp; <span><?php echo $value->email; ?></span>,&nbsp;<i class="kt-icon-phone3"></i> &nbsp; <span><?php echo $value->phno; ?></span></small>
		                			</div>
		                		</div>
		                		<div ></div>
		                	</div>

		                <?php
		            } // [ end foreach ]
		            return ob_get_clean();
		            ?>
            	</div>
            </div>
            <?php
        }// [ end if ]
        else
        {
            ob_start();
            ?>


            <?php
            return ob_clean();
        }
	}
}
?>
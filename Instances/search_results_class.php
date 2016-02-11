<?php
class sid_nsna_searchResults_cls{

	private $results = [];
	private $cats = [];

	function __construct($data, $cats){
		if( !empty($data) )
			$this->results = $data;
		else
			$this->results = false;

		if( !empty($cats) )
			$this->cats = $cats;
		else
			$this->cats = false;
	}

	public function throw_searchResults(){
		// echo($this->results);
		//     exit();
		if( $this->results )
        {
        	global $sid_nsna_base_dir;
			global $sid_nsna_plugin_dir;
            ob_start();
            ?>
            <div class="row">
            	<div class="col-md-3"> <!-- Search Filters -->
            		<div style="border-right: 1px solid grey; width:100%; min-height: 400px;" class="pull-right"> 

            			<?php
            			if( $this->cats )
            			{
	            			foreach ($this->cats as $key => $value) {
	            				?>
	            					<h5><a href="#"><?php echo $value['cat']; ?></a></h5>
	            				<?php
	            			}
	            		}
	            		else
	            		{
	            			?>
	            				<h4>No Categories</h4>
	            			<?php
            			}
            			?>

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
		            ?>
            	</div>
            	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbgFepltqsSw8FxQauYO8pmWjAXjPKVuQ&libraries=places" defer></script>
            </div>
            <?php
            return ob_get_clean();
        }// [ end if ]
        else
        {
            ?>
            	<h1>No results</h1>
            	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbgFepltqsSw8FxQauYO8pmWjAXjPKVuQ&libraries=places" defer></script>
            <?php
            return;
        }
	}
}
?>
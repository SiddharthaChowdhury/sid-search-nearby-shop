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
			$lat = $_GET['zip'];
			$lng = $_GET['piz'];
			// $cat = $_GET['cat'];
            ob_start();
            ?>

            <div class="row nsna_resultsContainer_pl3">
            	<input type="hidden" class="nsna_lat" value="<?php echo $lat; ?>" />
            	<input type="hidden" class="nsna_lng" value="<?php echo $lng; ?>" />
            	<input type="hidden" class="nsna_formatted_address_pl3"/>
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
		                <form method="post">
		                	<div class="row sid_singleResult_pl3">
		                		<div class="col-md-3 col-xs-4 text-center sid_nsna_shopImagDet_pl3">
		                			<a href="<?php echo $filePath; ?>" rel="lightbox">
		                				<img alt="logo missing" src="<?php echo $filePath; ?>" class="sid_singleResultLogo_pl3" ondragstart="return false;">
		                			</a>
		                		</div>
		                		<div class="col-md-8 col-xs-8 sid_nsna_shopOtherDet_pl3">
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
			                			<div class="col-md-12 col-xs-12 nsna_margin_bottom_1">
			                				<a data-toggle="modal" data-target="#sid_nsna_appoModal_pl3" href="#" class="nsna_getappo pull-left nsna_TopBot_padding_1by2">Get Appointment</a>
			                				<a data-toggle="modal" data-target="#sid_nsna_appoModal_pl3" href="#" class="nsna_quickBook pull-left nsna_TopBot_padding_1by2">Quick Book</a>
		                				</div>
		                				<div class="col-md-12 col-xs-12">
		                					<small><span><i class="kt-icon-mail-send"></i> &nbsp; <?php echo $value->email; ?></span>,&nbsp; <span><i class="kt-icon-phone3"></i> &nbsp; <?php echo $value->phno; ?></span></small>
		                					</div>
		                			</div>
		                		</div>
		                		<div>
		                			<input type="hidden" name="name" value="<?php echo $value->name; ?>">
		                			<input type="hidden" name="_id" value="<?php echo $value->id; ?>">
		                			<input type="hidden" name="email" value="<?php echo $value->email; ?>">
		                			<input type="hidden" name="type" value="<?php echo $value->type; ?>">
		                			<input type="hidden" name="subtype" value="<?php echo $value->subtype; ?>">
		                			<input type="hidden" name="address" value="">
		                			<input type="hidden" name="distance" value="<?php echo substr($value->distance, 0, 4); ?>">
		                		</div>
		                	</div>
		                </form>
		                <?php
		            } // [ end foreach ]
		            ?>
            	</div>
            	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbgFepltqsSw8FxQauYO8pmWjAXjPKVuQ&libraries=places" defer></script>
            </div>

            	<!-- Modal -->
            	<form method="POST">
					<div id="sid_nsna_appoModal_pl3" class="modal fade" role="dialog">
					  	<div class="modal-dialog">
						    <div class="modal-content">
							    <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title text-center"> Appointment Schedule </h4>
							        <div class="nsna_margin_top_1">
							        	<div>
							        		<span class="text-left">
							        			<i class="kt-icon-office nsna_margin_right_1 nsna_margin_left_2"></i><small class="nsna_sch_for_name"></small>
							        		</span>
							        	</div>
							        	<div>
							        		<span class="text-left">
							        			<i class="kt-icon-tag2 nsna_margin_right_1 nsna_margin_left_2"></i><small class="nsna_sch_for_tag"></small>
							        		</span>
							        	</div>
							        </div>
							    </div>
						      	<div class="modal-body">
						        <!-- Modal content-->
						        	<div class="row">
						        		<div class="col-md-12 sid_nsna_modalContent_pl3">

						        			
						        			<div class="input-group nsna_margin_bottom_1">
											  	<span class="input-group-addon" id="basic-addon1">Name</span>
											  	<input type="text" class="form-control" placeholder="Full Name" aria-describedby="basic-addon1"/>
											</div>
											<div class="input-group nsna_margin_bottom_1">
											  	<span class="input-group-addon" id="basic-addon1">Email</span>
											  	<input type="text" class="form-control" placeholder="Email@Address (optional)" aria-describedby="basic-addon1"/>
											</div>
											<div class="input-group nsna_margin_bottom_1">
											  	<span class="input-group-addon" id="basic-addon1">Phone</span>
											  	<input type="text" class="form-control" placeholder="10 digit contact number" aria-describedby="basic-addon1"/>
											</div>
											<div class="input-group nsna_margin_bottom_1">
												<label class="col-md-1 col-xs-1" for="nsna_timestamp_pl3">
													<h4><i class="kt-icon-calendar" id="basic-addon1"></i></h4>
												</label>
												<div class="col-md-10 col-xs-10">
											  		<input type="text" id="nsna_timestamp_pl3" class="nsna_dateTimePick_pl3" placeholder="Date and Time" /> 
												</div>
											</div>
											<div class="nsna_margin_bottom_1 text-center">
												<div class="nsna_margin_bottom_1 nsna_hide_this nsna_otp_cont">
													<div>Please ensure us that you are not a <a href="https://en.wikipedia.org/wiki/Spambot" target="_blank">Spambot</a>!</div>
													<label class="nsna_tiny_font">Please NOTE: A system generated 4-digit OTP has been sent to the given contact details. Please check and enter the OPT below carefully. The OTP is valid for only 6-minutes in THIS system.</label>
													<h3 class="nsna_margin_bottom_1">
														<input type="text" class="nsna_otp" id="nsna_otp" placeholder="OTP" />
														<label for="nsna_otp">
															<a href="#" class="nsna_very_otp">
																<i class="kt-icon-shield2"></i>
															</a>
														</label>
													</h3>
													<div class="nsna_margin_bottom_1">
														<a href="#" class="nsna_resend_otp"><i class="kt-icon-refresh"></i>&nbsp;Resend OTP?</a>
													</div>
													<input type="checkbox" checked disabled> I have read and I agree to all the mentioned <a href="#">Terms and Conditions.</a>
												</div>
												<!-- <div><button class="btn btn-warning nsna_checkHuman">Check Human</button></div> -->
											</div>

						        		</div>
						        	</div>
						        	<input type="hidden" name="sid_nsna_AppoNonce_pl3" id="nonce" class="jq_IP_pl3" value="<?php echo wp_create_nonce('sid-nsna-AppoNonce-pl3'); ?>"/>
						      		<input type="hidden" class="nsna_id" />
		                			<input type="hidden" class="nsna_email" />
		                			<input type="hidden" class="nsna_type" />
		                			<input type="hidden" class="nsna_subtype" />
						      	<div class="modal-footer ">
						      		<div class="text-center">
						      			<button class="btn btn-warning nsna_checkHuman">Confirm Appointment<i class="kt-icon-clipboard4 nsna_margin_left_1"></i></button>
						      			<h1 class="nsna_tiny_font">
						      				Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.
						      			</h1>
						      		</div>
						      	</div>
						    </div>

					  	</div>
					</div>
				</form>

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
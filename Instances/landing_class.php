<?php

class sid_nsna_landing_cls{

	public function sid_nsna_homePage_pl3(){
		global $sid_nsna_plugin_dir;
		ob_start(); 
		$select = new sid_nsna_selectDb_pl3();
		$cats = $select->getCatHierarchy_pl3();
		?>
				<div class="row">
					<div class="col-md-12 text-center">
						<?php foreach ($cats as $key => $value) {
						?>
							<div class="col-md-1 col-sm-3 col-xs-4 sid_marbot_pl3">
							    <a data-toggle="modal" data-target="#sid_addressModal_pl3" href="#" data-cat="<?php echo $key; ?>" class="sid_catsSearch_pl3">
								    <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/'.$key.'.png?ver=1'; ?>" alt="Something" ondragstart="return false;" class="img-responsive">
							    </a>
							    <small class="text-center"><?php echo $key; ?></small>
							</div>
						<?php
						} ?>
					</div>
				</div>

				<!-- Modal -->
				<form method="POST">
					<div id="sid_addressModal_pl3" class="modal fade" role="dialog">
					  	<div class="modal-dialog">
						    <div class="modal-content">
							    <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title sid_nsna_modal_cat"> Title</h4>
							        <div class="text-center sid_nsna_status_pl3"></div>
							    </div>
						      	<div class="modal-body">
						        <!-- Modal content-->
						        <div class="row text-center sid_marbot_pl3">
							        <div class="col-md-12">
							        	<div class="col-md-7 col-sm-7 col-xs-7">
							        		<input style="width:100%;" type="text" class="form-control" id="sid_nsna_autocomplete_pl3" placeholder="Enter ZIP or Location">
							        	</div>
							        	<label class="col-md-1 col-sm-1 col-xs-1">
							        		OR
							        	</label>
							        	<div class="col-md-4 col-sm-4 col-xs-4">
							        		<button class="btn btn-default btn-block sid_nsna_locateMe_pl3" style="width:100%;">Find Near Me</button>
							        	</div>
							        </div>
						        </div>
						        <div class="row sid_marbot_pl3">
						        	<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4  col-xs-8 col-xs-offset-2 text-center">
	  									<div class="dropdown">
										  <button class="btn btn-default dropdown-toggle sid_nsna_selectedService_pl3" data-toggle="dropdown">Choose Service
										  <span class="caret"></span></button>
										  <ul class="dropdown-menu sid_nsna_subItems_pl3">
										  </ul>
										</div>
									</div>
								</div>
							    <div class="row sid_marbot_pl3">
							    	<div class="col-md-12 text-center" id="sid_nsna_formattedAddress_pl3">
							    		Please set a valid location.
							    	</div>
							    </div>
						      	<div class="modal-footer">
						      		<a class="btn btn-success center-block sid_nsna_btnSearch_pl3" href="<?php echo "http://"."$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"."/search-results"; ?>">SEARCH</a>
						      	</div>
						    </div>

					  	</div>
					</div>
					<input type="hidden" name="sid_nsna_chosenCat_pl3" />
					<input type="hidden" name="sid_nsna_latlng_pl3" id="sid_nsna_latlng_pl3" />
					<input type="hidden" name="sid_nsna_searchResultsNonce_pl3" value="<?php echo wp_create_nonce('sid-nsna-searchResultsNonce-pl3'); ?>" />
				</form>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbgFepltqsSw8FxQauYO8pmWjAXjPKVuQ&libraries=places" defer></script>
			<?php
		return ob_get_clean();
	}
}
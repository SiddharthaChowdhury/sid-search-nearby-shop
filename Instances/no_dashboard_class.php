<?php
class sid_nsna_noDash_cls{

	public function sid_nsna_notLoggedIn_pl3()
	{
		global $sid_nsna_plugin_dir;
		ob_start(); ?>
				
				<div class="row banner_header1_pl3">
					<div class="col-md-12">
						<img style="background-size: cover;" src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/header.jpg'; ?>">
						<div class="banner_poly_buttons_cont">
							<a class="poly_banner_buttons" href="#contact_us_pl3">New User</a>
							<a class="poly_banner_buttons" href="#new_user_pl3">Existing User</a>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<h2 class="text-center-align-pl3">Why Partner With Us?</h2>
					<div class="text-center-align-pl3 mar-bot_pl3">Expand your reach and add value to your business</div>
					<hr>
				
					<div class="col-md-10 col-md-offset-1" style="text-align:center;">
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/list.png?ver=1'; ?>" alt="Listing">
					      <div class="caption">
					        <h3>Listing</h3>
					        <div>Listing with us is free and always will be. No cancellation, setup, or sign up fees.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/target.png?ver=1'; ?>" alt="Targeted customers">
					      <div class="caption">
					        <h3>Targeted customers</h3>
					        <div>We cut through the clutter to give you efficient and potential customers.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/retaintion.png?ver=1'; ?>" alt="Customer retention">
					      <div class="caption">
					        <h3>Customer retention</h3>
					        <div>Instantly view customer's feedback posted on our page, which helps in understanding & retaining customers.</div>
					      </div>
					    </div>
					  </div>
					
				<!-- ===================== -->
	
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/24x7.png?ver=1'; ?>" alt="24x7">
					      <div class="caption">
					        <h3>24x7 service</h3>
					        <div>Clients can access our site, view service availability and make appointments with you 24x7.</div>
					      </div>
					    </div>
					  </div>
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/notif.png?ver=1'; ?>" alt="Instant Notifications">
					      <div class="caption">
					        <h3>Instant Notifications</h3>
					        <div>We help you in reminding customers to confirm their appointments. Can't make it into work? Cancel or reschedule of appointments can be done through a click.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/promotion.png?ver=1'; ?>" alt="List promotions:">
					      <div class="caption">
					        <h3>List promotions:</h3>
					        <div>We help you in promoting offers through a hassle free process. In a single word we are your digital marketing partners.</div>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
				<hr>
				<!-- Contact with us -->
				<form class="nsna_contactUS_form">
					<div class="row" id="contact_us_pl3">
						<h2 class="text-center-align-pl3">Contact Us</h2>
						<div class="text-center-align-pl3">Need assistance? Report Problem? Wanna know more?</div><br>
						<hr>
						<div class="col-md-8 col-md-offset-2 contact-us-cs">
						<div class="col-md-12 nsna_ContactUsmike_pl3"></div>
							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon">Name</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuName_pl3" id="Name" placeholder="Shop Name" aria-describedby="basic-addon1">
							</div>

							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon ">+91</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuPhone_pl3" id="Phone" placeholder="Contact number" aria-describedby="basic-addon1">
							</div>

							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon">@</span>
							  <input type="text" class="form-control cu_jsIP_pl3  nsna_cuEmail_pl3" id="Email" placeholder="Email address" aria-describedby="basic-addon1">
							</div>

							<div class="input-group username-cs mar-bot_pl3" style="display:none;">
							  <span class="input-group-addon ">Username</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuUame_pl3" id="username" placeholder="Username" aria-describedby="basic-addon1">
							</div>
							<textarea class="form-control mar-bot_pl3 nsna_cuDesc_pl3 cu_jsIP_pl3" rows="6" placeholder="Describe your query" id="Description"></textarea>
							
							<button type="button" class="btn btn-success nsna_contactUS_pl3">Submit Query</button>
						</div>
					</div>
				</form>
				<hr>
			<div class="row" id="new_user_pl3">
				<h2 class="text-center-align-pl3">Existing User ?</h2>
				<div class="text-center-align-pl3 mar-bot_pl3">If you are a registered organization, Please LOG IN and get into your dashboard.</div>
				<hr>
				<div class="col-md-8 col-md-offset-2">
					<?php 
				      // Custom widget area start
				      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Custom Widget Area') ) : ?>
					<?php endif; ?>
				</div>
			</div>
			<hr>
			<div class="row">
				<h2 class="text-center-align-pl3">How To Become A Partner ?</h2>
				<div class="text-center-align-pl3 mar-bot_pl3">Please follow the instructions given below to be one of us.</div>
					<hr>
					<div class="col-md-10 col-md-offset-1">
						<div class="mar-bot_pl3" ><span class="strong_font_pl3">Step 1:</span> You have to register yourself. (SKIP if you are registered with holastylist.com)</div>
						<div class="mar-bot_pl3" ><span class="strong_font_pl3">Step 2:</span> After registering you have to log-in. (SKIP if your are already logged in)</div>
						<div class="mar-bot_pl3" ><span class="strong_font_pl3">Step 3:</span> Now you can either use the "CONTACT US" form given above (recommended), and let us know that you want to be our valuable partner OR if you can find a link beside <span style="color:white; background-color:#6c6; padding:2px 4px; border-radius:3px;"> Submit Query </span>&nbsp; button of the Contact-Us form saying <span style="color:#98b;">Get Registration Form</span>. Click on that link and you will get the "PARTNER WITH US" form.</div>
						<div class="mar-bot_pl3" ><span class="strong_font_pl3">Thats it!</span> We will contact you soon after we find you are interested.</div>
					</div>
			</div>
		<?php
		return ob_get_clean();
	}

	public function sid_nsna_shopReg_pl3()
	{

		global $sid_nsna_plugin_dir;

		if( isset($_GET['request']) ){
			if( $_GET['request'] == 'regform' ){
				add_filter('the_content','sid_nsna_shopRegForm_pl3');
				return $this->sid_nsna_shopRegForm_pl3();
				exit();
			}
		}
		else
		{
			$select = new sid_nsna_selectDb_pl3();
			ob_start();
		?>
				<div class="row banner_header1_pl3">
					<div class="col-md-12">
						<img style="background-size: cover;" src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/header.jpg'; ?>">
						<div class="banner_poly_buttons_cont">
							<a class="poly_banner_buttons" href="#contact_us_pl3">New User</a>
							<a class="poly_banner_buttons" href="#new_user_pl3">Existing User</a>
						</div>
					</div>
				</div>
				<br>
				<div class="row new-section-pl3">
					<h2 class="text-center-align-pl3">Why Partner With Us?</h2>
					<div class="text-center-align-pl3 mar-bot_pl3">Expand your reach and add value to your business</div>
					<hr>
				
					<div class="col-md-10 col-md-offset-1" style="text-align:center;">
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/list.png?ver=1'; ?>" alt="Listing">
					      <div class="caption">
					        <h3>Listing</h3>
					        <div>Listing with us is free and always will be. No cancellation, setup, or sign up fees.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/target.png?ver=1'; ?>" alt="Targeted customers">
					      <div class="caption">
					        <h3>Targeted customers</h3>
					        <div>We cut through the clutter to give you efficient and potential customers.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/retaintion.png?ver=1'; ?>" alt="Customer retention">
					      <div class="caption">
					        <h3>Customer retention</h3>
					        <div>Instantly view customer's feedback posted on our page, which helps in understanding & retaining customers.</div>
					      </div>
					    </div>
					  </div>
				<!-- ===================== -->
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/24x7.png?ver=1'; ?>" alt="24x7">
					      <div class="caption">
					        <h3>24x7 service</h3>
					        <div>Clients can access our site, view service availability and make appointments with you 24x7.</div>
					      </div>
					    </div>
					  </div>
					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/notif.png?ver=1'; ?>" alt="Instant Notifications">
					      <div class="caption">
					        <h3>Instant Notifications</h3>
					        <div>We help you in reminding customers to confirm their appointments. Can't make it into work? Cancel or reschedule of appointments can be done through a click.</div>
					      </div>
					    </div>
					  </div>

					  <div class="col-sm-6 col-md-4">
					    <div class="thumbnail">
					      <img src="<?php echo $sid_nsna_plugin_dir.'/Assets/images/promotion.png?ver=1'; ?>" alt="List promotions:">
					      <div class="caption">
					        <h3>List promotions:</h3>
					        <div>We help you in promoting offers through a hassle free process. In a single word we are your digital marketing partners.</div>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
				<!-- Contact with us -->
				
				<div class="col-md-8 col-md-offset-2 new-section-pl3" id="contact_us_pl3">
					<form class="nsna_contactUS_form">
						<h2 class="text-center-align-pl3">Contact Us</h2>
						<div class="text-center-align-pl3">Need assistance? Report Problem? Wanna know more?</div><br>
						<div class="col-md-12 contact-us-cs">
						<div class="col-md-12 nsna_ContactUsmike_pl3"></div>	
							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon">Name</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuName_pl3" id="Name" placeholder="Shop Name" aria-describedby="basic-addon1">
							</div>

							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon ">+91</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuPhone_pl3" id="Phone" placeholder="Contact number" aria-describedby="basic-addon1">
							</div>

							<div class="input-group mar-bot_pl3">
							  <span class="input-group-addon">@</span>
							  <input type="text" class="form-control cu_jsIP_pl3  nsna_cuEmail_pl3" id="Email" placeholder="Email address" aria-describedby="basic-addon1">
							</div>

							<div class="username-cs input-group mar-bot_pl3" style="display:none; ">
							  <span class="input-group-addon ">Username</span>
							  <input type="text" class="form-control cu_jsIP_pl3 nsna_cuUame_pl3" id="username" placeholder="Username" aria-describedby="basic-addon1">
							</div>
							<textarea class="form-control mar-bot_pl3 nsna_cuDesc_pl3 cu_jsIP_pl3" rows="6" placeholder="Describe your query" id="Description"></textarea>
							
							<button type="button" class="btn btn-success nsna_contactUS_pl3">Submit Query</button>
							<?php 
								if(!$select->isRegistered_pl3() ){
							?>
									<span class="pull-right">
										<a href="<?php echo "http://"."$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"."?request=regform"; ?>">Get Registration Form</a>
									</span>
							<?php
								}
							?>
						</div>
					</form>
				</div>
				

				<div class="col-md-12 new-section-pl3" id="new_user_pl3">
					<h2 class="text-center-align-pl3">Existing User ?</h2>
					<div class="text-center-align-pl3 mar-bot_pl3">If you are a registered organization, Please LOG IN and get into your dashboard.</div>
					<hr>
					<div class="col-md-8 col-md-offset-2">
						<?php 
					      // Custom widget area start
					      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Custom Widget Area') ) : ?>
						<?php endif; 
							if( $select->isRegistered_pl3() ){
								echo '<button class="my_dashboard_button_pl3" disabled>TAKE TO MY DASHBOARD</button>';
							}

						?>
					</div>
				</div>
				<hr>

				<div class="col-md-12 new-section-pl3">
					<h2 class="text-center-align-pl3">How To Become A Partner ?</h2>
					<div class="text-center-align-pl3 mar-bot_pl3">Please follow the instructions given below to be one of us.</div>
						<hr>
						<div class="col-md-10 col-md-offset-1">
							<div class="mar-bot_pl3" > <span class="strong_font_pl3">As you already logged-in </span></div>
							<div class="mar-bot_pl3" ><span class="strong_font_pl3">Step last:</span> Now you can either use the "CONTACT US" form given above (recommended), and let us know that you want to be our valuable partner OR if you can find a link beside <span style="color:white; background-color:#6c6; padding:2px 4px; border-radius:3px;"> Submit Query </span>&nbsp; button of the Contact-Us form saying <span style="color:blue;">Get Registration Form</span>. Click on that link and you will get the "PARTNER WITH US" form.</div>
							<div class="mar-bot_pl3" ><span class="strong_font_pl3">Thats it! </span>We will contact you soon after we find you are interested.</div>
						</div>
				</div>
		<?php
		return ob_get_clean();
		}

	}
	public function sid_nsna_shopRegForm_pl3()
	{
		ob_start(); ?>
		<form id="nsns_RegForm_pl3">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<div class="col-md-12 nsna_mike"></div>				
				<div class="col-md-12">
				<!-- Primary details -->
					<h3>Basic Details</h3>
					<div class="col-md-12">
						
						<div class="form-group">
						    <label for="emailinput">Email Id Of Organization</label>
						    <input type="email" class="form-control shop_email_pl3 jq_IP_pl3" id="Email" readonly value="<?php global $user_email;  get_currentuserinfo(); echo $user_email; ?>">
						</div>

						<div class="form-group">
						    <label for="shopname">Name Of Orgnization</label>
						    <input type="text" class="form-control jq_IP_pl3" id="Shop_Name" placeholder="Name of organization">
						</div>
						
						<div class="form-group">
						    <label for="phone1">Primary Phone/Contact Number</label>
						    <input type="email" class="form-control jq_IP_pl3" id="Contact_Number" placeholder="Phone number">
						</div>
					</div>
					<input type="hidden" name="sid_nsna_nonce_pl3" id="nonce" class="jq_IP_pl3" value="<?php echo wp_create_nonce('sid-nsna-nonce-pl3'); ?>"/>
				</div>
				<hr> 
				<!-- Location Details -->
				<div class="col-md-12">
					<h3>Location Details</h3>
					<div class="col-md-12">
							<div>
								<label>Enter your address</label>
								<div><input type="text" id="nsna-autocompleteAddress-pl3" name="autocomplete_pl3" placeholder="Enter you location" class="form-control"/></div>
							</div>
							<p class="para pad-top">
								<b>Please Note:</b> You might not get your exact address automatically just by typing on above textbox,
								in such case you have to type in your ZIP/PIN code (recommended) , area or city (select it from the dropdown) and find the required location manually using the MAP.
								Once you find the exact location, click on that place which leave a red mark ther on the map. 
							</p>

							<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbgFepltqsSw8FxQauYO8pmWjAXjPKVuQ&libraries=places"></script> 
							<div clas="col-md-12">
								<div id="lat_lng_map_pl3" class="inlineBlck_pl3" ></div>
							</div>
							<div class="formattedAddress_pl3">
								<div class=" col-md-12 nsna-mapTips-pl3">
									In case if the address given below is wrong, please use the map properly to make it right. 
								</div>
								<div class="col-md-12">
									<h5>Your formatted address is:<span class="label label-default inlineBlck_pl3 formatted_address_pl3 jq_IP_pl3 text-pl3" id="formatted_address" data-msg="Address "></span></h5>
								</div>
								<div class="col-md-12 hide">
									<h5>Latitude:<span id="lat_pl3" class="label label-default jq_IP_pl3 text-pl3"  data-msg="Map attribute"></span></h5>&nbsp;, <h5>Longitude:<span id="lng_pl3" class="label label-default jq_IP_pl3 text-pl3 " data-msg="Map attribute"></span></h5>
								</div>
								<div class="col-md-12">
									<div class="form-horizontal">
										<div class="form-group">
										    <label for="zip" class="col-md-1 col-sm-2 col-xs-4 control-label">ZIPCODE</label>
										    <div class="col-md-2 col-sm-4 col-xs-8">
										    	<div class="form-control jq_IP_pl3 text-pl3" data-msg="ZIP" id="zip_pl3" readonly > </div>
										    </div>
										</div>
										<div class="lat-Landmark-pl3">
											<label for="landmark">Landmark</label><input type="text" class="form-control" id="Landmark_pl3">
											<input type="text" class="form-control jq_IP_pl3" id="landmark" placeholder="Landmark">
										</div>
									</div>
								</div>
							</div>
					</div>
				</div> 
				<hr>
				<!--  CATEGORY SELECTION -->
				<div class="col-md-12">
					<h3>Shop Details</h3>
					<div class=" col-md-12 inlineBlck_pl3">
						<label>What is the type of your Organization?</label>
						<div class="sid_cat_pl3 cats_pl3">
						<?php 
							$cats = new sid_nsna_selectDb_pl3();
							$catts = $cats->getParentCats_pl3();
							if (!empty($catts)) {
								foreach ($catts as $key => $value) {
						?>
							<div class="cat_pl3 "><label><?php echo $value['cat']; ?></label><input type="checkbox" data-count="<?php echo $key; ?>" class="nsna-chkbx-pl3 nsna-cats-pl3" value="<?php echo $value['cat']; ?>"/></div>
						<?php
								}
							}
							else
								echo "<div> No Shop Are Added Yet!</div>";
						?>
						</div>

						<div class="services_pl3 required_pl3 col-md-12">
							<div class="nsna_cats_pl3 nsna_hide_this_pl3 ">
								<div class="nsna_cat_pl3"></div>
								<div class="nsna_subcats_pl3">
									<span class="nsna_subcat_pl3 nsna_hide_this_pl3" data-index=""></span>
								</div>
							</div>
						</div> 
					</div>
				</div>
				
				<hr>
				<!-- DONE  -->
				<div class="col-md-12">
						<p class="text-success"> We thank you for registering with us and kindly note that your account will be activated within maximum 48 hours, once after your account details is verified valid.</p>
						<button type="submit" class="btn btn-warning sid-nsna-createAccountShop-pl3">Create An Account</button>
						<h5>Please note by creating account you agree to our terms and conditions.</h5>
				</div>
				
			</div>
		</div>
		</form>
		<?php
		return ob_get_clean();
	}
}
?>
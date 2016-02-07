<?php

//call to menu creation 
add_action( 'admin_menu', function(){
	// $GLOBALS['admin_page_hooks'] is the list of registered pages.
	if ( empty ( $GLOBALS['admin_page_hooks']['sid-parent-slug'] ) )
		add_menu_page( 'Sid Plugins', 'Sid Plugins', 'manage_options', 'sid-parent-slug', 'sid_nsna_adminManageCatForm_pl3' );
		
	add_submenu_page( 'sid-parent-slug', 'Manage Category', 'Manage Category', 'manage_options', 'job-applications', 'sid_nsna_adminManageCatForm_pl3' );
	add_submenu_page( 'sid-parent-slug', 'Manage Shops', 'Manage Shops', 'manage_options', 'manage-shops', 'sid_nsna_manageClientsForm_pl3' );
	remove_submenu_page('sid-parent-slug','sid-parent-slug');
});

// //call register settings 
// add_action( 'admin_init', function(){
// 	//register our settings
// 	register_setting( 'sid_nsna_adminOptionGroup_pl3', 'sid_addNewCats_pl3' );
// 	// register_setting( 'sid_nsna_adminOptionGroup_pl3', 'some_other_option' );
// 	// register_setting( 'sid_nsna_adminOptionGroup_pl3', 'option_etc' );
// } );

function sid_nsna_adminManageCatForm_pl3(){
	$cats = new sid_nsna_selectDb_pl3();
	ob_start(); ?>
		<div class="col-md-12">
		<h1>Add Shop Categories</h1>
			
				
			<div class="si_disp_inlineblck_pl3">
				<form method="post" id="nsna_admin_reg_form" action="options.php">
					<div>Category Name</div>
					<input type="text" id="nsna_cat_pl3"><br><br>

					<div>Parent</div>
					<select id="nsna_parentCat_pl3">
						<option value="none">None</option>
						<?php
							$catts = $cats->getParentCats_pl3();
							if(is_array($catts))
								foreach ( $catts as $key => $value ) 
									echo '<option> '. $value['cat'] .' </option>';
							else
								echo '<option id="getRid_pl3"> '. 'No parent categories yet' .' </option>';	
						?>
					</select>
					<br><br>
					<div>
						<input type="submit" class="button button-primary sid-nsna-addNewCatSubmit-pl3" value="Save Changes">
					</div>
				</form>
			</div>
			
			<div class="si_disp_inlineblck_pl3">
				<div>
				<table>
					
					<tr>
						<th>Category</th>
						<th>Parent</th>
						<th>Level</th>
						<th>Actions</th>
					</tr>
				<?php
					$Allcats = $cats->getCatHierarchy_pl3();
					if( !empty($Allcats) ){
						foreach ($Allcats as $key => $value) {
						?>
							<tr data-id="<?php echo $value['self']; ?>" data-cls="<?php echo $value['level']; ?>">
								<th> <?php echo $value['self']; ?> </th>
								<th> <?php echo $value['parent']; ?> </th>
								<th> <?php echo $value['level']; ?> </th>
								<th> <a href="#" class="del_cat_pl3">Delete</a></th>
							</tr>
						<?php
							if ( !empty($value['child']) ) {
								foreach ($value['child'] as $k => $v) {
							?>
									<tr data-id="<?php echo $v['self']; ?>" data-cls="<?php echo $v['level']; ?>">
										<td> <?php echo $v['self']; ?> </td>
										<td> <?php echo $v['parent']; ?> </td>
										<td> <?php echo $v['level']; ?> </td>
										<td> <a href="#" class="del_cat_pl3">Delete</a></td>
									</tr>
								<?php
								}	
							}
						}
					}
					else
						echo '<td> No Categories added</td>'
					?>
				</table>
				<?php
					// var_dump($cats->getCatHierarchy_pl3());
				?>
				</div>
			</div>
		</div>

			
		

	<?php
	echo ob_get_clean();
}

function sid_nsna_manageClientsForm_pl3(){
	$usrs = new sid_nsna_selectDb_pl3();
	$ppls = $usrs->get_shopListings();
	ob_start(); ?>
		
		<!-- Pending requests -->
		<h2>Pending Requests</h2>
		<table>
		<?php
		if( empty($ppls['inactive']) ){
				echo "No Pending Users";
		}
		else{
		?>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Reg at</th>
					<th>Address</th>
					<th>Actions</th>
				</tr>
		<?php
			foreach ($ppls['inactive'] as $key => $value) {
		?>
					<tr>
						<td> <?php echo $value['name'] ?> </td>
						<td> <?php echo $value['email'] ?> </td>
						<td> <?php echo $value['regat'] ?> </td>
						<td> <?php echo $value['address'] ?> </td>
						<td> 
							<a href="#" class="activateUser_pl3">Activate</a>
							<a href="#" class="rejectUser_pl3">Reject</a>
							<a href="#" class="DetailsUser_pl3">Details</a>
						</td>
					</tr>
		<?php
			}
				// var_dump( $usrs->get_shopListings() );
		}
		?>
		</table>
		

		<!-- AccepteD users -->
		<hr>
		<h2>Active Users</h2>
		<table>
		<?php
		if( empty($ppls['active']) ){
				echo "No Active Users";
		}
		else{
		?>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Reg at</th>
					<th>Address</th>
					<th>Actions</th>
				</tr>
		<?php
			foreach ($ppls['active'] as $key => $value) {
		?>
					<tr>
						<td> <?php echo $value['name'] ?> </td>
						<td> <?php echo $value['email'] ?> </td>
						<td> <?php echo $value['regat'] ?> </td>
						<td> <?php echo $value['address'] ?> </td>
						<td> 
							<a href="#" class="activateUser_pl3">Activate</a>
							<a href="#" class="rejectUser_pl3">Reject</a>
							<a href="#" class="DetailsUser_pl3">Details</a>
						</td>
					</tr>
		<?php
			}
				// var_dump( $usrs->get_shopListings() );
		}
		?>
		</table>


	<?php
	echo ob_get_clean();
}
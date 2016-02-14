<?php
error_reporting(E_ALL);
/*
* Plugin Name: Sid Nearby Shop With Appontment
* Description: Your site visitor can get appointment to all his/her nearby registered shops (spa, saloon, whatever).
* Version: v1.0
* Author: Mr Sidd
* License: GPL2
*/
	register_activation_hook(__FILE__, function(){
		$initt = new sid_nsna_activation_pl3();
		$initt->sid_init_db_pl3();
		$initt->sid_init_pages_pl3();
	});

	register_deactivation_hook( __FILE__, function(){
		$dumpp = new sid_nsna_Dactivation_pl3();
		// $dumpp->sid_dump_db_pl3();
		$dumpp->sid_dump_pages_pl3();
	}); 

	add_action('init', function(){
	    wp_register_script('sid_nsna_landing_script_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/nsna_landingScript1.js?ver=1');   
	    wp_register_script('sid_nsna_parentjs_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/nsna_registrationScript1.js?ver=1');
	    wp_register_script('sid_nsna_bootstrap_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/bootstrap.min.js?ver=1');
	    wp_register_script('sid_nsna_dashboard_script_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/nsna_dashboardScript1.js?ver=1');
	    wp_register_script('sid_nsna_searchResults_script_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/nsna_searchResultsjs.js?ver=1');
	    
	    wp_enqueue_style('sid_nsna_parentcss_pl3', plugin_dir_url( __FILE__ ) . 'Assets/styles/nsna_style1.css?ver=1');
		
		if (isset( $_POST["sid_nsna_chosenCat_pl3"] ) && isset( $_POST["sid_nsna_latlng_pl3"] ) && wp_verify_nonce($_POST['sid_nsna_searchResultsNonce_pl3'], 'sid-nsna-searchResultsNonce-pl3'))
		{
			if( !empty($_POST["sid_nsna_chosenCat_pl3"]) && !empty($_POST["sid_nsna_latlng_pl3"]) && !empty($_POST['sid_nsna_searchResultsNonce_pl3']) )
			{
				$cat = str_replace(" ", "_", $_POST["sid_nsna_chosenCat_pl3"]);
				$latlng = explode(',', $_POST["sid_nsna_latlng_pl3"]);
				
				// $salt = 'MrSidd';
				$lat = $latlng[0];
				$lng = $latlng[1];

				wp_redirect( get_permalink( get_page_by_path( 'search-results' ) ) .'?zip='.$lat.'&piz='.$lng.'&cat='.$cat );
				exit();
			}
		}
		//check for get_appointmernt button ppessed
		//> check nonce
		//> check cat 
		//> check shop_id
		//> check lat lng of chosen address 
	});

	add_action('admin_enqueue_scripts', function(){
		// wp_enqueue_script( 'jquery' );
		// wp_enqueue_script( 'sid_nsna_adminjq_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/jquery.min.js' );
	    wp_enqueue_script( 'sid_nsna_adminjs_pl3', plugin_dir_url( __FILE__ ) . 'Assets/scripts/nana_adminScript1.js?ver=1' );
	    wp_localize_script( 'sid_nsna_adminjs_pl3', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
	});
	
		
	global $sid_nsna_plugin_dir;
	global $sid_nsna_base_dir;
	$sid_nsna_plugin_dir = plugin_dir_url( __FILE__ );
	$sid_nsna_base_dir = plugin_dir_path(__FILE__);

	add_action('wp_footer', function(){

		global $sid_nsna_loadRegScript_pl3;
		global $sid_nsna_loadLndScript_pl3;
		global $sid_nsna_loadDshScript_pl3;
		global $sid_nsna_searchResults_pl3;
 
    	if ( $sid_nsna_loadRegScript_pl3 ){
    		wp_enqueue_script( 'jquery' );
		    wp_enqueue_script( 'sid_nsna_parentjs_pl3' );
		    wp_enqueue_script( 'sid_nsna_bootstrap_pl3' );
		    /* Localize script for AJAX*/
		    wp_localize_script( 'sid_nsna_parentjs_pl3', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
    	}
    	elseif ($sid_nsna_loadLndScript_pl3) {
    		wp_enqueue_script( 'jquery' );
		    wp_enqueue_script( 'sid_nsna_landing_script_pl3' );
		    // wp_enqueue_script( 'sid_nsna_bootstrap_pl3' );
		    /* Localize script for AJAX*/
		    wp_localize_script( 'sid_nsna_landing_script_pl3', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
    	}
    	elseif ($sid_nsna_loadDshScript_pl3) {
    		wp_enqueue_script( 'jquery' );
		    wp_enqueue_script( 'sid_nsna_dashboard_script_pl3' );
		    // wp_enqueue_script( 'sid_nsna_bootstrap_pl3' );
		    /* Localize script for AJAX*/
		    wp_localize_script( 'sid_nsna_dashboard_script_pl3', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
    	}
    	elseif ($sid_nsna_searchResults_pl3) {
    		wp_enqueue_script( 'jquery' );
		    wp_enqueue_script( 'sid_nsna_searchResults_script_pl3' );
		    // wp_enqueue_script( 'sid_nsna_bootstrap_pl3' );
		    /* Localize script for AJAX*/
		    wp_localize_script( 'sid_nsna_searchResults_script_pl3', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
    	}
    	else
        	return;

        global $sid_nsna_loadStyles_pl3;
	    if($sid_nsna_loadStyles_pl3)
	    {
			wp_enqueue_style('sid_nsna_boostrap_pl3', plugin_dir_url( __FILE__ ) . 'Assets/styles/bootstrap.min.css');   
	    }
	    else
	    	return;

	});
	

	require "shortcodes.php";
	require "crust.php";
	require "function_class.php";
	
	require "Instances/no_dashboard_class.php";
	require "Instances/dashboard_class.php";
	require "Instances/landing_class.php";
	require "Instances/search_results_class.php";

	require "Libraries/insert.php";
	require "Libraries/select.php";
	require "Libraries/delete.php";
	require "Libraries/logic.php";

	require "Admin/index.php";
	

// --[ Front end AJAX Implementation ]--
add_action( 'wp_ajax_sid_nsna_ajax_pl3', 'sid_nsna_ajax_pl3' );
add_action( 'wp_ajax_nopriv_sid_nsna_ajax_pl3', 'sid_nsna_ajax_pl3' );

function sid_nsna_ajax_pl3(){
	$new = new sid_nsna_ShopClass_pl3();
	$type = $_POST['token'];
    if (isset($type)) {
        switch ($type) {
            case 'register_shop':
            		$new->sid_nsna_populate_pl3($_POST['data_sent']);
                    $resp = $new->sid_nsna_newShop_pl3();
                    echo $resp;
                    exit();
                break;
            case 'admin_add_category':
            		$cat = new sid_nsna_insertDb_pl3();
            		echo $cat->createCategory_pl3($_POST['data_sent']);
					exit();
            	break;
            case 'admin_del_category':
            		$cat = new sid_nsna_deleteDb_pl3();
            		echo $cat->deleteCat_pl3($_POST['data_sent']);
					exit();
            	break;
            case 'contact_shop':
            		$logix = new sid_nsna_logic_pl3();
            		// echo "heyyyyoo";
            		echo $logix->contactUs_pl3($_POST['data_sent']);
					exit();
            	break;
            case 'get_subcats':
            		$cat = new sid_nsna_selectDb_pl3();
            		echo $cat->getSubcat_pl3($_POST['data_sent']);
					exit();
            	break;
            case 'get_particular_subcats':
            		$cat = new sid_nsna_selectDb_pl3();
            		echo $cat->getHisSubcats_pl3($_POST['data_sent']);
					exit();
            	break;

            	
            // default:
            //     echo 'fishy! Something went wrong! Sorry for the inconvenience..' ;
            //     break;
        }
    }
        
}

add_action('wp_ajax_sid_nsna_pl3_fuAjax', 'sid_nsna_ajaxFU_pl3');
add_action('wp_ajax_nopriv_sid_nsna_pl3_fuAjax', 'sid_nsna_ajaxFU_pl3');

function sid_nsna_ajaxFU_pl3()
{
	$file = $_FILES;
	reset($file);
	$type = key($file);

	// echo $type;
	// var_dump($file[$type]);
	$logic = new sid_nsna_logic_pl3();
	switch ($type) {
		case 'shopLogo':
				echo $logic->uploadLogo_pl3( $file[$type], plugin_dir_path(__FILE__) );
				exit();
			break;

	}
}

// Custom widget area.
 register_sidebar( array(
    'name' => __( 'Custom Widget Area'),
    'id' => 'custom-widget-area',
    'description' => __( 'An optional custom widget area for your site' ),
    'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );
?>
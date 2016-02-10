<?php
class sid_nsna_activation_pl3{
		public function sid_init_db_pl3()
		{
			global $wpdb;
			global $sid_nsna_db_version_pl3;

			$table_name0 = $wpdb->prefix . "sid_shopid_pl3";
			$table_name1 = $wpdb->prefix . "sid_shops_pl3";
			$table_name2 = $wpdb->prefix . "sid_shopscontacts_pl3";
			$table_name3 = $wpdb->prefix . "sid_shopsbank_pl3";
			$table_name4 = $wpdb->prefix . "sid_shopscat_pl3";

		    $sid_nsna_db_version_pl3 = '1.0';
		    $charset_collate = $wpdb->get_charset_collate();
		    // LEARN get_charset_collate: https://hakre.wordpress.com/2010/12/26/wordpress-database-charset-and-collation-configuration/6

		    $sql0 = "CREATE TABLE IF NOT EXISTS $table_name0(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				email varchar(60) NOT NULL,
				name varchar(80) NOT NULL,
				address varchar(150) NOT NULL,
				regat DATETIME NOT NULL,
				activated ENUM('0','1') NOT NULL DEFAULT '0',
				certified ENUM('0','1') NOT NULL DEFAULT '0',
				UNIQUE KEY id (id)
			) $charset_collate;";


			$sql1 = "CREATE TABLE IF NOT EXISTS $table_name1(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name varchar(80) NOT NULL,
				email varchar(60) NOT NULL,
				pin varchar(10) NOT NULL, 
				type varchar(20) NOT NULL,  
				subtype varchar(20) NOT NULL, /* store subcategory */ 
				lat varchar(50) NOT NULL,
				lng varchar(50) NOT NULL,
				address varchar(150) NOT NULL,
				operateStamp varchar(32) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

			$sql2 = "CREATE TABLE IF NOT EXISTS $table_name2(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				shopId varchar(60) NOT NULL,
				phno varchar(200) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";
			
			$sql3 = "CREATE TABLE IF NOT EXISTS $table_name3(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				shopId varchar(60) NOT NULL,
				vat varchar(80) NOT NULL,
				pan varchar(60) NOT NULL,
				bnkNM varchar(20) NOT NULL,
				bnkAC varchar(20) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

			$sql4 = "CREATE TABLE IF NOT EXISTS $table_name4(
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				cat varchar(60) NOT NULL,
				parentt varchar(60) NOT NULL,
				level int(2) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";
	


			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql0 );
			dbDelta( $sql1 );
			dbDelta( $sql2 );
			dbDelta( $sql3 );
			dbDelta( $sql4 );
			
			add_option( 'sid_nsna_db_version_pl3', $sid_nsna_db_version_pl3 );
		}

		public function sid_init_pages_pl3()
		{
			$_ = [
		        '19' => [
		           'post_title' => 'Shop EPlanet',
		           'post_content' => "[sid_SC_page_pl3]",
		           'post_status' => 'publish',
		           'post_type' => 'page',
		           'comment_status' => 'closed',
		           'ping_status' => 'closed',
		           'post_category' => array(1)
		        ],
		        '20' => [
		           'post_title' => 'Search Results',
		           'post_content' => "[sid_SR_page_pl3]",
		           'post_status' => 'publish',
		           'post_type' => 'page',
		           'comment_status' => 'closed',
		           'ping_status' => 'closed',
		           'post_category' => array(1)
		        ],
		    ];

		    foreach ($_ as $key => $value) {
		        $the_page_title = $value['post_title'];
		        $the_page_name = $value['post_title'];

		        // the menu entry...
		        delete_option($value['post_title']);
		        add_option($value['post_title'], $the_page_title, '', 'yes');
		        // the slug...
		        delete_option($value['post_title']);
		        add_option($value['post_title'], $the_page_name, '', 'yes');
		        // the id...
		        delete_option($key);
		        add_option($key, '0', '', 'yes');

		        $the_page = get_page_by_title( $the_page_title );

		        if ( ! $the_page ) {
		            $the_page_id = wp_insert_post( $value );
		        }
		        else {
		            $the_page_id = $the_page->ID;
		            $the_page->post_status = 'publish';
		            $the_page_id = wp_update_post( $the_page );
		        }

		        delete_option( $key );
		        add_option( $key, $the_page_id );
		    }
		}
	}

	class sid_nsna_Dactivation_pl3{
		public function sid_dump_db_pl3()
		{
			 global $wpdb;
			 $tabls = [];

			 $table_name0 = $wpdb->prefix . "sid_shopid_pl3";
		     $table_name1 = $wpdb->prefix . "sid_shops_pl3";
			 $table_name2 = $wpdb->prefix . "sid_shopscontacts_pl3";
			 $table_name3 = $wpdb->prefix . "sid_shopsbank_pl3";
			 $table_name4 = $wpdb->prefix . "sid_shopscat_pl3";

			 array_push($tabls, $table_name0);
			 array_push($tabls, $table_name1);
			 array_push($tabls, $table_name2);
			 array_push($tabls, $table_name3);
			 array_push($tabls, $table_name4);

			 foreach ($tabls as $value) {
			 	$sql = "DROP TABLE IF EXISTS $value;";
		     	$wpdb->query($sql); //dbDelta() not supported DROP TABLE query.
			 }

		     delete_option("sid_nsna_db_version_pl3");
		}

		public function sid_dump_pages_pl3(){
		    $pages = [
		        '19' => 'Shop EPlanet',
		    ];
		    foreach ($pages as $key => $value) {
		        $the_page_title = get_option( $value );
		        $the_page_name = get_option( $value );

		        //  the id of our page...
		        $the_page_id = get_option( $key );
		        if( $the_page_id ) {
		            wp_delete_post( $the_page_id ); // this will trash, not delete
		        }
		        delete_option($value);
		        delete_option($value);
		        delete_option( $key );
		    }
		}
	}
?>
<?php
add_shortcode('sid_SC_page_pl3',function(){// Custom page

	global $sid_nsna_loadRegScript_pl3;
    global $sid_nsna_loadStyles_pl3;
    global $sid_nsna_loadDshScript_pl3;
    
    $sid_nsna_loadStyles_pl3 = true;

    if(is_user_logged_in())
    {
        
        $usr = new sid_nsna_selectDb_pl3();
        if( !$usr->isRegistered_pl3() )
        {
            $sid_nsna_loadRegScript_pl3 = true;
            $var = new sid_nsna_noDash_cls();
            $output = $var->sid_nsna_shopReg_pl3();
        }
        else
        {
            $sid_nsna_loadDshScript_pl3 = true;
            $var = new sid_nsna_Dash_cls();
            $output = $var->sid_nsna_Dashboard_pl3();
        }
    }
    else
    {	
        $sid_nsna_loadRegScript_pl3 = true;
    	$var = new sid_nsna_noDash_cls();
        $output = $var->sid_nsna_notLoggedIn_pl3();
    }
    return $output;
}); 

add_shortcode('sid_nsna_searchbar_pl3', function(){// Custom page

	global $sid_nsna_loadLndScript_pl3;
    global $sid_nsna_loadStyles_pl3;

    $sid_nsna_loadStyles_pl3 = true;
    $sid_nsna_loadLndScript_pl3 = true;
    $var = new sid_nsna_landing_cls();
    return $var->sid_nsna_homePage_pl3();

});

add_shortcode('sid_SR_page_pl3', function(){// Custom page

    global $sid_nsna_loadStyles_pl3;
    global $sid_nsna_searchResults_pl3;

    $sid_nsna_searchResults_pl3 = true;
    $sid_nsna_loadStyles_pl3 = true;

    if (isset( $_GET["cat"] ) && isset( $_GET["zip"]) && isset( $_GET["piz"]) )
    {
        if( !empty($_GET["cat"]) && !empty($_GET["zip"]) && !empty($_GET["piz"]) )
        {

            $cat = str_replace("_", " ", $_GET["cat"]);
            $lat = $_GET["zip"];
            $lng = $_GET["piz"];
            $radius = 3;

            $select = new sid_nsna_selectDb_pl3();
            $result = $select->get_AreaBounds($lat, $lng, $radius, $cat);
            $cats = $select->getParentCats_pl3();
            // var_dump($result);
            // exit();

            $var = new sid_nsna_searchResults_cls($result, $cats);
            return $var->throw_searchResults();
        }
    }
});

?>
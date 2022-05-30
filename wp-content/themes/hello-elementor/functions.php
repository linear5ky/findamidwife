<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.5.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( [ 'menu-1' => __( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => __( 'Footer', 'hello-elementor' ) ] );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( hello_header_footer_experiment_active() && is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}
 $google_api_key = 'AIzaSyDt0fVw3YeRz0Ldt1dlzk2ssx9M3-GDmNM';
wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$google_api_key);
wp_enqueue_script('google-jsapi','https://www.google.com/jsapi');



  ///////////////
    //
    // Find a midwife functionality
    //
    ///////////////

    /**
     * Function: disatance_sort
     * This function allows us to compare the distance value in the two parameters to determine which is closer (or if
     * they are the same).
     *
     * @param $midwife_a
     * @param $midwife_b
     * @return int
     */
    function distance_sort($midwife_a, $midwife_b){
        if($midwife_a["distance"] == $midwife_b["distance"]){
            return 0;
        }

        if($midwife_a["distance"] < $midwife_b["distance"]){
            return -1;
        }
        return 1;
    }

    /**
    * Function: midwife_search
    * This function performs the search for midwives and practices that are current registered within the system.  The
    * function take a number of parameters which can be defined to filter the list of users that are returned.  This
    * includes a midwife's name, practice name, specialism, region or a radius form the location specified.
    *
    * Search rules
    *
    * - Location is required to calculate the distance from the user
    * - If a midwife name or practice distance value is ignored.
    *
    *
    **/
    function midwife_search($search_point, $midwife_name, $practice_name, $specialism, $region, $radius){
        global $wpdb;
        // echo 'imuktest0_'.$search_point.'<br />';
        if(is_null($search_point["latitude"]) || is_null($search_point["longitude"])){
            $search_point = google_geoencode(str_replace(' ', '+', $search_point["postcode"]));
        }
        // sometimes its blank from this point onwards... WHY???
        // echo 'imuktest1_'.$search_point.'<br />';

        $midwife_name = strtolower($midwife_name);
        $practice_name = strtolower($practice_name);
        $practice_id = NULL;
        if($practice_name != ''){
            $post = get_page_by_title($practice_name, 'OBJECT', 'practices');
            $practice_id = $post->ID;

            if($practice_id == 0){
                return array();
            }
        }

        if($region != '-1'){
            $region = get_term($region, 'region');
        }

        if($specialism != '-1'){
            $specialism = get_term($specialism, 'specialism');
        }

        $midwife_roles = array(
            "Midwife",
            "Midwife+"
        );
        $all_markers = array();

        foreach($midwife_roles as $role){

            $args = array(
                "role" => $role,
            );

            if($midwife_name != '' || $practice_name != ''){
                $radius = '';

                if($practice_name != ''){
                    $args["meta_query"] = array(
                        array(
                            "key" => "practice",
                            "compare" => "=",
                            "value" => $practice_id
                        )
                    );
                    $radius = '';
                }
            }
            $midwives = get_users($args);
            // echo ('imuktestingstring_'.count($midwives));

            foreach($midwives as $midwife){
                $name = $midwife->first_name." ".$midwife->last_name;

                // FILTER "Midwife Name": If the user has entered a name and that name value doesn't exist within the midwife's name then move to new midwife
                if($midwife_name != '' && (strpos(strtolower($name), $midwife_name) === FALSE)){
                    continue;
                }


                // FILTER "Specialism": Next check to see if the midwife has the appropriate specialism to be listed based on the user's search criteria.
                if($specialism != -1){
                    if(!is_object_in_term($midwife->ID, 'specialism', $specialism)){
                        continue;
                    }
                }

                // FILTER "Region":
                if($region != -1){
                    if(!is_object_in_term($midwife->ID, 'region', $region)){
                        continue;
                    }
                }

                $midwife_location = array(
                    "latitude" => get_the_author_meta("latitude", $midwife->ID),
                    "longitude" => get_the_author_meta("longitude", $midwife->ID)
                );

               // print_r($midwife_location);

                // Double check the latitude and longitude values to make sure that they are set, if not then simply ignore them
                if($midwife_location["latitude"] == "" || $midwife_location["longitude"] == ""){
                    continue;
                }

                // Calculate the distance from the user's specified location
                $distance = vincentyGreatCircleDistance(
                    $search_point["lat"], $search_point["lng"],
                    $midwife_location["latitude"], $midwife_location["longitude"]
                );

                // echo ('imuktestingstring_dr_'.$distance);

                // FILTER "Distance": Check to see if they are searching within a radius, and if so check they are within the radius
                if($radius != '' && $distance >= $radius){
                    continue;
                }

                // echo ('imuktestingstring2_addresult');
                $all_markers[] = array(
                    "type" => "midwife",
                    "name" => $name,
                    "lat" => $midwife_location["latitude"],
                    "lng" => $midwife_location["longitude"],
                    "distance" => $distance,
                    "id" => $midwife->ID,
                    "url" => get_bloginfo('url') ."/profile/?midwife=".$midwife->user_login,
                    "marker" => markerBuilder(
                        "midwife",
                        get_bloginfo('url') ."/profile/?midwife=".$midwife->user_login,
                        $name,
                        $distance,
                        getThumbnail($midwife->ID, true),
                        $midwife->ID
                    )
                );
                //getThumbnail($midwife->ID, true),
              //  print_r(  $all_markers);
            }
            // echo ('imuktestingstring3_'.count($all_markers));
        }

        /* This search code allows performs a search for practices based on the search conditions provided.
        $all_practices = get_posts(
            array(
                "post_type" => "practices",
                "posts_per_page" => -1,
                "orderby" => "title",
                "order"=>"ASC",
                "post_status" => "published"
            )
        );

        foreach($all_practices as $practice){
            $practice_location = array(
                "latitude" => get_post_meta($practice->ID, "latitude", true),
                "longitude" => get_post_meta($practice->ID, "longitude", true)
            );

            // Double check the latitude and longitude values to make sure that they are set, if not then simply ignore them
            if($practice_location["latitude"] == "" or $practice_location["longitude"] == ""){
                continue;
            }
            $distance = vincentyGreatCircleDistance(
                $search_point["lat"], $search_location["lng"],
                $practice_location["latitude"], $practice_location["longitude"]
            );

            $post_thumbnail = 'default.svg';
            if(has_post_thumbnail($practice->ID)){
                $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($practice->ID), 'medium' )[0];
            }


            // Check to see if they are searching within a radius, and if so check they are within the radius
            if($radius != '' && $distance >= $radius){
                continue;
            }
            $all_markers[] = array(
                "type" => "practice",
                "name" => $practice->post_title,
                "lat" => $practice_location["latitude"],
                "lng" => $practice_location["longitude"],
                "distance" => $distance,
                "id" => $practice->ID,
                "url" => get_permalink($practice->ID),
                "marker" => markerBuilder(
                    "practice",
                    get_permalink($practice->ID),
                    $practice->post_title,
                    $distance,
                    $post_thumbnail
                )
            );
        }
        */

        usort($all_markers, "distance_sort");
        return $all_markers;
    }

    /**
    *Midwife marker for map
    **/
    function markerBuilder($type, $url, $name, $distance, $avatar, $id) {
        $str = ("<div style='width: 251px'>");
            $str .= ("<a style='color: #5fcbd2;' href='".$url."'>");
                $str .= "<div style='display: block; float: left; height: 80px; width: 103px; background-color: #999; margin-right: 6px; margin-top: 4px; margin-bottom: 4px; background-size: cover; background-position: center center; background-image:url(".$avatar['url'].")' class='thumbnail default ".$avatar['type']."'></div>";
                $str .= "<p style='font-family:GTHaptik; font-weight: bold; margin: 0 0 0 113px; font-size: 14px; text-transform: uppercase;'>".$name."</p>";
                $str .= "<p style='font-family:GTHaptik; font-weight: normal; margin: 0 0 0 113px; font-size: 14px; text-transform: uppercase;'>".$distance." Miles Away</p>";
            $str.= ("</a>");
        $str.= ("</div>");
        return $str;
    }


	function google_geoencode($address){
        // $google_api_key = 'AIzaSyBdUua-jce9HcnHaygqJ__dmzIRoQCKTmo';
        $google_api_key = 'AIzaSyB9qSi9lZhVvBXCGjWwWwMwDVaOlhfAELI';
        $base_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
        $address= str_replace(' ', '+', $address);

        $url = $base_url.$address.'&key='.$google_api_key;
        if($results = @file_get_contents($url)){
            //convert the json file to PHP array
            $response = json_decode($results, true);
            //If the user entered address matched a Google Maps API address, it will return 'OK' in the status field.
            if($response["status"] == "OK"){
                //If okay, find the lat and lng values and assign them to local array
                $latLng = array(
                    "lat"=>$response["results"][0]["geometry"]["location"]["lat"],
                    "lng" =>$response["results"][0]["geometry"]["location"]["lng"]
                );
                return $latLng;
            
            // } else { printr( $response );
            }
        }
        return NULL;
    }

    function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return round(($miles * 1.609344), 2);
        } else if ($unit == "N") {
            return round(($miles * 0.8684), 2);
        } else {
            return round($miles, 2);
        }
    }

    function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        $ratio = 0.621371192;

        return round( ((($angle * $earthRadius)/1000) * $ratio), 2);
    }

    function initialize_theme_settings(){

        //If you change the capabilitie for the two midwife roles, then you will need to uncomment the lines below for the new capabilities to appear
        remove_role('Basic');
        remove_role('Midwife');
        remove_role('Midwife+');

//TODO: Need to define the capabilities for these two roles to make sure they can get to the parts they need
        $capabilities = array(
            'read' => true,
        );

        // This will be the standard role for paid midwives.
        add_role(
            'Midwife',
            __('Midwife'),
            $capabilities
        );

        // The 'Midwife+' role will be used to indicate the midwives that should also be able to author new content on the site
        add_role(
            'Midwife+',
            __('Midwife+'),
            $capabilities
        );

        add_role(
            'Basic',
            __('Basic'),
            $capabilities
        );
    }
    add_action('load-themes.php', 'initialize_theme_settings');


    

    include_once('taxonomy_region.php');
    include_once('taxonomy_specialism.php');
    include_once('type_user.php');
    
    include_once('shortcodes.php');


    function getThumbnail($id, $is_profile) {
        $thumbnail['type'] = 'custom';
        if ($is_profile) {
            $thumbnail['url'] = get_cupp_meta($id, 'full');
        }
        else {
            $test = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            $thumbnail['url'] = $test[0];
        }

        if ($thumbnail['url'] == '' ){
            $mod = $id % 12;
            if ($mod < 1) $mod = 1;
            $thumbnail['type'] = 'default type_'.$mod;
            $thumbnail['url'] = '';
        }
        return $thumbnail;
    }

<?php

    /**
    * This file contains all the taxonomy setting for the region taxonomy which we will be using in the theme.
    */


    /**
    * Function: taxonomy_create_region
    *
    **/
    function taxonomy_create_region(){
        register_taxonomy(
            'region',
            'user',
            array(
                'public' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'show_in_nav_menus' => false,
                'hierarchical' => true,
                'labels' => array(
                    'name' => __('Region' ),
                    'singular_name' => __('Region'),
                    'menu_name' => __('Regions'),
                    'search_items' => __('Search Regions'),
                    'popular_items' => __('Popular Regions'),
                    'all_items' => __('All Regions'),
                    'edit_item' => __('Edit Region'),
                    'update_item' => __('Update Region'),
                    'add_new_item' => __('Add New Region'),
                    'new_item_name' => __('New Region Name'),
                    'separate_items_with_commas' => __('Separate regions with commas'),
                    'add_or_remove_items' => __('Add or remove regions'),
                    'choose_from_most_used' => __('Choose from the most popular regions'),
                ),
                'capabilities' => array(
                    'manage_terms' => 'edit_users',
                    'edit_terms'   => 'edit_users',
                    'delete_terms' => 'edit_users',
                    'assign_terms' => 'read',
                ),
                'rewrite' => array(
                    'with_front' => true,
                    'slug' => 'author/region'
                )
            )
        );
    }

    /**
    * Function: taxonomy_page_region
    *
    **/
    function taxonomy_page_region(){
        $taxonomy = get_taxonomy('region');
        add_users_page(
            esc_attr( $taxonomy->labels->menu_name ),
            esc_attr( $taxonomy->labels->menu_name ),
            $taxonomy->cap->manage_terms,
            'edit-tags.php?taxonomy=' . $taxonomy->name
        );
    }




    add_action('init', 'taxonomy_create_region');
    add_action('admin_menu', 'taxonomy_page_region');
?>
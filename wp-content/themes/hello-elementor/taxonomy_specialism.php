<?php

    /**
    * The following function is used to define the specalism taxonomy that users will use to define their skill set
    **/
    function create_taxonomy_specialism(){
        register_taxonomy(
            'specialism',
            'user',
            array(
                'public'=>true,
                'labels' => array(
                    'name' => __('Specialism' ),
                    'singular_name' => __('Specialism'),
                    'menu_name' => __('Specialisms'),
                    'search_items' => __('Search Specialisms'),
                    'popular_items' => __('Popular Specialisms'),
                    'all_items' => __('All Specialisms'),
                    'edit_item' => __('Edit Specialism'),
                    'update_item' => __('Update Specialism'),
                    'add_new_item' => __('Add New Specialism'),
                    'new_item_name' => __('New Specialism Name'),
                    'separate_items_with_commas' => __('Separate specialisms with commas'),
                    'add_or_remove_items' => __('Add or remove specialisms'),
                    'choose_from_most_used' => __('Choose from the most popular specialisms'),
                ),
//TODO: Might need to revisit these permissions, not sure assign_terms should be read
                'capabilities' => array(
                    'manage_terms' => 'edit_users',
                    'edit_terms'   => 'edit_users',
                    'delete_terms' => 'edit_users',
                    'assign_terms' => 'read',
                ),
                'rewrite' => array(
                    'with_front' => true,
                    'slug' => 'author/specialism' //Using 'author' (default WP user slug).
                )
                //'update_count_callback' => 'taxonomy_count_callback',
            )
        );
    }

    /**
     * Creates the admin page for the 'profession' taxonomy under the 'Users' menu.  It works the same as any
     * other taxonomy page in the admin.  However, this is kind of hacky and is meant as a quick solution.  When
     * clicking on the menu item in the admin, WordPress' menu system thinks you're viewing something under 'Posts'
     * instead of 'Users'.  We really need WP core support for this.
     */
    function my_add_profession_admin_page() {

        $tax = get_taxonomy('specialism');
        add_users_page(
            esc_attr( $tax->labels->menu_name ),
            esc_attr( $tax->labels->menu_name ),
            $tax->cap->manage_terms,
            'edit-tags.php?taxonomy=' . $tax->name
        );
    }
    /* Adds the taxonomy page in the admin. */


    add_action('init', 'create_taxonomy_specialism');
    add_action('admin_menu', 'my_add_profession_admin_page' );
?>
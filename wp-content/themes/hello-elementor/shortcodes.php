<?php

    /**
     * Function: cell_css_width
     * This function converts a numeric cell width value into the appropriate CSS class name for the cell to span the
     * appropriate width within the layout.
     *
     * @param $width_number
     * @return string
     */
    function cell_css_width($width_number){
        switch($width_number){
            case 3:
            case '3':
                return 'width_3';
            case 2:
            case '2':
                return 'width_2';
            default:
                return 'width_1';
        }
    }

    /**
     * Function: cell_css_height
     * This function converts a numeric cell height value into the appropriate CSS class name for the cell to span the
     * appropriate height within the layout.
     *
     * @param $height_number
     * @return string
     */
    function cell_css_height($height_number){
        switch($height_number){
            case 3:
            case '3':
                return 'height_3';
            case 2:
            case '2':
                return 'height_2';
            default:
                return 'height_1';
        }
    }
    
    function image_tags($source_image) {
        if ($source_image == '') {
            $id = get_the_ID();
            $mod = $id % 12;
            if ($mod < 1) $mod = 1;
            $image['classes'] = 'default type_'.$mod;
            $image['styles'] = '';
        }
        else {
            $image['classes'] = 'custom';
            $image['styles'] = 'style="background-image: url('.$source_image.')"';
        }
        return $image;
    }

    function cell_html_structure($cell_classes, $image_url, $link, $html_content){
        $image_tags = image_tags($image_url);
        $image_classes = $image_tags['classes'];
        $image_styles = $image_tags['styles'];
        return  '<div class="'.$cell_classes.'">'
                . '    <div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                . '        <a href="'.$link.'">&nbsp;</a>'
                . '    </div>'
                . '    <div class="caption">'
                . '        <a href="'.$link.'">'
                . '            '.$html_content
                . '        </a>'
                . '    </div>'
                . '</div>';
    }


    /*
     * Function: cell_group
     * This function will be tied to the shortcode tag that will allow the editor to group a number of content elements
     * together.  The CSS styling will then take care to make sure all the elements are the same size.
     *
     * @param $attr
     * @param null $content
     * @return string
     */
    function cell_group($attr, $content=null){
        $html = '<div class="cell_group">'.do_shortcode($content).'</div>';
        return $html;
    }

    /**
     * Function: blockquote
     * This function generates the actual HTML elements required for the stylised blockquotes for the theme.  The
     * shortcode takes in the quote text and the who the quote is from and then renders the appropriate HTML.
     *
     * @param $attr - associative array containing the 'quote' and 'who' keys and relevant values to render
     * @param null $content - ignored
     * @return string
     */
    function blockquote($attr, $content=null){
        $attr = shortcode_atts(
            array(
                'quote' => '&nbsp;',
                'who' => '&nbsp;',
            ),
            $attr
        );
        return '<blockquote>'
                .'<p>'.$attr['quote'].'</p>'
                .'<p style="text-align: right;">'.$attr['who'].'</p>'
                .'</blockquote>';
    }

    /**
     * Function: cell
     * This function generates a basic cell element and all the required HTML code for the site's custom grid layout
     * within the content area editors.  This particular function is tied to a shortcode function to make it easier for
     * them to function is tied to a shortcode to make it easier for the user's to update and managed the site's content.
     * @param $attr
     * @param null $content
     * @return string
     */
    function cell($attr, $content=null){
        $attr = shortcode_atts(
            array(
                'audience' => 'everyone',
                'width' => 1,
                'height' => 1,
                'css' => '',
                'target' => '_top'
            ),
            $attr
        );
        
        // Determine the CSS class string that will be needed for the cell in question
        $css_classes = 'cell '.cell_css_width($attr['width']).' '.cell_css_height($attr['height']).' '.$attr['audience'].' '.$attr['css'];
        return '<div class="'.$css_classes.'">'
                .'    '.do_shortcode($content)
                .'</div>';
    }


    function content_cell($attr, $content=null){

        $attr = shortcode_atts(
            array(
                'audience' => 'everyone',
                'width' => 1,
                'height' => 1,
                'link' => '',
                'image' => '',
                'small_title' => '&nbsp;',
                'large_title' => '&nbsp;',
                'css' => '',
                'target' => '_top'
            ),
            $attr
        );
        $image_tags = image_tags($attr['image']);
        $image_classes = $image_tags['classes'];
        $image_styles = $image_tags['styles'];
        $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                .'    &nbsp;'
                .'</div>'
                .'<div class="caption">'
                .'<div class="no_link">'
                .'<h4>' . $attr['small_title'] . '</h4>'
                .'<h3>' . $attr['large_title'] . '</h3>'
                .'</div>'
                .'</div>';

        if($attr['link'] != '') {
            $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                    .'    <a href="'.$attr['link'].'" target="'.$attr['target'].'">&nbsp;</a>'
                    .'</div>'
                    .'<div class="caption">'
                    .'<a href="' . $attr['link'] . '" target="'.$attr['target'].'">'
                    .'    <h4>' . $attr['small_title'] . '</h4>'
                    .'    <h3>' . $attr['large_title'] . '</h3>'
                    .'</a>'
                    .'</div>';
        }

        return cell($attr, $html);
    }

    function simple_cell($attr, $content=null){
        $attr = shortcode_atts(
            array(
                'audience' => 'everyone',
                'width' => 1,
                'height' => 1,
                'link' => '',
                'image' => '',
                'text' => '&nbsp;',
                'css' => '',
                'target' => '_top'
            ),
            $attr
        );
        $image_tags = image_tags($attr['image']);
        $image_classes = $image_tags['classes'];
        $image_styles = $image_tags['styles'];
        $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                .'    &nbsp;'
                .'</div>'
                .'<div class="caption">'
                .'<div class="no_link">'
                .'<p>'.$attr['text'].'</p>'
                .'</div>'
                .'</div>';

        if($attr['link'] != ''){
            $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                    .'    <a href="'.$attr['link'].'" target="'.$attr['target'].'">&nbsp;</a>'
                    .'</div>'
                    .'<div class="caption">'
                    .'<a href="'.$attr['link'].'" target="'.$attr['target'].'">'
                    .'    <p>'.$attr['text'].'</p>'
                    .'</a>'
                    .'</div>';
        }

        return cell($attr, $html);
    }
    /**
     * Function: latest_blog
     * This function will be tied to the shortcode tag that allows an editor to insert a link to the latest blog post.
     * The contents of the tag will be used to populate the text that appears beneath the
     * @param $attr
     * @param content $
     * @return string
     */
    function latest_blog($attr, $content=null){
        $attr = shortcode_atts(
            array(
                'audience' => 'everyone',
                'width' => 1,
                'height' => 2,
                'css' => '',
                'target' => '_top'
            ),
            $attr
        );

        $args = array(
            "post_type" => "post",
            "post_per_page" => 1
        );

        $my_query = new WP_Query($args);

        if(!$my_query->have_posts()){
            return '';
        }

        $my_query->the_post();

        $attr['audience'] = 'latest_blog';

        $ID = get_the_ID();
        $image_classes = 'default';
        $image_styles = '';
        if(has_post_thumbnail($ID)){
            $test = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full');
            $image_tags = image_tags($test[0]);
            $image_classes = $image_tags['classes'];
            $image_styles = $image_tags['styles'];
        }

        $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
                .'    <a href="'.get_permalink().'" target="'.$attr['target'].'">&nbsp;</a>'
                .'</div>'
                .'<div class="caption">'
                .'    <a href="'.get_permalink().'" target="'.$attr['target'].'">'
                .'        <h4 class="post-title hidden-sm">'.get_the_title().'</h4>'
                .'        <div class="hidden-sm">'
                .'            '.apply_filters('the_content', get_the_excerpt())
                .'        </div>'
                .'        <div class="align-bottom">'
                .'            <h4>Latest from IMUK</h4>'
                .'            <h3>Check out our blog</h3>'
                .'        </div>'
                .'    </a>'
                .'</div>';

        return cell($attr, $html);
    }

    function featured_birth_story($attr, $content=null){
        $attr = shortcode_atts(
            array(
                'audience' => 'families',
                'width' => 2,
                'height' => 2,
                'small_title' => null,
                'css' => '',
                'target' => '_top'
            ),
            $attr
        );

        $my_query = get_featured_story();

        if(!$my_query->have_posts()){
            return '';
        }

        $my_query->the_post();
        $ID = get_the_ID();
        $image_classes = 'default';
        $image_styles = '';
        if(has_post_thumbnail($ID)){
            $test = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full');
            $image_tags = image_tags($test[0]);
            $image_classes = $image_tags['classes'];
            $image_styles = $image_tags['styles'];
        }


        $small_title = $attr['small_title'];
        if($small_title == null || $small_title == ''){
            $small_title = get_post_meta($ID, 'subtitle', true);
            if($small_title == null || $small_title == ''){
                $small_title = '&nbsp;';
            }
        }
        $html =  '<div class="cell_image '.$image_classes.'" '.$image_styles.'>'
        //$html = '<div class="cell_image '.$thumbnail['type'].'" style="background-image: url('.$thumbnail['url'].')">'
                .'    <a href="'.get_permalink().'" target="'.$attr['target'].'">&nbsp;</a>'
                .'</div>'
                .'<div class="caption">'
                .'<a href="'.get_permalink().'" target="'.$attr['target'].'">'
                .'    <h4>'.$small_title.'</h4>'
                .'    <h3>'.get_the_title().'</h3>'
                .'</a>'
                .'</div>';

        return cell($attr, $html);
    }

    add_shortcode('cell_group', 'cell_group');


    function gallery_container($attr, $content=null){
        $html = '<div class="no_cap">'
              . do_shortcode($content)
              . '<div class="clear"></div>'
              . '</div>';
        return $html;
    }
    
    function stats_group_container($attr, $content=null){
        $html = '<div id="results" class="image_view">'
              . do_shortcode($content)
              . '<div class="clear"></div>'
              . '</div>';
        return $html;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // TinyMCE controls
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function my_add_mce_button(){
        // check user permissions
        if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
            return;
        }
        // check if WYSIWYG is enabled
        if ( 'true' == get_user_option( 'rich_editing' ) ) {
            add_filter( 'mce_external_plugins', 'my_add_tinymce_plugin' );
            add_filter( 'mce_buttons', 'my_register_mce_button' );
        }
    }
    add_action('admin_head', 'my_add_mce_button');

    // Declare script for new button
    function my_add_tinymce_plugin( $plugin_array ) {
        $plugin_array['my_mce_button'] = get_template_directory_uri() .'/js/mce-button.js';
        return $plugin_array;
    }

    // Register new button in the editor
    function my_register_mce_button( $buttons ) {
        array_push( $buttons, 'my_mce_button' );
        return $buttons;
    }

    // Create a mapping for 'styled_quote' which will call the blockquote function.
    add_shortcode('styled_quote', 'blockquote');

    // Create a mapping for 'cell' which will call the cell function.
    add_shortcode('cell', 'cell');

    // Create a mapping for 'content_cell' which will call the content_cell function
    add_shortcode('content_cell', 'content_cell');

    add_shortcode('simple_cell', 'simple_cell');
    add_shortcode('image_cell', 'simple_cell');

    add_shortcode('latest_blog', 'latest_blog');

    add_shortcode('featured_birth_story', 'featured_birth_story');
    
    add_shortcode('gallery_container', 'gallery_container');
    add_shortcode('stats_group_container', 'stats_group_container');
?>

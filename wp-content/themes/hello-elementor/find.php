<?php
/*
Template Name: Find a wife
*/
require_once FINDAMIDWI_PLUGIN_DIR . 'core/class-findamidwife.php';
get_header();?>





<div id="bd">
    <div id="find_a_midwife">
       <?php echo do_shortcode('[showMap]'); ?>

    </div>
</div>

<?php 
get_footer();
?>
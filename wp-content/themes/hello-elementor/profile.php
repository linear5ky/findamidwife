<div id="bd" class="cookies  profile">
<div id="profile" class="container">
    <div class="row">
        <div class="col hidden-sm col-md-6 col-lg-8">
            <p class="handwritten"><?php echo $title; ?></p>
            <?php echo $bio; ?>
        </div>
        <div id="sidebar" class="col col-sm-4 col-md-3 col-lg-4">
            <div class="thumbnail <?php echo($avatar['type']); ?>" style="background-image: url('<?php echo $avatar['url']; ?>')">
                &nbsp;
            </div>
            <?php if ($personal_site != '') { ?>
                <a class="btn" href="<?php echo $personal_site; ?>" target="_blank">
                    View Personal Site
                </a>
            <?php } ?>
            <ul class="hidden-sm">
                <?php if ($location != '') { ?>
                    <li>
                        <h4>Location</h4>
                        <p><?php echo $location; ?></p>
                    </li>
                <?php } ?>
                <?php if ($practice != '' && $practice != 'Profile') { ?>
                    <li>
                        <h4>Practice</h4>
                        <p><?php echo $practice; ?></p>
                    </li>
                <?php } ?>
                <?php if ($profile_type == "Practice" && $midwives != '') { ?>
                    <li>
                        <h4>Midwives</h4>
                        <p>
                            <?php
                                foreach ($midwives as $midwife) {
                                    echo '<a href="'.get_bloginfo('url').'/midwife/'.$midwife->nickname.'">'.$midwife->first_name.' '.$midwife->last_name.'</a><br />';
                                }
                            ?>
                        </p>
                    </li>
                <?php } ?>
                <?php if ($phone != '') { ?>
                    <li>
                        <h4>Telephone</h4>
                        <p>
                            <?php echo $phone; ?><br />
                        </p>
                    </li>
                <?php } ?>
                <?php if ($email != '') { ?>
                    <li>
                        <h4>Email</h4>
                        <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                    </li>
                <?php } ?>
                <?php
                    if ($profile_type == 'Midwife') {
                        foreach ($taxonomies as $taxonomy) {
                            $terms = wp_get_object_terms($midwife->ID, $taxonomy);
                            if (!empty($terms)) {
                                echo('<li class="tax_list">');
                                echo('<h4>'.$taxonomy.'s</h4>');
                                echo('<p>');
                                foreach( $terms as $key => $term ) {
                                    echo ($term->name.'<br />');
                                }
                                echo('</p>');
                                echo('</li>');
                            }
                        }
                    }
                ?>
                <?php if ($profile_type == "Practice" && $specialisms != '') { ?>
                    <li class="tax_list">
                        <h4>Specialisms</h4>
                        <p>
                            <?php
                                foreach ($specialisms as $specialism) {
                                    echo $specialism.'<br />';
                                }
                            ?>
                        </p>
                    </li>
                <?php } ?>
                <?php if ($social != '') { ?>
                    <li>
                        <h4>More From <?php echo($title) ?></h4>
                        <p class="capitalize"><?php echo $social; ?></p>
                    </li>
                <?php } ?>
            </ul>
            <div class="visible-sm">
                <a class="btn mobile_expander_trigger" href="#">
                    <span>Show</span> <?php echo $profile_type ?> Details
                </a>
            </div>
        </div>
        <div class="col col-md-6 col-lg-8 mobile_bio visible-sm">
            <p class="handwritten"><?php echo $title; ?></p>
            <?php echo $bio; ?>
        </div>
    </div>
</div>
                </div>
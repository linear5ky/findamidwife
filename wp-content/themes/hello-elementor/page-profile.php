<?php 
    /*
    Template Name: Midwife Profile
    */
    $midwife = get_user_by('login', $_GET['midwife']);
    $midwife_meta = get_the_author_meta($midwife->ID);
    
    get_header();

    $profile_type = 'Midwife';
    $title = $midwife->first_name.' '.$midwife->last_name;
    $bio = apply_filters('the_content', get_the_author_meta('approved_bio', $midwife->ID));;
    $town = get_the_author_meta('town', $midwife->ID);
    $county = get_the_author_meta('county', $midwife->ID);
    $practice = get_the_title(get_the_author_meta('practice', $midwife->ID));
    $practice_url = get_permalink(get_the_author_meta('practice', $midwife->ID));
    $home_phone = get_the_author_meta('home_phone', $midwife->ID);
    $work_phone = get_the_author_meta('work_phone', $midwife->ID);
    $mobile_phone = get_the_author_meta('mobile_phone', $midwife->ID);
    $email = get_the_author_meta('email', $midwife->ID);
    $personal_site = get_the_author_meta('user_url', $midwife->ID);
    $taxonomies = array('specialism', 'region');
    $blog = get_the_author_meta('blog', $midwife->ID);
    $facebook = get_the_author_meta('facebook', $midwife->ID);
    $twitter = get_the_author_meta('twitter', $midwife->ID);
    $linkedin = get_the_author_meta('linkedin', $midwife->ID);
    $googleplus = get_the_author_meta('googleplus', $midwife->ID);
    $avatar = getThumbnail($midwife->ID, true);
    
    $location = $town;
    if ($county != '') {
        $location = $location.', '.$county;
    }
    
    $phone = '';
    $phones = array($home_phone, $work_phone, $mobile_phone);
    $count = 1;
    foreach ($phones as $this_phone) {
        if ($this_phone != '') {
            if ($count > 1) {
                $phone .= ('<br />');
            }
            $phone .= $this_phone;
            $count ++;
        }
    }
    
    $social = '';
    $socials = array(
        'blog'=>$blog,
        'twitter'=>$twitter,
        'facebook'=>$facebook,
        'linkedin'=>$linkedin,
        'google+'=>$googleplus
    );
    $count = 1;
    foreach ($socials as $this_network => $this_social) {
        if ($this_social != '') {
            if ($count > 1) {
                $social .= ('<br />');
            }
            if (strpos($this_social,'http') == false) {
                $this_social = 'http://'.$this_social;
            }
            $social .= '<a href="'.$this_social.'" target="_blank">'.$this_network.'</a>';
            $count ++;
        }
    }

    include('profile.php');

    get_footer(); 
?>

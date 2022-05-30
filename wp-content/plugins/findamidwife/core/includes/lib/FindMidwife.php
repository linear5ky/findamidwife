<?php 

class FindMidwife  {

    public static function showMap() { ?>


        <?php    $search_location = array("postcode"=>NULL, "latitude"=>NULL, "longitude"=>NULL);
            $midwife_name = '';
            $practice_name = '';
            $specialism = -1;
            $region = -1;
            $radius = 60;


            if(isset($_POST['radius'])){
                $radius = $_POST['radius'];
            }

            // If the user has submitted the form and the postcode value is set then override the current value for $search_location
            if(isset($_POST['postcode']) && $_POST['postcode'] != ''){
                $search_location["postcode"] = $_POST['postcode'];
                if (!(strstr($search_location["postcode"], ', UK'))) {
                    $search_location["postcode"] .= ', UK';
                }
                $search_location["latitude"] = NULL;
                $search_location["longitude"] = NULL;
            }

            if(isset($_POST['midwife']) && $_POST['midwife'] != ''){
                $midwife_name = $_POST['midwife'];
                $radius = '';
            }

            if(isset($_POST['practice']) && $_POST['practice'] != ''){
                $practice_name = $_POST['practice'];
                $radius = '';
            }

            if(isset($_POST['specialism']) && $_POST['specialism'] != -1){
                $specialism = $_POST['specialism'];
            }

            if(isset($_POST['region']) && $_POST['region'] != -1){
                $region = $_POST['region'];
                $radius = '';
            }

            $midwives = array();

            if($search_location["postcode"] != ''){
                $midwives = midwife_search($search_location, $midwife_name, $practice_name, $specialism, $region, $radius);

                if(is_null($search_location["latitude"]) || is_null($search_location["longitude"])){
                    $search_point = google_geoencode(str_replace(' ', '+', $search_point["postcode"]));
                }
                else{
                    $search_point["lat"] = $search_location["latitude"];
                    $search_point["lng"] = $search_location["longitude"];
                }
            }
            else{
                $search_location["postcode"] = "";
            }?>

        <div id="find_a_midwife" class="container">
        <div class="row">
            
            <div id="map_hole" class="col col-sm-4 col-md-6 col-lg-8 <?php if (!(isset($_POST["postcode"]))) echo 'hidden-sm'; ?>">
                <div id="close_map">
                    You are near<br /><div class="you_are_near"><?php echo($_POST['postcode']) ?></div>
                </div>
                <div id="map_holder" class="minimized">
                    <div id="map">
                        Map
                    </div>
                </div>
            </div>
            <div id="form" class="col col-sm-4 col-md-3 col-lg-4 <?php if ((isset($_POST["postcode"]))) echo 'hidden-sm'; ?>">
                <form method="post" action="">
                    <h4 class="margin0">Find a midwife<span class="hidden-md"> in your area</span></h4>
                    <h2>Search Options</h2>
                    <label for="postcode">
                        <h4>Location</h4>
                    </label>
                    <input type="text" name="postcode" value="<?php echo $search_location["postcode"];?>" placeholder="Your Location" />
                    <label for="distance">
                        <h4>Distance</h4>
                    </label>
                    <select name="radius">
                        <?php
                            for ($i = 1; $i < 10; $i++) {
                                $miles = $i * 15;
                                if($miles != $radius){
                                    echo('<option value="'.$miles.'">'.$miles.' Mile Radius</option>');
                                }
                                else{
                                    echo('<option value="'.$miles.'" selected>'.$miles.' Mile Radius</option>');
                                }
                            }
                        ?>
                        <option value="" <?php if($radius==''){ echo "selected";}?>>Nationwide</option>
                    </select>
                    <label for="midwife">
                        <h4>Midwife Name</h4>
                    </label>
                    <input type="text" name="midwife" value="<?php echo $midwife_name;?>" placeholder="Midwife Name" />
<!--                    <label for="practice">
                        <h4>Practice name</h4>
                    </label>
                    <input type="text" name="practice" value="<?php echo $practice_name;?>" placeholder="Practice Name" />
                    -->
                    <h2 class="margin_top20">Advanced<br />Search Options</h2>
                    <label for="specialism">
                        <h4>Specialisms</h4>
                    </label>
                    <?php wp_dropdown_categories('show_option_none=Please select...&hide_empty=0&show_count=0&orderby=name&echo=1&taxonomy=specialism&name=specialism&selected='.$specialism); ?>
                    <label for="region">
                        <h4>Region</h4>
                    </label>
                    <?php wp_dropdown_categories('show_option_none=Please select...&hide_empty=0&show_count=0&orderby=name&echo=1&taxonomy=region&name=region&selected='.$region); ?>
                    <input type="submit" name="" value="Find a Midwife" />
                </form>
            </div>
            <?php 
                if (isset($_POST["postcode"])) {
            ?>
                <div class="visible-sm col col-sm-4">
                    <a class="btn mobile_expander_trigger disappears" href="#">
                        Change Search Criteria
                    </a>
                </div>
            <?php
                }
            ?>
        </div>

        <?php
            if(isset($_POST["postcode"])){
            ?>
            <div class="row">
                <div id="toggles" class="col col-sm-4 col-md-9 col-lg-12">
                    <span class="list_view" data-view="list">List View</span> | <span class="image_view active" data-view="image">Image View</span>
                </div>
                <div class="clear"></div>
            </div>
            <?php
                if ( ! empty( $midwives ) ) {
                    echo ('<div id="results" class="image_view">');
                        $count = 0;
                        foreach ( $midwives as $midwife ) {
                            if ($count % 3 == 0) {
                                echo('<div class="row">');
                            }
                            $count ++;
                            $thumbnail = getThumbnail($midwife['id'], true);
                            $small_title = '&nbsp;';
                            $shortcode = '[content_cell audience="everyone" image="'.$thumbnail['url'].'" link="'.$midwife["url"].'" small_title="'.$midwife["distance"].' miles away" large_title="'.$midwife["name"].'"]';
                            echo do_shortcode($shortcode);
                            if ($count % 3 == 0) {
                                echo('<!--full row-->');
                                echo('</div>');
                            }
                        }
                        if ($count % 3 != 0) {
                            echo('<!--partial row-->');
                            echo('</div>');
                        }
                    echo ('</div>');
                } else {
                    echo ('<div class="col col-sm-4 col-md-9 col-lg-12"><h1 class="no_side_margin">No midwives found.</h1></div>');
                }
            }
        ?>
        
        <div class="row">
            <div class="col col-sm-4 col-md-9 col-lg-12">
                <?php 
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                ?>
            </div>
        </div>
    </div>

    <?php
        if(!isset($_POST['postcode'])){
            ?>
    <script type="text/javascript">
        navigator.geolocation.getCurrentPosition(locationSuccess, locationFail);
            function locationSuccess(position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode( {'latLng':new google.maps.LatLng(latitude, longitude)}, function(results, status){

                    if (status == google.maps.GeocoderStatus.OK) {

                        if (results[1]) {
                            jQuery("input[name=postcode]").val(results[1].address_components[0].long_name);
                            loadMap(latitude, longitude, true);
                        }
                    }
                });
            }
            function locationFail() {
                //loadMap(55.3617609, -3.4433238, false);
            }
    </script>
            <?php
        }
    ?>
    
    <script type="text/javascript">
        function loadMap(latitude, longitude, me_pin) {
            var infowindow = new google.maps.InfoWindow()
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: new google.maps.LatLng(latitude, longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var markerBounds = new google.maps.LatLngBounds();

            if(me_pin){
                var MyPosition = new google.maps.LatLng(latitude, longitude);
                var marker = new google.maps.Marker({
                    position: MyPosition,
                    map: map,
                    icon: "<?php echo get_bloginfo('template_url')."/images/marker_you.svg"; ?>"
                });
                markerBounds.extend(MyPosition); // you call this method for each Position (LatLng object)
                map.setZoom(9);
            }
            
            <?php
                foreach($midwives as $midwife){
                
                    $image = get_bloginfo('template_url')."/images/marker_midwife.svg";
                  
                    ?>
                    var Position = new google.maps.LatLng(<?php echo $midwife['lat'];?>, <?php echo $midwife['lng'];?>);
                    var marker = new google.maps.Marker({
                        position: Position,
                        map: map,
                        title: "<?php echo $midwife['name'];?>",
                        icon: "<?php echo $image;?>"
                    });
                   
                    markerBounds.extend(Position); // you call this method for each Position (LatLng object)
                 
                    google.maps.event.addListener(marker, 'click', function() {
                       infowindow.setContent("<?php echo $midwife["marker"];?>");
                       infowindow.open(map, this);
                    });
                    <?php
                }
            ?>
            
            //if there is at least 1 result, zoom out to encompass all pins. Otherwise, stay at a decent zoom level
            if (<?php echo count($midwives) ?> > 0) {
                map.fitBounds(markerBounds);
            }
            
            google.maps.event.addListener(map, "mousedown", function() { 
                infowindow.close();  
            }); 
        }
        
        var theLocation = [];
        theLocation['lat'] = 55.3617609;
        theLocation['lng'] = -3.4433238;
        
        <?php
        
            if(isset($search_point)){
                
                ?>
                theLocation['lat'] = <?php echo $search_point['lat'];?>;
                theLocation['lng'] = <?php echo $search_point['lng'];?>;
                loadMap(theLocation['lat'], theLocation['lng'], true);
                <?php
            }
            else{
                ?>
                loadMap(theLocation['lat'], theLocation['lng'], false);
                <?php
            }
            
        ?>
     </script>

<?php }

}
<?php
/*
Plugin Name: Really Simple Maps
Description: The easiest way to include your own google map!.
Plugin URI: http://wordpress.org/extend/plugins/really-simple-maps
Author: Stavros Kainich
Version: 1.0
Author URI: http://gr.linkedin.com/pub/stavros-kainich/71/ba9/308

*/
function SimpleMaps($atts){

extract( shortcode_atts( array(

'zoom'=>"14",
'address'=>"Athens",
'companyname'=>"MyCompanyName",
'imagesrc'=>plugins_url( '' , __FILE__ )."/MyImage.png",
'description'=>"A short description",
'height'=>'500px',
'width'=>'500px',
'key'=>'AIzaSyCoZlZpmHk64DguKRD_nv6BuXEou8DCbYw'


), $atts));

 $description='<div style="min-height:150px; min-width:100px;"><img src="'.$imagesrc.'"><h2>'.$companyname.'</h2><b><i>'.$address.'</i></b></div>';
return "
    <script src='http://maps.google.com/maps?file=api&amp;v=2&amp;key='$key' type='text/javascript'></script>
   
   <div id='map_canvas' style='width: $width; height: $height'></div>

	<script type='text/javascript'>

    var map = null;
    var geocoder = null;

   
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById('map_canvas'));
        //map.setCenter(new GLatLng(37.9837155, 23.72930969999993),10);
        
        geocoder = new GClientGeocoder();
      }
    

    
      if (geocoder) {
        geocoder.getLatLng(
          '$address',
          function(point) {
            if (!point) {
              alert(address + ' not found');
            } else {
              map.setCenter(point,$zoom);
              var marker = new GMarker(point, {title:'$companyname'});
              map.addOverlay(marker);
              
              GEvent.addListener(marker, 'click', function() {
                marker.openInfoWindowHtml('$description');
              });
	      GEvent.trigger(marker, 'click');
            }
          }
        );
      }
    
    </script>
";

}

add_shortcode('Simple Maps', 'SimpleMaps' );
?>
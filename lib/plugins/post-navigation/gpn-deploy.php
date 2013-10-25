<?php
function gpn_custom_css() {
	// design settings array
	$gpn_design	= get_option('gpn-settings');
	$gpn_bg	= $gpn_design['gpn_bg'];
	$gpn_bg_hover	= $gpn_design['gpn_bg_hover'];
	$text_color	= $gpn_design['text_color'];
	$text_hover	= $gpn_design['text_hover'];
    $cat_exclude = $gpn_design['gpn_cat_exclude'];


// Stores CSS in a string and hooks it in head tag
$gpn_css = "
#after-post-nav {
	height:45px;
	margin:30px;
	display:inline-block;
	}

.gps-nav-next{
	background: none repeat scroll 0 0 ".$gpn_bg.";
    border-radius:  0 30px 30px 0;
   -webkit-border-radius:  0 30px 30px 0;
   -moz-border-radius:  0 30px 30px 0;
   -o-border-radius:  0 30px 30px 0;
    padding: 10px;
    float: right;
    margin: 5px 20px 0 5px;
	display : block;
	cursor : pointer;
	}

.gps-nav-prev{

	 background: none repeat scroll 0 0 ".$gpn_bg.";
	 border-radius:30px 0 0 30px;
	 -moz-border-radius:30px 0 0 30px;
	 -webkit-border-radius:30px 0 0 30px;
	 -o-border-radius:30px 0 0 30px;
	 padding: 10px;
	 float: left;
	 margin: 5px 20px 5px 0;
	 display : block;
	 cursor : pointer;
	 }

.gps-nav-prev a, .gps-nav-next a{
	     display : block;
	     color: ".$text_color." !important;
	     text-decoration: none;}

.gps-nav-next:hover, .gps-nav-prev:hover{

		 background: ".$gpn_bg_hover." ;
		 padding-left:20px;
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		-ms-transition: all 0.5s ease-in-out;}

.gps-nav-prev a:hover{
        color: ".$text_hover." !important;
        padding-left:20px;
       -webkit-transition: all 0.5s ease-in-out;
       -moz-transition: all 0.5s ease-in-out;
       -o-transition: all 0.5s ease-in-out;
       -ms-transition: all 0.5s ease-in-out;}

.gps-nav-next a:hover{

        padding-right:20px;
        color: ".$text_hover." !important;
       -webkit-transition: all 0.5s ease-in-out;
       -moz-transition: all 0.5s ease-in-out;
       -o-transition: all 0.5s ease-in-out;
       -ms-transition: all 0.5s ease-in-out;
        }";



return $gpn_css;

}

add_action('wp_head','gpn_generate_css');

function gpn_generate_css(){
	$gpn_design	= get_option('gpn-settings');
	$gpn_squared_edges = $gpn_design['gpn_squared_edges'];
	if(is_singular()) {
	echo '<style>';
	echo gpn_custom_css();
	//Adds style for Squared edges
	if($gpn_squared_edges == 1){
    echo "
.gps-nav-next, .gps-nav-prev{
	border-radius:  0 ;
	-webkit-border-radius:  0 ;
	-moz-border-radius:  0 ;
	-o-border-radius:  0 ;}";}
	echo '</style>' ;
	}
}

//Adds Post Navigation Below every single post page
add_action( 'machina_entry_footer', 'gpn_after_post' );
add_action('wp_enqueue_scripts', 'gpn_custom_script');

function gpn_custom_script(){
 wp_enqueue_script( 'gpn-custom-script', plugins_url( '/js/gpn_custom_script.js', __FILE__ ), array( 'jquery' ) );
}

function gpn_after_post() {
	$gpn_design	= get_option('gpn-settings');
	$cat_nav = $gpn_design['cat_nav'];
	$postid = get_the_ID();
	$post_cat =  wp_get_post_categories( $postid );
    $exclude = $gpn_design['gpn_cat_exclude'] ? explode( ',', str_replace( ' ', '', $gpn_design['gpn_cat_exclude'] ) ) : '';
	//$result_cat = array_diff($post_cat, $exclude);
   if ( ! is_singular( 'post' ) )
   return;
   if(!in_category($exclude))
   {
	  if ( $cat_nav == "1") {?>
	  <div id="after-post-nav">
	  <span class="gps-nav-prev">
	  <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'gpn') . '</span> %title', true ); ?>
	  </span>
	  <span class="gps-nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'gpn`' ) . '
	  </span>', true ); ?>
	  </span>
      </div><!-- #nav-single -->

      <?php } else {  ?>
      <div id="after-post-nav">
      <span class="gps-nav-prev">
      <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'gpn') . '</span> %title'); ?></span>
      <span class="gps-nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'gpn`' ) . '</span>'); ?>
      </span>
      </div><!-- #nav-single -->
	 <?php }
   }

}


<?php

add_action('wp_head','gsm_generate_css');

function gsm_generate_css(){

	echo '<style>'.  gsm_custom_css()  .'</style>' ;

}


function gsm_custom_css() {

	$gsm_design	= get_option('gsm-settings');

	$gsm_bg	= $gsm_design['gsm_bg'];

	$gsm_bg_hover	= $gsm_design['gsm_bg_hover'];

	$text_color	= $gsm_design['text_color'];

	$text_hover	= $gsm_design['text_hover'];

// Stores CSS in a string and hooks it in head tag

	$gsm_css = "

#subnav {
	background-color: ".$gsm_bg.";
	display: none;
	position: fixed;
	top: 0;
	width: 100%;
	z-index: 100000;
}

#subnav .wrap {
	margin: 0 auto;
	position: relative;
	width: 1152px;
}

#subnav .machina-nav-menu.menu-secondary {
	border: none;
}

.machina-nav-menu.menu-secondary a {
	color: ".$text_color.";
	padding: 20px;
	padding: 1.25rem;
}

.machina-nav-menu.menu-secondary a:hover,
.machina-nav-menu.menu-secondary li a:hover   {
	color: ".$text_hover.";
	background-color: ".$gsm_bg_hover.";
	-moz-transition: all 1s ease-in-out;
	-webkit-transition: all 1s ease-in-out;
	-o-transition: all 1s ease-in-out;
	-ms-transition: all 1s ease-in-out;
	transition: all 1s ease-in-out;
	}

.machina-nav-menu.menu-secondary li.sticky-right {
	float: right;
}

.machina-nav-menu.menu-secondary li li a {
	background-color: ".$gsm_bg.";
	color: ".$text_color.";
	border: 1px solid #fff;
	border-top: none;
	color: #fff;
	padding: 20px;
	padding: 1.25rem;
}

";

return $gsm_css;
}

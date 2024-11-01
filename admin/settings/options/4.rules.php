<?php


use SideMenuLite\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$show = [
	'general_start' => __( 'General', 'side-menu-lite' ),
	'everywhere'    => __( 'Everywhere', 'side-menu-lite' ),
	'shortcode'     => __( 'Shortcode', 'side-menu-lite' ),
	'general_end'   => __( 'General', 'side-menu-lite' ),

];



$args = [
	//region Display Rules
	'show' => [
		'type'  => 'select',
		'title' => __( 'Display', 'side-menu-lite' ),
		'val'   => 'everywhere',
		'atts'  => $show,
	],

	//endregion


	//region Other

	'fontawesome' => [
		'type'  => 'checkbox',
		'title' => __( 'Disable Font Awesome Icon', 'side-menu-lite' ),
		'val'   => 0,
		'label' => __( 'Disable', 'side-menu-lite' ),
	],
	
	//endregion

	//region Responsive Visibility
	'screen'       => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on smaller screens', 'side-menu-lite' ),
			'name'   => 'include_mobile',
			'toggle' => true,
		],
		'val'   => 480,
		'addon' => 'px',
	],

	'screen_more' => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on larger screens', 'side-menu-lite' ),
			'name'   => 'include_more_screen',
			'toggle' => true,
		],
		'val'   => 1024,
		'addon' => 'px'
	],

	//endregion

];


return $args;

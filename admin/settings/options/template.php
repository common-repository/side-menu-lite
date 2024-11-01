<?php

defined( 'ABSPATH' ) || exit;

$template = [
	'text' => [
		'type'  => 'text',
		'title' => __( 'Title', 'side-menu-lite' ),
		'val'   => '',
		'atts' => [
			'placeholder' => __( 'Placeholder', 'side-menu-lite' ),
		],
	],

	'number' => [
		'type'  => 'number',
		'title' => __( 'Title', 'side-menu-lite' ),
		'val'   => '',
		'atts' => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	],

	'select' => [
		'type' => 'select',
		'title' => __('Title', 'side-menu-lite'),
		'val' => '1',
		'atts' => [
			'1' => __( '1', 'side-menu-lite' ),
			'2' => __( '2', 'side-menu-lite' ),
			'3' => __( '3', 'side-menu-lite' ),
		],
	],

	'color' => [
		'type'  => 'text',
		'val'   => '#ffffff',
		'title' => __( 'Color', 'side-menu-lite' ),
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'checkbox' => [
		'type'  => 'checkbox',
		'title' => __( 'Title', 'side-menu-lite' ),
		'label' => __( 'Enable', 'side-menu-lite' ),
	],

	'title' => [
		'label'  => __( 'Title', 'side-menu-lite' ),
		'name'   => '',
		'toggle' => true,
		'val'    => 1
	],

	'addon' => [
		'type' => 'select',
		'name' => '',
		'val'  => '',
		'atts' => [
			'1' => __( '1', 'side-menu-lite' ),
			'2' => __( '2', 'side-menu-lite' ),
			'3' => __( '3', 'side-menu-lite' ),
		],
	],

];
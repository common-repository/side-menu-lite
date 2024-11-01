<?php

use SideMenuLite\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$args = [
	'item_tooltip' => [
		'type'  => 'text',
		'title' => __( 'Label Text', 'side-menu-lite' ),
	],


	'item_type' => [
		'type'  => 'select',
		'title' => __( 'Type', 'side-menu-lite' ),
		'atts'  => Settings_Helper::item_type(),
	],

	'item_link' => [
		'type'  => 'text',
		'title' => __( 'Link', 'side-menu-lite' ),
		'class' => 'is-hidden',
	],

	'new_tab' => [
		'type'  => 'checkbox',
		'title' => __( 'Open in new Window', 'side-menu-lite' ),
		'label' => __( 'Enable', 'side-menu-lite' ),
		'class' => 'is-hidden',
	],

	// Icons
	'item_icon' => [
		'type'  => 'text',
		'title' => __( 'Icon', 'side-menu-pro' ),
		'val'   => 'fas fa-wand-magic-sparkles',
		'atts'  => [
			'class' => 'wpie-icon-box',
		]
	],

	'item_icon_anomate' => [
		'type'  => 'select',
		'title' => __( 'Icon', 'side-menu-lite' ),
		'atts'  => Settings_Helper::icon_anim(),
	],


	// Style
	'color'            => [
		'type'  => 'text',
		'val'   => '#ffffff',
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
		'title' => __( 'Font Color', 'side-menu-lite' ),
	],

	'iconcolor' => [
		'type'  => 'text',
		'val'   => '#ffffff',
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
		'title' => __( 'Icon Color', 'side-menu-lite' ),
	],

	'bcolor' => [
		'type'  => 'text',
		'val'   => '#128be0',
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
		'title' => __( 'Background', 'side-menu-lite' ),
	],

	'hbcolor'   => [
		'type'  => 'text',
		'val'   => '#128be0',
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
		'title' => __( 'Hover Background', 'side-menu-lite' ),
	],

	'item_tooltip_font' => [
		'type'  => 'select',
		'title' => __( 'Label Font Family', 'side-menu-lite' ),
		'atts'  => [
			'inherit'         => __( 'Use Your Themes', 'side-menu-lite' ),
			'Tahoma'          => __( 'Tahoma', 'side-menu-lite' ),
			'Georgia'         => __( 'Georgia', 'side-menu-lite' ),
			'Comic Sans MS'   => __( 'Comic Sans MS', 'side-menu-lite' ),
			'Arial'           => __( 'Arial', 'side-menu-lite' ),
			'Lucida Grande'   => __( 'Lucida Grande', 'side-menu-lite' ),
			'Times New Roman' => __( 'Times New Roman', 'side-menu-lite' ),
		],
	],

	'item_tooltip_style' => [
		'type'  => 'select',
		'title' => __( 'Label Font Style', 'side-menu-lite' ),
		'atts'  => [
			'normal' => __( 'Normal', 'side-menu-lite' ),
			'italic' => __( 'Italic', 'side-menu-lite' ),
		],
	],

	'item_tooltip_weight' => [
		'type'  => 'select',
		'title' => __( 'Label Font Weight ', 'side-menu-lite' ),
		'atts'  => [
			'normal'  => __( 'Normal', 'side-menu-lite' ),
			'lighter' => __( 'Lighter', 'side-menu-lite' ),
			'bold'    => __( 'Bold', 'side-menu-lite' ),
			'bolder'  => __( 'Bolder', 'side-menu-lite' ),
		],
	],

	// Attributes
	'button_id' => [
		'type'  => 'text',
		'title' => __( 'ID for element', 'side-menu-lite' ),
	],

	'button_class' => [
		'type'  => 'text',
		'title' => __( 'Class for element', 'side-menu-lite' ),
	],

	'link_rel' => [
		'type'  => 'text',
		'title' => __( 'Attribute: rel', 'side-menu-lite' ),
	],

];

$prefix  = 'menu_1-';
$newArgs = [];

foreach ( $args as $key => $value ) {
	$newArgs[ $prefix . $key ] = $value;
}

return $newArgs;
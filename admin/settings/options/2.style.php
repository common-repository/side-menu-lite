<?php

defined( 'ABSPATH' ) || exit;

return [
	//region Properties
	'zindex' => [
		'type' => 'number',
		'title' => __('Z-index', 'side-menu-lite'),
		'val' => '9',
		'atts' => [
			'min'         => '0',
			'step'        => '1',
			'placeholder' => '9',
		],
	],
	//endregion

	//region Location
	'menu' => [
		'type' => 'select',
		'title' => __('Position', 'side-menu-lite'),
		'val' => 'left',
		'atts' => [
			'left'  => esc_attr__( 'Left', 'side-menu' ),
			'right' => esc_attr__( 'Right', 'side-menu' ),
		],
	],

	'align' => [
		'type' => 'select',
		'title' => __('Vertical alignment', 'side-menu-lite'),
		'val' => 'center',
		'atts' => [
			'top'    => esc_attr__( 'Top', 'side-menu' ),
			'center' => esc_attr__( 'Center', 'side-menu' ),
			'bottom' => esc_attr__( 'Bottom', 'side-menu' ),
		],
	],

	'margin' => [
		'type' => 'number',
		'title' => __('Offset', 'side-menu-lite'),
		'val' => '0',
		'atts' => [
			'step'        => '1',
			'placeholder' => '10',
		],
		'addon' => 'px',
	],

	'gap' => [
		'type' => 'number',
		'title' => __('Space between items', 'side-menu-lite'),
		'val' => '2',
		'atts' => [
			'step'        => '1',
			'placeholder' => '2',
		],
		'addon' => 'px',
	],
	//endregion

	//region Appearance
	'shadow' => [
		'type' => 'select',
		'title' => __('Shadow', 'side-menu-lite'),
		'val' => '',
		'atts' => [
			'shadow' => esc_attr__( 'Yes', 'side-menu' ),
			''       => esc_attr__( 'No', 'side-menu' ),
		],
	],

	'fontstyle' => [
		'type' => 'select',
		'title' => __('Font style', 'side-menu-lite'),
		'val' => 'normal',
		'atts' => [
			'normal' => 'Normal',
			'italic' => 'Italic',
		],
	],

	'fontweight' => [
		'type' => 'select',
		'title' => __('Font weight', 'side-menu-lite'),
		'val' => 'normal',
		'atts' => [
			'normal'  => esc_attr__( 'Normal', 'side-menu' ),
			'bold'    => esc_attr__( 'Bold', 'side-menu' ),
			'bolder'  => esc_attr__( 'Bolder', 'side-menu' ),
			'lighter' => esc_attr__( 'Lighter', 'side-menu' ),
		],
	],

	'bwidth' => [
		'type' => 'number',
		'title' => __('Border width', 'side-menu-lite'),
		'val' => '0',
		'atts' => [
			'min'         => '0',
			'step'        => '1',
			'placeholder' => '0',
		],
		'addon' => 'px',
	],

	'bradiustop' => [
		'type' => 'number',
		'title' => __('Top border radius', 'side-menu-lite'),
		'val' => '0',
		'atts' => [
			'min'         => '0',
			'step'        => '1',
			'placeholder' => '0',
		],
		'addon' => 'px',
	],

	'bradiusbottom' => [
		'type' => 'number',
		'title' => __('Bottom border radius', 'side-menu-lite'),
		'val' => '0',
		'atts' => [
			'min'         => '0',
			'step'        => '1',
			'placeholder' => '0',
		],
		'addon' => 'px',
	],

	'bcolor' => [
		'type'  => 'text',
		'val'   => 'rgba(0,0,0,0.75)',
		'title' => __( 'Border color', 'side-menu-lite' ),
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],
	//endregion

	//region Size
	'height' => [
		'type'  => 'number',
		'title' => __( 'Item Height', 'side-menu-lite' ),
		'val'   => '40',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],

	'iconsize' => [
		'type'  => 'number',
		'title' => __( 'Icon Size', 'side-menu-lite' ),
		'val'   => '24',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],

	'fontsize' => [
		'type'  => 'number',
		'title' => __( 'Font size', 'side-menu-lite' ),
		'val'   => '24',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],


	'mobile' => [
		'type'  => 'checkbox',
		'title' => __( 'Mobile devices', 'side-menu-lite' ),
		'label' => __( 'Enable', 'side-menu-lite' ),
	],

	'm_screen' => [
		'type'  => 'number',
		'title' => __( 'Mobile screen', 'side-menu-lite' ),
		'val'   => '768',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
	],

	'm_height' => [
		'type'  => 'number',
		'title' => __( 'Item Height', 'side-menu-lite' ),
		'val'   => '40',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],

	'm_iconsize' => [
		'type'  => 'number',
		'title' => __( 'Icon Size', 'side-menu-lite' ),
		'val'   => '24',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],

	'm_fontsize' => [
		'type'  => 'number',
		'title' => __( 'Font size', 'side-menu-lite' ),
		'val'   => '24',
		'atts' => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],

	//endregion
];
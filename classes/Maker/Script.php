<?php

namespace SideMenuLite\Maker;

defined( 'ABSPATH' ) || exit;

class Script {
	const NAME = 'SideMenuLite_';
	private $object_data;

	public function __construct() {
		$this->object_data = array();
	}

	public function add( $property_name, $property_value ) {
		$this->object_data[ $property_name ] = $property_value;
	}

	public function generate( $id, $param ) {
		$this->add_element( $id );
		$this->add_settings( $param );
		$this->add_style( $param );
		$this->add_item( $param );
		if ( ! empty( $param['mobile'] ) ) {
			$this->add_mobile_style( $param );
		}

		return 'var ' . self::NAME . $id . ' = ' . wp_json_encode( $this->object_data ) . ';';
	}

	public function add_element( $id ) {
		$this->add( 'element', 'side-menu-' . absint( $id ) );
	}

	public function add_settings( $param ) {
		$settings = array(
			'showAfterPosition' => 'showAfterPosition',
			'hideAfterPosition' => 'hideAfterPosition',
			'showAfterTimer'    => 'showAfterTimer',
			'hideAfterTimer'    => 'hideAfterTimer',
			'touch'             => 'touch',
			'scrollSpyOffset'   => 'scrollSpyOffset',
		);


		foreach ( $settings as $param_key => $setting_key ) {
			if ( ! empty( $param[ $param_key ] ) ) {
				$this->add( $setting_key, (int) $param[ $param_key ] );
			}
		}

		if ( ! empty( $param['include_mobile'] ) ) {
			$mobileHide = ! empty( $param['screen'] ) ? $param['screen'] : 480;
			$this->add( 'mobileHide', (int) $mobileHide );
		}

		if ( ! empty( $param['include_more_screen'] ) ) {
			$desktopHide = ! empty( $param['screen_more'] ) ? $param['screen_more'] : 1200;
			$this->add( 'desktopHide', (int) $desktopHide );
		}
	}

	public function add_style( $param ) {
		$defaults = array(
			'zindex'        => '9',
			'margin'        => '0',
			'height'        => '40',
			'iconsize'      => '24',
			'fontsize'      => '24',
			'fontstyle'     => 'normal',
			'fontweight'    => 'normal',
			'bwidth'        => '0',
			'bradiustop'    => '0',
			'bradiusbottom' => '0',
			'bcolor'        => 'rgba(0,0,0,0.75)',
			'gap'           => '0',
		);

		$param = array_merge( $defaults, $param );

		$style = array(
			'--sm-z-index'           => ( $param['zindex'] === '9' ) ? '9999' : $param['zindex'],
			'--sm-offset'            => $param['margin'] . 'px',
			'--sm-item-height'       => $param['height'] . 'px',
			'--sm-icon-width'        => $param['height'] . 'px',
			'--sm-icon-size'         => $param['iconsize'] . 'px',
			'--sm-label-size'        => $param['fontsize'] . 'px',
			'--sm-label-font'        => 'inherit',
			'--sm-label-font-style'  => $param['fontstyle'],
			'--sm-label-font-weight' => $param['fontweight'],
			'--sm-border-width'      => $param['bwidth'] . 'px',
			'--sm-border-color'      => $param['bcolor'],
			'--sm-radius-top'        => $param['bradiustop'] . 'px',
			'--sm-radius-bottom'     => $param['bradiusbottom'] . 'px',
			'--sm-button-space'      => $param['gap'] . 'px',
		);

		$this->add( 'style', $style );
	}

	public function add_item( $param ) {
		$item = [];

		if ( is_array( $param['menu_1']['item_type'] ) ) {
			$itemTypeCount = count( $param['menu_1']['item_type'] );

			for ( $i = 0; $i < $itemTypeCount; $i ++ ) {
				$item[ $i ] = [
					'--sm-color'            => $param['menu_1']['color'][ $i ],
					'--sm-icon-color'       => $param['menu_1']['iconcolor'][ $i ],
					'--sm-extra-text-color' => '#ffffff',
					'--sm-background'       => $param['menu_1']['bcolor'][ $i ],
					'--sm-hover-background' => $param['menu_1']['hbcolor'][ $i ],
					'--sm-extra-text-width' => ( ! empty( $param['menu_1']['item_text_width'][ $i ] ) ? $param['menu_1']['item_text_width'][ $i ] : '270' ) . 'px',
					'--sm-extra-fontsize'   => ( ! empty( $param['menu_1']['item_text_size'][ $i ] ) ? $param['menu_1']['item_text_size'][ $i ] : '16' ) . 'px',
				];
			}
		}

		$this->add( 'items', $item );
	}

	public function add_mobile_style( $param ) {
		$m_screen = isset( $param['m_screen'] ) ? $param['m_screen'] : 768;
		$this->add( 'mobile', absint( $m_screen ) );

		$m_height   = isset( $param['m_height'] ) ? $param['m_height'] : '40';
		$m_iconsize = isset( $param['m_iconsize'] ) ? $param['m_iconsize'] : '24';
		$m_fontsize = isset( $param['m_fontsize'] ) ? $param['m_fontsize'] : '24';

		$mobileStyle = [
			'--sm-item-height' => $m_height . 'px',
			'--sm-icon-width'  => $m_height . 'px',
			'--sm-icon-size'   => $m_iconsize . 'px',
			'--sm-label-size'  => $m_fontsize . 'px',
		];
		$this->add( 'mobileStyle', $mobileStyle );
	}

}
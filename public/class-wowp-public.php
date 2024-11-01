<?php
/**
 * Class WOWP_Public
 *
 * This class handles the public functionality of the Float Menu Pro plugin.
 *
 * @package    SideMenuLite
 * @subpackage Public
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace SideMenuLite;

use SideMenuLite\Admin\DBManager;
use SideMenuLite\Maker\Content;
use SideMenuLite\Maker\Script;
use SideMenuLite\Publish\Conditions;
use SideMenuLite\Publish\Display;
use SideMenuLite\Publish\Singleton;

defined( 'ABSPATH' ) || exit;

class WOWP_Public {

	private string $pefix;

	public function __construct() {
		// prefix for plugin assets
		$this->pefix = '.min';

		add_shortcode( WOWP_Plugin::SHORTCODE, [ $this, 'shortcode' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'assets' ] );
		add_action( 'wp_footer', [ $this, 'footer' ] );

	}


	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			[ 'id' => "" ],
			$atts,
			WOWP_Plugin::SHORTCODE
		);

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		$singleton = Singleton::getInstance();

		if ( $singleton->hasKey( $atts['id'] ) ) {
			return '';
		}

		$result = DBManager::get_data_by_id( $atts['id'] );

		if ( empty( $result->param ) ) {
			return '';
		}

		$conditions = Conditions::init( $result );

		if ( $conditions === false ) {
			return '';
		}

		$param = maybe_unserialize( $result->param );
		$singleton->setValue( $atts['id'], $param );

		return '';
	}

	public function assets(): void {
		$handle  = WOWP_Plugin::SLUG;
		$assets  = plugin_dir_url( __FILE__ ) . 'assets/';
		$version = WOWP_Plugin::info( 'version' );
		$url_fontawesome = WOWP_Plugin::url() . 'vendors/fontawesome/css/all.css';


		$this->check_display();
		$this->check_shortcode();

		$singleton = Singleton::getInstance();
		$args      = $singleton->getValue();

		if ( ! empty( $args ) ) {
			$style_file = is_rtl() ? 'style-rtl' : 'style';
			wp_enqueue_style( $handle, $assets . 'css/'. $style_file . $this->pefix . '.css', [], $version, $media = 'all' );
		}
		foreach ( $args as $id => $param ) {
			if ( empty( $param['fontawesome'] ) ) {
				wp_enqueue_style( $handle . '-fontawesome', $url_fontawesome, null, '6.6' );
			}
			if ( ! empty( $param['style'] ) ) {
				$data = trim( preg_replace( '~\s+~s', ' ', $param['style'] ) );
				wp_add_inline_style( $handle, $data );
			}

		}
	}


	public function footer(): void {
		$handle  = WOWP_Plugin::SLUG;
		$assets  = plugin_dir_url( __FILE__ ) . 'assets/';
		$version = WOWP_Plugin::info( 'version' );
		$url_fontawesome = WOWP_Plugin::url() . 'vendors/fontawesome/css/all.css';

		$singleton = Singleton::getInstance();
		$args      = $singleton->getValue();

		if ( empty( $args ) ) {
			return;
		}

		$style_file = is_rtl() ? 'style-rtl' : 'style';
		wp_enqueue_style( $handle, $assets . 'css/'. $style_file . $this->pefix . '.css', [], $version, $media = 'all' );
		wp_enqueue_script( $handle, $assets . 'js/script' . $this->pefix . '.js', [], $version, true );

		foreach ( $args as $id => $param ) {
			$content = new Content($id, $param);
			echo $content->init();

			if ( ! empty( $param['style'] ) ) {
				$data = trim( preg_replace( '~\s+~s', ' ', $param['style'] ) );
				wp_add_inline_style( $handle, $data );
			}

			if ( empty( $param['fontawesome'] ) ) {
				wp_enqueue_style( $handle . '-fontawesome', $url_fontawesome, null, '6.6' );
			}

			$inline_script = $this->script( $param, $id );
			wp_add_inline_script( $handle, $inline_script, 'before' );

		}
	}

	public function script( $param, $id ): string {
		return ( new Script )->generate( $id, $param );
	}

	private function check_display(): void {
		$results = DBManager::get_all_data();
		if ( $results !== false ) {
			$singleton = Singleton::getInstance();
			foreach ( $results as $result ) {
				$param = maybe_unserialize( $result->param );
				if ( Display::init( $result->id, $param ) === true && Conditions::init( $result ) === true ) {
					$singleton->setValue( $result->id, $param );
				}
			}
		}
	}

	private function check_shortcode(): void {
		global $post;
		$shortcode = WOWP_Plugin::SHORTCODE;
		$singleton = Singleton::getInstance();

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $shortcode ) ) {
			$pattern = get_shortcode_regex( [ $shortcode ] );
			if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches )
			     && array_key_exists( 2, $matches )
			     && in_array( $shortcode, $matches[2] )
			) {
				foreach ( $matches[3] as $attrs ) {
					$attrs = shortcode_parse_atts( $attrs );
					if ( $attrs && is_array( $attrs ) && array_key_exists( 'id', $attrs ) ) {
						$result = DBManager::get_data_by_id( $attrs['id'] );

						if ( ! empty( $result->param ) ) {
							$param = maybe_unserialize( $result->param );
							if ( Conditions::init( $result ) === true ) {
								$singleton->setValue( $attrs['id'], $param );
							}
						}

					}
				}
			}
		}
	}


}
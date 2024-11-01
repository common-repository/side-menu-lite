<?php

namespace SideMenuLite\Maker;

defined( 'ABSPATH' ) || exit;

class Content {
	/**
	 * @var mixed
	 */
	private $id;
	/**
	 * @var mixed
	 */
	private $param;
	/**
	 * @var mixed
	 */
	private $title;

	public function __construct( $id, $param ) {
		$this->id    = $id;
		$this->param = $param;
	}

	public function init(): string {
		return $this->create();
	}

	private function create(): string {
		$id = $this->id;
		$param = $this->param;

		$count = ! empty( $param['menu_1']['item_type'] ) ? count( $param['menu_1']['item_type'] ) : 0;

		if ( $count === 0 ) {
			return false;
		}

		$wrapper = $this->wrapper( $id, $param );

		$menu = $wrapper;
		$menu .= '<ul class="sm-list">';

		$menu .= $this->elements( $count, $param );

		$menu .= '</ul></div>'; // close menu tags

		return $menu;
	}

	private function wrapper( $id, $param ): string {
		$position        = isset( $param['menu'] ) ? 'is-' . $param['menu'] : ' is-left';
		$align           = isset( $param['align'] ) ? ' -' . $param['align'] : ' -center';
		$shadow          = ! empty( $param['shadow'] ) ? ' has-shadow' : '';
		$list            = ! empty( $param['connect'] ) ? ' sm-connected' : '';
		$connect_visible = ( ! empty( $param['connect'] ) && ! empty( $param['hold_open'] ) ) ? ' sm-open' : '';

		$menu_add_classes = 'notranslate side-menu is-hidden ' . $position . $align . $shadow . $list . $connect_visible;

		return '<div class="' . esc_attr( $menu_add_classes ) . '" id="side-menu-' . absint( $id ) . '">';
	}

	private function elements( $count, $param ): string {
		$elements = '';
		$subMenu  = 0;

		for ( $i = 0; $i < $count; $i ++ ) {
			$has_text = ! empty( $param['menu_1']['item_text'][ $i ] ) ? ' has-text' : '';
			$open     = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' sm-open' : '';

			$item_type = $param['menu_1']['item_type'][ $i ];

			if ( $item_type === 'next_post' ) {
				$next_post = get_next_post( true );
				if ( empty( $next_post ) ) {
					continue;
				}
			} elseif ( $item_type === 'previous_post' ) {
				$previous_post = get_previous_post( true );
				if ( empty( $previous_post ) ) {
					continue;
				}
			}


			if ( ! empty( $param['menu_1']['sub_item'][ $i + 1 ] ) && empty( $param['menu_1']['sub_item'][ $i ] ) ) {
				$element = '<li class="sm-item' . esc_attr( $open . $has_text ) . ' sm-has-submenu">';
				$subMenu = 1;
			} else {
				$element = '<li class="sm-item' . esc_attr( $open . $has_text ) . '">';
				$subMenu = 0;
			}

			if ( ! empty( $param['menu_1']['item_text'][ $i ] ) ) {
				$element .= '<div class="sm-extra-text">' . do_shortcode( ( wp_kses_post( $param['menu_1']['item_text'][ $i ] ) ) ) . '</div>';
			}

			$element .= $this->create_element( $param, $i, $item_type );

			if ( $subMenu === 1 ) {
				$element .= '<ul class="sm-sub-menu">';
			}

			if ( ! empty( $param['menu_1']['sub_item'][ $i ] ) && empty( $param['menu_1']['sub_item'][ $i + 1 ] ) ) {
				$element .= '</ul>';
				$subMenu = 0;
			}

			$element .= '</li>';

			$elements .= $element;
		}

		return $elements;
	}

	private function create_element( $param, $i, $item_type ): string {
		$icon  = $this->create_icon( $param, $i );
		$label = $this->create_label( $param, $i, $item_type );

		$link = $this->create_link( $param, $i, $item_type, $icon, $label );

		return $link;
	}

	private function create_icon( $param, $i ): string {
		$icon = '';
		if ( ! empty( $param['menu_1']['item_custom'][ $i ] ) ) {
			$img_alt  = ! empty( $param['menu_1']['image_alt'][ $i ] ) ? $param['menu_1']['image_alt'][ $i ] : '';
			$img_link = $param['menu_1']['item_custom_link'][ $i ];
			$icon     = '<span class="sm-icon"><img src="' . esc_url( $img_link ) . '" alt="' . esc_attr( $img_alt ) . '"></span>';
		} elseif ( ! empty( $param['menu_1']['item_custom_text_check'][ $i ] ) ) {
			$icon = '<span class="sm-icon">' . wp_kses_post( $param['menu_1']['item_custom_text'][ $i ] ) . '</span>';
		} else {
			$icon_class   = $param['menu_1']['item_icon'][ $i ];
			$icon_animate = ! empty( $param['menu_1']['item_icon_anomate'][ $i ] ) ? ' ' . $param['menu_1']['item_icon_anomate'][ $i ] : '';
			$icon         = '<span class="sm-icon ' . esc_attr( $icon_class . $icon_animate ) . '"></span>';
		}

		return $icon;
	}

	private function create_label( $param, $i, $item_type ): string {
		$label = '';
		$text  = $param['menu_1']['item_tooltip'][ $i ];

		if ( $item_type === 'email' ) {
			$text = is_email( $text ) ? antispambot( $text ) : $text;
		}

		if ( $item_type === 'search' ) {
			$label = '<span class="sm-label"><form class="sm-search" action="' . esc_url( home_url( '/' ) ) . '"><input type="search" class="sm-input" name="s" value="' . esc_attr( $text ) . '"></form></span>';
		} else {
			$label = ! empty( $text ) ? '<span class="sm-label">' . esc_attr( $text ) . '</span>' : '';
		}

		return $label;
	}

	private function create_link( $param, $i, $item_type, $icon, $tooltip ): string {
		$link_param = $this->link_param( $param, $i );
		$menu       = '';

		switch ( $item_type ) {
			case 'link':
				$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link   = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu   .= $this->generate_link( $link, $target, $icon, $tooltip, $link_param );
				break;
			case 'share':
				$share_service = mb_strtolower( $param['menu_1']['item_share'][ $i ] );
				$menu          .= $this->generate_link( '#', '', $icon, $tooltip, $link_param, 'data-btn-share',
					$share_service );
				break;
			case 'translate':
				$glang = $param['menu_1']['gtranslate'][ $i ];
				$menu  .= $this->generate_link( '#', '', $icon, $tooltip, $link_param, 'data-google-lang', $glang );
				break;
			case 'print':
			case 'totop':
			case 'tobottom':
			case 'goback':
			case 'goforward':
				$menu .= $this->generate_link( '#', '', $icon, $tooltip, $link_param, 'data-btn-action', $item_type );
				break;
			case 'smoothscroll':
			case 'scrollSpy':
				$link = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$action = ($item_type === 'smoothscroll') ? 'scroll' : $item_type;
				$menu .= $this->generate_link( $link, '', $icon, $tooltip, $link_param, 'data-btn-action', $action );
				break;
			case 'login':
			case 'logout':
			case 'lostpassword':
				$link = call_user_func( 'wp_' . $item_type . '_url', $param['menu_1']['item_link'][ $i ] );
				$menu .= $this->generate_link( $link, '', $icon, $tooltip, $link_param );
				break;
			case 'register':
				$link = wp_registration_url();
				$menu .= $this->generate_link( $link, '', $icon, $tooltip, $link_param );
				break;
			case 'telephone':
				$link = 'tel:' . $param['menu_1']['item_link'][ $i ];
				$menu .= $this->generate_link( $link, '', $icon, $tooltip, $link_param );
				break;
			case 'email':
				$email   = $param['menu_1']['item_link'][ $i ];
				$link    = is_email( $email ) ? 'mailto:' . antispambot( $email ) : $email;
				$tooltip = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
				$menu    .= $this->generate_link( $link, '', $icon, $tooltip, $link_param );
				break;
			case 'modal':
				$link = '#' . $param['menu_1']['item_modal'][ $i ];
				$menu .= $this->generate_link( $link, '', $icon, $tooltip, $link_param );
				break;
			case 'shiftnav':
				$menu .= '<a class="shiftnav-toggle sm-link" data-shiftnav-target="shiftnav-main">';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'search':
				$tooltip_text = $param['menu_1']['item_tooltip'][ $i ];
				$menu         .= $this->generate_search_link( $icon, $tooltip_text, $link_param );
				break;
			case 'next_post':
				$target    = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$next_post = get_next_post( true );
				$link      = get_permalink( $next_post );
				$menu      .= $this->generate_link( $link, $target, $icon, $tooltip, $link_param );
				break;
			case 'previous_post':
				$target        = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$previous_post = get_previous_post( true );
				$link          = get_permalink( $previous_post );
				$menu          .= $this->generate_link( $link, $target, $icon, $tooltip, $link_param );
				break;
			case 'close':
				$menu .= '<span class="sm-link" data-smmenu-target="close">';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
		}

		return $menu;
	}

	private function generate_link(
		$url,
		$target = '',
		$icon = '',
		$tooltip = '',
		$link_param = '',
		$data_attr = '',
		$data_value = ''
	): string {
		$link = '<a href="' . esc_url( $url ) . '" ' . wp_specialchars_decode( $link_param, 'double' );
		$link .= ! empty( $target ) ? ' target="' . esc_attr( $target ) . '"' : '';
		$link .= ! empty( $data_attr ) ? ' ' . esc_attr( $data_attr ) . '="' . esc_attr( $data_value ) . '"' : '';
		$link .= '>';
		$link .= $icon . $tooltip;
		$link .= '</a>';

		return $link;
	}

	private function generate_search_link( $icon, $tooltip_text, $link_param ): string {
		$link = '<span ' . wp_specialchars_decode( $link_param, 'double' ) . '>';
		$link .= $icon . '<span class="sm-label"><form class="sm-search" action="' . esc_url( home_url( '/' ) ) . '">';
		$link .= '<input type="search" class="sm-input" name="s" placeholder="' . esc_attr( $tooltip_text ) . '">';
		$link .= '</form></span></span>';

		return $link;
	}


	private function link_param( $param, $i ): string {
		// Update to version 4.0
		$link_type = isset( $param['menu_1']['item_type'][ $i ] ) ? $param['menu_1']['item_type'][ $i ] : '';
		$class_id  = '';
		if ( $link_type === 'id' ) {
			$class_id = ! empty( $param['menu_1']['item_modal'][ $i ] ) ? $param['menu_1']['item_modal'][ $i ] : '';

			$param['menu_1']['button_id'][ $i ] = $class_id;
			$param['menu_1']['item_type'][ $i ] = 'link';
		} elseif ( $link_type === 'class' ) {
			$class_id = ! empty( $param['menu_1']['item_modal'][ $i ] ) ? $param['menu_1']['item_modal'][ $i ] : '';

			$param['menu_1']['button_class'][ $i ] = $class_id;
			$param['menu_1']['item_type'][ $i ]    = 'link';
		}

		$button_class = $param['menu_1']['button_class'][ $i ];
		$class_add    = ! empty( $button_class ) ? ' class="sm-link ' . esc_attr( $button_class ) . '"' : ' class="sm-link"';
		$button_id    = $param['menu_1']['button_id'][ $i ];
		$id_add       = ! empty( $button_id ) ? ' id="' . esc_attr( $button_id ) . '"' : "";
		$link_rel     = ! empty( $param['menu_1']['link_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['menu_1']['link_rel'][ $i ] ) . '"' : '';

		return $id_add . $class_add . $link_rel;
	}

	private function get_link( $param, $i, $item_type ) {
		$link = '';
		switch ( $item_type ) {
			case 'link':
			case 'smoothscroll':
				$link = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				break;
			case 'share':
			case 'translate':
			case 'print':
			case 'totop':
			case 'tobottom':
			case 'goback':
			case 'goforward':
			case 'shiftnav':
				$link = '#';
				break;
			case 'login':
				$link = wp_login_url( $param['menu_1']['item_link'][ $i ] );
				break;
			case 'logout':
				$link = wp_logout_url( $param['menu_1']['item_link'][ $i ] );
				break;
			case 'register':
				$link = wp_registration_url();
				break;
			case 'lostpassword':
				$link = wp_lostpassword_url( $param['menu_1']['item_link'][ $i ] );
				break;
			case 'telephone':
				$link = 'tel:' . $param['menu_1']['item_link'][ $i ];
				break;
			case 'email':
				$email = $param['menu_1']['item_link'][ $i ];
				$link  = is_email( $email ) ? 'mailto:' . antispambot( $email ) : $email;
				break;
			case 'modal':
				$link = '#' . $param['menu_1']['item_modal'][ $i ];
				break;
			case 'next_post':
		}
	}

}
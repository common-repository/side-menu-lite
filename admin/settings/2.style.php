<?php

/*
 * Page Name: Style
 */

use SideMenuLite\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/2.style.php' );

$field = new CreateFields( $options, $page_opt );


$item_order = ! empty( $options['item_order']['properties'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
    <input type="hidden" name="param[item_order][properties]" class="wpie-item__toggle"
           value="<?php echo absint( $item_order ); ?>">
    <summary class="wpie-item_heading">
        <span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-ruler-pen"></span></span>
        <span class="wpie-item_heading_label"><?php esc_html_e( 'Properties', 'side-menu-lite' ); ?></span>
        <span class="wpie-item_heading_type"></span>
        <span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
    </summary>
    <div class="wpie-item_content">

        <div class="wpie-fieldset">
            <div class="wpie-fields">
				<?php $field->create( 'zindex' ); ?>
            </div>
        </div>

    </div>
</details>

<?php
$item_order = ! empty( $options['item_order']['location'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
    <input type="hidden" name="param[item_order][location]" class="wpie-item__toggle"
           value="<?php echo absint( $item_order ); ?>">
    <summary class="wpie-item_heading">
        <span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-pointer"></span></span>
        <span class="wpie-item_heading_label"><?php esc_html_e( 'Location', 'side-menu-lite' ); ?></span>
        <span class="wpie-item_heading_type"></span>
        <span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
    </summary>
    <div class="wpie-item_content">

        <div class="wpie-fieldset">
            <div class="wpie-fields">
				<?php $field->create( 'menu' ); ?>
				<?php $field->create( 'align' ); ?>
				<?php $field->create( 'margin' ); ?>
				<?php $field->create( 'gap' ); ?>
            </div>
        </div>

    </div>
</details>

<?php
$item_order = ! empty( $options['item_order']['appearance'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
    <input type="hidden" name="param[item_order][appearance]" class="wpie-item__toggle"
           value="<?php echo absint( $item_order ); ?>">
    <summary class="wpie-item_heading">
        <span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-paintbrush"></span></span>
        <span class="wpie-item_heading_label"><?php esc_html_e( 'Appearance', 'side-menu-lite' ); ?></span>
        <span class="wpie-item_heading_type"></span>
        <span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
    </summary>
    <div class="wpie-item_content">

        <div class="wpie-fieldset">
            <div class="wpie-fields">
				<?php $field->create( 'shadow' ); ?>
				<?php $field->create( 'fontstyle' ); ?>
				<?php $field->create( 'fontweight' ); ?>
            </div>
            <div class="wpie-fields">
				<?php $field->create( 'bwidth' ); ?>
				<?php $field->create( 'bradiustop' ); ?>
				<?php $field->create( 'bradiusbottom' ); ?>
				<?php $field->create( 'bcolor' ); ?>
            </div>
        </div>

    </div>
</details>

<?php
$item_order = ! empty( $options['item_order']['size'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
    <input type="hidden" name="param[item_order][size]" class="wpie-item__toggle"
           value="<?php echo absint( $item_order ); ?>">
    <summary class="wpie-item_heading">
        <span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-text"></span></span>
        <span class="wpie-item_heading_label"><?php esc_html_e( 'Size', 'side-menu-lite' ); ?></span>
        <span class="wpie-item_heading_type"></span>
        <span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
    </summary>
    <div class="wpie-item_content">

        <div class="wpie-fieldset">
            <div class="wpie-fields">
				<?php $field->create( 'height' ); ?>
				<?php $field->create( 'iconsize' ); ?>
				<?php $field->create( 'fontsize' ); ?>
            </div>
        </div>

        <div class="wpie-fieldset">
            <div class="wpie-fields">
				<?php $field->create( 'mobile' ); ?>
				<?php $field->create( 'm_screen' ); ?>
            </div>

            <div class="wpie-fields">
				<?php $field->create( 'm_height' ); ?>
				<?php $field->create( 'm_iconsize' ); ?>
				<?php $field->create( 'm_fontsize' ); ?>
            </div>
        </div>
    </div>
</details>


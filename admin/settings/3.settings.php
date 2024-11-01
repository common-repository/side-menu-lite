<?php

/*
 * Page Name: Settings
 */

use SideMenuLite\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/3.settings.php' );

$field = new CreateFields( $options, $page_opt );

?>

<div class="wpie-fieldset">
	<div class="wpie-legend"><?php esc_html_e('Settings', 'side-menu-lite');?></div>
	<div class="wpie-fields">
		<?php $field->create( 'touch' ); ?>
	</div>
</div>
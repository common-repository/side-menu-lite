<?php
/**
 * Page Name: Support
 *
 */

use SideMenuLite\Admin\SupportForm;
use SideMenuLite\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;
?>

    <div class="wpie-block-tool is-white">

        <p>
			<?php
			esc_html_e( 'To get your support related question answered in the fastest timing, please send a message via the form below or write to us via', 'side-menu-lite' );
			echo ' <a href="' . esc_url( WOWP_Plugin::info( 'support' ) ) . '">' . esc_html__( 'support page', 'side-menu-lite' ) . '</a>';
			?>
        </p>

        <p>
			<?php esc_html_e( 'Also, you can send us your ideas and suggestions for improving the plugin.', 'side-menu-lite' ); ?>
        </p>

		<?php SupportForm::init(); ?>

    </div>
<?php

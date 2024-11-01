<?php
/**
 * All the settings registeration should be done here.
 *
 * @package WEB3TokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

/**
 * Main class representation for settings.
 */
class WEB3_Token_Gate_Settings_Premium {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'plugin_action_links_' . WPVNFT_PLUGIN_BASE_NAME, array( $this, 'merge_link' ) );
	}

	/**
	 * Merges the settings link for the settings homepage.
	 *
	 * @param string[] $links - Existing links.
	 *
	 * @return void
	 */
	public function merge_link( $links ) {
		// Build and escape the URL.
		$settings_url = esc_url(
			add_query_arg(
				'post_type',
				'web3tg-connections',
				get_admin_url() . 'edit.php'
			)
		);

		$settings_link = "<a href='$settings_url'>" . __( 'Settings' ) . '</a>';

		// Appending the new link.
		array_push(
			$links,
			$settings_link
		);

		return $links;
	}

}

new WEB3_Token_Gate_Settings_Premium();

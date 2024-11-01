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
class WEB3_Token_Gate_Settings {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
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

		if (web3tg_fs()->is_free_plan()) {
			// Build and escape the URL.
			$settings_url = esc_url(
				add_query_arg(
					'page',
					'web3-token-gate',
					get_admin_url() . 'admin.php'
				)
			);

			$upgrade_url = web3tg_fs()->get_upgrade_url();
	
			$settings_link = "<a href='$settings_url'>" . __( 'Settings' ) . '</a>';
			$upgrade_link = "<a href='$upgrade_url' style='color:red; font-weight: bold;'>" . __( 'Go Pro' ) . '</a>';
	
			// Appending the new link.
			array_push(
				$links,
				$settings_link
			);

			array_push(
				$links,
				$upgrade_link
			);
		}


		return $links;
	}

	/**
	 * Register setting fields.
	 *
	 * @return void
	 */
	public function register() {

		register_setting(
			'wp-verify-nft-asset-address',
			'wp-verify-nft-asset-address',
			array(
				'default'           => '',
				'show_in_rest'      => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'wp-verify-nft-success-text',
			'wp-verify-nft-success-text',
			array(
				'default'           => 'Verified! You have the NFT',
				'show_in_rest'      => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'wp-verify-nft-failure-text',
			'wp-verify-nft-failure-text',
			array(
				'default'           => 'Oops! You don\'t have the NFT',
				'show_in_rest'      => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

	}

}

new WEB3_Token_Gate_Settings();

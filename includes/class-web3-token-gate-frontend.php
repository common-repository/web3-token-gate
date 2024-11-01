<?php
/**
 * Frontend Class.
 *
 * @package WEB3TokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

/**
 * Main class for handling frontend related assets and functionalities.
 */
class WEB3_Token_Gate_Frontend {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		\add_action( 'init', array( $this, 'load_assets' ) );
	}

	/**
	 * All frontend assets enqueuing should be done here.
	 *
	 * @return void
	 */
	public function load_assets() {
		if ( ! is_admin() ) {

			$frontend_script_path = WPVNFT_PLUGIN_URL . 'dist/frontend-free.js';

			if ( web3tg_fs()->can_use_premium_code__premium_only() ) {
				$frontend_script_path = WPVNFT_PLUGIN_URL . 'dist/frontend-premium.js';
			}

			\wp_enqueue_script(
				'wp-verify-nft-frontend-script',
				$frontend_script_path,
				array(
					'wp-api',
					'wp-i18n',
					'wp-components',
					'wp-element',
					'wp-editor',
				),
				uniqid(),
				true
			);

			$rest_url = rest_url( '/wptokengate/v1/verify' );

			// add an inline script.
			\wp_add_inline_script(
				'wp-verify-nft-frontend-script',
				"let wpVerifyNFTRestUrl = `$rest_url`;",
				'before'
			);

			\wp_enqueue_style(
				'wp-verify-nft-frontend-style',
				WPVNFT_PLUGIN_URL . 'dist/frontend.css',
				array(
					'wp-components',
				),
				uniqid()
			);

		}
	}

}

new WEB3_Token_Gate_Frontend();

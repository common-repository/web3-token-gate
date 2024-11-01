<?php
/**
 * Admin Class.
 *
 * @package WEB3TokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

/**
 * Main class for handling admin related assets and functionalities.
 */
class WEB3_Token_Gate_Admin {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		if ( web3tg_fs()->can_use_premium_code__premium_only() ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'load_block_editor_assets' ) );
		}

	}

	/**
	 * All the registerations should be done here.
	 *
	 * @return void
	 */
	public function register() {

		add_action(
			'admin_menu',
			function() {

				add_menu_page(
					__( 'Web3 Token Gate', 'web3-token-gate' ),
					__( 'Web3 Token Gate', 'web3-token-gate' ),
					'manage_options',
					'web3-token-gate',
					function() {
						?>
							<div id="wp-verify-nft-root"></div>
						<?php
					},
					'dashicons-admin-generic',
					99
				);
			}
		);

	}


	/**
	 * All assets enqueuing should be done here
	 *
	 * @param string $hook_suffix - Page suffix.
	 * @return void
	 */
	public function load_assets( $hook_suffix ) {
		if ( web3tg_fs()->is_free_plan() && 'toplevel_page_web3-token-gate' === $hook_suffix ) {
			\wp_enqueue_script(
				'wp-verify-nft-admin-script',
				WPVNFT_PLUGIN_URL . 'dist/admin.js',
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

			\wp_enqueue_style(
				'wp-verify-nft-admin-style',
				WPVNFT_PLUGIN_URL . 'dist/admin.css',
				array(
					'wp-components',
				),
				uniqid()
			);
		}
	}

	/**
	 * All block editor assets should be loaded here.
	 *
	 * @return void
	 */
	public function load_block_editor_assets() {
		// Checks if the current enqueue is for the tokengate post type.
		if ( web3tg_fs()->can_use_premium_code__premium_only() ) {
			global $post;

			$is_token_gate_post_type = 'web3tg-connections' === $post->post_type;

			if ( $is_token_gate_post_type ) {
				\wp_enqueue_script(
					'wp-token-gate-gutenberg-script',
					WPVNFT_PLUGIN_URL . 'dist/gutenberg.js',
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

				\wp_enqueue_style(
					'wp-token-gate-gutenberg-style',
					WPVNFT_PLUGIN_URL . 'dist/gutenberg.css',
					array(
						'wp-components',
					),
					uniqid()
				);
			} else {
				\wp_enqueue_script(
					'web3-token-gate-gutenberg-extensions-script',
					WPVNFT_PLUGIN_URL . 'dist/extensions.js',
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

				wp_localize_script( 'web3-token-gate-gutenberg-extensions-script', 'web3tokengateConnections', web3_token_gate_get_connections() );

				\wp_enqueue_style(
					'web3-token-gate-gutenberg-extensions-style',
					WPVNFT_PLUGIN_URL . 'dist/extensions.css',
					array(
						'wp-components',
					),
					uniqid()
				);
			}
		}

	}

}

new WEB3_Token_Gate_Admin();

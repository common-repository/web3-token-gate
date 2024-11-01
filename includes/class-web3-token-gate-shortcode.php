<?php
/**
 * All the shortcode registeration should be done here.
 *
 * @package WEB3TokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

/**
 * Main class for handling shortcode.
 */
class WEB3_Token_Gate_Shortcode {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'token-gate-verify-app', array( $this, 'render_application' ) );
		add_shortcode( 'token-gate-output', array( $this, 'render_verification_placeholder' ) );
	}

	/**
	 * Renders the verification application.
	 *
	 * @return string
	 */
	public function render_application() {

		return "
		<div class='wptokengate-verification-application'>
			<button class='wptokengate-verification-connect'>Connect Wallet</button>
			<p class='wptokengate-wallet-connected-placeholder'></p>
		</div>";

	}


	/**
	 * Renders the verification placeholder.
	 *
	 * @return string
	 */
	public function render_verification_placeholder() {
		return "
			<p class='wptokengate-verification-placeholder unloaded'></p>
		";
	}

}


new WEB3_Token_Gate_Shortcode();

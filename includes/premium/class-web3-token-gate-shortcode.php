<?php
/**
 * All the premium shortcode registeration should be done here.
 *
 * @package WPTokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

/**
 * Main class for handling premium shortcode.
 */
class WEB3_Token_Gate_Shortcode_Premium {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'tokengate-verify-app', array( $this, 'render_application' ) );
		add_shortcode( 'tokengate-output', array( $this, 'render_verification_placeholder' ) );
	}

	/**
	 * Renders the verification application.
	 *
	 * @param array $attrs - Shortcode Attributes.
	 *
	 * @return string
	 */
	public function render_application( $attrs ) {
		$atts = shortcode_atts(
			array(
				'id'           => null,
				'is_page_gate' => 'false',
			),
			$attrs,
			'tokengate-verify-app'
		);

		$is_page_gate    = $atts['is_page_gate'] === 'true';
		$current_post_id = get_the_ID();

		$chain_id         = get_post_meta( $atts['id'], 'tokengate-chain-id', true );
		$button_classname = get_post_meta( $atts['id'], 'tokengate-button-classname', true );

		$output_type = 'connection-content';

		if ( $is_page_gate ) {
			$output_type = get_post_meta( $current_post_id, 'tokengate-success-output-type', true );
		}

		$final_button_classname = esc_html( $button_classname );

		return sprintf(
			'<div class="wptokengate-verification-application">
				<button class="wptokengate-verification-connect %1$s" data-chainid="%2$s" data-connectionid="%3$s" data-postid="%4$s" data-pagegate="%5$s" data-outputtype="%6$s">Connect Wallet</button>
				<p class="wptokengate-wallet-connected-placeholder" data-connectionid="%3$s"></p>
			</div>',
			$final_button_classname,
			$chain_id,
			$atts['id'],
			$current_post_id,
			$is_page_gate ? 'true' : 'false',
			$output_type
		);

	}


	/**
	 * Renders the verification placeholder.
	 *
	 * @param array $attrs - Shortcode Attributes.
	 *
	 * @return string
	 */
	public function render_verification_placeholder( $attrs ) {
		$atts = shortcode_atts(
			array(
				'id'           => null,
				'is_page_gate' => 'false',
			),
			$attrs,
			'tokengate-output'
		);

		$is_page_gate = $atts['is_page_gate'] === 'true';

		$output_tag = $is_page_gate ? 'div' : 'p';

		return sprintf(
			'<%1$s class="wptokengate-verification-placeholder unloaded" data-connectionid="%2$s"> </%1$s>',
			$output_tag,
			$atts['id'],
		);
	}

}

new WEB3_Token_Gate_Shortcode_Premium();

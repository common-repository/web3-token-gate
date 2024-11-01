<?php
/**
 * Custom helper utilities.
 *
 * @package WPTokenGate
 */

/**
 * Obtains the application configuration.
 *
 * @return array Configuration.
 */
function wptgv_get_config() {

	$config_file = WPVNFT_DIR_PATH . 'config.json';

	global $wp_filesystem;

	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();

	if ( ! $wp_filesystem->exists( $config_file ) ) {
		return array();
	}

	$config = json_decode( $wp_filesystem->get_contents( $config_file ), true );

	return ! is_array( $config ) ? array() : $config;

}

/**
 * Obtains the token gate verification output.
 *
 * @param int|string $gate_id - Gate id.
 * @param string     $output_type - Output type, Can either be 'success' or 'failure'.
 */
function wptgv_get_verification_output( $gate_id, $output_type = 'success' ) {

	$post                = get_post( $gate_id );
	$blocks              = parse_blocks( $post->post_content );
	$verification_output = '';

	foreach ( $blocks as $block ) {

		if ( ! isset( $block['blockName'] ) ) {
			continue;
		}

		$is_output_block        = 'web3tokengate/verification-output' === $block['blockName'];
		$is_current_output_type = $block['attrs']['type'] === $output_type;

		if ( $is_output_block && $is_current_output_type ) {
			$verification_output = serialize_block( $block );
			break;
		}
	}

	return $verification_output;
}

<?php

/**
 * Obtains a list of token gate created connections.
 *
 * @return array
 */
function web3_token_gate_get_connections() {
	$connections = get_posts(
		array(
			'post_type'      => 'web3tg-connections',
			'posts_per_page' => -1,
		)
	);

	$mapped_connections = array_map(
		function( $connection ) {
			return array(
				'label' => $connection->post_title,
				'value' => $connection->ID,
			);
		},
		$connections
	);

	return $mapped_connections;
}

/**
 * Merges connection gate content with the given content.
 *
 * @param int    $connection_id - Connection Gate Id.
 * @param string $content - Current Post Content.
 */
function web3_token_gate_merge_connection( $connection_id, $content ) {

	$shortcode_markup = '';

	$shortcode_markup .= do_shortcode(
		'[tokengate-verify-app id="' . $connection_id . '" is_page_gate="true"]'
	);

	$shortcode_markup .= do_shortcode(
		'[tokengate-output id="' . $connection_id . '" is_page_gate="true"]'
	);

	$content = $shortcode_markup . $content;

	return $content;
}

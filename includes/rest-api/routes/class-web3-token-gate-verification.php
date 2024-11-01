<?php
/**
 * Redirect route for verifying NFT tokens.
 */

register_rest_route(
	'wptokengate/v1',
	'/verify',
	array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => function( WP_REST_Request $request ) {

			$has_connection_id = $request->has_param( 'connection_id' );
			$connection_id = $request->get_param( 'connection_id' );
			$post_id = $request->get_param( 'post_id' );

			$has_post_id = $request->has_param( 'post_id' );

			if ( ! $request->has_param( 'signature' ) ) {
				return new WP_REST_Response(
					array(
						'success' => false,
						'message' => 'Missing signature parameter.',
					),
					400
				);
			}

			$signature = $request->get_param( 'signature' );

			$token_address = get_option( 'wp-verify-nft-asset-address' ); // nft token.
			$chain = 'ethereum';

			if ( $has_connection_id ) {
				$token_address = get_post_meta( $connection_id, 'tokengate-token-address', true );
				$chain = get_post_meta( $connection_id, 'tokengate-chain-id', true );
			}

			if ( empty( $token_address ) ) {
				return new WP_REST_Response(
					array(
						'success' => false,
						'message' => 'No NFT token address set.',
					),
					404
				);
			}

			$app_config         = wptgv_get_config();
			$verification_route = $app_config['backend_url'] . '/verify-ownership';

			$request = wp_remote_post(
				$verification_route,
				array(
					'headers'     => array( 'Content-Type' => 'application/json' ),
					'blocking'    => true,
					'timeout'     => 20,
					'body'        => wp_json_encode(
						array(
							'signature'     => $signature,
							'token_address' => $token_address,
							'chain'         => web3tg_fs()->can_use_premium_code__premium_only() ? $chain : 'ethereum',
						)
					),
					'data_format' => 'body',
				)
			);

			$response_data = json_decode( wp_remote_retrieve_body( $request ), true );
			$current_token_balance = isset( $response_data['currentBalance'] ) ? $response_data['currentBalance'] : 0;

			$response_code = wp_remote_retrieve_response_code( $request );
			$is_success = 200 === $response_code;

			$success_text = get_option( 'wp-verify-nft-success-text' );
			$failure_text = get_option( 'wp-verify-nft-failure-text' );

			if ( $has_connection_id ) {
				$success_text = apply_filters( 'web3_token_gate_success_output', wptgv_get_verification_output( $connection_id, 'success' ), $connection_id, $current_token_balance );
				$failure_text = apply_filters( 'web3_token_gate_failure_output', wptgv_get_verification_output( $connection_id, 'failure' ), $connection_id, $current_token_balance );

				// Updating success.
				$is_success = apply_filters( 'web3_token_gate_is_success', $is_success, $connection_id, $current_token_balance );
			}

			if ( $has_post_id ) {
				// Checking output type.
				$output_type = get_post_meta( $post_id, 'tokengate-success-output-type', true );

				if ( 'page-content' === $output_type ) {
					$output_post = get_post( $post_id );

					$success_text = apply_filters(
						'the_content',
						$output_post->post_content
					);

					$is_success = apply_filters( 'web3_token_gate_is_success', $is_success, $connection_id, $current_token_balance );
				}
			}

			if ( $is_success ) {
				return new WP_REST_Response(
					array(
						'success' => true,
						'message' => do_blocks( $success_text ),
					),
					200
				);
			} else {
				return new WP_REST_Response(
					array(
						'success' => false,
						'message' => do_blocks( $failure_text ),
					),
					500
				);
			}

		},
	)
);


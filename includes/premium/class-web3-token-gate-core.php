<?php
/**
 * All the core necessacities are handled in this file.
 *
 * Note: Necessary file for the premium version.
 *
 * @package WPTokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

class WEB3_Token_Gate_Core {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'the_content', array( $this, 'handle_automatic_gate_connections' ), 999999 );
	}

	/**
	 * All the registerations should be done here.
	 *
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'                  => _x( 'Connections', 'Post type general name', 'wp-token-gate' ),
			'singular_name'         => _x( 'Connection', 'Post type singular name', 'wp-token-gate' ),
			'menu_name'             => _x( 'Connections', 'Admin Menu text', 'wp-token-gate' ),
			'name_admin_bar'        => _x( 'Connection', 'Add New on Toolbar', 'wp-token-gate' ),
			'add_new'               => __( 'Add New', 'wp-token-gate' ),
			'add_new_item'          => __( 'Add New connection', 'wp-token-gate' ),
			'new_item'              => __( 'New connection', 'wp-token-gate' ),
			'edit_item'             => __( 'Edit connection', 'wp-token-gate' ),
			'view_item'             => __( 'View connection', 'wp-token-gate' ),
			'all_items'             => __( 'Connections', 'wp-token-gate' ),
			'search_items'          => __( 'Search connections', 'wp-token-gate' ),
			'parent_item_colon'     => __( 'Parent connections:', 'wp-token-gate' ),
			'not_found'             => __( 'No connections found.', 'wp-token-gate' ),
			'not_found_in_trash'    => __( 'No connections found in Trash.', 'wp-token-gate' ),
			'featured_image'        => _x( 'Connection Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wp-token-gate' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wp-token-gate' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wp-token-gate' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wp-token-gate' ),
			'archives'              => _x( 'Connection archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wp-token-gate' ),
			'insert_into_item'      => _x( 'Insert into connection', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wp-token-gate' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this connection', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wp-token-gate' ),
			'filter_items_list'     => _x( 'Filter connections list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wp-token-gate' ),
			'items_list_navigation' => _x( 'Connections list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wp-token-gate' ),
			'items_list'            => _x( 'Connections list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wp-token-gate' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'Connection custom post type.',
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'web3-token-gate',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'connection' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array( 'title', 'editor', 'custom-fields' ),
			'show_in_rest'       => true,
			'template_lock'      => true,
			'template'           => array(
				array(
					'web3tokengate/verification-output',
					array(
						'type'  => 'success',
						'align' => 'full',
					),
					array(
						array(
							'core/heading',
							array(
								'textAlign' => 'center',
								'content'   => 'You have valid token',
							),
						),
						array(
							'core/paragraph',
							array(
								'align'   => 'center',
								'content' => 'Congratulations! You have a valid NFT token.',
							),
						),
					),
				),
				array(
					'core/spacer',
					array(
						'height' => 20,
					),
				),
				array(
					'web3tokengate/verification-output',
					array(
						'type'  => 'failure',
						'align' => 'full',
					),
					array(
						array(
							'core/heading',
							array(
								'textAlign' => 'center',
								'content'   => 'You don\'t have valid token',
							),
						),
						array(
							'core/paragraph',
							array(
								'align'   => 'center',
								'content' => 'Seems like you don\'t own the valid token.',
							),
						),
					),
				),
			),
		);

		/**
		 * For All Post types.
		 */

		register_meta(
			'post',
			'tokengate-connection-gate',
			array(
				'default'      => -1,
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'integer',
			)
		);

		register_meta(
			'post',
			'tokengate-success-output-type',
			array(
				'default'      => 'page-content', // Can either be 'page-content' or 'connection-content'.
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);

		$post_type_key = 'web3tg-connections';

		register_post_type( $post_type_key, $args );

		register_post_meta(
			$post_type_key,
			'tokengate-token-address',
			array(
				'default'      => '',
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',

			)
		);

		register_post_meta(
			$post_type_key,
			'tokengate-button-classname',
			array(
				'default'      => '',
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',

			)
		);

		register_post_meta(
			$post_type_key,
			'tokengate-chain-id',
			array(
				'default'      => 'ethereum',
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',

			)
		);

	}

	/**
	 * Handles automatic gate connection using metadata.
	 *
	 * @param string $content - Page/Post Content.
	 *
	 * @return string
	 */
	public function handle_automatic_gate_connections( $content ) {
		$current_post_id = get_the_ID();
		$output_type     = get_post_meta( $current_post_id, 'tokengate-success-output-type', true );

		$automatic_gate_connection_id = get_post_meta( $current_post_id, 'tokengate-connection-gate', true );

		// Exiting early.
		if ( empty( $automatic_gate_connection_id ) || '' === $automatic_gate_connection_id || -1 === $automatic_gate_connection_id || '-1' === $automatic_gate_connection_id ) {
			return $content;
		}

		if ( 'page-content' === $output_type ) {
			// Removing the current post content, so it can re-appear from fetch request later.
			$content = '';
		}

		$content = web3_token_gate_merge_connection( $automatic_gate_connection_id, $content, $current_post_id );

		return $content;
	}
}

new WEB3_Token_Gate_Core();

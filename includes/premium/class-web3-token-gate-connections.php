<?php
/**
 * All the additional work related to connections is done here.
 *
 * @package WPTokenGate
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

class WEB3_Token_Gate_Connections {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'manage_web3tg-connections_posts_columns', array( $this, 'add_table_headers' ) );
		add_action( 'manage_web3tg-connections_posts_custom_column', array( $this, 'add_table_data' ), 10, 2 );
		add_action( 'admin_notices', array( $this, 'render_instructions' ) );

	}

	/**
	 * Renders the instructions for the connections.
	 *
	 * @return void
	 */
	public function render_instructions() {

		$current_screen = get_current_screen();

		if ( 'edit' === $current_screen->base && 'web3tg-connections' === $current_screen->post_type ) {
			?>
			<div class="notice-info notice" style="box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
				<h3>
					<?php echo esc_html_e( 'Web3 Token Gate Instructions', 'web3-token-gate' ); ?>
				</h3>
				<p>
					<?php echo esc_html_e( 'You can start validating your NFT Tokens very quickly with Web3 token gate. Here are a list of instructions.', 'web3-token-gate' ); ?>
				</p>
				<ol>
					<li>
						<strong>
							<?php echo esc_html_e( 'Creating a new Connection', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Create a new connection using the "Add New" button.', 'web3-token-gate' ); ?>
					</li>
					<li>
						<strong>
							<?php echo esc_html_e( 'Add Token Address', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Add your token address via the "Token Address" panel inside the connection.', 'web3-token-gate' ); ?>
					</li>
					<li>
						<strong>
							<?php echo esc_html_e( 'Add Chain Id', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Add your chain id via the "Chain Id" panel inside the connection. By default Web3 token gate uses ethereum chain', 'web3-token-gate' ); ?>
					</li>
					<li>
						<strong>
							<?php echo esc_html_e( 'Create Success and Failure Outputs', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Create custom outputs for success and failure verification result.', 'web3-token-gate' ); ?>
					</li>
					<li>
						<strong>
							<?php echo esc_html_e( 'Publish the Connection', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Pubish your newly made connection so that it is ready for the validation.', 'web3-token-gate' ); ?>
					</li>
					<li>
						<strong>
							<?php echo esc_html_e( 'Using Shortcode', 'web3-token-gate' ); ?>
						</strong>
						<?php echo esc_html_e( 'Use the "app shortcode" for rendering the validation app and the "verification shortcode" for rendering the validation result.', 'web3-token-gate' ); ?>
					</li>
					
				</ol>
			</div>
			<?php
		}

	}

	/**
	 * Adds new custom table headers to the connection CPT.
	 *
	 * @param array $columns - Current cols.
	 *
	 * @return array - Mutated columns.
	 */
	public function add_table_headers( $columns ) {
		// Shifting date to the end.
		$date_col = $columns['date'];

		unset( $columns['date'] );

		$columns['token-address']          = __( 'Token Address', 'wp-token-gate' );
		$columns['chain-id']               = __( 'Chain', 'wp-token-gate' );
		$columns['app-shortcode']          = __( 'App Shortcode', 'wp-token-gate' );
		$columns['verification-shortcode'] = __( 'Verification Shortcode', 'wp-token-gate' );

		$columns['date'] = $date_col;

		return $columns;
	}

	/**
	 * Adds new data to the connection CPT.
	 *
	 * @param array $columns - Current column id.
	 * @param int   $post_id - Current post id.
	 *
	 * @return void
	 */
	public function add_table_data( $column, $post_id ) {
		switch ( $column ) {
			case 'token-address':
				$address = get_post_meta( $post_id, 'tokengate-token-address', true );
				echo WEB3_Token_Gate_ClipboardField::render( $address );
				break;

			case 'app-shortcode':
				echo WEB3_Token_Gate_ClipboardField::render( '[tokengate-verify-app id="' . $post_id . '"]' );
				break;

			case 'verification-shortcode':
				echo WEB3_Token_Gate_ClipboardField::render( '[tokengate-output id="' . $post_id . '"]' );
				break;

			case 'chain-id':
				$chain_id = get_post_meta( $post_id, 'tokengate-chain-id', true );
				echo $chain_id;
				break;
		}
	}


}

new WEB3_Token_Gate_Connections();

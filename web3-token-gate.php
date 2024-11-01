<?php

/**
 * Plugin Name: Web3 Token Gate
 * Description: Web3 Token Gate allows users to show hidden content only to those that verify they own a specific Ethereum NFT in their cryptocurrency wallet. Web3 Token Gate authenticates the user and checks ownership of their crypto wallet.
 * Author: W3P
 * Author URI:  https://web3plugins.com/wordpress-plugins/web3-token-gate/
 * Version: 1.0.4
 * Requires at least: 5.8.3
 * Requires PHP: 5.7
 * Text Domain: web3-token-gate
 * Domain Path: /languages
 * Tested up to: 6.2.2
 *
 * @package WEB3TokenGate
 */
if ( !defined( 'ABSPATH' ) ) {
    die( 'No direct access' );
}
if ( !defined( 'WPVNFT_DIR_PATH' ) ) {
    define( 'WPVNFT_DIR_PATH', \plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPVNFT_PLUGIN_URL' ) ) {
    define( 'WPVNFT_PLUGIN_URL', \plugins_url( '/', __FILE__ ) );
}
if ( !defined( 'WPVNFT_PLUGIN_BASE_NAME' ) ) {
    define( 'WPVNFT_PLUGIN_BASE_NAME', \plugin_basename( __FILE__ ) );
}
if ( is_readable( WPVNFT_DIR_PATH . 'lib/autoload.php' ) ) {
    include_once WPVNFT_DIR_PATH . 'lib/autoload.php';
}

if ( !class_exists( 'WEB3_Token_Gate' ) ) {
    /**
     * Main plugin class
     */
    final class WEB3_Token_Gate
    {
        /**
         * Var to make sure we only load once
         *
         * @var boolean $loaded
         */
        public static  $loaded = false ;
        /**
         * Constructor
         *
         * @return void
         */
        public function __construct()
        {
            
            if ( function_exists( 'web3tg_fs' ) ) {
                web3tg_fs()->set_basename( false, __FILE__ );
            } else {
                
                if ( !function_exists( 'web3tg_fs' ) ) {
                    // Create a helper function for easy SDK access.
                    function web3tg_fs()
                    {
                        global  $web3tg_fs ;
                        
                        if ( !isset( $web3tg_fs ) ) {
                            // Include Freemius SDK.
                            require_once dirname( __FILE__ ) . '/freemius/start.php';
                            $web3tg_fs = fs_dynamic_init( array(
                                'id'              => '11132',
                                'slug'            => 'web3-token-gate',
                                'type'            => 'plugin',
                                'public_key'      => 'pk_c0aa573b841e25b3e48acf2927a3f',
                                'is_premium'      => false,
                                'premium_suffix'  => 'Pro',
                                'has_addons'      => false,
                                'has_paid_plans'  => true,
                                'has_affiliation' => 'all',
                                'menu'            => array(
                                'slug' => 'web3-token-gate',
                            ),
                                'is_live'         => true,
                            ) );
                        }
                        
                        return $web3tg_fs;
                    }
                    
                    // Init Freemius.
                    web3tg_fs();
                    // Signal that SDK was initiated.
                    do_action( 'web3tg_fs_loaded' );
                }
            
            }
            
            require_once WPVNFT_DIR_PATH . 'includes/helpers.php';
            require_once WPVNFT_DIR_PATH . 'includes/views/clipboard-field.php';
            require_once WPVNFT_DIR_PATH . 'includes/class-web3-token-gate-admin.php';
            require_once WPVNFT_DIR_PATH . 'includes/class-web3-token-gate-frontend.php';
            require_once WPVNFT_DIR_PATH . 'includes/rest-api/rest.php';
            require_once WPVNFT_DIR_PATH . 'includes/class-web3-token-gate-settings.php';
            if ( web3tg_fs()->is_free_plan() ) {
                require_once WPVNFT_DIR_PATH . 'includes/class-web3-token-gate-shortcode.php';
            }
        }
    
    }
    new WEB3_Token_Gate();
}

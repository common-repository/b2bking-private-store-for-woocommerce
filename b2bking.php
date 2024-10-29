<?php
/*
/**
 * Plugin Name:       Private Store for WooCommerce B2B & Wholesale by B2BKing
 * Plugin URI:        https://kingsplugins.com/woocommerce-wholesale/b2bking/
 * Description:       B2BKing is the ultimate plugin solution for B2B and Wholesale stores with 137+ features, handling everything from business registration, to wholesale pricing, catalog visibility, tax exemptions, and much more.
 * Version:           1.1.2
 * Author:            WebWizards
 * Author URI:        webwizards.dev
 * Text Domain:       b2bking
 * Domain Path:       /languages
 * WC requires at least: 5.0.0
 * WC tested up to: 8.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'B2BKINGPRIVATE_DIR', plugin_dir_path( __FILE__ ) );

require B2BKINGPRIVATE_DIR . 'includes/class-b2bking.php';

// Load plugin language
add_action( 'init', 'b2bkingpriv_load_language');
function b2bkingpriv_load_language() {
   load_plugin_textdomain( 'b2bking', FALSE, basename( dirname( __FILE__ ) ) . '/languages');
}

// Begins execution of the plugin.
function b2bkingpriv_run() {
	$plugin = new B2bkingpriv();
}

if (!defined('B2BKINGMAIN_DIR')){
	b2bkingpriv_run();
}

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );
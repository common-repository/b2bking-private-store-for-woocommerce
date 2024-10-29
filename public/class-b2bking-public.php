<?php

class B2bkingpriv_Public{

	function __construct() {
		
		add_action('plugins_loaded', function(){

			// Only load if WooCommerce is activated
			if ( class_exists( 'woocommerce' ) ) {

				// Check that plugin is enabled
				if ( get_option('b2bking_plugin_status_setting', 'disabled') !== 'disabled' ){

					/* Guest access restriction settings: */
					// Hide prices
					if (!is_user_logged_in()){
						if (get_option('b2bking_guest_access_restriction_setting', 'hide_prices') === 'hide_prices'){	
							add_filter( 'woocommerce_get_price_html', array($this, 'b2bking_hide_prices_guest_users'), 9999, 2 );
							add_filter( 'woocommerce_variation_get_price_html', array($this, 'b2bking_hide_prices_guest_users'), 9999, 2 );
							// Hide add to cart button as well / purchasable capabilities
							add_filter( 'woocommerce_is_purchasable', array($this, 'b2bking_disable_purchasable_guest_users'));
							add_filter( 'woocommerce_variation_is_purchasable', array($this, 'b2bking_disable_purchasable_guest_users'));
						}
						// Hide website completely ( force login )
						if (get_option('b2bking_guest_access_restriction_setting', 'hide_prices') === 'hide_website_completely'){
							add_action( 'wp', array($this, 'b2bking_member_only_site') );
						}
					}
				}
			}
		});
	}

	// Hide prices to guest users
	function b2bking_hide_prices_guest_users( $price, $product ) {
		// if user is guest
		if (!is_user_logged_in()){
			return wp_kses(get_option('b2bking_hide_prices_guests_text_setting', esc_html__('Login to view prices','b2bking')), array('a' => array('href'  => array())));
		} else {
			return $price;
		}
	}

	function b2bking_disable_purchasable_guest_users($purchasable){
		// if user is guest
		if (!is_user_logged_in()){
			return false;
		} else {
			return $purchasable;
		}
	}

	function b2bking_member_only_site() {
	    if ( !is_user_logged_in() && (get_current_user_id() === 0) ) {
	        auth_redirect();
	    }
	}
    	
}


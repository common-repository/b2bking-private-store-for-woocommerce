<?php

class B2bkingpriv_Admin{

	function __construct() {

		// Require WooCommerce notification
		add_action( 'admin_notices', array($this, 'b2bking_plugin_dependencies') );
		// Load admin notice resources (enables notification dismissal)
		add_action( 'admin_enqueue_scripts', array($this, 'load_global_admin_notice_resource') ); 

		add_action( 'plugins_loaded', function(){
			if ( class_exists( 'woocommerce' ) ) {

				/* Load resources */
				// Only load scripts and styles in this specific admin page
				add_action( 'admin_enqueue_scripts', array($this, 'load_admin_resources') );

				/* Settings */
				// Registers settings
				add_action( 'admin_init', array( $this, 'b2bking_settings_init' ) );
				// Renders settings 
				add_action( 'admin_menu', array( $this, 'b2bking_settings_page' ) ); 

			}
		});
	}

	function b2bking_settings_page() {
		// Admin Menu Settings 
		$page_title = 'B2BKing';
		$menu_title = 'B2BKing';
		$capability = 'manage_woocommerce';
		$slug = 'b2bking';
		$callback = array( $this, 'b2bking_settings_page_content' );

		$iconurl = plugins_url('../includes/assets/images/b2bking-icon.svg', __FILE__);
		$position = 57;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $iconurl, $position );

		// Add "Dashboard" submenu page
		add_submenu_page(
	        'b2bking',
	        'Settings', //page title
	        'Settings', //menu title
	        'manage_woocommerce', //capability,
	        'b2bking',//menu slug
	        '', //callback function
	    	0	
	    );

		// Build plugin file path relative to plugins folder
		$absolutefilepath = dirname(plugins_url('', __FILE__),1);
		$pluginsurllength = strlen(plugins_url())+1;
		$relativepath = substr($absolutefilepath, $pluginsurllength);

		// Add the action links
		add_filter('plugin_action_links_'.$relativepath.'/b2bking.php', array($this, 'b2bking_action_links') );
		// Add row meta links
		add_filter( 'plugin_row_meta', array($this, 'b2bking_plugin_row_meta'), 10, 4 );
	}

	function b2bking_plugin_row_meta( $links_array, $plugin_file_name, $plugin_data, $status ){

		// Build plugin file path relative to plugins folder
		$absolutefilepath = dirname(plugins_url('', __FILE__),1);
		$pluginsurllength = strlen(plugins_url())+1;
		$relativepath = substr($absolutefilepath, $pluginsurllength);
	 
		if( $plugin_file_name == $relativepath.'/b2bking.php' ) {
			$links_array[] = '<a href="https://kingsplugins.com/woocommerce-wholesale/b2bking/">Get B2BKing</a>';
		}
	 
		return $links_array;
	}
	
	function b2bking_action_links( $links ) {
		// Build and escape the URL.
		$url = esc_url( add_query_arg('page', 'b2bking', get_admin_url() . 'admin.php') );

		// Create the link.
		$settings_link = '<a href='.esc_attr($url).'>' . esc_html__( 'Settings', 'b2bking' ) . '</a>';

		// Create the link.
		$upgrade_link = '<a href="https://kingsplugins.com/woocommerce-wholesale/b2bking/">' . esc_html__( 'Get B2BKing', 'b2bking' ) . '</a>';
		
		// Adds the link to the end of the array.
		array_unshift($links,	$upgrade_link );
		array_unshift($links,	$settings_link );
		return $links;
	}

	
	function b2bking_settings_init(){
		require_once ( B2BKINGPRIVATE_DIR . 'admin/class-b2bking-settings.php' );
		$settings = new B2bkingpriv_Settings;
		$settings-> register_all_settings();
	}
	
	function b2bking_settings_page_content() {
		require_once ( B2BKINGPRIVATE_DIR . 'admin/class-b2bking-settings.php' );
		$settings = new B2bkingpriv_Settings;
		$settings-> render_settings_page_content();
	}

	function load_global_admin_notice_resource(){
		wp_enqueue_script( 'b2bking_global_admin_notice_script', plugins_url('assets/js/adminnotice.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);

		// Send data to JS
		$data_js = array(
			'security'  => wp_create_nonce( 'b2bking_notice_security_nonce' ),
		);
		wp_localize_script( 'b2bking_global_admin_notice_script', 'b2bking_notice', $data_js );
		
	}

	function load_admin_resources($hook) {

		wp_enqueue_style ( 'b2bking_admin_style_global', plugins_url('assets/css/adminglobal.css', __FILE__));

		// Load only on this specific plugin admin
		if($hook != 'toplevel_page_b2bking') {
			return;
		}
		
		wp_enqueue_script('jquery');

		wp_enqueue_script('semantic', plugins_url('../includes/assets/lib/semantic/semantic.min.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);
		wp_enqueue_style( 'semantic', plugins_url('../includes/assets/lib/semantic/semantic.min.css', __FILE__));

		wp_enqueue_style ( 'b2bking_admin_style', plugins_url('assets/css/adminstyle.css', __FILE__));
		wp_enqueue_script( 'b2bking_admin_script', plugins_url('assets/js/admin.js', __FILE__), $deps = array(), $ver = false, $in_footer =true);

		wp_enqueue_style( 'b2bking_style', plugins_url('../includes/assets/css/style.css', __FILE__)); 

	}


	function b2bking_plugin_dependencies() {
		if ( ! class_exists( 'woocommerce' ) ) {
			// if notice has not already been dismissed once by the current user
			if (intval(get_user_meta(get_current_user_id(),'b2bking_dismiss_activate_woocommerce_notice', true)) !== 1){
	    		?>
	    	    <div class="b2bking_activate_woocommerce_notice notice notice-warning is-dismissible">
	    	        <p><?php esc_html_e( 'Warning: The plugin "Private Store by B2BKing" requires WooCommerce to be installed and activated.', 'b2bking' ); ?></p>
	    	    </div>
    	    	<?php
    	    }
		}
	}


}

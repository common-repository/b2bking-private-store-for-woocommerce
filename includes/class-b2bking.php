<?php

class B2bkingpriv {

	function __construct() {

		// Run Admin/Public code 
		if ( is_admin() ) { 
			require_once B2BKINGPRIVATE_DIR . '/admin/class-b2bking-admin.php';
			$admin = new B2bkingpriv_Admin();
		} else if ( !$this->b2bking_is_login_page() ) {
			require_once B2BKINGPRIVATE_DIR . '/public/class-b2bking-public.php';
			$public = new B2bkingpriv_Public();
		}
	
	}

	// Helps prevent public code from running on login / register pages, where is_admin() returns false
	function b2bking_is_login_page() {
		if(isset($GLOBALS['pagenow'])){
	    	return in_array( $GLOBALS['pagenow'],array( 'wp-login.php', 'wp-register.php', 'admin.php' ),  true  );
	    }
	}

}


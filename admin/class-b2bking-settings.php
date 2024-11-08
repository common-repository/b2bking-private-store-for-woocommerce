<?php

/**
*
* PHP File that handles Settings management
*
*/

class B2bkingpriv_Settings {

	public function register_all_settings() {

		// Set plugin status (Disabled, B2B & B2C, or B2B)
		register_setting('b2bking', 'b2bking_plugin_status_setting');

		// Current Tab Setting - Misc setting, hidden, only saves the last opened menu tab
		register_setting( 'b2bking', 'b2bking_current_tab_setting');
		add_settings_field('b2bking_current_tab_setting', '', array($this, 'b2bking_current_tab_setting_content'), 'b2bking', 'b2bking_hiddensettings');

		/* Access restriction */

		// Set guest access restriction (none, hide prices, hide website, replace with request quote)
		register_setting('b2bking', 'b2bking_guest_access_restriction_setting');

		add_settings_section('b2bking_access_restriction_settings_section', '',	'',	'b2bking');

		/* Language Settings */

		add_settings_section('b2bking_languagesettings_text_section', '',	'',	'b2bking');

		// Hide prices to guests text
		register_setting('b2bking', 'b2bking_hide_prices_guests_text_setting');
		add_settings_field('b2bking_hide_prices_guests_text_setting', esc_html__('Hide prices to guests text', 'b2bking'), array($this,'b2bking_hide_prices_guests_text_setting_content'), 'b2bking', 'b2bking_languagesettings_text_section');

	}

	// This function remembers the current tab as a hidden input setting. When the page loads, it goes to the saved tab
	function b2bking_current_tab_setting_content(){
		echo '
		 <input type="hidden" id="b2bking_current_tab_setting_input" name="b2bking_current_tab_setting" value="'.esc_attr(get_option( 'b2bking_current_tab_setting', 'accessrestriction' )).'">
		';
	}

	function b2bking_hide_prices_guests_text_setting_content(){
		echo '
		<div class="ui form">
			<div class="field">
				<label>'.esc_html__('What guests see when "Hide prices to guests" is enabled','b2bking').'</label>
				<input type="text" name="b2bking_hide_prices_guests_text_setting" value="'.esc_attr(get_option('b2bking_hide_prices_guests_text_setting', esc_html__('Login to view prices','b2bking'))).'">
			</div>
		</div>
		';
	}

	
	public function render_settings_page_content() {
		?>

		<!-- Admin Menu Page Content -->
		<form id="b2bking_admin_form" method="POST" action="options.php">
			<?php settings_fields('b2bking'); ?>
			<?php do_settings_fields( 'b2bking', 'b2bking_hiddensettings' ); ?>

			<div id="b2bking_admin_wrapper" >

				<!-- Admin Menu Tabs --> 
				<div id="b2bking_admin_menu" class="ui labeled stackable large vertical menu attached">
					<img id="b2bking_menu_logo" src="<?php echo plugins_url('../includes/assets/images/logo.png', __FILE__); ?>">
					<a class="green item <?php echo $this->b2bking_isactivetab('accessrestriction'); ?>" data-tab="accessrestriction">
						<i class="unlock icon"></i>
						<div class="header"><?php esc_html_e('Private Store','b2bking'); ?></div>
						<span class="b2bking_menu_description"><?php esc_html_e('Hide prices & store','b2bking'); ?></span>
					</a>
					<a class="green item <?php echo $this->b2bking_isactivetab('upgrade'); ?>" data-tab="upgrade">
						<i class="dolly icon"></i>
						<div class="header"><?php esc_html_e('Upgrade to B2BKing','b2bking'); ?></div>
						<span class="b2bking_menu_description"><?php esc_html_e('Get 137+ Premium Features','b2bking'); ?></span>
					</a>
					
				
				</div>
			
				<!-- Admin Menu Tabs Content--> 
				<div id="b2bking_tabs_wrapper">

					<!-- Access Restriction Tab--> 
					<div class="ui bottom attached tab segment <?php echo $this->b2bking_isactivetab('accessrestriction'); ?>" data-tab="accessrestriction">
						<div class="b2bking_attached_content_wrapper">
							<h2 class="ui block header">
								<i class="unlock icon"></i>
								<div class="content">
									<?php esc_html_e('Private Store for WooCommerce by B2BKing','b2bking'); ?>
									<div class="sub header">
										<?php esc_html_e('Hide prices & store','b2bking'); ?>
									</div>
								</div>
							</h2>
							<table class="form-table">
								<div class="ui info message">
								  <i class="close icon"></i>
								  <div class="header"> <i class="question circle icon"></i>
								  	<?php esc_html_e('Documentation','b2bking'); ?>
								  </div>
								  <ul class="list">
								    <li><a href="https://kingsplugins.com/woocommerce-wholesale/b2bking/"><?php esc_html_e('Plugin Status - options explained','b2bking'); ?></a></li>
								     <li><a href="https://kingsplugins.com/woocommerce-wholesale/b2bking/"><?php esc_html_e('Guest Access Restriction - functionality explained','b2bking'); ?></a></li>
								  </ul>
								</div>
								<div class="ui large form b2bking_plugin_status_container">
								  <div class="inline fields">
								    <label><?php esc_html_e('Plugin Status','b2bking'); ?></label>
								    <div class="field">
								      <div class="ui checkbox">
								        <input type="radio" tabindex="0" class="hidden" name="b2bking_plugin_status_setting" value="disabled" <?php checked('disabled',get_option( 'b2bking_plugin_status_setting', 'disabled' ), true); ?>">
								        <label><?php esc_html_e('Disabled','b2bking'); ?></label>
								      </div>
								    </div>
								    <div class="field">
								      <div class="ui checkbox">
								        <input type="radio" tabindex="0" class="hidden" name="b2bking_plugin_status_setting" value="b2b" <?php checked('b2b',get_option( 'b2bking_plugin_status_setting', 'disabled' ), true); ?>">
								        <label><i class="dolly icon"></i>&nbsp;<?php esc_html_e('Enabled','b2bking'); ?></label>
								      </div>
								    </div>
								    
								  </div>
								</div>
							</table>
		

							<table class="form-table">
								<div class="ui large form b2bking_plugin_status_container">
									<label class="b2bking_access_restriction_label"><?php esc_html_e('Guest Access Restriction','b2bking'); ?></label>

								  <div class="inline fields">
								    <div class="field">
								      <div class="ui checkbox">
								        <input type="radio" tabindex="0" class="hidden" name="b2bking_guest_access_restriction_setting" value="none" <?php checked('none', get_option( 'b2bking_guest_access_restriction_setting', 'hide_prices' ), true); ?>">
								        <label><?php esc_html_e('None','b2bking'); ?></label>
								      </div>
								    </div>
								    <div class="field">
								      <div class="ui checkbox">
								        <input type="radio" tabindex="0" class="hidden" name="b2bking_guest_access_restriction_setting" value="hide_prices" <?php checked('hide_prices', get_option( 'b2bking_guest_access_restriction_setting', 'hide_prices' ), true); ?>">
								        <label><i class="eye slash icon"></i><?php esc_html_e('Hide prices for guests','b2bking'); ?></label>
								      </div>
								    </div>
								   
								    <div class="field">
								      <div class="ui checkbox">
								        <input type="radio" tabindex="0" class="hidden" name="b2bking_guest_access_restriction_setting" value="hide_website_completely" <?php checked('hide_website_completely', get_option( 'b2bking_guest_access_restriction_setting', 'hide_prices' ), true); ?>">
								        <label><i class="lock icon"></i><?php esc_html_e('Hide website & force login','b2bking'); ?></label>
								      </div>
								    </div>
								    
								  </div>
								</div>
								<?php do_settings_fields('b2bking', 'b2bking_languagesettings_text_section');?>
							</table>

						</div>
					</div>

					<!-- Upgrade Tab--> 
					<div class="ui bottom attached tab segment <?php echo $this->b2bking_isactivetab('upgrade'); ?>" data-tab="upgrade">
						<div class="b2bking_attached_content_wrapper">
							<h2 class="ui block header">
								<i class="dolly icon"></i>
								<div class="content">
									<?php esc_html_e('Get B2BKing - The Ultimate B2B & Wholesale Plugin for WooCommerce','b2bking'); ?>
									<div class="sub header">
										<?php esc_html_e('Get the #1 wholesale solution for WooCommerce','b2bking'); ?>
									</div>
								</div>
							</h2>
							<a class="b2bking_button_color_gold" href="https://kingsplugins.com/woocommerce-wholesale/b2bking/"><button class="ui orange large button" type="button"><i class="dolly icon"></i>&nbsp;<?php esc_html_e('Get B2BKing for the Premium Wholesale / B2B Store Experience','b2bking'); ?></button></a>
							<div class="ui icon message">
								<i class="briefcase icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Extended Business Registration','b2bking'); ?>
									</div>
									<p><?php esc_html_e('Business registration with multiple roles dropdown, 9 types of custom fields, manual and automatic approval, VAT nr support, VIES API validation and much more. ','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="alternate list icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Wholesale Bulk Order Form','b2bking'); ?>
									</div>
									<p>
										<?php esc_html_e('Bulk order form with AJAX instant search, Search by SKU, search in product description, variation support, save form as purchase list and more! ','b2bking'); ?>
									</p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="shopping basket icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('B2B & B2C Hybrid Store Mode','b2bking'); ?>
										
									</div>
									<p>
										<?php esc_html_e('Dedicated modes for pure B2B, and B2B&B2C hybrid stores. B2B features hidden for B2C. Separate registrations. Manual approval for B2B but automatic for B2C.','b2bking'); ?>
									
									</p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="boxes icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Offers & Bundles','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Create product bundles or make negotiated offers for either groups or specific users. Set offer visibility.','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="comments icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Conversations & Messaging','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Built-in messaging system between admin and b2b users for negotiation, quotes and inquiries.','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="tags icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Request a Quote','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Receive custom quote requests in a normal store or operate exclusively via quote','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="th list icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Purchase Lists','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Allow B2B users to save lists, re-order, replenish stock, add lists to cart, etc.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="users icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Subaccounts (Multiple Buyers on Account)','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Support multiple buyers inside a company, with permissions setup for who can view products, place orders, message, etc.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="file alternate outline icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Invoice Payment Gateway','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Allow users to select an invoice option at checkout, so you can manually finalise the transaction later','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="money bill alternate outline icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Tax Exemptions','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Exempt business users from paying tax or make them pay tax in cart, depending on your required legal setup'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="dollar sign icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Wholesale Prices','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Powerful pricing setups with prices by group, by user, complex discounts, dynamic rules, minimum orders, free shipping rules, etc.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="eye slash icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Product and Category Visibility','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Hide or show products to each user or group, to create unique personalized catalogs for your users.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="retweet icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Complex Dynamic Rules','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Set complex condition-based rules for: discounts, minimum and maximum orders, free shipping, add custom taxes, zero tax products, tax exemptions, hidden prices (by product / category), etc.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="eye icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Display Price Including or Excluding Tax','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Show or hide tax, or set tax to be payable in cart. Alternatively set "withholding tax" (Ritenuta D\'acconto), for tax display only','b2bking'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="rocket icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('High Performance Caching & Usage Detection','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Caching and smart algorithms ensure the plugin and your site run smoothly.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="file excel icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('CSV Import and Export Tools','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Download price lists and set prices in excel and then import them into WooComemrce through B2BKing.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="level up alternate icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Tiered Pricing','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Through pricing conditions you can set tiered prices and bulk discounts: e.g. 1 price for 1-10 items, but another price for 10-100 items'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="building icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Groups Management','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Organize users into groups and apply all rules, pricing, discount and visibility conditions by group'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="truck icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Shipping Methods Control','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Control available shipping methods by group or by user.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="amazon pay icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Payment Methods Control','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Control available payment methods by group or by user.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="paint brush icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Full Theme Compatibility','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Compatible with any WooCommerce theme and any store. Tested with hundreds of themes including the most popular themes in the market.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="lock icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('Private Store','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('Even more features: hide b2b portal option, replace prices with quote requests, hide prices by category or by product, etc.'); ?></p>
							  	</div>
							</div>
							<div class="ui icon message">
								<i class="tasks icon b2bking_upgrade_icon"></i>
								<div class="content">
									<div class="header">
										<?php esc_html_e('137+ Features and Functionalities','b2bking'); ?>
										
									</div>
									<p><?php esc_html_e('B2BKing has many other features and we are constantly adding even more! From shortcodes that restrict content by group or user, to quantity discounts, to extended re-ordering system, multisite support, b2b customers panel, and many others, B2BKing is the ultimate solution for your b2b or wholesale store.'); ?></p>
							  	</div>
							</div>
							<a class="b2bking_button_color_gold" href="https://kingsplugins.com/woocommerce-wholesale/b2bking/"><button class="ui orange large button" type="button"><i class="dolly icon"></i>&nbsp;<?php esc_html_e('Get Started!','b2bking'); ?></button></a>
							</div>

						</div>
					</div>

				</div>
			</div>

			<br>
			<input type="submit" name="submit" id="b2bking-admin-submit" class="ui primary button" value="Save Settings">
		</form>

		<?php
	}

	function b2bking_isactivetab($tab){
		$gototab = 'accessrestriction';

		if ($tab === $gototab){
			return 'active';
		}
	}

}
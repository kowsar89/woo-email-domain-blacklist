<?php
/**
 * Plugin Name: Woo Email Domain Blacklist
 * Plugin URI: http://kowsarhossain.com/
 * Description: A lightweight plugin to block any email domain from WooCommerce checkout page
 * Version: 1.0.1
 * Author: Md. Kowsar Hossain
 * Author URI: http://kowsarhossain.com
 * Text Domain: woo-email-domain-blacklist
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'WPINC' ) ) die;

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )):
	return;
endif;

define('WEDBFOA_BASENAME', plugin_basename(__FILE__));

if ( is_admin() ):
	require_once dirname( __FILE__ ) . '/admin/class.settings-api.php';
	require_once dirname( __FILE__ ) . '/admin/wc-email-blacklist-admin.php';
	FOA_Woo_Email_Domain_Blacklist_Admin::instance();
endif;

require_once dirname( __FILE__ ) . '/public/wc-email-blacklist.php';
FOA_Woo_Email_Domain_Blacklist::instance();

register_activation_hook( __FILE__, array( 'FOA_Woo_Email_Domain_Blacklist', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'FOA_Woo_Email_Domain_Blacklist', 'deactivate' ) );
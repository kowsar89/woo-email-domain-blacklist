<?php
/**
 * Plugin Name: Woo EDD Email Domain Blacklist
 * Plugin URI: http://kowsarhossain.com/
 * Description: A lightweight plugin to block any email domain from WooCommerce and Easy Digital Download checkout page
 * Version: 2.0.0
 * Author: Md. Kowsar Hossain
 * Author URI: http://kowsarhossain.com
 * Text Domain: woo-email-domain-blacklist
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'WPINC' ) ) die;

define('WEDBFOA_BASENAME', plugin_basename(__FILE__));

if ( is_admin() ):
require_once dirname( __FILE__ ) . '/admin/class.settings-api.php';
	require_once dirname( __FILE__ ) . '/admin/email-blacklist-admin.php';
	FOA_Email_Domain_Blacklist_Admin::instance();
endif;

require_once dirname( __FILE__ ) . '/public/email-blacklist.php';
FOA_Email_Domain_Blacklist::instance();

register_activation_hook( __FILE__, array( 'FOA_Email_Domain_Blacklist', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'FOA_Email_Domain_Blacklist', 'deactivate' ) );

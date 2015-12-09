<?php

if ( class_exists('FOA_Woo_Email_Domain_Blacklist' ) ) return;

class FOA_Woo_Email_Domain_Blacklist{

    private static $instance = null;
    public $plugin_slug = 'woo-email-domain-blacklist';

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'woocommerce_checkout_process', array( $this, 'email_domain_validation' ));

        add_filter( 'cron_schedules', array( $this, 'wedb_add_weekly_schedule' ) );
        add_action( 'wedb_check_external_domain_update', array( $this, 'update_external_domains' ) );
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // textdomain
    public function load_textdomain(){
        load_plugin_textdomain( 'woo-email-domain-blacklist', false, $this->plugin_slug. '/languages/' );
    }

    // checkout page functionality
    public function email_domain_validation() {
        $options = get_option( 'foa_wc_email_blacklist', '' );

        if ( empty($options) ) return;

        // return if billing email doesn't exists
        if ( ! $_POST['billing_email'] )
            return;

        $email = trim($_POST['billing_email']);

        // return if billing email is unvalid
        if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
            return;
        }

        $status = true;
        
        // store only the domain part of email address
        $email = explode('@', $email);
        $email = $email[1];

        //get blacklisted domains from database
        $blacklists = empty($options['blacklist'])?'':$options['blacklist'];
        $blacklists = array_map('trim',explode(PHP_EOL,$blacklists));

        // add external domains
        if ( !empty($options['externalblacklist']) ) {
            $blacklists = array_merge( $blacklists, $options['externalblacklist']);
        }

        // check if user email is blacklisted
        foreach ($blacklists as $blacklist) {
            if ($blacklist == $email) {
                $status = false;
                break;
            }
        }

        // show error for blacklisted emails
        if (!$status) {
            $errornotice = empty($options['errornotice'])?__('This email domain has been blacklisted. Please try another email address', 'woo-email-domain-blacklist'):$options['errornotice'];
            wc_add_notice( __( $errornotice ), 'error' );
        }
    }

    // New Cron schedule weekly
    public function wedb_add_weekly_schedule( $schedules ) {
        $schedules['wedb_weekly'] = array(
            'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
            'display' => __( 'Run Weekly', 'woo-email-domain-blacklist' )
            );
        return $schedules;
    }   

    // Add cron on activation
    public static function activate(){
        $timestamp = wp_next_scheduled( 'wedb_check_external_domain_update' );
        if( $timestamp == false ){
            wp_schedule_event( time(), 'wedb_weekly', 'wedb_check_external_domain_update' );
        }
        
    }

    // Remove cron on deactivation
    public static function deactivate(){
        wp_clear_scheduled_hook( 'wedb_check_external_domain_update' );
    }

    // Update options on cron job
    public function update_external_domains(){
        $options = get_option( 'foa_wc_email_blacklist', '' );

        if(empty($options['enableexternal']) || $options['enableexternal'] == 'off') return;

        $result = false;
        $json_string = @file_get_contents('http://kowsarhossain.com/api/temporary-email-domains/temporary-email-domains.json');
        $json_string = trim($json_string);
        if (!empty($json_string)) {
            $result = json_decode($json_string, true);
            $result = call_user_func_array('array_merge', $result);
            $result = array_map('trim', $result);
        }

        if ($result) {
            $options['externalblacklist'] = $result;
            update_option( 'foa_wc_email_blacklist', $options );
        }
    }
}

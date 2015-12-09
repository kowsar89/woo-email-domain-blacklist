<?php

if ( class_exists('FOA_Woo_Email_Domain_Blacklist_Admin' ) ) return;

class FOA_Woo_Email_Domain_Blacklist_Admin {
    
    private static $instance = null;
    public $plugin_slug = 'woo-email-domain-blacklist';
    private $settings_api;

    private function __construct() {

        $this->settings_api = new Foa_Email_Blacklist_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );

        add_filter('plugin_action_links_'.WEDBFOA_BASENAME, array( $this, 'plugin_settings_link' ) ); 
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Settings link for plugin page
    public function plugin_settings_link($links) {
        $settings_link = '<a href="admin.php?page='.$this->plugin_slug.'">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_submenu_page( 'woocommerce', 'Email Blacklist', 'Email Blacklist', 'manage_options', $this->plugin_slug, array($this, 'plugin_page') );
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'foa_wc_email_blacklist',
                'title' => __( 'Email Blacklist', 'woo-email-domain-blacklist' )
            )
        );

        // Store external email list in database
        add_filter('sanitize_option_foa_wc_email_blacklist', array($this, 'sanitize_foa_wc_email_blacklist'), 12);

        return $sections;
    }

    /**
     * Returns all the settings fields
     *  
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'foa_wc_email_blacklist' => array(
                array(
                    'name'    => 'blacklist',
                    'label'   => __( 'Blacklist', 'woo-email-domain-blacklist' ),
                    'desc'    => __( 'Enter email domain name in each line', 'woo-email-domain-blacklist' ),
                    'type'    => 'textarea',
                    'placeholder'    => __( 'eg. yahoo.com', 'woo-email-domain-blacklist' ),
                ),
                array(
                    'name'    => 'errornotice',
                    'label'   => __( 'Error Notice', 'woo-email-domain-blacklist' ),
                    'desc'    => __( 'Error notice when a blacklisted email found', 'woo-email-domain-blacklist' ),
                    'type'    => 'textarea',
                    'placeholder'    => __( 'eg. This email domain has been blacklisted. Please try another email address', 'woo-email-domain-blacklist' ),
                ),
                array(
                    'name'    => 'enableexternal',
                    'label'   => __( 'Enable External blacklist', 'woo-email-domain-blacklist' ),
                    'desc'    => __( 'There is a list of disposable/temporary email domains in <a href="https://github.com/kowsar89/temporary-email-domains/" target="_blank">Github</a>. You can use this list too along with your own blacklist.', 'woo-email-domain-blacklist' ),
                    'type'    => 'checkbox',
                ),
            )
        );

        return $settings_fields;
    }

    // Store external email list in database
    public function sanitize_foa_wc_email_blacklist($options){
        if(empty($options['enableexternal'])) return $options;

        if ($options['enableexternal']=='on') {
            $external_list = $this->get_external_blacklisted_domains();
            if ($external_list) {
                $options['externalblacklist'] = $external_list;
            }
        }
        else{
            unset($options['externalblacklist']);
        }
        return $options;
    }

    // Helper function
    private function get_external_blacklisted_domains(){
        $result = false;
        $json_string = @file_get_contents('http://kowsarhossain.com/api/temporary-email-domains/temporary-email-domains.json');
        $json_string = trim($json_string);
        if (!empty($json_string)) {
            $result = json_decode($json_string, true);
            $result = call_user_func_array('array_merge', $result);
            $result = array_map('trim', $result);
        }
        return $result;
    }

    public function plugin_page() {
        echo '<div class="wrap">';
        $this->settings_api->show_forms();
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

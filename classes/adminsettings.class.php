<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace b_reputation;

class adminsettings extends singleton {

    protected function __construct() {
        parent::__construct();
    }

    /**
     * custom option and settings
     */
    function b_reputation_settings_init() {
        // register a new setting for "b_reputation" page
        register_setting('b_reputation_group', B_Reputation_Settings);

        // register a new section in the "b_reputation" page
        add_settings_section(
                'b_reputation_settings_section', '', '', 'b_reputation'
        );

        // register a new field under "b_reputation_settings" section in the "b_reputation" page
        add_settings_field('b_reputation_review_siren_id', __('Siren', 'b-reputation-reviews'), array(adminsettings::get_instance(), 'b_reputation_review_siren_field_cb'), 'b_reputation', 'b_reputation_settings_section', array('label_for' => B_Reputation_Siren_Field));
        // register a new field under "b_reputation_settings" section in the "b_reputation" page
        add_settings_field('b_reputation_review_company_name_id', __('Company Name', 'b-reputation-reviews'), array(adminsettings::get_instance(), 'b_reputation_review_company_name_field_cb'), 'b_reputation', 'b_reputation_settings_section', array('label_for' => B_Reputation_Company_Name_Field));
        // register a help message under "b_reputation_settings" section in the "b_reputation" page
        add_settings_field('b_reputation_review_help_label_id', '', array(adminsettings::get_instance(), 'b_reputation_review_help_label_cb'), 'b_reputation', 'b_reputation_settings_section');
    }

    /*
     * Callback Function to output siren settings field
     */

    function b_reputation_review_siren_field_cb($args) {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option(B_Reputation_Settings);

        // output the field
        ?>
        <div class="tooltip">
            <input type="text" name="b_reputation_settings[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo isset($setting[B_Reputation_Siren_Field]) ? esc_attr($setting[B_Reputation_Siren_Field]) : ''; ?>" placeholder="<?php _e('Siren', 'b-reputation-reviews') ?>">
            <span class="tooltiptext"><?php _e('Enter your company\'s siren', 'b-reputation-reviews') ?></span>
        </div>
        <?php
    }

    /*
     * Callback Function to output company name settings field
     */

    function b_reputation_review_company_name_field_cb($args) {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option(B_Reputation_Settings);

        // output the field
        ?>
        <div class="tooltip">
            <input type="text" name="b_reputation_settings[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo isset($setting[B_Reputation_Company_Name_Field]) ? esc_attr($setting[B_Reputation_Company_Name_Field]) : ''; ?>" placeholder="<?php _e('Company Name', 'b-reputation-reviews') ?>">
            <span class="tooltiptext"><?php _e('Enter your company\'s name', 'b-reputation-reviews') ?></span>
        </div>
        <?php
    }

    /*
     * Callback Function to output company name settings field
     */

    function b_reputation_review_help_label_cb() {
        // output the field
        ?>
        <span><?php _e('Copy the following shortcode anywhere into a pages or posts: [b_reputation_display]', 'b-reputation-reviews') ?></span>
        <?php
    }

    /*
     * Function to create Sub menu page under Settings Tab
     * Callable Function : b_reputation_settings_page_html
     */

    function b_reputation_settings() {
        add_submenu_page(
                'options-general.php', __('B-Reputation reviews settings', 'b-reputation-reviews'), 'B-Reputation Settings', 'manage_options', 'b_reputation', array(adminsettings::get_instance(), 'b_reputation_settings_page_html')
        );
    }

    function b_reputation_settings_page_html() {
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?= esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output fields for the registered setting "b_reputation"
                settings_fields('b_reputation_group');
                // output setting sections and their fields
                do_settings_sections('b_reputation');
                // output save settings button
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Function to register and enqueue stylesheet
     */
    function b_reputation_register_style() {
        wp_register_style('b_reputation_admin_style', plugins_url('B-Reputation-Reviews/css/custom.css'), array(), NULL);
        wp_enqueue_style('b_reputation_admin_style');
    }

    /**
     * Function to add settings link in plugin
     */
    function add_action_links($links) {
        $mylinks = array(
            '<a href="' . admin_url('options-general.php?page=b_reputation') . '">Settings</a>',
        );
        return array_merge($links, $mylinks);
    }

}

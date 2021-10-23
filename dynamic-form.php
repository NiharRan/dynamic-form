<?php

/**
 * @link            https://dynamic-form.com
 * @since           1.0.0
 * @package         Dynamic_Form
 *
 * Plugin Name: Dynamic Form
 * Plugin URI: https://dynamic-form.com
 * Description: A dynamic form starter for plugin development.
 * Version: 1.0.0
 * Author: Nihar Ranjan Das
 * Author URI: https://nihardev.me
 * License: GPL v3
 * Text-Domain: textdomain
 */

use DynamicForm\Api\Api;
use DynamicForm\Api\Includes\AdminPanel;
use DynamicForm\Api\Models\DynamicForm;

require_once "vendor/autoload.php";


class Dynamic_Form
{
    protected $version = '1.0';


    public function __construct()
    {
        $this->register_constants();
        $this->register_shortcodes();
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deativate']);
        add_action("plugin_loaded", [$this, "init_plugin"]);
    }


    public function register_shortcodes()
    {
        add_shortcode(FORM_SHORTCODE, [$this, "add_form_shortcode"]);
    }

    public function add_form_shortcode($attr)
    {
        ob_start();
        $data['form'] = (new DynamicForm)->find_one(['shortcode' => $attr['code']]);
        extract($data);
        require_once DYN_FORM_VIEW_DIR . "shortcodes/form.php";
        return ob_get_clean();
    }


    public function register_constants()
    {
        global $wpdb;
        define("DYN_FORM_VERSION", $this->version);
        define("DYNAMIC_FORM", $wpdb->prefix . 'dynamic_form');
        define("FORM_FIELD", $wpdb->prefix . 'form_fields');
        define("FIELD_TYPE", $wpdb->prefix . 'field_types');
        define("FIELD_OPTION", $wpdb->prefix . 'field_options');


        define("FORM_SHORTCODE", "dynamicform");

        define("DYN_FORM_PLUGIN_URL", trailingslashit(plugin_dir_url(__FILE__)));
        define("DYN_FORM_PLUGIN_DIR", trailingslashit(plugin_dir_url(__FILE__)));
        define("DYN_FORM_VIEW_DIR", trailingslashit(plugin_dir_path(__FILE__) . "views"));
    }

    public function activate()
    {
        $this->create_database_schema();

        $is_installed = get_option("dyn_form_installed");
        if (!$is_installed) {
            update_option("dyn_form_installed", time());
        }

        update_option("dyn_form_installed", DYN_FORM_VERSION);
    }

    public function deativate()
    {
        global $wpdb;

        $table_name = DYNAMIC_FORM;
        $sql = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = FORM_FIELD;
        $sql = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = FIELD_TYPE;
        $sql = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = FIELD_OPTION;
        $sql = "DROP TABLE $table_name";
        $wpdb->query($sql);
    }

    public function create_database_schema()
    {
        require_once ABSPATH . "wp-admin/includes/upgrade.php";

        $table_name = DYNAMIC_FORM;
        // need to create the table for plugin
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(100) NOT NULL,
            slug VARCHAR(110) NOT NULL,
            shortcode VARCHAR(50) NOT NULL,
            classes VARCHAR(100) NULL,
            form_id VARCHAR(100) NULL,
            status TINYINT(4) DEFAULT 1,

            PRIMARY KEY  (id)
        )";
        dbDelta($sql);

        $table_name = FORM_FIELD;
        // need to create the table for plugin
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            label VARCHAR(100) NOT NULL,
            placeholder VARCHAR(110) NOT NULL,
            name VARCHAR(50) NOT NULL,
            field_id VARCHAR(100) NULL,
            dynamic_form_id INT NOT NULL,
            width VARCHAR(20) NULL,
            height VARCHAR(20) NULL,
            type VARCHAR(20) NULL,
            input_type VARCHAR(20) NULL,
            rows int(11) DEFAULT 4,
            is_required TINYINT(4) DEFAULT 0,
            status TINYINT(4) DEFAULT 1,

            PRIMARY KEY  (id)
        )";
        dbDelta($sql);

        $table_name = FIELD_TYPE;
        // need to create the table for plugin
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            status TINYINT(4) DEFAULT 1,

            PRIMARY KEY  (id)
        )";
        dbDelta($sql);

        $table_name = FIELD_OPTION;
        // need to create the table for plugin
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            form_field_id INT NOT NULL,
            value VARCHAR(100) NOT NULL,
            text VARCHAR(100) NOT NULL,
            status TINYINT(4) DEFAULT 1,

            PRIMARY KEY  (id)
        )";
        dbDelta($sql);
    }


    public function init_plugin()
    {
        new AdminPanel();
        new Api();
    }


    public static function init()
    {
        $instance = null;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }
}


function start_dynamic_form()
{
    Dynamic_Form::init();
}


start_dynamic_form();

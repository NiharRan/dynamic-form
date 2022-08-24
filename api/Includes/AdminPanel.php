<?php

namespace DynamicForm\Api\Includes;

class AdminPanel
{
    public function __construct()
    {
        add_action("admin_menu", [$this, "admin_menu"]);
        add_action("admin_enqueue_scripts", [$this, "register_assets"], 99);
    }


    public function register_assets()
    {
        $this->register_styles();
        $this->register_scripts();
    }

    public function register_styles()
    {
        wp_register_style(
            'dynamic-form-style',
            DYN_FORM_PLUGIN_URL . "assets/app.css",
            [],
            false
        );

        wp_enqueue_style("dynamic-form-style");
    }

    public function register_scripts()
    {
        wp_register_script(
            'dynamic-form-script',
            DYN_FORM_PLUGIN_URL . "assets/main.js",
            [],
            rand(),
            true
        );

        wp_enqueue_script("dynamic-form-script");
    }


    public function admin_menu()
    {
        global $submenu;
        $capability = 'manage_options';
        $slug = 'dynamic-form';

        $hook = add_menu_page(
            'Dynamic Form',
            'Dynamic Form',
            $capability,
            $slug,
            [$this, "menu_page_template"],
            "dashicons-buddicons-replies"
        );

        if (current_user_can($capability)) {
            $submenu[$slug]['/'] = ['All Forms', $capability, "admin.php?page=$slug#/"];
            $submenu[$slug]['new-form'] = ['New Form', $capability, "admin.php?page=$slug#/new-form"];
        }
    }


    public function menu_page_template()
    {
        echo '<div class="wrap"><div id="app"></div></div>';
    }
}

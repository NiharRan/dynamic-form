<?php

namespace DynamicForm\Api\Includes;

class FrontendPanel
{
    public function __construct()
    {
        add_action("wp_enqueue_scripts", [$this, "register_assets"]);
    }

    public function register_assets()
    {
        $this->register_scripts();
        $this->register_styles();
    }

    public function register_scripts()
    {
        # code...
    }

    public function register_styles()
    {
        wp_register_style(
            'dynamic-form-style-front',
            DYN_FORM_PLUGIN_URL . "assets/app.css",
            [],
            false
        );
        wp_enqueue_style("dynamic-form-style-front");
    }
}

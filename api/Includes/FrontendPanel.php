<?php

namespace DynamicForm\Api\Includes;

class FrontendPanel
{
    public function __construct()
    {
        add_action("wp_enqueue_scripts", [$this, "register_assets"]);
        add_action("init", [$this, "show_form_preview_page"]);
    }

    public function loadView($file, $data = [])
    {
        $file = DYN_FORM_VIEW_DIR . $file . '.php';
        ob_start();
        extract($data);
        if (file_exists($file)) {
            include $file;
        } else {
            return  $file . " <span style='color: red'>not exists</span>";
        }

        return ob_get_clean();
    }
    public function show_form_preview_page()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'preview-form') {
            echo $this->loadView('preview-form', $_REQUEST);
            exit;
        }
    }

    public function register_assets()
    {
        $this->register_scripts();
        $this->register_styles();
    }

    public function register_scripts()
    {
        wp_enqueue_script("jquery");
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

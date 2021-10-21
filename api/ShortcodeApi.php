<?php

namespace DynamicForm\Api;

use DynamicForm\Api\Models\DynamicForm;
use WP_REST_Controller;
use \WP_REST_Response;
use WP_REST_Server;

class ShortcodeApi extends WP_REST_Controller
{
    protected $namespace = '';
    protected $dynamic_form;
    public function __construct()
    {
        $this->dynamic_form = new DynamicForm;
        $this->namespace = 'dynamic-form/v1';
    }


    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/shortcodes',
            [
                [
                    'method' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_shortcode'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );
    }


    public function get_shortcode()
    {
        $shortcode = $this->dynamic_form->get_unique_shortcode();
        return new WP_REST_Response(['shortcode' => $shortcode]);
    }


    public function get_dynamic_forms_permission_check()
    {
        return true;
    }
}

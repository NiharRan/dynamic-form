<?php

namespace DynamicForm\Api;

use DynamicForm\Api\Models\FormEntry;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Server;

class FormEntryApi extends WP_REST_Controller
{
    protected $namespace = '';
    protected $form_entry = null;
    public function __construct()
    {
        $this->form_entry = new FormEntry();
        $this->namespace = 'dynamic-form/v1';
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/forms/entries',
            [
                [
                    'method' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );
    }


    public function store(WP_REST_Request $request)
    {
        $params = $request->get_params();
        dd($params);
    }


    public function get_dynamic_forms_permission_check()
    {
        return true;
    }
}

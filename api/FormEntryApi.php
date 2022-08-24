<?php

namespace DynamicForm\Api;

use DynamicForm\Api\Models\FormEntry;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
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
            '/entries',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'fetch_all'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );
    }

    public function fetch_all(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $rows = $this->form_entry->fetch_all($params);
        foreach ($rows as $key => $row) {
            $rows[$key]->data = json_decode($row->data);
        }

        return new WP_REST_Response($rows);
    }

    public function store(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $result = $this->form_entry->store($params);
        return new WP_REST_Response($result);
    }


    public function get_dynamic_forms_permission_check()
    {
        return true;
    }
}

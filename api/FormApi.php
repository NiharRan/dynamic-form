<?php

namespace DynamicForm\Api;

use DynamicForm\Api\Models\DynamicForm;
use DynamicForm\Api\Models\FieldOption;
use DynamicForm\Api\Models\FormField;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class FormApi extends WP_REST_Controller
{
    protected $namespace = '';
    protected $dynamic_form;
    protected $form_field;
    protected $field_option;
    public function __construct()
    {
        $this->dynamic_form = new DynamicForm;
        $this->form_field = new FormField;
        $this->field_option = new FieldOption;
        $this->namespace = 'dynamic-form/v1';
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/forms',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_dynamic_forms'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'update'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'destroy'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/forms/empty',
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'create_empty_form'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
            ]
        );


        register_rest_route(
            $this->namespace,
            '/forms/find',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'find_one'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
            ]
        );


        register_rest_route(
            $this->namespace,
            '/forms/fields',
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store_form_field_info'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'update_form_field_info'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'delete_field_info'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
            ]
        );

        register_rest_route(
            $this->namespace,
            '/forms/fields/options',
            [
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'delete_option'],
                    'permission_callback' => [$this, 'get_dynamic_forms_permission_check'],
                    'args' => $this->get_collection_params()
                ],
            ]
        );
    }

    public function create_empty_form()
    {
        $response = $this->dynamic_form->create_empty_form();
        return $response;
    }

    public function update(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $data = [
            'title' => $params['title'],
            'slug' => $params['slug'],
            'shortcode' => $params['shortcode'],
            'classes' => $params['classes'],
            'form_id' => $params['form_id'],
        ];
        $response = $this->dynamic_form->update($data, $params['id']);
        return $response;
    }

    public function get_dynamic_forms(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $response = $this->dynamic_form->get_filter_forms($params);

        return new WP_REST_Response($response);
    }

    public function destroy(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $result = $this->dynamic_form->destroy($params['id']);

        return new WP_REST_Response($result);
    }


    public function find_one(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $response = $this->dynamic_form->find($params['id']);

        return new WP_REST_Response($response);
    }


    public function store_form_field_info(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $response = $this->form_field->store($params);

        return new WP_REST_Response($response);
    }

    public function update_form_field_info(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $response = $this->form_field->update($params);

        return new WP_REST_Response($response);
    }

    public function delete_field_info(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $result = $this->form_field->destroy($params['id']);
        if ($result) {
            return new WP_REST_Response($result);
        }
        return null;
    }

    public function delete_option(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $result = $this->field_option->destroy($params['id']);
        if ($result) {
            return new WP_REST_Response($result);
        }
        return null;
    }

    public function get_dynamic_forms_permission_check()
    {
        return true;
    }
}

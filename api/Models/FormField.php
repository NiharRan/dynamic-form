<?php

namespace DynamicForm\Api\Models;

class FormField
{
    protected $table = '';
    public function __construct()
    {
        $this->table = FORM_FIELD;
    }



    public function form_fields($form_id)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $this->table WHERE dynamic_form_id=$form_id");
    }


    public function store($params)
    {
        global $wpdb;

        $data = [
            'label' => $params['label'],
            'placeholder' => $params['placeholder'],
            'name' => $params['name'],
            'field_id' => $params['field_id'],
            'width' => $params['width'],
            'height' => $params['height'],
            'type' => $params['type'],
            'is_required' => $params['is_required'],
            'dynamic_form_id' => $params['dynamic_form_id'],
        ];
        $result = $wpdb->insert($this->table, $data);

        if ($result) {
            $last_id = $wpdb->insert_id;
            $row = $this->find($last_id);

            return $row;
        }
        return null;
    }

    public function update($params)
    {
        global $wpdb;

        $data = [
            'label' => $params['label'],
            'placeholder' => $params['placeholder'],
            'name' => $params['name'],
            'field_id' => $params['field_id'],
            'width' => $params['width'],
            'height' => $params['height'],
            'type' => $params['type'],
            'is_required' => $params['is_required'],
            'dynamic_form_id' => $params['dynamic_form_id'],
        ];
        $result = $wpdb->update($this->table, $data, ['id' => $params['id']]);

        if ($result) {
            $last_id = $wpdb->insert_id;
            $row = $this->find($last_id);

            return $row;
        }
        return null;
    }

    public function find($id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE id=%d", $id));
    }
}

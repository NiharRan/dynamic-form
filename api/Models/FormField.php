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
        $fields = $wpdb->get_results("SELECT * FROM $this->table WHERE dynamic_form_id=$form_id");
        foreach ($fields as $key => $field) {
            $fields[$key]->is_required = boolval($field->is_required);
        }

        return $fields;
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
            'input_type' => $params['input_type'],
            'rows' => $params['rows'],
            'is_required' => $params['is_required'] == "true" ? 1 : 0,
            'dynamic_form_id' => $params['dynamic_form_id'],
        ];
        $wpdb->insert($this->table, $data);

        $last_id = $wpdb->insert_id;

        if (is_array($params['options']) && count($params['options']) > 0) {
            foreach ($params['options'] as $option) {
                $option = [
                    'value' => $option['value'],
                    'text' => $option['text'],
                    'form_field_id' => $last_id,
                ];
                (new FieldOption)->store($option);
            }
        }
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
            'input_type' => $params['input_type'],
            'rows' => $params['rows'],
            'is_required' => $params['is_required'] == "true" ? 1 : 0,
            'dynamic_form_id' => $params['dynamic_form_id'],
        ];
        $wpdb->update($this->table, $data, ['id' => $params['id']]);

        if (is_array($params['options']) && count($params['options']) > 0) {
            foreach ($params['options'] as $row) {
                $option = [
                    'value' => $row['value'],
                    'text' => $row['text'],
                    'form_field_id' => $params['id'],
                ];
                if ($row['id'] == 0) {
                    (new FieldOption)->store($option);
                } else {
                    $option['id'] = $row['id'];
                    (new FieldOption)->update($option);
                }
            }
        }
    }


    public function destroy($id)
    {
        global $wpdb;
        $wpdb->delete(FIELD_OPTION, ['form_field_id' => $id]);

        return $wpdb->delete($this->table, ['id' => $id]);
    }

    public function find($id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE id=%d", $id));
    }
}

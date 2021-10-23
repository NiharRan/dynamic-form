<?php

namespace DynamicForm\Api\Models;

class FieldOption
{
    protected $table = '';

    public function __construct()
    {
        $this->table = FIELD_OPTION;
    }

    public function field_options($field_id)
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM $this->table WHERE form_field_id=$field_id");
    }

    public function store($params)
    {
        global $wpdb;
        $data = [
            'form_field_id' => $params['form_field_id'],
            'text' => $params['text'],
            'value' => $params['value'],
            'status' => 1,
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
            'text' => $params['text'],
            'value' => $params['value'],
            'form_field_id' => $params['form_field_id'],
        ];
        $result = $wpdb->update($this->table, $data, ['id' => $params['id']]);

        if ($result) {
            $row = $this->find($params['id']);

            return $row;
        }
        return null;
    }

    public function find($id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE id=%d", $id));
    }


    public function destroy($id)
    {
        global $wpdb;
        return $wpdb->delete($this->table, ['id' => $id]);
    }
}

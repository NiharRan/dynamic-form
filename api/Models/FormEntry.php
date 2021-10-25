<?php

namespace DynamicForm\Api\Models;

class FormEntry
{
    protected $table = '';
    public function __construct()
    {
        $this->table = FORM_ENTRIE;
    }

    public function fetch_all($params)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $this->table ORDER BY id DESC");
    }

    public function store($params)
    {
        global $wpdb;
        unset($params['per_page']);
        unset($params['page']);
        $id = $params['id'];
        unset($params['id']);

        $data = json_encode($params);
        return $wpdb->insert($this->table, [
            'dynamic_form_id' => $id,
            'data' => $data,
        ]);
    }
}

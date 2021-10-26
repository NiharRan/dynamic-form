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
        $condition = '';
        $sql = "SELECT * FROM $this->table A";

        if (isset($params['id']) && $params['id'] != '') {
            $condition .= "A.dynamic_form_id=" . $params['id'] . " AND";
        }

        if ($condition != '') {
            $condition = " WHERE $condition ";
        }

        $condition = rtrim($condition, " AND ");
        $sql .= $condition;
        $sql .= " ORDER BY A.id DESC";
        return $wpdb->get_results($sql);
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

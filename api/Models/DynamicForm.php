<?php

namespace DynamicForm\Api\Models;

use DynamicForm\Api\Utils\RandomStringGenerator;
use WP_REST_Response;

class DynamicForm
{
    public $table;
    public function __construct()
    {
        $this->table = DYNAMIC_FORM;
    }


    public function get_unique_shortcode()
    {
        global $wpdb;
        $shortcode = '';
        while (true) {
            $shortcode = FORM_SHORTCODE;
            $rand = (new RandomStringGenerator)->generate(5);
            $shortcode = "$shortcode code=$rand";
            $result = $wpdb->get_row("SELECT * FROM $this->table WHERE shortcode='$shortcode'");
            if (!$result) {
                break;
            }
        }

        return $shortcode;
    }



    public function create_empty_form()
    {
        global $wpdb;
        $last_form = $wpdb->get_row("SELECT * FROM $this->table ORDER BY id DESC");
        $id = $last_form ? $last_form->id + 1 : 1;
        $title = "Demo Form $id";
        $slug = "demo_form_$id";
        $data = [
            'title' => $title,
            'slug' => $slug,
            'shortcode' => $this->get_unique_shortcode(),
            'classes' => '',
            'form_id' => "form-$id",

        ];
        $result = $wpdb->insert($this->table, $data);

        if ($result) {
            $last_id = $wpdb->insert_id;
            $row = $this->find($last_id);
            return new WP_REST_Response($row);
        }
        return null;
    }


    public function get_all_users($params = [])
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->table";
        $condition = '';
        if (count($params) > 0) {
            $condition = 'WHERE  ';
        }
        if (isset($params['id']) && $params['id'] != '') {
            $condition .= "id=" . $params['id'] . " AND ";
        }
        if (isset($params['name']) && $params['name'] != '') {
            $condition .= "name LIKE '%" . $params['name'] . "%' AND ";
        }
        if (isset($params['email']) && $params['email'] != '') {
            $condition .= "email LIKE '%" . $params['email'] . "%' AND ";
        }
        if (isset($params['role']) && $params['role'] != '') {
            $condition .= "role='" . $params['role'] . "' AND ";
        }
        if (isset($params['status']) && $params['status'] != '') {
            $condition .= "status=" . $params['status'] . " AND ";
        }

        $condition = rtrim($condition, " AND ");
        $sql .= " $condition";
        $sql .= " ORDER BY id DESC";

        // dd($params);

        return $wpdb->get_results($sql);
    }


    public function get_filter_forms($params = [])
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->table";
        $condition = '';
        if (isset($params['id']) && $params['id'] != '') {
            $condition .= "id=" . $params['id'] . " AND ";
        }
        if (isset($params['name']) && $params['name'] != '') {
            $condition .= "name LIKE '%" . $params['name'] . "%' AND ";
        }
        if (isset($params['email']) && $params['email'] != '') {
            $condition .= "email LIKE '%" . $params['email'] . "%' AND ";
        }
        if (isset($params['role']) && $params['role'] != '') {
            $condition .= "role='" . $params['role'] . "' AND ";
        }
        if (isset($params['status']) && $params['status'] != '') {
            $condition .= "status=" . $params['status'] . " AND ";
        }

        if ($condition != '') {
            $condition = " WHERE $condition ";
        }

        $condition = rtrim($condition, " AND ");
        $sql .= $condition;
        $sql .= " ORDER BY id DESC";

        return $wpdb->get_results($sql);
    }


    public function store($data)
    {
        global $wpdb;
        $result = $wpdb->insert($this->table, $data);

        if ($result) {
            $last_id = $wpdb->insert_id;
            return $this->find($last_id);
        }
        return null;
    }

    public function update($data, $id)
    {
        global $wpdb;
        $result = $wpdb->update($this->table, $data, array("id" => $id));

        if ($result) {
            return $this->find($id);
        }
        return null;
    }

    public function find($id)
    {
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE id=%d", $id));

        $fields = (new FormField)->form_fields($id);
        foreach ($fields as $key => $field) {
            $fields[$key]->options = (new FieldOption)->field_options($field->id);
        }
        $row->fields = $fields;
        return $row;
    }

    public function find_one($params = [])
    {
        global $wpdb;


        $condition = '';
        if (isset($params['shortcode']) && $params['shortcode'] != '') {
            $shortcode = $params['shortcode'];
            $condition .= " shortcode='$shortcode' AND";
        }

        $condition = rtrim($condition, " AND");
        if ($condition != '') {
            $condition = "WHERE $condition";
        }

        $sql = "SELECT * FROM $this->table $condition";

        $row = $wpdb->get_row($sql);

        $fields = (new FormField)->form_fields($row->id);
        foreach ($fields as $key => $field) {
            $fields[$key]->options = (new FieldOption)->field_options($field->id);
        }
        $row->fields = $fields;
        return $row;
    }

    public function destroy_many($ids = [])
    {
        global $wpdb;
        $form_field_table = FORM_FIELD;
        $field_option_table = FIELD_OPTION;

        $ids = implode(",", array_filter($ids, fn ($id) => !is_null($id) && $id != ''));

        $sql = "DELETE $this->table AS A, $form_field_table AS B , $field_option_table AS C
            FROM A
                INNER JOIN B
                    ON B.dynamic_form_id=A.id
                LEFT JOIN C
                    ON C.form_field_id=B.id
            WHERE A.id IN($ids)
        ";
        return $wpdb->query($sql);
    }

    public function destroy($id)
    {
        global $wpdb;
        $form_field_table = FORM_FIELD;
        $field_option_table = FIELD_OPTION;

        $rows = $wpdb->get_results("SELECT * FROM $form_field_table WHERE dynamic_form_id=$id");
        foreach ($rows as $row) {
            $wpdb->delete($field_option_table, ['form_field_id' => $row->id]);
            $wpdb->delete($form_field_table, ['id' => $row->id]);
        }
        return $wpdb->delete($this->table, ['id' => $id]);
    }
}

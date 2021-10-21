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
            $rand = (new RandomStringGenerator)->generate(5);
            $shortcode = "FORM-$rand";
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
            'action' => '',
            'form_id' => "form-$id",
            'has_file_upload' => false
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

        $row->fields = (new FormField)->form_fields($id);
        return $row;
    }

    public function destroy_many($ids = [])
    {
        global $wpdb;
        $ids = implode(",", array_filter($ids, fn ($id) => !is_null($id) && $id != ''));
        return $wpdb->query("DELETE FROM $this->table WHERE id IN($ids)");
    }

    public function destroy($id)
    {
        global $wpdb;
        return $wpdb->delete($this->table, ['id' => $id]);
    }
}

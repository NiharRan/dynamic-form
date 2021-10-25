<?php

namespace DynamicForm\Api\Utils;

class Validator
{
    protected $rules = [];
    protected $messages = [];
    protected $errors = [];
    protected $data = [];

    public function __construct()
    {
    }

    public function make($data, $rules, $messages = []) {
        $this->rules = $rules;
        $this->data = $data;
        $this->messages = $messages;
    }

    public function is_empty($field, $body)
    {
        if (!isset($body[$field]) || $body[$field] == '') {
            return true;
        }
        return false;
    }


    public function is_unique($field, $body)
    {
        global $wpdb;
        if ($body[$field] != '') {
            $table = SMART_TABLE;
            $data = $body[$field];
            $result = $wpdb->get_results("SELECT * FROM $table WHERE $field='$data'");
            if ($result) {
                return false;
            }
        }
        return true;
    }

    public function errors($errors)
    {
        foreach ($this->errors as $value) {
            if ($value != "") {
                return false;
            }
        }
        return true;
    }
}

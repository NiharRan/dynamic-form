<?php

namespace DynamicForm\Api\Models;

class FormEntry
{
    protected $table = '';
    public function __construct()
    {
        $this->table = FIELD_OPTION;
    }
}

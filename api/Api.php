<?php

namespace DynamicForm\Api;

class Api
{
    public function __construct()
    {
        add_action("rest_api_init", [$this, "register_routes"]);
    }

    public function register_routes()
    {
        (new FormApi)->register_routes();
        (new ShortcodeApi)->register_routes();
    }
}

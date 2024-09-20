<?php

use Illuminate\Support\Facades\Session;

if (!function_exists("role")) {
    function role($name) {
        $role = Session::get("role");

        if ($role == $name) {
            return true;
        }else {
            return false;
        }
    }
}

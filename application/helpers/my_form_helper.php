<?php
if (!function_exists('validation_errors')) {
    function validation_errors() {
        $CI =& get_instance();
        return $CI->form_validation->error_string();
    }
}
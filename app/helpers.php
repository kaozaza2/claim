<?php

if (!function_exists('_c') && function_exists('trans_choice')) {
    function _c($key, $number, array $replace = [], $locale = null): string
    {
        return trans_choice($key, $number, $replace, $locale);
    }
}

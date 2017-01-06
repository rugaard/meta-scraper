<?php
if (!function_exists('camel_case')) {
    /**
     * Convert string to camelCase.
     *
     * @param string $string String to convert to camelCase
     * @return string
     */
    function camel_case(string $string)
    {
        return lcfirst(
            str_replace(' ', '', ucwords(strtr($string, '_-', ' ')))
        );
    }
}

if (!function_exists('snake_case')) {
    /**
     * Convert string to snake_case
     *
     * @param  string $string String to convert to snake_case
     * @return string
     */
    function snake_case(string $string)
    {
        return strtolower(
            preg_replace('/(?<=\\w)(?=[A-Z])/', "_$1", substr($string, 3))
        );
    }
}
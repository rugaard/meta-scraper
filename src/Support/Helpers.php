<?php
declare(strict_types=1);

if (! function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object  $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('camel_case')) {
    /**
     * Convert string to camelCase.
     *
     * @param  string $string
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
     * Convert string to snake_case.
     *
     * @param  string $string
     * @return string
     */
    function snake_case(string $string)
    {
        return strtolower(
            preg_replace('/(?<=\\w)(?=[A-Z])/', '_$1', substr($string, 3))
        );
    }
}

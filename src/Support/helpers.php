<?php

if (! function_exists('service_path')) {
    /**
     * Get the service path.
     * 
     * @param  string[]  $paths,...
     * @return string
     */
    function service_path(string ...$paths) {
        $paths = implode('/', $paths);
        
        return rtrim(app_path("Services/{$paths}"), '/');
    }
}

if (! function_exists('service_classname')) {
    /**
     * Get the service classname.
     * 
     * @param  string[]  $paths,...
     * @return string
     */
    function service_classname(string ...$paths) {
        $paths = implode('\\', $paths);
        
        return rtrim("App\\Services\\{$paths}", '\\');
    }
}
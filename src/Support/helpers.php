<?php

if (! function_exists('service_path')) {
    /**
     * Get the service path.
     * 
     * @param  string|null  $path
     * @return string
     */
    function service_path($path = null) {
        return app_path("Services/{$path}");
    }
}
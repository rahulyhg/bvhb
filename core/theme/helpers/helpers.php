<?php

use Botble\Theme\Facades\ThemeOptionFacade;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

if (!function_exists('theme')) {
    /**
     * Get the theme instance.
     *
     * @param  string $themeName
     * @param  string $layoutName
     * @return Theme
     * @author Teepluss <admin@laravel.in.th>
     * @throws FileNotFoundException
     */
    function theme($themeName = null, $layoutName = null)
    {
        $theme = app('theme');

        if ($themeName) {
            $theme->theme($themeName);
        }

        if ($layoutName) {
            $theme->layout($layoutName);
        }
        return $theme;
    }
}

if (!function_exists('theme_option')) {
    /**
     * @return mixed
     * @author DGL Custom
     */
    function theme_option($key = null, $default = null)
    {
        if (!empty($key)) {
            try {
                return ThemeOption::getOption($key, $default);
            } catch (FileNotFoundException $exception) {
                info($exception->getMessage());
            }
        }

        return ThemeOptionFacade::getFacadeRoot();
    }
}

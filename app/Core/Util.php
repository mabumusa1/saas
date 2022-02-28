<?php

namespace App\Core;

use App\Core\Adapters\Theme;
use tidy;

class Util
{
    /**
     * Class init state.
     *
     * @var bool
     */
    private static $initialized = false;

    public static function getArrayValue($array, $path)
    {
        if (is_string($path)) {
            // dot delimiter
            $path = explode('/', $path);
        }

        $ref = &$array;
        foreach ($path as $key) {
            $ref = &$ref[$key];
        }

        $prev = $ref;

        return $prev;
    }

    public static function hasArrayValue($array, $path)
    {
        return self::getArrayValue($array, $path) !== null;
    }

    public static function getIf($cond, $value, $alt = '')
    {
        return $cond ? $value : $alt;
    }

    public static function putIf($cond, $value, $alt = '')
    {
        echo self::getIf($cond, $value, $alt);
    }

    public static function notice($text, $state = 'danger', $icon = 'icons/duotune/art/art006.svg')
    {
        $html = '';

        $html .= '<!--begin::Notice-->';
        $html .= '<div class="d-flex align-items-center rounded py-5 px-4 bg-light-'.$state.' ">';
        $html .= '  <!--begin::Icon-->';
        $html .= '  <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">';
        $html .= '      '.Theme::getSvgIcon('icons/duotune/abstract/abs051.svg', 'svg-icon-'.$state.' position-absolute opacity-10', 'w-80px h-80px');
        $html .= '	    '.Theme::getSvgIcon($icon, 'svg-icon-3x svg-icon-'.$state.'  position-absolute');
        $html .= '  </div>';
        $html .= '  <!--end::Icon-->';

        $html .= '  <!--begin::Description-->';
        $html .= '      <div class="text-gray-700 fw-bold fs-6 lh-lg">';
        $html .= $text;
        $html .= '      </div>';
        $html .= '  <!--end::Description-->';
        $html .= '</div>';
        $html .= '<!--end::Notice-->';

        echo $html;
    }

    public static function info($text, $state = 'danger', $icon = 'icons/duotune/general/gen044.svg')
    {
        $html = '';

        $html .= '<!--begin::Information-->';
        $html .= '<div class="d-flex align-items-center rounded py-5 px-5 bg-light-'.$state.' ">';
        $html .= '    <!--begin::Icon-->';
        $html .= '	  '.Theme::getSvgIcon($icon, 'svg-icon-3x svg-icon-'.$state.' me-5');
        $html .= '    <!--end::Icon-->';

        $html .= '    <!--begin::Description-->';
        $html .= '    <div class="text-gray-700 fw-bold fs-6">';
        $html .= $text;
        $html .= '    </div>';
        $html .= '    <!--end::Description-->';
        $html .= '</div>';
        $html .= '<!--end::Information-->';

        echo $html;
    }

    public static function getHtmlAttributes($attributes = [])
    {
        $result = [];

        if (empty($attributes)) {
            return false;
        }

        foreach ($attributes as $name => $value) {
            if (! empty($value)) {
                $result[] = $name.'="'.$value.'"';
            }
        }

        return ' '.implode(' ', $result).' ';
    }

    public static function putHtmlAttributes($attributes)
    {
        $result = self::getHtmlAttributes($attributes);

        if ($result) {
            echo $result;
        }
    }

    public static function getHtmlClass($classes, $full = true)
    {
        $result = [];

        $classes = implode(' ', $classes);

        if ($full === true) {
            return ' class="'.$classes.'" ';
        } else {
            return ' '.$classes.' ';
        }
    }

    public static function getCssVariables($variables, $full = true)
    {
        $result = [];

        foreach ($variables as $name => $value) {
            if (! empty($value)) {
                $result[] = $name.':'.$value;
            }
        }

        $result = implode(';', $result);

        if ($full === true) {
            return ' style="'.$result.'" ';
        } else {
            return ' '.$result.' ';
        }
    }

    /**
     * Create a cache file.
     *
     * @param $key
     * @param $value
     */
    public static function putCache($key, $value)
    {
        global $_COMMON_PATH;

        // check if cache file exist
        $cache = $_COMMON_PATH.'/dist/libs/cache/'.$key.'.cache.json';

        // create cache folder if folder does not exist
        if (! file_exists(dirname($cache))) {
            mkdir(dirname($cache), 0777, true);
        }

        // create cache file
        file_put_contents($cache, json_encode($value));
    }

    /**
     * Retrieve a cache file by key.
     *
     * @param $key
     *
     * @return mixed|null
     */
    public static function getCache($key)
    {
        global $_COMMON_PATH;

        // check if cache file exist
        $cache = $_COMMON_PATH.'/dist/libs/cache/'.$key.'.cache.json';

        // check if the requested cache file exists
        if (file_exists($cache)) {
            return json_decode(file_get_contents($cache), true);
        }

        return null;
    }

    /**
     * Sample demo for docs for multidemo site.
     *
     * @return string
     */
    public static function sampleDemoText()
    {
        $demo = '';
        if (Theme::isMultiDemo()) {
            $demo = '--demo1';
        }

        return $demo;
    }

    public static function camelize($input, $separator = '_')
    {
        return str_replace($separator, ' ', ucwords($input, $separator));
    }

    public static function arrayMergeRecursive()
    {
        $arrays = func_get_args();
        $merged = [];

        while ($arrays) {
            $array = array_shift($arrays);

            if (! is_array($array)) {
                trigger_error(__FUNCTION__.' encountered a non array argument', E_USER_WARNING);

                return;
            }

            if (! $array) {
                continue;
            }

            foreach ($array as $key => $value) {
                if (is_string($key)) {
                    if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key])) {
                        $merged[$key] = self::arrayMergeRecursive($merged[$key], $value);
                    } else {
                        $merged[$key] = $value;
                    }
                } else {
                    $merged[] = $value;
                }
            }
        }

        return $merged;
    }

    public static function isHexColor($color)
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }
}

<?php

if (! function_exists('get_svg_icon')) {
    function get_svg_icon($path, $class = null, $svgClass = null)
    {
        if (strpos($path, 'media') === false) {
            $path = theme()->getMediaUrlPath().$path;
        }

        $file_path = public_path($path);

        if (! file_exists($file_path)) {

        }

        $svg_content = file_get_contents($file_path);

        if (empty($svg_content)) {

        }

        $dom = new DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new DOMXPath($dom);

        // add class to svg
        if (! empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = ['svg-icon'];

        if (! empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/'.$asd[1];
        }

        $output = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="'.implode(' ', $cls).'">'.$string.'</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }
}

if (! function_exists('theme')) {
    /**
     * Get the instance of Theme class core.
     *
     * @return \App\Core\Adapters\Theme|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function theme()
    {
        return app(\App\Core\Adapters\Theme::class);
    }
}


if (! function_exists('bootstrap')) {
    /**
     * Get the instance of Util class core.
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     * @throws Throwable
     */
    function bootstrap()
    {
        $demo = ucwords(theme()->getDemo());
        $bootstrap = "\App\Core\Bootstraps\Bootstrap$demo";
        return app($bootstrap);
    }
}

if (! function_exists('assetCustom')) {
    /**
     * Get the asset path of RTL if this is an RTL request.
     *
     * @param $path
     * @param  null  $secure
     *
     * @return string
     */
    function assetCustom($path)
    {
        // Include default css file
        return asset(theme()->getDemo().'/'.$path);
    }
}

if (! function_exists('preloadCss')) {
    /**
     * Preload CSS file.
     *
     * @return bool
     */
    function preloadCss($url)
    {
        return '<link rel="preload" href="'.$url.'" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" type="text/css"><noscript><link rel="stylesheet" href="'.$url.'"></noscript>';
    }
}

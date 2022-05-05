<?php

use App\Models\Domain;
use Spatie\Dns\Dns;

if (! function_exists('roles')) {
    function roles()
    {
        return [
            'admin' => 'Admin',
            'owner' => 'Owner',
            'fb' => 'Full (with Billing)',
            'fnb' => 'Full (without Billing)',
            'pb' => 'Partial (with Billing)',
            'pnb' => 'Partial (without Billing)',
        ];
    }
}

if (! function_exists('installType')) {
    function installType()
    {
        return [
            'prd' => 'Production',
            'stg' => 'Staging',
            'dev' => 'Dev',
        ];
    }
}

if (! function_exists('get_svg_icon')) {
    function get_svg_icon($path, $class = null, $svgClass = null)
    {
        if (strpos($path, 'media') === false) {
            $path = 'skin/media/'.$path;
        }

        $file_path = public_path($path);

        if (! file_exists($file_path)) {
            return '';
        }
        $svg_content = file_get_contents($file_path);

        if (empty($svg_content)) {
            return '';
        }

        $dom = new DOMDocument();
        $dom->loadXML($svg_content);

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

        $output = "<!--begin::Svg Icon | path: ${path}-->\n";
        $output .= '<span class="'.implode(' ', $cls).'">'.$string.'</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }
}

if (! function_exists('VerifyDomainHelper')) {
    function VerifyDomainHelper(Domain $domain)
    {
        $dns = new Dns();
        $dns->useNameserver('8.8.8.8');
        $records = $dns->getRecords($domain->name, 'CNAME');
        if ($records) {
            foreach ($records as $record) {
                /* @phpstan-ignore-next-line */
                if ($record->target() === $domain->install->cname) {
                    /* @phpstan-ignore-next-line */
                    $domain->verified_at = now();
                    $domain->save();

                    return true;
                }
            }
        }

        return false;
    }
}

if (! function_exists('VerifyDomainOwnershipHelper')) {
    function VerifyDomainOwnershipHelper(String $value, String $installName, Domain $domain)
    {
        $dns = new Dns();
        $dns->useNameserver('8.8.8.8');
        $records = $dns->getRecords($value, 'TXT');
        if ($records) {
            foreach ($records as $record) {
                // the user managed to verify the domain, they own it
                if ($record->txt() === "sc-verification={$installName}") {

                    //delete the existing domain, to add the new one
                    $domain->delete();

                    return true;
                } else {
                    //someone else has the domain, we check DNS TXT records
                    return false;
                }
            }
        }
    }
}

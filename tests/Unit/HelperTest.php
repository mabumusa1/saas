<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * Test can helper render an imageas SVG.
     *
     * @return void
     */
    public function test_empty_get_svg_icon()
    {
        $img = get_svg_icon('filenotfound.svg');
        $this->assertEquals($img, '');
    }

    public function test_get_svg_icon()
    {
        // Make a file in the public folder
        $file = <<<'EOF'
        <?xml version="1.0" encoding="utf-8"?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100">
        <rect x="0" y="0" width="40" height="40" style="fill: #0000FF"/>
        </svg>
        EOF;

        $expected = <<<'EOF'
        <!--begin::Svg Icon | path: assets/media/file.svg-->
        <span class="svg-icon class"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" class="svgclass">
        <rect x="0" y="0" width="40" height="40" style="fill: #0000FF"/>
        </svg></span>
        <!--end::Svg Icon-->
        EOF;
        if (!is_dir(public_path('skin/media/'))) {
            mkdir(public_path('skin/media/'));
        }

        file_put_contents(public_path('skin/media/file.svg'), $file);

        $img = get_svg_icon('file.svg', 'class', 'svgclass');
        $this->assertEquals($img, $expected);

        $file = '';
        file_put_contents(public_path('skin/media/file.svg'), $file);
        $img = get_svg_icon('file.svg', 'class', 'svgclass');
        $this->assertEquals($img, '');

        unlink(public_path('skin/media/file.svg'));
    }
}

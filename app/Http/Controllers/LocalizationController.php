<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;

class LocalizationController
{
    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function index($locale)
    {
        App::setLocale($locale);
        session()->put('local', $locale);

        return redirect()->back();
    }
}

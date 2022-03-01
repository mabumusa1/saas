<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;

class LocalizationController
{
    /**
     * @param string $locale
     * @return RedirectResponse
     */
    public function index(string $locale)
    {
        App::setLocale($locale);
        session()->put('local', $locale);

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');
        $sites = Site::where('name', 'LIKE', "%{$query}%")->get();
        $installs = Install::where('name', 'LIKE', "%{$query}%")->get();
        $res = [];
        if (count($sites) > 0) {
            $res['sites'] = $sites;
        }
        if (count($installs) > 0) {
            $res['installs'] = $installs;
        }

        return response()->json($res);
    }
}

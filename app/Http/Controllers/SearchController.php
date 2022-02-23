<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');
        $sites = Site::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json([
            'status' => true,
            'sites' => $sites,
            'installs' => [],
        ]);
    }
}

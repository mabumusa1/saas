<?php

namespace App\Http\Controllers;

use App\Datacenter;
use App\Http\Requests\DataCenterStoreRequest;
use App\Models\DataCenter;
use Illuminate\Http\Request;

class DataCenterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCenters = DataCenter::all();

        return view('datacenter.index', compact('DataCenters'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('datacenter.create');
    }

    /**
     * @param \App\Http\Requests\DataCenterStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataCenterStoreRequest $request)
    {
        $datacenter = Datacenter::create($request->validated());

        return redirect()->route('datacenter.index');
    }
}

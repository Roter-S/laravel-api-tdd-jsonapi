<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstrumentCollection;
use App\Http\Resources\InstrumentResource;
use App\Models\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): InstrumentCollection
    {
        return InstrumentCollection::make(Instrument::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $instrument = Instrument::create($request->input('data.attributes'));

        return InstrumentResource::make($instrument);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument): InstrumentResource
    {
        return InstrumentResource::make($instrument);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

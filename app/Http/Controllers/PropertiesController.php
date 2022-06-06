<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Station;
use App\Models\Road;
use Validator;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $properties = Property::get();;
        return view('property.list')->with([
            'properties' => $properties,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('property.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $property = new Property;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->category = $request->category;
        $property->open_date = $request->open_date;
        $property->start_date = $request->start_date;
        $property->land_area = $request->land_area;
        $property->ground = $request->ground;
        $property->city_planning = $request->city_planning;
        $property->use_district = $request->use_district;
        $property->building_coverage_ratio = $request->building_coverage_ratio;
        $property->floor_area_ratio = $request->floor_area_ratio;
        $property->text = $request->text;
        $property->user_id = Auth::user()->id;
        $property->save();
        $last_insert_id = $property->id;

        $station = new Station;
        $station->route = $request->route;
        $station->station = $request->station;
        $station->time = $request->time;
        $station->property_id = $last_insert_id;
        $station->save();

        $road = new Road;
        $road->kind = $request->road;
        // $road->length = $request->length;
        $road->property_id = $last_insert_id;
        $road->save();

        $properties = Property::get();


        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

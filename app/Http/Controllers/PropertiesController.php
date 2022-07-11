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

        for($i = 0;$i<$request->count_access + 1;$i++){
            $route = 'route_'.$i;
            $station_val = 'station_'.$i;
            $time = 'time_'.$i;
            if(isset($request->$route) && isset($request->$station_val)){
                $station = new Station;
                $station->route = $request->$route;
                $station->station = $request->$station_val;
                $station->time = $request->$time;
                $station->property_id = $last_insert_id;
                $station->save();
            }
        }

        for($i = 0;$i<$request->count_road + 1;$i++){
            $road_kind = 'road_kind_'.$i;
            $direction = 'direction_'.$i;
            $length = 'length_'.$i;
            if(isset($request->$route) && isset($request->$direction)){
                $road = new Road;
                $road->road_kind = $request->$road_kind;
                $road->direction = $request->$direction;
                $road->length = $request->$length;
                $road->property_id = $last_insert_id;
                $road->save();
            }
        }

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
        $property = Property::find($id);
        return view('property.detail')->with([
            'property' => $property,
        ]);


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
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'property_id' => 'required',
            'name' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $property = Property::find($request->property_id);

        $property->name = $request->name;
        $property->address = $request->address;
        $property->category = $request->category;
        $property->land_area = $request->land_area;
        $property->ground = $request->ground;
        $property->city_planning = $request->city_planning;
        $property->use_district = $request->use_district;
        $property->building_coverage_ratio = $request->building_coverage_ratio;
        $property->floor_area_ratio = $request->floor_area_ratio;
        $property->text = $request->text;
        $property->user_id = Auth::user()->id;
        $property->save();

        $del_stations = Station::where("property_id",$request->property_id)->delete();
        for($i = 0;$i<$request->count_access + 1;$i++){
            $route = 'route_'.$i;
            $station_val = 'station_'.$i;
            $time = 'time_'.$i;
            if(isset($request->$route) && isset($request->$station_val)){
                $station = new Station;
                $station->route = $request->$route;
                $station->station = $request->$station_val;
                $station->time = $request->$time;
                $station->property_id = $request->property_id;
                $station->save();
            }
        }

        $del_roads = Road::where("property_id",$request->property_id)->delete();
        for($i = 0;$i<$request->count_road + 1;$i++){
            $road_kind = 'road_kind_'.$i;
            $direction = 'direction_'.$i;
            $length = 'length_'.$i;
            if(isset($request->$route) && isset($request->$direction)){
                $road = new Road;
                $road->road_kind = $request->$road_kind;
                $road->direction = $request->$direction;
                $road->length = $request->$length;
                $road->property_id = $request->property_id;
                $road->save();
            }
        }

        return redirect()->route('propertyDetail',["id"=>$request->property_id]);

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

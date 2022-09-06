<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Project;
use Validator;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    //
    public function dashboard()
    {
        //
        $property_list = Property::orderBy('updated_at', 'DESC')->get();
        $properties = Property::orderBy('updated_at', 'DESC')->take(5)->get();
        $projects = Project::orderBy('updated_at', 'DESC')->take(5)->get();
        session()->put(['scroll_top' => 0]);
        return view('dashboard')->with([
            'properties' => $properties,
            'projects' => $projects,
            'property_list' => $property_list,

        ]);
    }


}

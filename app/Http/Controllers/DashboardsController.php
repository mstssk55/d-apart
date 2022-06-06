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
        $properties = Property::get();
        $projects = Project::orderBy('updated_at', 'DESC')->take(5)->get();;
        return view('dashboard')->with([
            'properties' => $properties,
            'projects' => $projects,
        ]);
    }


}

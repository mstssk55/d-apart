<?php

namespace App\Http\Controllers;
use App\Models\ConstructionPlan;
use Validator;

use Illuminate\Http\Request;

class ConstructionPlansController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $constructionplan = new ConstructionPlan;
        $constructionplan->name = $request->constructionplan;
        $constructionplan->save();
        return redirect()->route('setting');
    }

    public function destroy(ConstructionPlan $id)
    {
        //
        $id->delete();
        return redirect()->route('setting');
    }

}

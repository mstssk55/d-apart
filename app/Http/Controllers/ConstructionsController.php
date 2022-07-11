<?php

namespace App\Http\Controllers;
use App\Models\Construction;
use Validator;

use Illuminate\Http\Request;

class ConstructionsController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $construction = new Construction;
        $construction->name = $request->cr_name;
        $construction->save();
        return redirect()->route('setting');
    }

    public function destroy(Construction $id)
    {
        //
        $id->delete();
        return redirect()->route('setting');
    }


}

<?php

namespace App\Http\Controllers;
use App\Models\Layout;
use Validator;

use Illuminate\Http\Request;

class LayoutsController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $layout = new Layout;
        $layout->name = $request->cr_name;
        $layout->save();
        return redirect()->route('setting');
    }

    public function destroy(Layout $id)
    {
        //
        $id->delete();
        return redirect()->route('setting');
    }


}

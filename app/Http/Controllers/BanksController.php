<?php

namespace App\Http\Controllers;
use App\Models\Bank;
use Validator;

use Illuminate\Http\Request;

class BanksController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'bank_ratio' => 'required',
        ]);
        $bank = new Bank;
        $bank->name = $request->bank_name;
        $bank->ratio = $request->bank_ratio;
        $bank->save();
        return redirect()->route('setting');
    }

    public function destroy(Bank $id)
    {
        //
        $id->delete();
        return redirect()->route('setting');
    }

}

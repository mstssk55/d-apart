<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KanrisController extends Controller
{
    //

    public function kanri()
    {
        $users = User::get();

        return view('user.list')->with([
                'users'=>$users
            ]);
        //
        // $crs = Construction::get();
        // $layouts = Layout::get();
        // $cr_plans = ConstructionPlan::get();
        // $banks = Bank::get();
        // return view('setting.detail')
        // ->with([
        //     'crs' => $crs,
        //     'layouts' => $layouts,
        //     'cr_plans'=>$cr_plans,
        //     'banks'=>$banks
        // ])
        // ;
    }

}

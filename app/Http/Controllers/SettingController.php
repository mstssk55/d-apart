<?php

namespace App\Http\Controllers;
use App\Models\Construction;
use App\Models\Layout;
use App\Models\ConstructionPlan;
use App\Models\Bank;


use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function setting()
    {
        //
        $crs = Construction::get();
        $layouts = Layout::get();
        $cr_plans = ConstructionPlan::get();
        $banks = Bank::get();
        return view('setting.detail')
        ->with([
            'crs' => $crs,
            'layouts' => $layouts,
            'cr_plans'=>$cr_plans,
            'banks'=>$banks
        ])
        ;
    }

}

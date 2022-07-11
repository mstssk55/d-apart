<?php

namespace App\Http\Controllers;
use App\Models\Construction;
use App\Models\Layout;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function setting()
    {
        //
        $crs = Construction::get();
        $layouts = Layout::get();
        return view('setting.detail')
        ->with([
            'crs' => $crs,
            'layouts' => $layouts,
        ])
        ;
    }

}

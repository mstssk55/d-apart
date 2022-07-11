<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\Construction;
use App\Models\Layout;
use Validator;
use App\Models\Parking;
use App\Models\Plan;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::get();;
        return view('project.list')->with([
            'projects' => $projects,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        //バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required',
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }


        $project = new Project;
        $project->property_id = $request->id;
        $project->user_id = Auth::user()->id;
        $project->name = $request->name;
        $project->save();
        $last_insert_id = $project->id;
        return redirect()->route('projectDetail', ['id' => $last_insert_id]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $project = Project::find($id);
        $users = User::get();
        $crs = Construction::get();
        $layouts = Layout::get();
        // if (is_null($building_detail)) {
        //     \Session::flash('err_msg', 'データがありません。');
        //     return redirect(route('buildings'));
        // }

        return view('project.detail')->with([
            'project' => $project,
            'users'=> $users,
            'crs' => $crs,
            'layouts'=> $layouts,
        ]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
        return back()
            ->withInput()
            ->withErrors($validator);
        }
        $project = Project::find($request->id);


        // 収支計画基本情報-----------------------------------------
        $project->name = $request->name;
        $project->client = $request->client;
        $project->manager = $request->manager;
        $project->house_name = $request->house_name;
        $project->open_date = $request->open_date;
        $project->start_date = $request->start_date;

        // 建築プラン-----------------------------------------
        $project->plan_kind =  $request->plan_kind;
        $project->structure = $request->structure;
        $project->floor = $request->floor;
        $project->equipment = $request->equipment;

        // $project->household = $request->household;
        // $project->plan_basement_area = $request->plan_basement_area;
        // $project->plan_tenant_area = $request->plan_tenant_area;
        // $project->plan_room_area = $request->plan_room_area;
        // $project->plan_total_area = $request->plan_total_area;

        // 間取り-----------------------------------------
        $del_plans = Plan::where("project_id",$request->id)->delete();
        for($i = 0;$i<$request->count_room_plan + 1;$i++){
            $count = $i;
            $room_plan = 'room_plan_'.$count;
            $room_count = 'room_count_'.$count;
            if(isset($request->$room_plan) && isset($request->$room_count)){
                $plan = new Plan;
                $plan->plan = $request->$room_plan;
                $plan->count = $request->$room_count;
                $plan->project_id = $request->id;
                $plan->save();
                $count ++;
            }
        }
        // 駐車場-----------------------------------------
        $del_parkings = Parking::where("project_id",$request->id)->delete();
        for($i = 0;$i<$request->count_parking_plan + 1;$i++){
            $count = $i;
            $parking_plan = 'parking_plan_'.$count;
            $parking_count = 'parking_count_'.$count;
            $parking_fee = 'parking_fee_'.$count;
            if(isset($request->$parking_plan) && isset($request->$parking_count)){

                $parking = new Parking;
                $parking->plan = $request->$parking_plan;
                $parking->count = $request->$parking_count;
                $parking->fee = $request->$parking_fee;
                $parking->project_id = $request->id;
                $parking->save();
                $count ++;
            }
        }
        // 販売価格-----------------------------------------
        $project->price_land =  $request->price_land;
        $project->price_prop = $request->price_prop;


        // 固定資産税評価額-----------------------------------------
        $project->estate_tax_jutaku =  $request->estate_tax_jutaku;
        $project->property_tax_area =  $request->property_tax_area;
        $project->property_tax_prop = $request->property_tax_prop;


        // 賃金、借入金内訳-----------------------------------------
        $project->debt =  $request->debt;
        $project->own_resources = $request->own_resources;
        $project->expense = $request->expense;
        $project->repayment_method = $request->repayment_method;
        $project->borrowing_period = $request->borrowing_period;
        $project->deferred_period = $request->deferred_period;
        $project->interest_rate = $request->interest_rate;
        $project->total_expenses = $request->total_expenses;
        $project->monthly_repayment_amount = $request->monthly_repayment_amount;


        // 不動産取得税-----------------------------------------
        $project->estate_tax_shintiku = $request->estate_tax_shintiku;
        $project->estate_tax_area = $request->estate_tax_area;
        $project->estate_tax_prop = $request->estate_tax_prop;

        // 登録免許税-----------------------------------------
        $project->display_registration =  $request->display_registration;
        $project->land_ownership_transfer = $request->land_ownership_transfer;
        $project->prop_ownership_transfer = $request->prop_ownership_transfer;
        $project->mortgage_setting_costs = $request->mortgage_setting_costs;

        // 賃金、借入金内訳-----------------------------------------
        $project->judicial_scrivener_fee =  $request->judicial_scrivener_fee;
        $project->loan_fees = $request->loan_fees;
        $project->loan_guarantee_fee = $request->loan_guarantee_fee;
        $project->brokerage_fee = $request->brokerage_fee;
        $project->other_cost = $request->other_cost;
        $project->housing_insurance_year = $request->housing_insurance_year;
        $project->housing_insurance_cost = $request->housing_insurance_cost;
        $project->earthquake_insurance_year = $request->earthquake_insurance_year;
        $project->earthquake_insurance_cost = $request->earthquake_insurance_cost;

        // 家賃-----------------------------------------
        $del_rooms = Room::where("project_id",$request->id)->delete();
        for($i = 0;$i<$request->rent_rooms_count;$i++){
            $room_no = 'room_no_'.$i;
            $room_plan = 'room_plan_'.$i;
            $room_area = 'room_area_'.$i;
            $room_rent = 'room_rent_'.$i;
            $room_common = 'room_common_'.$i;

            $room = new Room;
            $room->room_no = $request->$room_no;
            $room->room_plan = $request->$room_plan;
            $room->room_area = $request->$room_area;
            $room->room_rent = $request->$room_rent;
            $room->room_common = $request->$room_common;
            $room->project_id = $request->id;
            $room->save();
        }


        $project->save();

        return redirect()->route('projectDetail', ['id' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}

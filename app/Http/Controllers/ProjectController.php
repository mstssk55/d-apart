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
use App\Models\Floor;
use App\Models\Plan;
use App\Models\ConstructionPlan;
use App\Models\Other;
use App\Models\Room;
use App\Models\Bank;
use App\Models\Bikou;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $user_id = "";
        $property_id = "";
        $users = User::get();
        $properties = Property::get();
        $projects = Project::orderBy('updated_at', 'DESC')->paginate(15);
        return view('project.list')->with([
            'projects' => $projects,
            'users' => $users,
            'properties' => $properties,
            'user_id' => $user_id,
            'property_id' => $property_id,
        ]);

    }
    public function search(Request $request)
    {
        //
        $user_id = $request->search_user;
        $property_id = $request->search_property;
        $condition = [];
        if($user_id != null){
            $set = ["user_id",$user_id];
            array_push($condition,$set);
        }
        if($property_id != null){
            $set = ["property_id",$property_id];
            array_push($condition,$set);
        }
        $users = User::get();
        $properties = Property::get();
        $projects = Project::where($condition)->paginate(15);

        return view('project.list')->with([
            'projects' => $projects,
            'users' => $users,
            'properties' => $properties,
            'user_id' => $user_id,
            'property_id' => $property_id,
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
        $property = Property::get();
        $property_ids = [];
        $p_name = "";
        foreach($property as $pid){
            array_push($property_ids,$pid->id);
            if($pid->id == $request->id){
                $p_name = $pid->name;
            }
        }
        //バリデーション
        $validator = Validator::make($request->all(), [
            'id' => [
                Rule::in($property_ids)
            ],
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        // $name = $request->name;
        // if($request->name == ""){
        $name = $p_name;
        // }
        session()->put(['scroll_top' => 0]);
        $project = new Project;
        $project->property_id = $request->id;
        $project->user_id = Auth::user()->id;
        $project->name = $name;
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
        $users = User::where('is_delete',0)->get();
        $crs = Construction::get();
        $layouts = Layout::get();
        $banks = Bank::get();
        $cr_plans = ConstructionPlan::get();
        // if (is_null($building_detail)) {
        //     \Session::flash('err_msg', 'データがありません。');
        //     return redirect(route('buildings'));
        // }

        return view('project.detail')->with([
            'project' => $project,
            'users'=> $users,
            'crs' => $crs,
            'layouts'=> $layouts,
            'cr_plans'=> $cr_plans,
            'banks'=> $banks,
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
        $project->project_type = $request->project_type;
        $project->project_cat = $request->project_cat;
        $project->client = $request->client;
        $project->manager = $request->manager;
        $project->house_name = $request->house_name;
        $project->open_date = $request->open_date;
        $project->start_date = $request->start_date;
        $project->project_start_date = $request->project_start_date;
        $project->return_debt_date = $request->return_debt_date;

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
            $room_plan = 'room_plan_cat_'.$count;
            $room_count = 'room_count_'.$count;
            // dd($request->$room_plan);
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

        // 間取り-----------------------------------------
        $del_floors = Floor::where("project_id",$request->id)->delete();
        $floor_total_num = 0;
        $floor_total_area = 0;
        for($i = 0;$i<=$request->floor;$i++){
            $tenant_num = 'tenant_num_'.$i;
            $tenant_area = 'tenant_area_'.$i;
            $house_num = 'house_num_'.$i;
            $house_area = 'house_area_'.$i;

            $floor = new Floor;
            $floor->floor = $i;
            $floor->tenant_num = $request->$tenant_num;
            $floor->tenant_area = $request->$tenant_area;
            $floor->house_num = $request->$house_num;
            $floor->house_area = $request->$house_area;
            $floor->project_id = $request->id;
            $floor->save();
            $floor_total_num += $request->$tenant_num + $request->$house_num;
            $floor_total_area += $request->$tenant_area + $request->$house_area;

        }

        $project->floor_total_num =  $floor_total_num;
        $project->floor_total_area = $floor_total_area;


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


        // 固定資産税評価額-----------------------------------------
        $project->estate_tax_jutaku =  $request->estate_tax_jutaku;
        $project->property_tax_area =  $request->property_tax_area;
        $project->property_tax_prop = $request->property_tax_prop;

        // 登録免許税-----------------------------------------
        $project->display_registration =  $request->display_registration;
        $project->land_ownership_transfer = $request->land_ownership_transfer;
        $project->prop_ownership_transfer = $request->prop_ownership_transfer;
        $project->mortgage_setting_costs = $request->mortgage_setting_costs;

        // 不動産取得税-----------------------------------------
        $project->estate_tax_area = $request->estate_tax_area;
        $project->estate_tax_prop = $request->estate_tax_prop;

        // 固定資産税・都市計画税-----------------------------------------
        $project->estate_tax_shintiku = $request->estate_tax_shintiku;
        $project->estate_tax_shintiku_year = $request->estate_tax_shintiku_year;

        // 固定資産税・都市計画税計算式■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
        $tax_ratio = 0.014;
        $plan_ratio = 0.003;
        function calc_floor($num){
            $calc = floor($num/100)*100;
            return $calc;
        }
        function calc_tokurei($area,$num,$hyouka,$normal_num,$upper_num,$ratio,$type=0){
            $calc = 0;
            if($area <= $num){
                $calc = calc_floor($hyouka /$normal_num * $ratio);
            }else{
                $upper_area = $area - $num;
                $each = $hyouka / $area;

                $under = $num*$each/$normal_num;
                $upper = $upper_area*$each/$upper_num;
                if($type == 1){
                    $upper = $upper *2;
                }
                $calc = calc_floor(($under + $upper)*$ratio);

            }
            return $calc;
        }
        $property_tax_area = 0;
        $property_tax_prop = 0;
        if($request->estate_tax_jutaku == "特例なし"){
            $property_tax_area = calc_floor($request->property_tax_area * $tax_ratio);
        }else if($request->estate_tax_jutaku == "特例あり"){
            $property_tax_area = calc_tokurei($project->property->land_area,200,$request->property_tax_area,6,3,$tax_ratio);
        }
        if($request->estate_tax_shintiku == "特例なし"){
            $property_tax_prop = calc_floor($request->property_tax_prop * $tax_ratio);
        }else if($request->estate_tax_shintiku == "特例あり"){
            $property_tax_prop = calc_tokurei($floor_total_area,120,$request->property_tax_prop,2,1,$tax_ratio);
        }

        $city_planning_tax_area = 0;
        $city_planning_tax_prop = calc_floor($request->property_tax_prop * $plan_ratio);;
        if($request->estate_tax_jutaku == "特例なし"){
            $city_planning_tax_area = calc_floor($request->property_tax_area * $plan_ratio);
        }else if($request->estate_tax_jutaku == "特例あり"){
            $city_planning_tax_area = calc_tokurei($project->property->land_area,200,$request->property_tax_area,3,3,$plan_ratio,1);
        }

        $property_tax = $property_tax_area + $property_tax_prop;
        $city_planning_tax = $city_planning_tax_area + $city_planning_tax_prop;

        $project->property_tax = $property_tax;
        $project->city_planning_tax = $city_planning_tax;
        // 固定資産税・都市計画税計算式ここまで■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■

        // 賃金、借入金内訳-----------------------------------------
        $project->judicial_scrivener_fee =  $request->judicial_scrivener_fee;
        $project->loan_fees = $request->loan_fees;
        $project->loan_guarantee_fee = $request->loan_guarantee_fee;
        $project->brokerage_fee = $request->brokerage_fee;

        // その他雑費-----------------------------------------
        $del_others = Other::where("project_id",$request->id)->delete();
        for($i = 0;$i<$request->count_other_fee + 1;$i++){
            $count = $i;
            $other_cycle = 'other_cycle_'.$count;
            $other_name = 'other_name_'.$count;
            $other_fee = 'other_fee_'.$count;
            if(isset($request->$other_name) && isset($request->$other_fee)){
                $other = new Other;
                $other->cycle = $request->$other_cycle;
                $other->name = $request->$other_name;
                $other->fee = $request->$other_fee;
                $other->project_id = $request->id;
                $other->save();
                $count ++;
            }
        }

        $project->management_fee = $request->management_fee;
        $project->internet_fee = $request->internet_fee;
        $project->common_electricity = $request->common_electricity;
        $project->cleaning_fee = $request->cleaning_fee;
        $project->transfer_fee = $request->transfer_fee;
        $project->housing_insurance_case = $request->housing_insurance_case;
        $project->housing_insurance_year = $request->housing_insurance_year;
        $project->housing_insurance_cost = $request->housing_insurance_cost;
        $project->earthquake_insurance_case = $request->earthquake_insurance_case;
        $project->earthquake_insurance_year = $request->earthquake_insurance_year;
        $project->earthquake_insurance_cost = $request->earthquake_insurance_cost;

        // 減価償却-----------------------------------------
        $project->building_depreciation_kind =  $request->building_depreciation_kind;
        $project->building_depreciation_year = $request->building_depreciation_year;
        $project->building_depreciation_ratio = $request->building_depreciation_ratio;
        $project->equipment_depreciation_kind =  $request->equipment_depreciation_kind;
        $project->equipment_depreciation_year = $request->equipment_depreciation_year;
        $project->equipment_depreciation_ratio = $request->equipment_depreciation_ratio;
        $project->equipment_ratio = $request->equipment_ratio;

        // 賃金、借入金内訳-----------------------------------------
        $total_expenses = 0;
        $total_expenses += $request->price_land;
        $total_expenses += round($request->price_prop *1.1);
        $total_expenses += $request->display_registration;
        $total_expenses += $request->land_ownership_transfer;
        $total_expenses += $request->prop_ownership_transfer;
        $total_expenses += $request->mortgage_setting_costs;
        $total_expenses += $request->estate_tax_area;
        $total_expenses += $request->estate_tax_prop;
        $total_expenses += $request->judicial_scrivener_fee;
        $total_expenses += $request->loan_fees;
        $total_expenses += $request->loan_guarantee_fee;
        $total_expenses += $request->brokerage_fee;
        // $total_expenses += $request->housing_insurance_cost;
        // $total_expenses += $request->earthquake_insurance_cost;

        $risoku = 0;
        $geturi = $request->interest_rate/100/12;
        $month = 12*$request->borrowing_period-$request->deferred_period;
        if($request->debt > 0 && $geturi > 0 && $month > 0){
            if($request->repayment_method =="元利均等"){
                $risoku = $request->debt * $geturi *pow(1+$geturi,$month);
                $risoku = $risoku / (pow(1+$geturi,$month)-1);
                $risoku = round($risoku);
            }else{
                $risoku = $request->debt/$month + $request->debt*$geturi;
            }
        }

        $project->debt =  $request->debt;
        $project->monthly_repayment_amount = $risoku;
        $project->own_resources = $total_expenses - $request->debt;
        $project->repayment_method = $request->repayment_method;
        $project->bank_name = $request->bank_name;
        $project->total_expenses = $total_expenses;
        $project->borrowing_period = $request->borrowing_period;
        $project->deferred_period = $request->deferred_period;
        $project->interest_rate = $request->interest_rate;
        $project->ganri_3 = $request->ganri_3;
        $project->ganri_5 = $request->ganri_5;
        $project->ganri_10 = $request->ganri_10;


        // 事業計画-----------------------------------------
        $jigyou_risoku = 0;

        $day1 = new DateTime($request->debt_start_date);
        $day2 = new DateTime($request->debt_end_date);
        $diff = $day1->diff($day2);
        $diff = $diff->days + 1;

        $jigyou_risoku = round($request->jigyuo_debt * $request->bank_ratio /365 * $diff);


        $project->structure_start_date = $request->structure_start_date;
        $project->structure_end_date = $request->structure_end_date;
        $project->debt_start_date = $request->debt_start_date;
        $project->debt_end_date = $request->debt_end_date;
        $project->jigyuo_area_cost = $request->jigyuo_area_cost;
        $project->jigyuo_brokerage_fee = $request->jigyuo_brokerage_fee;
        $project->jigyuo_syoukai_fee = $request->jigyuo_syoukai_fee;
        $project->jigyuo_neteitou = $request->jigyuo_neteitou;
        $project->jigyuo_tourokumenkyo = $request->jigyuo_tourokumenkyo;
        $project->jigyuo_fudousansyutoku = $request->jigyuo_fudousansyutoku;
        $project->jigyuo_sihousyosi = $request->jigyuo_sihousyosi;
        $project->jigyuo_ginkou_fee = $request->jigyuo_ginkou_fee;
        $project->jigyuo_koteisisan = $request->jigyuo_koteisisan;
        $project->jigyuo_risoku = $request->jigyuo_risoku;
        $project->jigyuo_risoku_fee = $jigyou_risoku;
        $project->jigyuo_kaitai_fee_tubo = $request->jigyuo_kaitai_fee_tubo;
        $project->jigyuo_kaitai_fee = $request->jigyuo_kaitai_fee;

        $project->jigyuo_tatinoki = $request->jigyuo_tatinoki;
        // $project->jigyuo_bikou1 = $request->jigyuo_bikou1;
        // $project->jigyuo_bikou2 = $request->jigyuo_bikou2;
        // $project->jigyuo_bikou3 = $request->jigyuo_bikou3;
        // $project->jigyuo_bikou1_fee = $request->jigyuo_bikou1_fee;
        // $project->jigyuo_bikou2_fee = $request->jigyuo_bikou2_fee;
        // $project->jigyuo_bikou3_fee = $request->jigyuo_bikou3_fee;

            // 備考土地-----------------------------------------
            $del_others = Bikou::where([
                ["project_id",$request->id],
                ['kind', "area"]
              ])->delete();
            for($i = 0;$i<$request->count_bikou_area + 1;$i++){
                $count = $i;
                $bikou_area_name = 'bikou_area_name_'.$count;
                $bikou_area_fee = 'bikou_area_fee_'.$count;
                if(isset($request->$bikou_area_name) && isset($request->$bikou_area_fee)){
                    $bikou = new Bikou;
                    $bikou->name = $request->$bikou_area_name;
                    $bikou->fee = $request->$bikou_area_fee;
                    $bikou->kind = "area";
                    $bikou->project_id = $request->id;
                    $bikou->save();
                    $count ++;
                }
            }
        $project->jigyuo_debt = $request->jigyuo_debt;



        $project->jigyuo_kentiku_fee_tubo = $request->jigyuo_kentiku_fee_tubo;
        $project->jigyuo_kentiku_fee = $request->jigyuo_kentiku_fee;
        $project->jigyuo_kui = $request->jigyuo_kui;
        $project->jigyuo_sekkeikanri = $request->jigyuo_sekkeikanri;
        $project->jigyuo_net = $request->jigyuo_net;
        $project->jigyuo_jio = $request->jigyuo_jio;
        $project->jigyuo_gas = $request->jigyuo_gas;
        $project->jigyuo_ad = $request->jigyuo_ad;
            // 備考建物-----------------------------------------
            $del_others = Bikou::where([
                ["project_id",$request->id],
                ['kind', "prop"]
            ])->delete();
            for($i = 0;$i<$request->count_bikou_prop + 1;$i++){
                $count = $i;
                $bikou_prop_name = 'bikou_prop_name_'.$count;
                $bikou_prop_fee = 'bikou_prop_fee_'.$count;
                if(isset($request->$bikou_prop_name) && isset($request->$bikou_prop_fee)){
                    $bikou = new Bikou;
                    $bikou->name = $request->$bikou_prop_name;
                    $bikou->fee = $request->$bikou_prop_fee;
                    $bikou->kind = "prop";
                    $bikou->project_id = $request->id;
                    $bikou->save();
                    $count ++;
                }
            }
        // $project->other_cost = $request->other_cost;







        $project->save();
        session()->put(['scroll_top' => $request->scroll_top]);
        return redirect()->route('projectDetail', ['id' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $id)
    {
        //
        Floor::where("project_id",$id->id)->delete();
        Bikou::where("project_id",$id->id)->delete();
        Other::where("project_id",$id->id)->delete();
        Parking::where("project_id",$id->id)->delete();
        Plan::where("project_id",$id->id)->delete();
        Room::where("project_id",$id->id)->delete();
        $id->delete();
        return redirect()->route('projectList');

    }

    public function plan($id)
    {
        //
        $project = Project::find($id);

        return view('project.plan')->with([
            'project' => $project,
        ]);



    }
    public function pdf($id)
    {
        //
        $project = Project::find($id);

        // $pdf = \PDF::loadView('project.pdf', ['project' => $project]);
        // $pdf->setPaper('A4','landscape');
        // return $pdf->stream('title.pdf');

        // $pdf = PDF::loadView('project.pdf', compact('project'))
        // ->setPaper('A4')                                // 用紙サイズ
        // ->setOption('encoding', 'utf-8')                // Encoding
        // ->setOption('margin-top', 10)                   // 上マージン
        // ->setOption('margin-bottom', 10)                // 下マージン
        // ->setOption('margin-left', 10)                  // 左マージン
        // ->setOption('margin-right', 10)
        // ->setOption('orientation', 'Landscape') ;
        // return $pdf->stream();
        $pdf = PDF::loadView('project.pdf', compact('project'))
        ->setPaper('A4','landscape')                                // 用紙サイズ
        ->setOption('encoding', 'utf-8')                // Encoding
        ->setOption('margin-top', 10)                   // 上マージン
        ->setOption('margin-bottom', 10)                // 下マージン
        ->setOption('margin-left', 10)                  // 左マージン
        ->setOption('margin-right', 10)
        ->setOption('orientation', 'Landscape') ;
        return $pdf->stream();

        // return view('project.pdf')->with([
        //         'project' => $project,
        //     ]);
    }

    public function copy(Request $request)
    {
        session()->put(['scroll_top' => 0]);

        $oldrow = Project::find($request->copy_project_id);
        $newrow = $oldrow->replicate();
        $newrow->name = $newrow->name.'のコピー';
        $newrow->save();
        $last_insert_id = $newrow->id;

        $oldplans = Plan::where("project_id",$request->copy_project_id)->get();
        foreach($oldplans as $oldplan){
            $newplan = $oldplan->replicate();
            $newplan->project_id = $last_insert_id;
            $newplan->save();
        }
        $oldparkings = Parking::where("project_id",$request->copy_project_id)->get();
        foreach($oldparkings as $oldparking){
            $newparking = $oldparking->replicate();
            $newparking->project_id = $last_insert_id;
            $newparking->save();
        }
        $oldfloors = Floor::where("project_id",$request->copy_project_id)->get();
        foreach($oldfloors as $oldfloor){
            $newfloor = $oldfloor->replicate();
            $newfloor->project_id = $last_insert_id;
            $newfloor->save();
        }
        $oldrooms = Room::where("project_id",$request->copy_project_id)->get();
        foreach($oldrooms as $oldroom){
            $newroom = $oldroom->replicate();
            $newroom->project_id = $last_insert_id;
            $newroom->save();
        }
        $oldothers = Other::where("project_id",$request->copy_project_id)->get();
        foreach($oldothers as $oldother){
            $newother = $oldother->replicate();
            $newother->project_id = $last_insert_id;
            $newother->save();
        }
        $oldbikous = Bikou::where("project_id",$request->copy_project_id)->get();
        foreach($oldbikous as $oldbikou){
            $newbikou = $oldbikou->replicate();
            $newbikou->project_id = $last_insert_id;
            $newbikou->save();
        }







        return redirect()->route('projectDetail', ['id' => $last_insert_id]);

    }
    public function output() {
        $sushiTable = [
            'たまご' => '100円',
            'いくら' => '200円',
            'サーモン' => '180円',
            'いか' => '100円',
            'マグロ' => '110円',
            'えび' => '100円',
        ];

        $pdf = PDF::loadView('pdftest.test', ['sushiTable' => $sushiTable]);
        $pdf->setPaper('A4');
        return $pdf->stream();

    }
}

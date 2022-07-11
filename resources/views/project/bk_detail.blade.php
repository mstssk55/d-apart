<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <div class="py-5 fixed w-full">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2 px-6">
                <ul class="flex justify-between text-sky-600 text-sm">
                    <li><a href="#bukkenn-gaiyou">物件概要</a></li>
                    <li><a href="">基礎情報</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="py-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action={{route('projectUpdate')}} method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="w-full bg-sky-100 text-sm py-2 px-1 rounded-sm" id="bukkenn-gaiyou">
                            <h2>物件概要</h2>
                        </div>
                        <div class="flex mb-5">
{{--------------------------- 物件概要 -----------------------------------------------}}
                            <div class="w-4/12 text-center mr-2 text-xs">
                                @include('parts.project.h2',['title'=>'物件概要'])
                                @include('parts.project.h3',['title'=>'物件概要'])
                                <table class="table-fixed w-full mb-3">
                                    <tbody class="">
                                        @include('parts.project.gaiyou.normal',['title'=>'所在地','val'=>$project->property->address])
                                        @include('parts.project.gaiyou.normal',['title'=>'新築中古区分','val'=>$project->property->category])
                                        {{-- @include('parts.project.gaiyou.normal',['title'=>'完成予定','val'=>$project->property->open_date])
                                        @include('parts.project.gaiyou.normal',['title'=>'家賃送金開始日','val'=>$project->property->start_date]) --}}
                                        @include('parts.project.gaiyou.normal',['title'=>'館名','val'=>$project->property->name])
                                        @include('parts.project.gaiyou.normal',['title'=>'交通','val'=>$project->property->address])
                                        @include('parts.project.gaiyou.normal',['title'=>'地積','val'=>$project->property->land_area])
                                        @include('parts.project.gaiyou.normal',['title'=>'地目','val'=>$project->property->ground])
                                        @include('parts.project.gaiyou.normal',['title'=>'都市計画','val'=>$project->property->city_planning])
                                        @include('parts.project.gaiyou.normal',['title'=>'用途地域','val'=>$project->property->use_district])
                                        @include('parts.project.gaiyou.normal',['title'=>'建ぺい率/容積率','val'=>$project->property->building_coverage_ratio.'%/'.$project->property->floor_area_ratio.'%'])
                                        @include('parts.project.gaiyou.normal',['title'=>'道路','val'=>$project->property->address])
                                        @include('parts.project.gaiyou.normal',['title'=>'備考','val'=>$project->property->text])
                                    </tbody>
                                </table>
                                {{--------------------------- 建築プラン -----------------------------------------------}}
                                @include('parts.project.h3',['title'=>'建築プラン'])
                                <table class="table-fixed w-full text-xs mb-3">
                                    <tbody class="w-full">
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">種類</th>
                                            <td class="w-4/5 border">
                                                @include('parts.project.gaiyou.col_2',['name1'=>'plan_kind','val1'=>$project->plan_kind,'name2'=>'household','val2'=>$project->household,'unit'=>'世帯入'])
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                間取り
                                                <svg xmlns="http://www.w3.org/2000/svg" class="add_button_room_plan cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </th>
                                            <td class="w-4/5 border add_room_plan">
                                                @php
                                                    $plan_num = 0;
                                                @endphp
                                                @if (count($project->plans)>0)
                                                    @foreach ($project->plans as $plan)
                                                        @php
                                                            $room_plan_name = "room_plan_".$plan_num;
                                                            $room_count_name = "room_count_".$plan_num;
                                                        @endphp
                                                        @include('parts.project.gaiyou.col_2',['name1'=>$room_plan_name,'val1'=>$plan->plan,'name2'=>$room_count_name,'val2'=>$plan->count,'unit'=>'戸'])
                                                        @php
                                                            $plan_num += 1;
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $plan_num -= 1;
                                                    @endphp
                                                @else
                                                    @include('parts.project.gaiyou.col_2',['name1'=>'room_plan_0','val1'=>'','name2'=>'room_count_0','val2'=>'','unit'=>'戸'])
                                                @endif
                                                <input type="hidden" value="{{$plan_num}}" name="count_room_plan" id="count_room_plan">
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                駐車
                                                <svg xmlns="http://www.w3.org/2000/svg" class="add_button_parking_plan cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </th>
                                            <td class="w-4/5 border add_parking_plan">
                                                @php
                                                    $parking_num = 0;
                                                @endphp
                                                @if (count($project->parkings)>0)
                                                    @foreach ($project->parkings as $parking)
                                                        @php
                                                            $parking_plan_name = "parking_plan_".$parking_num;
                                                            $parking_count_name = "parking_count_".$parking_num;
                                                            $parking_fee_name = "parking_fee_".$parking_num;
                                                        @endphp
                                                        @include('parts.project.gaiyou.col_3',['name1'=>$parking_plan_name,'val1'=>$parking->plan,'name2'=>$parking_count_name,'val2'=>$parking->count,'name3'=>$parking_fee_name,'val3'=>$parking->fee,'unit'=>'台分'])
                                                        @php
                                                            $parking_num += 1;
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $parking_num -= 1;
                                                    @endphp
                                                @else
                                                    @include('parts.project.gaiyou.col_3',['name1'=>'parking_plan_0','val1'=>'','name2'=>'parking_count_0','val2'=>'','name3'=>'parking_fee_0','val3'=>'','unit'=>'台分'])
                                                @endif
                                                <input type="hidden" value="{{$parking_num}}" name="count_parking_plan" id="count_parking_plan">
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">構造</th>
                                            <td class="w-4/5 border">
                                                @include('parts.project.gaiyou.col_2',['name1'=>'structure','val1'=>$project->structure,'name2'=>'floor','val2'=>$project->floor,'unit'=>'階建て'])
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">設備</th>
                                            <td class="w-4/5 border">
                                                <div>
                                                    <input type="text" name="equipment" value="{{$project->equipment}}" class="border-none text-xs w-full h-full px-4 py-1">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">面積</th>
                                            <td class="w-4/5 border">
                                                @include('parts.project.gaiyou.col_2_area',['title'=>'地階（車庫）','name'=>'plan_basement_area'])
                                                @include('parts.project.gaiyou.col_2_area',['title'=>'テナント','name'=>'plan_tenant_area'])
                                                @include('parts.project.gaiyou.col_2_area',['title'=>'居住','name'=>'plan_room_area'])
                                                @include('parts.project.gaiyou.col_2_area',['title'=>'延床','name'=>'plan_total_area','last'=>'last'])
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="flex">
                                    <div class="mr-2">
                                        @include('parts.project.h3',['title'=>'家賃収入'])
                                        @php
                                            $total_room_rents = 0;
                                            $total_others = 0;
                                            $total_parking_fee = 0;
                                            foreach($project->rooms as $room){
                                                $total_room_rents += $room->room_rent;
                                                $total_others += $room->room_common;

                                            }
                                            foreach($project->parkings as $parking){
                                                $total_parking_fee += $parking->count*$parking->fee;
                                            }
                                            $total_fees = $total_room_rents + $total_others + $total_parking_fee;
                                        @endphp
                                        <p></p>
                                        <table class="table-fixed w-full">
                                            <tbody class="">
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'家賃','id'=>'total_rent','val'=>number_format($total_room_rents),'unit'=>'円／月'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'その他計','id'=>'total_rent','val'=>number_format($total_others),'unit'=>'円／月'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'駐車料計','id'=>'total_rent','val'=>number_format($total_parking_fee),'unit'=>'円／月'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'月額','id'=>'total_rent','val'=>number_format($total_fees),'unit'=>'円'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'年額','id'=>'total_rent','val'=>number_format($total_fees*12),'unit'=>'円'])
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        @include('parts.project.h3',['title'=>'販売価格'])
                                        @php
                                            $yield_tax = 0;
                                            $yield = 0;
                                            $price_prop_tax =$project->price_prop *0.1;
                                            $price_prop_total = $project->price_prop + $price_prop_tax;
                                            $total_price = $project->price_prop + $project->price_land;
                                            if($total_price > 0){
                                                $yield_tax = $total_fees*12/($total_price + $price_prop_tax)*100;
                                                $yield = $total_fees*12/$total_price*100;
                                            }
                                        @endphp
                                        <table class="table-fixed w-full">
                                            <tbody class="">
                                                @include('parts.project.gaiyou.col_1_input',['title'=>'土地','id'=>'price_land','unit'=>'円'])
                                                @include('parts.project.gaiyou.col_1_input',['title'=>'建物','id'=>'price_prop','unit'=>'円'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'(内消費税)','id'=>'price_prop_tax','val'=>number_format($price_prop_tax),'unit'=>'円','right'=>0])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'税込み','id'=>'price_prop_total','val'=>number_format($price_prop_total),'unit'=>'円','right'=>0])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'合計','id'=>'total_price','val'=>number_format($total_price),'unit'=>'円'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'利回(税込)','id'=>'yield_tax','val'=>number_format($yield_tax,2),'unit'=>'%'])
                                                @include('parts.project.gaiyou.col_1_rent',['title'=>'利回(税抜)','id'=>'yield','val'=>number_format($yield,2),'unit'=>'%'])
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
{{--------------------------- 基礎情報 -----------------------------------------------}}
                            <div class="w-4/12 text-center mr-2  text-xs">
                                @include('parts.project.h2',['title'=>'基礎情報'])
                                @include('parts.project.h3',['title'=>'賃金、借入金内訳'])
                                <table class="table-fixed w-full  mb-3">
                                    <tbody class="w-full">
                                        @include('parts.project.kiso.col1',['title'=>'借入金','name'=>'debt'])
                                        @include('parts.project.kiso.col1',['title'=>'自己資金','name'=>'own_resources'])
                                        @include('parts.project.kiso.col1',['title'=>'総事業合計','name'=>'expense'])
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">返済方法</th>
                                            <td class="w-4/5 border">
                                                <select id="" name="repayment_method" class="text-xs border-none w-full h-full px-4 py-1">
                                                    <option value="">選択してください</option>
                                                    @php
                                                        $ganri = "";
                                                        $gankin = "";
                                                        if($project->repayment_method =="元利均等"){
                                                            $ganri = "selected";
                                                        }else if($project->repayment_method =="元金均等"){
                                                            $gankin = "selected";
                                                        }
                                                    @endphp
                                                    <option value="元利均等" {{$ganri}} >元利均等</option>
                                                    <option value="元金均等" {{$gankin}} >元金均等</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @include('parts.project.kiso.col1',['title'=>'借入期間','name'=>'borrowing_period','unit'=>'年'])
                                        @include('parts.project.kiso.col1',['title'=>'措置期間','name'=>'deferred_period','unit'=>'ヶ月'])
                                        @include('parts.project.kiso.col1',['title'=>'借入金利','name'=>'interest_rate','unit'=>'%'])
                                        @include('parts.project.kiso.col1',['title'=>'諸費用合計','name'=>'total_expenses'])
                                        @include('parts.project.kiso.col1',['title'=>'月学返済額','name'=>'monthly_repayment_amount'])

                                    </tbody>
                                </table>
                                {{-- 固定資産税評価額----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'固定資産税評価額'])
                                <table class="table-fixed w-full text-xs mb-3">
                                    <tbody class="w-full">
                                        @include('parts.project.kiso.col1',['title'=>'土地評価額','name'=>'property_tax_area'])
                                        @include('parts.project.kiso.col1',['title'=>'建物評価額','name'=>'property_tax_prop'])
                                    </tbody>
                                </table>

                                {{-- 不動産取得税----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'不動産取得税'])
                                <table class="table-fixed w-full text-xs mb-3">
                                    <tbody class="w-full">
                                        <tr  class="w-full" class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">住宅用地に対する標準課税の特例</th>
                                            <td class="w-4/5 border">
                                                <input type="radio" id="estate_tax_jutaku_0" name="estate_tax_jutaku" value="特例あり" class="w-3 h-3 mr-1"><label for="estate_tax_jutaku_0">特例あり</label>
                                                <input type="radio" id="estate_tax_jutaku_1" name="estate_tax_jutaku" value="特例なし" class="w-3 h-3 mr-1"><label for="estate_tax_jutaku_1">特例あり</label>
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">新築住宅に対する減額措置</th>
                                            <td class="w-4/5 border">
                                                <input type="radio" id="estate_tax_shintiku_0" name="estate_tax_shintiku" value="特例あり" class="w-3 h-3 mr-1"><label for="estate_tax_shintiku_0">特例あり</label>
                                                <input type="radio" id="estate_tax_shintiku_1" name="estate_tax_shintiku" value="特例なし" class="w-3 h-3 mr-1"><label for="estate_tax_shintiku_1">特例なし</label>
                                            </td>
                                        </tr>
                                        @include('parts.project.kiso.col1',['title'=>'土地不動産取得税','name'=>'estate_tax_area'])
                                        @include('parts.project.kiso.col1',['title'=>'建物不動産取得税','name'=>'estate_tax_prop'])
                                    </tbody>
                                </table>

                                {{-- 登録免許税----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'登録免許税'])
                                <table class="table-fixed w-full  text-xs mb-3">
                                    <tbody class="w-full">
                                        @include('parts.project.kiso.col1',['title'=>'表示登記','name'=>'display_registration'])
                                        @include('parts.project.kiso.col1',['title'=>'土地所有権移転登記','name'=>'land_ownership_transfer'])
                                        @include('parts.project.kiso.col1',['title'=>'建物所有権移転登記','name'=>'prop_ownership_transfer'])
                                        @include('parts.project.kiso.col1',['title'=>'抵当権設定費用','name'=>'mortgage_setting_costs'])
                                    </tbody>
                                </table>

                                {{-- 手数料、保険料----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'手数料、保険料'])
                                <table class="table-fixed w-full text-xs">
                                    <tbody class="w-full">
                                        @include('parts.project.kiso.col1',['title'=>'司法書士手数料','name'=>'judicial_scrivener_fee'])
                                        @include('parts.project.kiso.col1',['title'=>'ローン手数料','name'=>'loan_fees'])
                                        @include('parts.project.kiso.col1',['title'=>'ローン保証料','name'=>'loan_guarantee_fee'])
                                        @include('parts.project.kiso.col1',['title'=>'仲介料','name'=>'brokerage_fee'])
                                        @include('parts.project.kiso.col1',['title'=>'その他雑費','name'=>'other_cost'])

                                        @include('parts.project.kiso.cal2',['title'=>'住宅総合保険','name1'=>'housing_insurance_year','name2'=>'housing_insurance_cost'])
                                        @include('parts.project.kiso.cal2',['title'=>'地震保険','name1'=>'earthquake_insurance_year','name2'=>'earthquake_insurance_cost'])
                                    </tbody>
                                </table>
                                <input type="hidden" name="id" value="{{$project->id}}" class="border-none px-4 py-1">
                            </div>
{{-- 家賃明細表---------------------------------------------------------------------------------------- --}}
                            <div class="w-4/12 text-center">
                                @include('parts.project.h2',['title'=>'家賃明細表'])
                                {{-- 家賃----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'家賃'])
                                <div class="check_rent text-xs">
                                    @if (count($project->rooms)>0)
                                        <table class="table-fixed w-full text-xs mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="bg-gray-100 border px-4 py-2">部屋No</th>
                                                    <th class="bg-gray-100 border px-4 py-2">間取り</th>
                                                    <th class="bg-gray-100 border px-4 py-2">㎡</th>
                                                    <th class="bg-gray-100 border px-4 py-2">賃料</th>
                                                    <th class="bg-gray-100 border px-4 py-2">管理費</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $room_count_php = 0;
                                                @endphp
                                                @foreach ($project->rooms as $room )
                                                    @include('parts.project.rent.rent',['name1'=>'room_no','name2'=>'room_plan','name3'=>'room_area','name4'=>'room_rent','name5'=>'room_common','count'=>$room_count_php])
                                                    @php
                                                        $room_count_php +=1;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            </table>
                                            <input type="hidden" name="rent_rooms_count" value="{{$project->household}}">
                                    @else
                                        @if ($project->household =="" or $project->floor == "")
                                            <div>
                                                <p class="bg-blue">先に建築プランを入力して保存を押してください</p>
                                            </div>
                                        @else
                                            <div id="insert_table_rent">
                                                <div class="flex items-center justify-center">
                                                    <p class="mr-5"><input type="number" id="new_rent_num" name="new_rent_num" class="text-right border-none text-xs" value="{{$project->household}}" disabled>部屋</p>
                                                    <p id="new_rent_button" class="rounded-md bg-gray-200 hover:bg-gray-400 py-2 px-3 cursor-pointer">家賃表を作成する</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                {{-- 駐車料----------------------------------------- --}}
                                @include('parts.project.h3',['title'=>'駐車料'])
                                <div class="check_rent text-xs">
                                    @if (count($project->parkings)>0)
                                        <table class="table-fixed w-full text-xs">
                                            <thead>
                                                <tr>
                                                    <th class="bg-gray-100 border px-4 py-2">プランNo.</th>
                                                    <th class="bg-gray-100 border px-4 py-2">タイプ</th>
                                                    <th class="bg-gray-100 border px-4 py-2">台数</th>
                                                    <th class="bg-gray-100 border px-4 py-2">単価</th>
                                                    <th class="bg-gray-100 border px-4 py-2">小計</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $park_count = 0;
                                                @endphp
                                                @foreach ($project->parkings as $park )
                                                    @include('parts.project.rent.park',['name1'=>'park_fee','count'=>$park_count])
                                                    @php
                                                        $park_count +=1;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            </table>
                                    @else
                                            <div>
                                                <p class="bg-blue">先に駐車プランを入力して保存を押してください</p>
                                            </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-1/2 text-center mr-2  text-xs">
                                @include('parts.project.h2',['title'=>'費用'])
                                @include('parts.project.h3',['title'=>'費用'])
                                <table class="table-fixed w-full  mb-3">
                                    <tbody class="w-full">
                                        @include('parts.project.fee.col2',['title'=>'土地代金'])
                                        @include('parts.project.fee.col2',['title'=>'仲介料'])
                                        @include('parts.project.fee.col2',['title'=>'紹介料'])
                                        @include('parts.project.fee.col2',['title'=>'根抵当権設定料'])
                                        @include('parts.project.fee.col2',['title'=>'登録免許税'])
                                        @include('parts.project.fee.col2',['title'=>'不動産取得税'])
                                        @include('parts.project.fee.col2',['title'=>'司法書士報酬'])
                                        @include('parts.project.fee.col2',['title'=>'銀行手数料／印紙'])
                                        @include('parts.project.fee.col2',['title'=>'固定資産税等'])
                                        @include('parts.project.fee.col2',['title'=>'支払利息'])
                                        @include('parts.project.fee.col2',['title'=>'解体費用'])
                                        @include('parts.project.fee.col2',['title'=>'立ち退き費用'])
                                        @include('parts.project.fee.col2',['title'=>'備考1'])
                                        @include('parts.project.fee.col2',['title'=>'備考2'])
                                        @include('parts.project.fee.col2',['title'=>'備考3'])
                                        @include('parts.project.fee.col2',['title'=>'土地費用合計'])
                                    </tbody>
                                </table>
                            </div>
                            <div class="w-1/2 text-center mr-2  text-xs">
                                @include('parts.project.h2',['title'=>'建築費用'])
                                @include('parts.project.h3',['title'=>'建築費用'])
                                <table class="table-fixed w-full  mb-3">
                                    <tbody class="w-full">
                                        @include('parts.project.fee.col2',['title'=>'建築本体工事'])
                                        @include('parts.project.fee.col2',['title'=>'杭工事費用'])
                                        @include('parts.project.fee.col2',['title'=>'設計管理費用'])
                                        @include('parts.project.fee.col2',['title'=>'インターネット工事'])
                                        @include('parts.project.fee.col2',['title'=>'JIO検査・保険料'])
                                        @include('parts.project.fee.col2',['title'=>'都市ガス工事'])
                                        @include('parts.project.fee.col2',['title'=>'広告料'])
                                        @include('parts.project.fee.col2',['title'=>'備考1'])
                                        @include('parts.project.fee.col2',['title'=>'備考2'])
                                        @include('parts.project.fee.col2',['title'=>'備考3'])
                                        @include('parts.project.fee.col2',['title'=>'備考3'])
                                        @include('parts.project.fee.col2',['title'=>'建築費用合計'])
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <button type="submit" class="fixed bottom-20 right-20 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保存する</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function set_tubo(num,id){
            $('#t-' + id).text((num * 0.3025).toFixed(2));
        }
        function change_tubo(id){
            $('#m-' + id).on('change',function(){
                set_tubo($(this).val(),id)
            })
        }
        function check_val(val){
            let value = 0;
            if(val != ""){
                value = val
            }
            return value;
        }
        const plan_basement_area = check_val('{{$project->plan_basement_area}}');
        const plan_tenant_area = check_val('{{$project->plan_tenant_area}}');
        const plan_room_area = check_val('{{$project->plan_room_area}}');
        const plan_total_area = check_val('{{$project->plan_total_area}}');
        console.log(plan_basement_area)
        set_tubo(plan_basement_area,"plan_basement_area")
        set_tubo(plan_tenant_area,"plan_tenant_area")
        set_tubo(plan_room_area,"plan_room_area")
        set_tubo(plan_total_area,"plan_total_area")
        change_tubo("plan_basement_area")
        change_tubo("plan_tenant_area")
        change_tubo("plan_room_area")
        change_tubo("plan_total_area")

        function add_button(kind,name1,name2){
            $('.add_button_'+kind).on('click',function(){
                let number = Number($('#count_'+kind).val()) + 1
                let unit = "戸"
                if(kind == "parking_plan"){
                    unit = "台数"
                }
                const insert =
                    `<div class="flex mb-1">
                        <div class="w-1/2"><input type="text" name="${name1}_${number}" class="border-none text-xs w-full h-full px-4 py-1"></div>
                        <div class="w-1/2"><input type="number" name="${name2}_${number}" class="border-none text-xs h-full px-4 py-1"><span>${unit}</span></div>
                    </div>`;
                $('.add_'+kind).append(insert);
                $('#count_'+kind).val(number)
            })
        }
        add_button("room_plan","room_plan","room_count")
        add_button("parking_plan","parking_plan","parking_count")




        $('#new_rent_button').on('click',function(){
            function body_num(name,val){
                const body = `<td class="border px-2 py-1"><input type="number" name="${name}" value="${val}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>`
                return body;
            }
            const total_rooms = Number('{{$project->household}}')
            const total_floors = Number('{{$project->floor}}')
            let remainder = total_rooms%total_floors
            let floor_rooms = Math.floor(total_rooms/total_floors)
            let floors = []
            for(let i = 0;i<total_floors;i++){
                let add_num = floor_rooms
                if(remainder > 0){
                    add_num ++;
                }
                floors.unshift(add_num)
                remainder --
            }
            let table_body = "";
            let name_count = 0;
            for(let i = 0;i<floors.length;i++){
                for(let n = 0;n<floors[i];n++){
                    let room_number = n+1
                    if(room_number<10){
                        room_number = '0' + String(room_number)
                    }
                    room_number = String(i+1)+String(room_number)
                    table_body += `<tr>
                                        ${body_num('room_no_'+ String(name_count),room_number)}
                                        ${body_num("room_plan_"+ String(name_count),"")}
                                        ${body_num("room_area_"+ String(name_count),"")}
                                        ${body_num("room_rent_"+ String(name_count),"")}
                                        ${body_num("room_common_"+ String(name_count),"")}
                                    </tr>`
                    name_count ++
                }
            }
            const insert = `<table class="table-fixed w-full text-xs">
                                <thead>
                                    <tr>
                                        <th class="bg-gray-100 border px-4 py-2">部屋No</th>
                                        <th class="bg-gray-100 border px-4 py-2">間取り</th>
                                        <th class="bg-gray-100 border px-4 py-2">㎡</th>
                                        <th class="bg-gray-100 border px-4 py-2">賃料</th>
                                        <th class="bg-gray-100 border px-4 py-2">管理費</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${table_body}
                                </tbody>
                                </table>
                                <input type="hidden" name="rent_rooms_count" value="${total_rooms}">`
            $('#insert_table_rent').html(insert);

        })
    </script>
</x-app-layout>

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
    @php
        $parking_item_list = ["青空駐車場","車庫","軽自動車","ピロティ"];
        $js_parking_item_list = json_encode($parking_item_list);
        $js_layouts = json_encode($layouts);
    @endphp
    {{-- <div class="py-5 fixed w-full">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2 px-6">
                <ul class="flex justify-between text-sky-600 text-sm">
                    <li><a href="#bukkenn-gaiyou">物件概要</a></li>
                    <li><a href="">基礎情報</a></li>
                </ul>
            </div>
        </div>
    </div> --}}
    <div class="py-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action={{route('projectUpdate')}} method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$project->id}}">
                        {{---------------------- form内容 ----------------------------------------------------------}}
                            {{--■■■■■■■■■■■■■■■■ 物件概要 ■■■■■■■■■■■■■■■■■■--}}
                                @include('parts.project.h2',['title'=>'物件概要'])
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ 収支計画基本情報 ~~~~~~~~~~~ --}}
                                    <div class="w-1/2 mr-8">
                                        @include('parts.project.h3',['title'=>'収支計画基本情報'])
                                        <table class="table-fixed w-full mb-3">
                                            <tbody class="">
                                                @include('parts.project.bukken.col_1_input',['title'=>'タイトル','id'=>'name'])
                                                @include('parts.project.bukken.col_1_input',['title'=>'顧客名','id'=>'client'])
                                                @include('parts.project.bukken.col_1_input',['title'=>'館名','id'=>'house_name'])
                                                <tr class="w-full">
                                                    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">担当者</th>
                                                    <td class="w-2/3 border">
                                                        <div class="flex items-center">
                                                            <select name="manager" id="manager" class="border-none w-full bg-sky-50">
                                                                <option value="">選択して下さい</option>
                                                                @foreach ($users as $user)
                                                                    @php
                                                                        $selected = "";
                                                                        if($user->id == $project->manager){
                                                                            $selected = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="{{$user->id}}" {{$selected}}>{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('parts.project.bukken.col_1_input',['title'=>'完成予定日','id'=>'open_date','type'=>'date'])
                                                @include('parts.project.bukken.col_1_input',['title'=>'家賃送金開始日','id'=>'start_date','type'=>'date'])
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- ~~~~~~~~~~~ 収支計画基本情報ここまで ~~~~~~~~~~~ --}}
                                    {{-- ~~~~~~~~~~~ 物件概要 ~~~~~~~~~~~ --}}
                                    <div class="w-1/2">
                                        @include('parts.project.h3',['title'=>'物件概要'])
                                        <table class="table-fixed w-full mb-3">
                                            <tbody class="">
                                                @include('parts.project.gaiyou.normal',['title'=>'物件名','val'=>$project->property->name])
                                                @include('parts.project.gaiyou.normal',['title'=>'所在地','val'=>$project->property->address])
                                                @include('parts.project.gaiyou.normal',['title'=>'新築中古区分','val'=>$project->property->category])
                                                @include('parts.project.gaiyou.normal',['title'=>'交通','val'=>$project->property->stations])
                                                @include('parts.project.gaiyou.normal',['title'=>'地積','val'=>$project->property->land_area,'unit'=>'㎡'])
                                                @include('parts.project.gaiyou.normal',['title'=>'地目','val'=>$project->property->ground])
                                                @include('parts.project.gaiyou.normal',['title'=>'都市計画','val'=>$project->property->city_planning])
                                                @include('parts.project.gaiyou.normal',['title'=>'用途地域','val'=>$project->property->use_district])
                                                @include('parts.project.gaiyou.normal',['title'=>'建ぺい率/容積率','val'=>$project->property->building_coverage_ratio.'%/'.$project->property->floor_area_ratio.'%'])
                                                @include('parts.project.gaiyou.normal',['title'=>'道路','val'=>$project->property->roads])
                                                @include('parts.project.gaiyou.normal',['title'=>'備考','val'=>$project->property->text])
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- ~~~~~~~~~~~ 物件概要ここまで ~~~~~~~~~~~ --}}
                                </div>
                            {{--■■■■■■■■■■■■■■■■ 物件概要ここまで ■■■■■■■■■■■■■■■■■■--}}

                            {{--■■■■■■■■■■■■■■■■ 建築プラン ■■■■■■■■■■■■■■■■■■--}}
                                @include('parts.project.h2',['title'=>'建築プラン'])
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ 建築プラン ~~~~~~~~~~~ --}}
                                        <div class="w-1/2 mr-8">
                                            @include('parts.project.h3',['title'=>'建築プラン'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="w-full">
                                                    @include('parts.project.bukken.col_1_input',['title'=>'種類','id'=>'plan_kind'])
                                                    <tr  class="w-full">
                                                        <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                            <div class="flex items-center">
                                                                <p class="w-1/2">間取り</p>
                                                                <div class="w-1/2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="add_button_room_plan cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
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
                                                            <div class="flex items-center">
                                                                <p class="w-1/2">駐車</p>
                                                                <div class="w-1/2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="add_button_parking_plan cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
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
                                                    @include('parts.project.bukken.col_1_input',['title'=>'設備','id'=>'equipment'])
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 建築プランここまで ~~~~~~~~~~~ --}}
                                    {{-- ~~~~~~~~~~~ 販売価格 ~~~~~~~~~~~ --}}
                                        <div class="w-1/2">
                                            @include('parts.project.h3',['title'=>'販売価格'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @php
                                                        $yield_tax = 0;
                                                        $yield = 0;
                                                        $price_prop_tax =$project->price_prop *0.1;
                                                        $price_prop_total = $project->price_prop + $price_prop_tax;
                                                        $total_price = $project->price_prop + $project->price_land;
                                                        // if($total_price > 0){
                                                        //     $yield_tax = $total_fees*12/($total_price + $price_prop_tax)*100;
                                                        //     $yield = $total_fees*12/$total_price*100;
                                                        // }
                                                    @endphp
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地','id'=>'price_land','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物','id'=>'price_prop','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'(内消費税)','id'=>'price_prop_tax','val'=>number_format($price_prop_tax),'unit'=>'円','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'税込み','id'=>'price_prop_total','val'=>number_format($price_prop_total),'unit'=>'円','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'合計','id'=>'total_price','val'=>number_format($total_price),'unit'=>'円'])
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 販売価格ここまで ~~~~~~~~~~~ --}}
                                </div>
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ 間取り ~~~~~~~~~~~ --}}
                                        <div class="w-1/2 mr-8">
                                            @include('parts.project.h3',['title'=>'間取り'])
                                            @if ($project->floor == "")
                                                <p class="text-center">先に階数を登録して下さい。</p>
                                            @else
                                                <table class="table-fixed w-full mb-3">
                                                    <thead class="w-full">
                                                        <th class="w-1/4 px-2 py-1 border font-normal bg-gray-100"></th>
                                                        <th class="w-1/4 px-2 py-1 border font-normal bg-gray-100">テナント</th>
                                                        <th class="w-1/4 px-2 py-1 border font-normal bg-gray-100">居住</th>
                                                        <th class="w-1/4 px-2 py-1 border font-normal bg-gray-100">合計</th>
                                                    </thead>
                                                    <tbody class="w-full">
                                                        <tr class="w-full text-center">
                                                            <th class="border-none font-normal bg-gray-100"></th>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300 bg-gray-100 text-xs py-1">
                                                                        <p>戸数</p>
                                                                    </div>
                                                                    <div class="w-3/4 bg-gray-100 text-xs py-1">
                                                                        <p>平米数</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300 bg-gray-100 text-xs py-1">
                                                                        <p>戸数</p>
                                                                    </div>
                                                                    <div class="w-3/4 bg-gray-100 text-xs py-1">
                                                                        <p>平米数</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300 bg-gray-100 text-xs py-1">
                                                                        <p>戸数</p>
                                                                    </div>
                                                                    <div class="w-3/4 bg-gray-100 text-xs py-1">
                                                                        <p>平米数</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @include('parts.project.plan.plan',["head"=>"地下"])
                                                        @for ($i = 1;$i<$project->floor + 1;$i++)
                                                            @include('parts.project.plan.plan',["head"=>$i."階"])
                                                        @endfor
                                                        <tr class="w-full">
                                                            <th class="px-2 py-1 border font-normal bg-gray-100">合計</th>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <p class="w-full text-center">4</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <p class="w-full text-center">1000</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <p class="w-full text-center">4</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <p class="w-full text-center">1000</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <p class="w-full text-center">4</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <p class="w-full text-center">1000</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            @endif

                                        </div>
                                    {{-- ~~~~~~~~~~~ 間取りここまで ~~~~~~~~~~~ --}}
                                    {{-- ~~~~~~~~~~~ 家賃 ~~~~~~~~~~~ --}}
                                        <div class="w-1/2">
                                            @include('parts.project.h3',['title'=>'家賃'])
                                        </div>
                                    {{-- ~~~~~~~~~~~ 家賃ここまで ~~~~~~~~~~~ --}}
                                </div>
                            {{--■■■■■■■■■■■■■■■■ 建築プランここまで ■■■■■■■■■■■■■■■■■■--}}

                            {{--■■■■■■■■■■■■■■■■ 基礎情報 ■■■■■■■■■■■■■■■■■■--}}
                                @include('parts.project.h2',['title'=>'基礎情報'])
                                <div class="flex mb-5">
                                    <div class="w-1/3 mr-3">
                                        {{-- ~~~~~~~~~~~ 固定資産税評価額 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'固定資産税評価額'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">住宅用地特例措置</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="estate_tax_jutaku" id="estate_tax_jutaku" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @php
                                                                        $estate_tax_jutaku_0 = "";
                                                                        $estate_tax_jutaku_1 = "";
                                                                        if($project->estate_tax_jutaku == "特例あり"){
                                                                            $estate_tax_jutaku_0 = "selected";
                                                                        }else if($project->estate_tax_jutaku == "特例なし"){
                                                                            $estate_tax_jutaku_1 = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="特例あり" {{$estate_tax_jutaku_0}}>特例あり</option>
                                                                    <option value="特例なし" {{$estate_tax_jutaku_1}}>特例なし</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地評価額','id'=>'property_tax_area','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物評価額','id'=>'property_tax_prop','unit'=>'円'])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 固定資産税評価額ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 登録免許税 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'登録免許税'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'表示登記','id'=>'display_registration','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地所有権移転登記','id'=>'land_ownership_transfer','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物所有権移転登記','id'=>'prop_ownership_transfer','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'抵当権設定費用','id'=>'mortgage_setting_costs','unit'=>'円'])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 登録免許税ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 不動産取得税 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'不動産取得税'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地不動産取得税','id'=>'estate_tax_area','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物不動産取得税','id'=>'estate_tax_prop','unit'=>'円'])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 不動産取得税ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 固定資産税・都市計画税 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'固定資産税・都市計画税'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">家屋特例措置</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="estate_tax_shintiku" id="estate_tax_shintiku" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    <option value="">特例あり</option>
                                                                    <option value="">特例なし</option>
                                                                </select>
                                                                <div class="w-2/6 block text-left ml-1 flex items-center text-xs">
                                                                    <p class="w-1/3">新築後</p>
                                                                    <input type="number" class="w-1/3 ">
                                                                    <p class="w-1/3">年間</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.tax',['title'=>'固定資産税','id'=>''])
                                                    @include('parts.project.tax',['title'=>'都市計画税','id'=>''])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 固定資産税・都市計画税ここまで ~~~~~~~~~~~ --}}


                                    </div>
                                    <div class="w-1/3 mr-3">
                                        {{-- ~~~~~~~~~~~ 手数料・保険料 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'手数料・保険料'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'司法書士手数料','id'=>'judicial_scrivener_fee','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'ローン手数料','id'=>'loan_fees','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'ローン保証料','id'=>'loan_guarantee_fee','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'仲介料','id'=>'brokerage_fee','unit'=>'円'])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">その他雑費</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-2/6 bg-sky-50">
                                                                    <option value="">１回限り</option>
                                                                    <option value="">毎年</option>
                                                                </select>
                                                                <div class="w-4/6 flex items-center border-l border-gray-300">
                                                                    <input type="number" id="" name="" value="" class="text-right border-none w-4/6 bg-sky-50">
                                                                    <span class="w-2/6 block text-left ml-1">円</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col2_total',['title'=>'管理手数料（戸）','id'=>''])
                                                    @include('parts.project.gaiyou.col2_total',['title'=>'インターネット使用料','id'=>''])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'共用電気量','id'=>'','unit'=>'円/月'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'定期清掃料','id'=>'','unit'=>'円/月'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'振込手数料','id'=>'','unit'=>'円/月'])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">住宅保険</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    <option value="">特例あり</option>
                                                                    <option value="">特例なし</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'住宅保険期間','id'=>'','unit'=>'年','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'住宅火災保険','id'=>'','unit'=>'円','right'=>0])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">地震保険</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    <option value="">特例あり</option>
                                                                    <option value="">特例なし</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'地震保険期間','id'=>'','unit'=>'年','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'地震保険','id'=>'','unit'=>'円','right'=>0])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 手数料・保険料ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 減価償却 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'減価償却'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">建物減価償却</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-1/3 bg-sky-50">
                                                                    <option value="">定率法</option>
                                                                    <option value="">定額法</option>
                                                                </select>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <input type="number" id="" name="" value="" class="text-right w-full border-none bg-sky-50">
                                                                </div>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <p class="text-center border-none w-full h-full">0.0022</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">設備原価償却</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-1/3 bg-sky-50">
                                                                    <option value="">定率法</option>
                                                                    <option value="">定額法</option>
                                                                </select>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <input type="number" id="" name="" value="" class="text-right w-full border-none bg-sky-50">
                                                                </div>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <p class="text-center border-none w-full h-full">0.0022</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">設備割合</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <div class="w-2/6 flex items-center">
                                                                    <input type="number" id="" name="" value="" class="text-right border-none w-full bg-sky-50">
                                                                </div>
                                                                <div class="w-4/6 flex items-center border-l border-gray-300">
                                                                    <p class="text-right border-none w-4/6">30,000,000</p>
                                                                    <span class="w-2/6 block text-left ml-1">円</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 減価償却ここまで ~~~~~~~~~~~ --}}
                                    </div>
                                    <div class="w-1/3">
                                        {{-- ~~~~~~~~~~~ 自己資金 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'自己資金'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入額','id'=>'','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'返済額','id'=>'','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'自己資金','id'=>'','unit'=>'円'])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">返済方法</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="" id="" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    <option value="">元利均等</option>
                                                                    <option value="">元金均等</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'総事業合計','id'=>'','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入期間','id'=>'','unit'=>'年',"right"=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'据置期間','id'=>'','unit'=>'ヶ月',"right"=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入金利','id'=>'','unit'=>'%',"right"=>0])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 自己資金ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 借入金利変動（元利均等のみ） ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'借入金利変動（元利均等のみ）'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'当初3年','id'=>'','unit'=>'%'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'4~5年','id'=>'','unit'=>'%'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'5~10年','id'=>'','unit'=>'%'])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 借入金利変動（元利均等のみ）ここまで ~~~~~~~~~~~ --}}
                                    </div>

                                </div>
                            {{--■■■■■■■■■■■■■■■■ 基礎情報ここまで ■■■■■■■■■■■■■■■■■■--}}
                            <button type="submit" class="fixed bottom-20 right-20 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保存する</button>
                        {{---------------------- form内容ここまで ----------------------------------------------------------}}
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

        $('.add_button_room_plan').on('click',function(){
            let number = Number($('#count_room_plan').val()) + 1
            const items = JSON.parse('<?php echo $js_layouts; ?>');
            let options = "";
            items.forEach(element => {
                options += `<option value="${element["name"]}">${element["name"]}</option>`
            });
            const insert =
                `<div class="flex items-center h-full">
                    <div class="w-3/5 h-full border-r border-gray-300">
                        <select name="room_plan_${number}" id="" class="border-none w-full bg-sky-50">
                            <option value="">選択して下さい</option>
                            ${options}
                        </select>
                    </div>
                    <div class="w-2/5 h-full flex items-center">
                        <input type="number" name="room_count_${number}" class="border-none  w-9/12 text-right bg-sky-50">
                        <span class="block pl-1 w-3/12 text-left">戸</span>
                    </div>
                </div>`;
            $('.add_room_plan').append(insert);
            $('#count_room_plan').val(number)
        })

        $('.add_button_parking_plan').on('click',function(){
            let number = Number($('#count_parking_plan').val()) + 1
            const items = JSON.parse('<?php echo $js_parking_item_list; ?>');
            let options = "";
            items.forEach(element => {
                options += `<option value="${element}">${element}</option>`
            });
            const insert =
                `<div class="flex items-center h-full">
                    <div class="w-5/12 h-full border-r border-gray-300">
                        <select name="parking_plan_${number}" id="" class="border-none w-full bg-sky-50">
                            <option value="">選択</option>
                            ${options}
                        </select>
                    </div>
                    <div class="w-3/12 h-full flex items-center">
                        <input type="number" name="parking_count_${number}" class="text-right w-9/12 border-none bg-sky-50">
                        <span class="block ml-1 w-3/12 text-left text-xs">台分</span>
                    </div>
                    <div class="w-4/12 h-full flex items-center">
                        <input type="number" name="parking_fee_${number}" class="text-right w-9/12 border-none bg-sky-50">
                        <span class="block ml-1 w-3/12 text-left text-xs">円</span>
                    </div>
                </div>`;
            $('.add_parking_plan').append(insert);
            $('#count_parking_plan').val(number)
        })




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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @include("project.parts.koteisisan")
@php
    $prop_syoukyaku = 0;
    $equip_syoukyaku = 0;
    if($project->building_depreciation_kind == "定額法"){
        $prop_syoukyaku = teigaku()[$project->building_depreciation_year - 2];
    }else{
        $prop_syoukyaku = teiritu()[$project->building_depreciation_year - 3];
    }
    if($project->equipment_depreciation_kind == "定額法"){
        $equip_syoukyaku = teigaku()[$project->equipment_depreciation_year - 2];
    }else{
        $equip_syoukyaku = teiritu()[$project->equipment_depreciation_year - 3];
    }
@endphp
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
            <div class="flex justify-end">
                <form action="{{ route('projectCopy') }}" method="POST" class=" mb-2 text-center w-1/12 bg-cyan-600 hover:bg-cyan-700 rounded py-2 text-white ml-3">
                    {{ csrf_field() }}
                    <input type="hidden" name="copy_project_id" value={{$project->id}}>
                    <input type="hidden" name="copy_property_id" value={{$project->property_id}}>
                    <button type="submit" class=" block w-full h-full">複製する</button>
                </form>
                <form action="{{route('projectDelete',['id'=>$project->id])}}" method="POST" class=" mb-2 text-center w-1/12 bg-white hover:bg-gray-200 rounded py-2 text-gray-500 ml-3 border border-gray-500">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class=" block w-full h-full">削除</button>
                </form>
            </div>
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
                                                @include('parts.project.bukken.col_1_input',['title'=>'物件番号','id'=>'project_type'])
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
                                                @include('parts.project.bukken.col_1_input',['title'=>'事業開始日','id'=>'project_start_date','type'=>'date'])
                                                @include('parts.project.bukken.col_1_input',['title'=>'銀行返済開始日','id'=>'return_debt_date','type'=>'date'])
                                            </tbody>
                                        </table>
                                        <div class="flex items-start">
                                            {{-- <a class="project_button bg-cyan-600 hover:bg-cyan-700" href="{{route('projectPlan',['id'=>$project->id])}}">収支</a> --}}
                                            <a class="project_button bg-cyan-600 hover:bg-cyan-700" href="{{route('projectPdf',['id'=>$project->id])}}" target="_blank">PDF</a>
                                            <a class="project_button bg-cyan-600 hover:bg-cyan-700" href="{{ route('propertyDetail', ['id' => $project->property->id]) }}">物件概要編集</a>



                                        </div>
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
                                                    <tr  class="w-full">
                                                        <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">種類</th>
                                                        <td class="w-4/5 border">
                                                            <div class="w-full h-full border-r border-gray-300">
                                                                <select name="plan_kind" id="plan_kind" class="border-none w-full bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @foreach ($cr_plans as $item)
                                                                        @php
                                                                            $selected = "";
                                                                            if($item->name == $project->plan_kind){
                                                                                $selected = "selected";
                                                                            }
                                                                        @endphp
                                                                        <option value="{{$item->name}}" {{$selected}}>{{$item->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
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
                                                                        $room_plan_name = "room_plan_cat_".$plan_num;
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
                                                                @include('parts.project.gaiyou.col_2',['name1'=>'room_plan_cat_0','val1'=>'','name2'=>'room_count_0','val2'=>'','unit'=>'戸'])
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
                                                        $floor_total_tenant_num = 0;
                                                        $floor_total_tenant_area = 0;
                                                        $floor_total_house_num = 0;
                                                        $floor_total_house_area = 0;
                                                        $floor_total_num = 0;
                                                        $floor_total_area = 0;
                                                        $each_floor_total_num = [];
                                                        $yield_tax = 0;
                                                        $yield = 0;
                                                        $price_prop_tax =round($project->price_prop *0.1);
                                                        $price_prop_total = $project->price_prop + $price_prop_tax;
                                                        $total_price = $project->price_prop + $project->price_land;
                                                        function total_fee($array,$val,$type= "room"){
                                                            $cost = 0;
                                                            foreach ($array as $fee) {
                                                                if($type == "room"){
                                                                    $cost += $fee->$val;
                                                                }else if($type == "park"){
                                                                    $park = $fee->$val;
                                                                    $cost += $park * $fee->count;
                                                                }
                                                            }
                                                            return $cost;
                                                        }
                                                        $total_fee_rent = total_fee($project->rooms,"room_rent");
                                                        $total_fee_kanri = total_fee($project->rooms,"room_common");
                                                        $total_fee_other = 0;
                                                        $total_fee_parking = total_fee($project->parkings,"fee","park");
                                                        $total_fee_all = $total_fee_rent + $total_fee_kanri + $total_fee_other + $total_fee_parking;

                                                        $plan_totla_price =$total_price;
                                                        $plan_totla_price_tax = $total_price+$price_prop_tax;

                                                        $jigyou_total_area_fee = 0;
                                                        $jigyou_total_area_fee_tax = 0;
                                                        $jigyou_total_area_fee +=$project->jigyuo_area_cost;
                                                        $jigyou_total_area_fee +=$project->jigyuo_brokerage_fee;
                                                        $jigyou_total_area_fee +=$project->jigyuo_syoukai_fee;
                                                        $jigyou_total_area_fee +=$project->jigyuo_neteitou;
                                                        $jigyou_total_area_fee +=$project->jigyuo_tourokumenkyo;
                                                        $jigyou_total_area_fee +=$project->jigyuo_fudousansyutoku;
                                                        $jigyou_total_area_fee +=$project->jigyuo_sihousyosi;
                                                        $jigyou_total_area_fee +=$project->jigyuo_ginkou_fee;
                                                        $jigyou_total_area_fee +=$project->jigyuo_risoku_fee;
                                                        $jigyou_total_area_fee +=$project->jigyuo_koteisisan;
                                                        $jigyou_total_area_fee +=$project->jigyuo_kaitai_fee;
                                                        $jigyou_total_area_fee +=$project->jigyuo_tatinoki;
                                                        if (count($project->bikous_kind("area",$project->id))>0){
                                                            foreach ($project->bikous_kind("area",$project->id) as $bikou){
                                                                $jigyou_total_area_fee +=$bikou->fee;
                                                                $jigyou_total_area_fee_tax += round($bikou->fee*0.1);
                                                            }
                                                        }
                                                        $jigyou_total_area_fee_tax += round($project->jigyuo_brokerage_fee*0.1);
                                                        $jigyou_total_area_fee_tax += round($project->jigyuo_sihousyosi*0.1);
                                                        $jigyou_total_area_fee_tax += round($project->jigyuo_kaitai_fee*0.1);
                                                        $jigyou_total_area_fee_tax += $jigyou_total_area_fee-$project->jigyuo_ginkou_fee;

                                                        $jigyou_total_prop_fee = 0;
                                                        $jigyou_total_prop_fee_tax = 0;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_kentiku_fee;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_kui;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_sekkeikanri;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_net;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_jio;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_gas * $floor_total_num;
                                                        $jigyou_total_prop_fee +=$project->jigyuo_ad * $floor_total_num;
                                                        if (count($project->bikous_kind("prop",$project->id))>0){
                                                            foreach ($project->bikous_kind("prop",$project->id) as $bikou){
                                                                $jigyou_total_prop_fee +=$bikou->fee;
                                                                $jigyou_total_prop_fee_tax += round($bikou->fee*0.1);
                                                            }
                                                        }
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_kentiku_fee*0.1);
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_kui*0.1);
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_sekkeikanri*0.1);
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_net*0.1);
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_gas * $floor_total_num*0.1);
                                                        $jigyou_total_prop_fee_tax += round($project->jigyuo_ad * $floor_total_num*0.1);
                                                        $jigyou_total_prop_fee_tax += $jigyou_total_prop_fee;

                                                        $total_genka = $jigyou_total_prop_fee + $jigyou_total_area_fee;
                                                        $arari = $plan_totla_price-$total_genka;
                                                        $arari_ratio = 0;
                                                        $rimawari = 0;
                                                        $rimawari_tax = 0;
                                                        if($total_price > 0){
                                                            $arari_ratio = $arari/$plan_totla_price *100;
                                                            $rimawari=($total_fee_all * 12)/$total_price *100;
                                                            $rimawari_tax = ($total_fee_all * 12)/$plan_totla_price_tax *100;
                                                        }
                                                    @endphp
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地','id'=>'price_land','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物','id'=>'price_prop','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'(内消費税)','id'=>'price_prop_tax','val'=>number_format($price_prop_tax),'unit'=>'円','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'税込み','id'=>'price_prop_total','val'=>number_format($price_prop_total),'unit'=>'円','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_rent',['title'=>'合計','id'=>'total_price','val'=>number_format($total_price),'unit'=>'円'])
                                                </tbody>
                                            </table>
                                            @include('parts.project.h3',['title'=>'利回り'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.rent_plan.price',['head'=>"税抜",'price'=>round($rimawari, 2)])
                                                    @include('parts.project.rent_plan.price',['head'=>"税込み",'price'=>round($rimawari_tax, 2)])
                                            </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 販売価格ここまで ~~~~~~~~~~~ --}}
                                </div>
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ 間取り ~~~~~~~~~~~ --}}
                                        <div class="w-1/2 mr-8">
                                            @include('parts.project.h3',['title'=>'間取り'])
                                            @php

                                            @endphp
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


                                                        @if(count($project->floors)>0)
                                                            @foreach ($project->floors as $floor)
                                                                @php
                                                                    $num = "";
                                                                    if($floor->floor == 0){
                                                                        $num = "地下";
                                                                    }else{
                                                                        $num = $floor->floor."階";
                                                                    }
                                                                    $floor_total_tenant_num += $floor->tenant_num;
                                                                    $floor_total_tenant_area += $floor->tenant_area;
                                                                    $floor_total_house_num += $floor->house_num;
                                                                    $floor_total_house_area += $floor->house_area;
                                                                    $floor_total_num += $floor->tenant_num + $floor->house_num;
                                                                    $floor_total_area += $floor->tenant_area + $floor->house_area;
                                                                    array_push($each_floor_total_num,$floor->tenant_num+$floor->house_num)
                                                                @endphp
                                                                @include('parts.project.plan.plan',["head"=>$num,"count"=>$floor->floor,"val"=>$floor])
                                                            @endforeach
                                                        @else
                                                            @for ($i = 0;$i<=$project->floor;$i++)
                                                                @php
                                                                    $num = "";
                                                                    if($i == 0){
                                                                        $num = "地下";
                                                                    }else{
                                                                        $num = $i."階";
                                                                    }
                                                                @endphp
                                                                @include('parts.project.plan.plan',["head"=>$num,"count"=>$i])
                                                            @endfor
                                                        @endif
                                                        <tr class="w-full">
                                                            <th class="px-2 py-1 border font-normal bg-gray-100">合計</th>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <p class="w-full text-center">{{number_format($floor_total_tenant_num)}}</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <p class="w-full text-center">{{number_format(round($floor_total_tenant_area,2),2)}}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <p class="w-full text-center">{{number_format($floor_total_house_num)}}</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <p class="w-full text-center">{{number_format(round($floor_total_house_area,2),2)}}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border">
                                                                <div class="flex">
                                                                    <div class="w-1/4 border-r border-gray-300">
                                                                        <input type="hidden" name="floor_total_num" id="floor_total_num" value={{$floor_total_num}}>
                                                                        <p class="w-full text-center">{{number_format($floor_total_num)}}</p>
                                                                    </div>
                                                                    <div class="w-3/4">
                                                                        <input type="hidden" name="floor_total_area" id="floor_total_area" value={{$floor_total_area}}>
                                                                        <p class="w-full text-center">{{number_format(round($floor_total_area,2),2)}}</p>
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
                                        <div class="check_rent text-xs">
                                            @if (count($project->rooms)>0)
                                            <div class="flex items-center justify-center">
                                                <p class="mr-5"><input type="number" id="new_rent_num" name="new_rent_num" class="text-right border-none text-xs" value="{{$floor_total_num}}" disabled>部屋</p>
                                                <p id="new_rent_button" class="rounded-md bg-gray-200 hover:bg-gray-400 py-2 px-3 cursor-pointer">家賃表を再度作成する</p>
                                            </div>
                                                <table class="table-fixed w-full text-xs mb-3">
                                                    @include('parts.project.rent_plan.head')
                                                    <tbody id="insert_table_rent">
                                                        {{-- <tr>
                                                            <td class="border"><input type="number" name="" value="" class="w-full text-center border-none h-full bg-sky-50"></td>
                                                            <td class="border">
                                                                <select name="" id="" class="border-none w-full bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @foreach ($layouts as $item)
                                                                        @php
                                                                            $selected = "";
                                                                            // if($item->name == $check){
                                                                            //     $selected = "selected";
                                                                            // }
                                                                        @endphp
                                                                        <option value="{{$item->name}}" {{$selected}}>{{$item->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="border"><input type="number" name="" value="" class="w-full text-center border-none h-full bg-sky-50"></td>
                                                            <td class="border"><input type="number" name="" value="" class="w-full text-center border-none h-full bg-sky-50"></td>
                                                            <td class="border"><input type="number" name="" value="" class="w-full text-center border-none h-full bg-sky-50"></td>
                                                        </tr> --}}
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
                                                <input type="hidden" name="rent_rooms_count" id="rent_rooms_count" value="{{$floor_total_num}}">
                                            @else
                                                @if ($floor_total_num == 0)
                                                    <div>
                                                        <p class="bg-blue">先に間取りを入力して保存を押してください</p>
                                                    </div>
                                                @else
                                                    <div id="">
                                                        <div class="flex items-center justify-center">
                                                            <p class="mr-5"><input type="number" id="new_rent_num" name="new_rent_num" class="text-right border-none text-xs" value="{{$floor_total_num}}" disabled>部屋</p>
                                                            <p id="new_rent_button" class="rounded-md bg-gray-200 hover:bg-gray-400 py-2 px-3 cursor-pointer">家賃表を作成する</p>
                                                        </div>
                                                    </div>
                                                    <table class="table-fixed w-full text-xs mb-3">
                                                        @include('parts.project.rent_plan.head')
                                                        <tbody id="insert_table_rent">
                                                        </tbody>
                                                    </table>
                                                    <input type="hidden" name="rent_rooms_count" id="rent_rooms_count" value="{{$floor_total_num}}">
                                                @endif
                                            @endif
                                        </div>

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
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地所有権移転登記','id'=>'land_ownership_transfer','unit'=>'円','calc'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物所有権移転登記','id'=>'prop_ownership_transfer','unit'=>'円','calc'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'抵当権設定費用','id'=>'mortgage_setting_costs','unit'=>'円','calc'=>0])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 登録免許税ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 不動産取得税 ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'不動産取得税'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'土地不動産取得税','id'=>'estate_tax_area','unit'=>'円','calc'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'建物不動産取得税','id'=>'estate_tax_prop','unit'=>'円','calc'=>1])
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
                                                                <select name="estate_tax_shintiku" id="estate_tax_shintiku" class="border-none w-3/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @php
                                                                        $estate_tax_shintiku_0 = "";
                                                                        $estate_tax_shintiku_1 = "";
                                                                        if($project->estate_tax_shintiku == "特例あり"){
                                                                            $estate_tax_shintiku_0 = "selected";
                                                                        }else if($project->estate_tax_shintiku == "特例なし"){
                                                                            $estate_tax_shintiku_1 = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="特例あり" {{$estate_tax_shintiku_0}}>特例あり</option>
                                                                    <option value="特例なし" {{$estate_tax_shintiku_1}}>特例なし</option>
                                                                </select>
                                                                <div class="w-3/6 block text-left ml-1 flex items-center text-xs">
                                                                    <p class="w-3/12">新築後</p>
                                                                    <select name="estate_tax_shintiku_year" id="estate_tax_shintiku_year" class="w-7/12 border-none bg-sky-50">
                                                                        <option value="">-</option>
                                                                        @php
                                                                            $estate_tax_shintiku_year_0 = "";
                                                                            $estate_tax_shintiku_year_1 = "";
                                                                            if($project->estate_tax_shintiku_year == "3"){
                                                                                $estate_tax_shintiku_year_0 = "selected";
                                                                            }else if($project->estate_tax_shintiku_year == "5"){
                                                                                $estate_tax_shintiku_year_1 = "selected";
                                                                            }
                                                                        @endphp
                                                                        <option value="3" {{$estate_tax_shintiku_year_0}}>3</option>
                                                                        <option value="5" {{$estate_tax_shintiku_year_1}}>5</option>
                                                                    </select>
                                                                    <p class="w-2/12">年間</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.tax',['title'=>'固定資産税','id'=>'property_tax'])
                                                    @include('parts.project.tax',['title'=>'都市計画税','id'=>'city_planning_tax'])
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
                                                        <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                            <div class="flex items-center">
                                                                <p class="w-2/3">その他雑費</p>
                                                                <div class="w-1/3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="add_button_other_fee cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="w-4/5 border add_other_fee">
                                                            @php
                                                                $other_num = 0;
                                                            @endphp
                                                            @if (count($project->others)>0)
                                                                @foreach ($project->others as $other)
                                                                    @php
                                                                        $other_cycle_name = "other_cycle_".$other_num;
                                                                        $other_name_name = "other_name_".$other_num;
                                                                        $other_fee_name = "other_fee_".$other_num;
                                                                    @endphp
                                                                    @include('parts.project.gaiyou.col_3_other',['name1'=>$other_cycle_name,'val1'=>$other->cycle,'name2'=>$other_name_name,'val2'=>$other->name,'name3'=>$other_fee_name,'val3'=>$other->fee])
                                                                    @php
                                                                        $other_num += 1;
                                                                    @endphp
                                                                @endforeach
                                                                @php
                                                                    $other_num -= 1;
                                                                @endphp
                                                            @else
                                                                @include('parts.project.gaiyou.col_3_other',['name1'=>'other_cycle_0','val1'=>'','name2'=>'other_name_0','val2'=>'','name3'=>'other_fee_0','val3'=>''])
                                                            @endif
                                                            <input type="hidden" value="{{$other_num}}" name="count_other_fee" id="count_other_fee">
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col2_total',['title'=>'管理手数料（戸）','id'=>'management_fee'])
                                                    @include('parts.project.gaiyou.col2_total',['title'=>'インターネット使用料','id'=>'internet_fee'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'共用電気料','id'=>'common_electricity','unit'=>'円/月'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'定期清掃料','id'=>'cleaning_fee','unit'=>'円/月'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'振込手数料','id'=>'transfer_fee','unit'=>'円/月'])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">住宅保険</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="housing_insurance_case" id="housing_insurance_case" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @php
                                                                        $housing_insurance_case_0 = "";
                                                                        $housing_insurance_case_1 = "";
                                                                        if($project->housing_insurance_case == "普通"){
                                                                            $housing_insurance_case_0 = "selected";
                                                                        }else if($project->housing_insurance_case == "総合"){
                                                                            $housing_insurance_case_1 = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="普通" {{$housing_insurance_case_0}}>普通</option>
                                                                    <option value="総合" {{$housing_insurance_case_1}}>総合</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'住宅保険期間','id'=>'housing_insurance_year','unit'=>'年','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'住宅火災保険','id'=>'housing_insurance_cost','unit'=>'円','right'=>0])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">地震保険</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="earthquake_insurance_case" id="earthquake_insurance_case" class="border-none w-4/6 bg-sky-50">
                                                                    <option value="">選択して下さい</option>
                                                                    @php
                                                                        $earthquake_insurance_case_0 = "";
                                                                        $earthquake_insurance_case_1 = "";
                                                                        if($project->earthquake_insurance_case == "入る"){
                                                                            $earthquake_insurance_case_0 = "selected";
                                                                        }else if($project->earthquake_insurance_case == "入らない"){
                                                                            $earthquake_insurance_case_1 = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="入る"  {{$earthquake_insurance_case_0}}>入る</option>
                                                                    <option value="入らない"  {{$earthquake_insurance_case_1}}>入らない</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'地震保険期間','id'=>'earthquake_insurance_year','unit'=>'年','right'=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'地震保険','id'=>'earthquake_insurance_cost','unit'=>'円','right'=>0])
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
                                                                <select name="building_depreciation_kind" id="building_depreciation_kind" class="border-none w-1/3 bg-sky-50">
                                                                    @php
                                                                        $teigaku = "selected";
                                                                        $teiritu = "";
                                                                        if($project->building_depreciation_kind =="定率法"){
                                                                            $teigaku = "";
                                                                            $teiritu = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="定率法" {{$teiritu}}>定率法</option>
                                                                    <option value="定額法" {{$teigaku}}>定額法</option>
                                                                </select>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <input type="number" id="building_depreciation_year" name="building_depreciation_year" value="{{$project->building_depreciation_year}}" class="text-right w-full border-none bg-sky-50">
                                                                </div>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <p class="text-center border-none w-full h-full">{{$prop_syoukyaku}}</p>
                                                                    <input type="hidden" name="building_depreciation_ratio" value={{$prop_syoukyaku}}>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">設備原価償却</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="equipment_depreciation_kind" id="equipment_depreciation_kind" class="border-none w-1/3 bg-sky-50">
                                                                    @php
                                                                        $teigaku = "selected";
                                                                        $teiritu = "";
                                                                        if($project->equipment_depreciation_kind =="定率法"){
                                                                            $teigaku = "";
                                                                            $teiritu = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="定率法" {{$teiritu}}>定率法</option>
                                                                    <option value="定額法" {{$teigaku}}>定額法</option>
                                                                </select>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <input type="number" id="equipment_depreciation_year" name="equipment_depreciation_year" value="{{$project->equipment_depreciation_year}}" class="text-right w-full border-none bg-sky-50">
                                                                </div>
                                                                <div class="w-1/3 flex items-center border-l border-gray-300">
                                                                    <p class="text-center border-none w-full h-full">{{$equip_syoukyaku}}</p>
                                                                    <input type="hidden" name="equipment_depreciation_ratio" value={{$equip_syoukyaku}}>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">設備割合</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <div class="w-2/6 flex items-center">
                                                                    <input type="number" id="equipment_ratio" name="equipment_ratio" value="{{$project->equipment_ratio}}" class="text-right border-none w-full bg-sky-50">
                                                                </div>
                                                                <div class="w-4/6 flex items-center border-l border-gray-300">
                                                                    <p class="text-right border-none w-4/6">{{number_format(round($project->equipment_ratio/100 * $project->price_prop *1.1)) }}</p>
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
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入額','id'=>'debt','unit'=>'円'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'返済額','id'=>'monthly_repayment_amount','unit'=>'円','type'=>"disabled"])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'自己資金','id'=>'own_resources','unit'=>'円','type'=>"disabled"])
                                                    <tr class="w-full">
                                                        <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">返済方法</th>
                                                        <td class="w-2/3 border">
                                                            <div class="flex items-center">
                                                                <select name="repayment_method" id="repayment_method" class="border-none w-4/6 bg-sky-50">
                                                                    @php
                                                                        $ganri = "selected";
                                                                        $gankin = "";
                                                                        if($project->repayment_method =="元金均等"){
                                                                            $ganri = "";
                                                                            $gankin = "selected";
                                                                        }
                                                                    @endphp
                                                                    <option value="元利均等" {{$ganri}}>元利均等</option>
                                                                    <option value="元金均等" {{$gankin}}>元金均等</option>
                                                                </select>
                                                                <span class="w-2/6 block text-left ml-1"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'総事業合計','id'=>'total_expenses','unit'=>'円','type'=>"disabled"])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入期間','id'=>'borrowing_period','unit'=>'年',"right"=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'据置期間','id'=>'deferred_period','unit'=>'ヶ月',"right"=>0])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'借入金利','id'=>'interest_rate','unit'=>'%',"right"=>0])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 自己資金ここまで ~~~~~~~~~~~ --}}
                                        {{-- ~~~~~~~~~~~ 借入金利変動（元利均等のみ） ~~~~~~~~~~~ --}}
                                            @include('parts.project.h3',['title'=>'借入金利変動（元利均等のみ）'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'当初3年','id'=>'ganri_3','unit'=>'%'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'4~5年','id'=>'ganri_5','unit'=>'%'])
                                                    @include('parts.project.gaiyou.col_1_input',['title'=>'5~10年','id'=>'ganri_10','unit'=>'%'])
                                                </tbody>
                                            </table>
                                        {{-- ~~~~~~~~~~~ 借入金利変動（元利均等のみ）ここまで ~~~~~~~~~~~ --}}
                                    </div>

                                </div>
                            {{--■■■■■■■■■■■■■■■■ 基礎情報ここまで ■■■■■■■■■■■■■■■■■■--}}
                            {{--■■■■■■■■■■■■■■■■ 事業計画 ■■■■■■■■■■■■■■■■■■--}}
                                @include('parts.project.h2',['title'=>'事業計画'])
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ 家賃 ~~~~~~~~~~~ --}}
                                        <div class="w-1/2 mr-8">
                                            @include('parts.project.h3',['title'=>'家賃'])
                                            <table class="table-fixed w-full mb-3">
                                                <thead class="w-full">
                                                    <th class="w-1/3 px-2 py-1 border font-normal bg-gray-100"></th>
                                                    <th class="w-1/3 px-2 py-1 border font-normal bg-gray-100">月収入</th>
                                                    <th class="w-1/3 px-2 py-1 border font-normal bg-gray-100">年収</th>
                                                </thead>
                                                <tbody class="w-full">
                                                    @php
                                                    @endphp
                                                    @include('parts.project.rent_plan.rent',['head'=>"家賃",'month'=>$total_fee_rent])
                                                    @include('parts.project.rent_plan.rent',['head'=>"管理費",'month'=>$total_fee_kanri])
                                                    @include('parts.project.rent_plan.rent',['head'=>"その他",'month'=>$total_fee_other])
                                                    @include('parts.project.rent_plan.rent',['head'=>"駐車場",'month'=>$total_fee_parking])
                                                    @include('parts.project.rent_plan.rent',['head'=>"合計",'month'=>$total_fee_all])
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 家賃ここまで ~~~~~~~~~~~ --}}
                                    {{-- ~~~~~~~~~~~ 販売価格 ~~~~~~~~~~~ --}}
                                        <div class="w-1/2">
                                            @include('parts.project.h3',['title'=>'販売価格'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.rent_plan.price',['head'=>"販売価格",'price'=>number_format($plan_totla_price)])
                                                    @include('parts.project.rent_plan.price',['head'=>"原価",'price'=>number_format($total_genka)])
                                                    @include('parts.project.rent_plan.price',['head'=>"粗利額",'price'=>number_format($arari)])
                                                    @include('parts.project.rent_plan.price',['head'=>"粗利率",'price'=>round($arari_ratio, 2)])
                                                </tbody>
                                            </table>
                                            @include('parts.project.h3',['title'=>'利回り'])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="">
                                                    @include('parts.project.rent_plan.price',['head'=>"税抜",'price'=>round($rimawari, 2)])
                                                    @include('parts.project.rent_plan.price',['head'=>"税込み",'price'=>round($rimawari_tax, 2)])
                                            </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 販売価格ここまで ~~~~~~~~~~~ --}}
                                </div>
                                <div class="flex mb-5">
                                    {{-- ~~~~~~~~~~~ その他 ~~~~~~~~~~~ --}}
                                        <div class="w-1/2 mr-8">
                                            @include('parts.project.h3',['title'=>''])
                                                <table class="table-fixed w-full mb-3">
                                                    <tbody class="w-full">
                                                        @include('parts.project.rent_plan.date',['head'=>"建築工期",'id'=>'structure'])
                                                        @include('parts.project.rent_plan.date',['head'=>"借入期間",'id'=>'debt'])
                                                        <tr class="w-full">
                                                            <th class="px-2 py-1 border font-normal bg-gray-100 w-1/3 text-left">土地関係</th>
                                                            <td class="border w-2/3">
                                                                <div class="flex items-center">
                                                                    <div class="flex items-center w-1/2">
                                                                        <p class="w-1/2 text-right">{{number_format($project->property->land_area)}}</p>
                                                                        <p class="w-1/2 ml-2">㎡</p>
                                                                    </div>
                                                                    <div class="flex items-center w-1/2">
                                                                        @php
                                                                            $tubo = 0;
                                                                            if($project->property->land_area >0){
                                                                                $tubo = round($project->property->land_area *0.3025,1);
                                                                            }
                                                                        @endphp
                                                                        <p class="w-1/2 text-right">{{$tubo}}</p>
                                                                        <p class="w-1/2 ml-2">坪</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">土地代金</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <div class="w-3/4 flex items-center">
                                                                        <input type="number" id="jigyuo_area_cost" name="jigyuo_area_cost" value="{{$project->jigyuo_area_cost}}" class="text-right border-none w-3/4 bg-sky-50">
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                    <div class="w-1/4 flex items-center">
                                                                        @php
                                                                            $tubo_p = 0;
                                                                            if($tubo >0){
                                                                                $tubo_p = number_format(round($project->jigyuo_area_cost/$tubo,2));
                                                                            }
                                                                        @endphp
                                                                        <span class="w-1/4 block text-left ml-1 text-xs">坪単価</span>
                                                                        <p class="text-right border-none w-2/4 text-sm">{{$tubo_p}}</p>
                                                                        <span class="w-1/4 block text-left ml-1 text-xs">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                        {{-- @include('parts.project.jigyou.col1',['title'=>'仲介料','id'=>'jigyuo_brokerage_fee','unit'=>'円','type'=>"税"]) --}}
                                                        @include('parts.project.gaiyou.col_1_input',['title'=>'仲介料','id'=>'jigyuo_brokerage_fee','unit'=>'円','calc'=>0,'tax'=>"税"])
                                                        @include('parts.project.jigyou.col1',['title'=>'紹介料','id'=>'jigyuo_syoukai_fee','unit'=>'円'])
                                                        @include('parts.project.gaiyou.col_1_input',['title'=>'根抵当権設定料','id'=>'jigyuo_neteitou','unit'=>'円','calc'=>0])
                                                        @include('parts.project.gaiyou.col_1_input',['title'=>'登録免許税','id'=>'jigyuo_tourokumenkyo','unit'=>'円','calc'=>0])
                                                        @include('parts.project.gaiyou.col_1_input',['title'=>'不動産取得税','id'=>'jigyuo_fudousansyutoku','unit'=>'円','calc'=>0])
                                                        @include('parts.project.jigyou.col1',['title'=>'司法書士報酬','id'=>'jigyuo_sihousyosi','unit'=>'円','type'=>"税"])
                                                        @include('parts.project.jigyou.col1',['title'=>'銀行手数料・印紙','id'=>'jigyuo_ginkou_fee','unit'=>'円'])
                                                        {{-- @include('parts.project.jigyou.col1',['title'=>'固定資産税等','id'=>'jigyuo_koteisisan','unit'=>'円']) --}}
                                                        @include('parts.project.gaiyou.col_1_input',['title'=>'固定資産税等','id'=>'jigyuo_koteisisan','unit'=>'円','calc'=>0])
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">支払い利息</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <select name="jigyuo_risoku" id="jigyuo_risoku" class="border-none bg-sky-50 w-1/3">
                                                                        <option value="">選択する</option>
                                                                        @foreach ($banks as $item)
                                                                            @php
                                                                                $selected = "";
                                                                                if($item->name == $project->jigyuo_risoku){
                                                                                    $selected = "selected";
                                                                                }
                                                                            @endphp
                                                                            <option value="{{$item->name}}" {{$selected}}>{{$item->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="w-1/3 flex items-center justify-center">
                                                                        @php
                                                                            $bank_ratio = 0;
                                                                            foreach($banks as $bank){
                                                                                if($bank->name == $project->jigyuo_risoku){
                                                                                    $bank_ratio = $bank->ratio;
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <p>{{$bank_ratio}}</p>
                                                                        <input type="hidden" name="bank_ratio" value={{$bank_ratio /100}}>
                                                                        <span>%</span>
                                                                    </div>
                                                                    <div class="w-1/3 flex items-center">
                                                                        <p class="text-right border-none w-3/4">{{number_format($project->jigyuo_risoku_fee)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @include('parts.project.jigyou.col1_kentiku',['title'=>'解体費用（坪）','id'=>'jigyuo_kaitai_fee_tubo','unit'=>'円'])
                                                        @include('parts.project.jigyou.col1_kentiku',['title'=>'解体費用','id'=>'jigyuo_kaitai_fee','unit'=>'円'])
                                                        @include('parts.project.jigyou.col1',['title'=>'立ち退き費用','id'=>'jigyuo_tatinoki','unit'=>'円'])
                                                        <tr class="w-full">
                                                            <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                                <div class="flex items-center">
                                                                    <p class="w-2/3">備考</p>
                                                                    <div class="w-1/3">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="add_button_bikou_area cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="w-2/3 border add_bikou_area">
                                                                @php
                                                                    $bikou_area_num = 0;
                                                                @endphp
                                                                @if (count($project->bikous_kind("area",$project->id))>0)
                                                                    @foreach ($project->bikous_kind("area",$project->id) as $bikou)
                                                                        @php
                                                                            $bikou_area_name_name = "bikou_area_name_".$bikou_area_num;
                                                                            $bikou_area_fee_name = "bikou_area_fee_".$bikou_area_num;
                                                                        @endphp
                                                                        @include('parts.project.jigyou.col_bikou',['name1'=>$bikou_area_name_name,'val1'=>$bikou->name,'name2'=>$bikou_area_fee_name,'val2'=>$bikou->fee])
                                                                        @php
                                                                            $bikou_area_num += 1;
                                                                        @endphp
                                                                    @endforeach
                                                                    @php
                                                                        $bikou_area_num -= 1;
                                                                    @endphp
                                                                @else
                                                                    @include('parts.project.jigyou.col_bikou',['name1'=>"bikou_area_name_0",'val1'=>"",'name2'=>"bikou_area_fee_0",'val2'=>0])
                                                                @endif
                                                                <input type="hidden" value="{{$bikou_area_num}}" name="count_bikou_area" id="count_bikou_area">
                                                            </td>
                                                        </tr>
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">土地費用合計</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <div class="w-3/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4">{{number_format($jigyou_total_area_fee)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                    <div class="w-1/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4 text-sm">{{number_format($jigyou_total_area_fee_tax)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1 text-xs">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table-fixed w-full mb-3">
                                                    <tbody class="w-full">
                                                        @include('parts.project.jigyou.col1',['title'=>'借入金','id'=>'jigyuo_debt','unit'=>'円'])
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">自己資金</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <div class="w-3/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4">{{number_format($jigyou_total_area_fee -$project->jigyuo_debt)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">土地費用合計</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <div class="w-3/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4">{{number_format($jigyou_total_area_fee)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                    <div class="w-1/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4 text-sm">{{number_format($jigyou_total_area_fee_tax)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1 text-xs">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    {{-- ~~~~~~~~~~~ 間取りここまで ~~~~~~~~~~~ --}}
                                    {{-- ~~~~~~~~~~~ 家賃 ~~~~~~~~~~~ --}}
                                    <div class="w-1/2">
                                        @include('parts.project.h3',['title'=>''])
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="w-full">
                                                    @include('parts.project.jigyou.col1_kentiku',['title'=>'建築本体費（坪）','id'=>'jigyuo_kentiku_fee_tubo','unit'=>'円'])
                                                    @include('parts.project.jigyou.col1_kentiku',['title'=>'建築本体費','id'=>'jigyuo_kentiku_fee','unit'=>'円'])
                                                    @include('parts.project.jigyou.col1',['title'=>'杭工事','id'=>'jigyuo_kui','unit'=>'円','type'=>"税"])
                                                    @include('parts.project.jigyou.col1',['title'=>'設計監理費用','id'=>'jigyuo_sekkeikanri','unit'=>'円','type'=>"税"])
                                                    @include('parts.project.jigyou.col2',['title'=>'ネット無料工事','id'=>'jigyuo_net','unit'=>'円','type'=>"税","kind"=>"棟","rooms"=>0])
                                                    @include('parts.project.jigyou.col2',['title'=>'JIO保険料','id'=>'jigyuo_jio','unit'=>'円',"kind"=>"棟","rooms"=>0])
                                                    @include('parts.project.jigyou.col2',['title'=>'都市ガス','id'=>'jigyuo_gas','unit'=>'円','type'=>"税","kind"=>"戸","rooms"=>$floor_total_num])
                                                    @include('parts.project.jigyou.col2',['title'=>'広告料','id'=>'jigyuo_ad','unit'=>'円','type'=>"税","kind"=>"戸","rooms"=>$floor_total_num])
                                                    <tr class="w-full">
                                                        <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">
                                                            <div class="flex items-center">
                                                                <p class="w-2/3">備考</p>
                                                                <div class="w-1/3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="add_button_bikou_prop cursor-pointer h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="w-2/3 border add_bikou_prop">
                                                            @php
                                                                $bikou_prop_num = 0;
                                                            @endphp
                                                            @if (count($project->bikous_kind("prop",$project->id))>0)
                                                                @foreach ($project->bikous_kind("prop",$project->id) as $bikou)
                                                                    @php
                                                                        $bikou_prop_name_name = "bikou_prop_name_".$bikou_prop_num;
                                                                        $bikou_prop_fee_name = "bikou_prop_fee_".$bikou_prop_num;
                                                                    @endphp
                                                                    @include('parts.project.jigyou.col_bikou',['name1'=>$bikou_prop_name_name,'val1'=>$bikou->name,'name2'=>$bikou_prop_fee_name,'val2'=>$bikou->fee])
                                                                    @php
                                                                        $bikou_prop_num += 1;
                                                                    @endphp
                                                                @endforeach
                                                                @php
                                                                    $bikou_prop_num -= 1;
                                                                @endphp
                                                            @else
                                                                @include('parts.project.jigyou.col_bikou',['name1'=>"bikou_prop_name_0",'val1'=>"",'name2'=>"bikou_prop_fee_0",'val2'=>0])
                                                            @endif
                                                            <input type="hidden" value="{{$bikou_prop_num}}" name="count_bikou_prop" id="count_bikou_prop">
                                                        </td>
                                                    </tr>
                                                        <tr class="w-full">
                                                            <th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">建築費用合計</th>
                                                            <td class="w-2/3 border">
                                                                <div class="flex items-center">
                                                                    <div class="w-3/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4">{{number_format($jigyou_total_prop_fee)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1">円</span>
                                                                    </div>
                                                                    <div class="w-1/4 flex items-center">
                                                                        <p class="text-right border-none w-3/4 text-sm">{{number_format($jigyou_total_prop_fee_tax)}}</p>
                                                                        <span class="w-1/4 block text-left ml-1 text-xs">円</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                            <table class="table-fixed w-full mb-3">
                                                <tbody class="w-full">
                                                </tbody>
                                            </table>
                                    </div>
                                {{-- ~~~~~~~~~~~ 家賃ここまで ~~~~~~~~~~~ --}}
                                </div>
                            {{--■■■■■■■■■■■■■■■■ 事業計画ここまで ■■■■■■■■■■■■■■■■■■--}}

                            <input type="hidden" name="scroll_top" value=1000 class="st">
                            <button type="submit" id="submit_btn" class="fixed bottom-20 right-20 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保存する</button>
                        {{---------------------- form内容ここまで ----------------------------------------------------------}}
                    </form>

                </div>
            </div>
        </div>
    </div>
    @php
        $scroll_top = session()->get('scroll_top');
    @endphp
    <script>
        const input_numbers = document.querySelectorAll('input[type="number"]');
        for(i = 0;i<input_numbers.length;i++){

            input_numbers[i].classList.add("input_type_number")
            // input_numbers[i].dataset.type = 'number';
            input_numbers[i].setAttribute("type","text")
            input_numbers[i].value = Number(input_numbers[i].value).toLocaleString()
        }
        $('body').on('blur','.input_type_number',function(){
            let val = $(this).val()
            val = val.replace(/[^0-9.]/g, '')
            val = Number(val).toLocaleString()
            $(this).val(val)
        })
        $('body').on('click','.input_type_number',function(){
            let val = $(this).val()
            val = val.replace(/[^0-9.]/g, '')
            $(this).val(val)
        })
        $('#submit_btn').on('click',function(){
            for(i = 0;i<input_numbers.length;i++){
                let val = input_numbers[i].value
                val = val.replace(/[^0-9.]/g, '')
                input_numbers[i].value =val
            }
        })

        $('form').submit(function(){
            var scroll_top = $(window).scrollTop();  //送信時の位置情報を取得
            $('input.st',this).prop('value',scroll_top);  //隠しフィールドに位置情報を設定
        });
        $(document).ready(function(){
            $(this).scrollTop(JSON.parse('<?php echo $scroll_top; ?>'));
        });

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
                        <select name="room_plan_cat_${number}" id="" class="border-none w-full bg-sky-50">
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
        $('.add_button_other_fee').on('click',function(){
            let number = Number($('#count_other_fee').val()) + 1
            // const items = JSON.parse('<?php echo $js_parking_item_list; ?>');
            // let options = "";
            // items.forEach(element => {
            //     options += `<option value="${element}">${element}</option>`
            // });
            const insert =
                `<div class="flex items-center h-full">
                    <div class="w-5/12 h-full border-r border-gray-300">
                        <select name="other_cycle_${number}" id="" class="border-none w-full bg-sky-50">
                            <option value="1回限り">1回限り</option>
                            <option value="毎年">毎年</option>
                        </select>
                    </div>
                    <div class="w-3/12 h-full flex items-center border-r border-gray-300">
                        <input type="text" name="other_name_${number}" class="w-full border-none bg-sky-50" placeholder="名称">
                    </div>
                    <div class="w-4/12 h-full flex items-center">
                        <input type="number" name="other_fee_${number}" class="text-right w-9/12 border-none bg-sky-50">
                        <span class="block ml-1 w-3/12 text-left text-xs">円</span>
                    </div>
                </div>`;
            $('.add_other_fee').append(insert);
            $('#count_other_fee').val(number)
        })
        $('.add_button_bikou_area').on('click',function(){
            let number = Number($('#count_bikou_area').val()) + 1
            const insert =
                `<div class="flex items-center">
                    <div class="w-5/12">
                        <input type="text" id="" name="bikou_area_name_${number}" class="text-left border-none bg-sky-50">
                    </div>
                    <div class="w-5/12 flex items-center">
                        <input type="number" id="" name="bikou_area_fee_${number}" value=0 class="text-right border-none w-3/4 bg-sky-50">
                        <span class="w-1/4 block text-left ml-1">円</span>
                    </div>
                    <div class="w-2/12 flex items-center">
                        <p class="text-right border-none w-3/4">0</p>
                        <span class="w-1/4 block text-left ml-1">円</span>
                    </div>
                </div>`;
            $('.add_bikou_area').append(insert);
            $('#count_bikou_area').val(number)
        })
        $('.add_button_bikou_prop').on('click',function(){
            let number = Number($('#count_bikou_prop').val()) + 1
            const insert =
                `<div class="flex items-center">
                    <div class="w-5/12">
                        <input type="text" id="" name="bikou_prop_name_${number}" class="text-left border-none bg-sky-50">
                    </div>
                    <div class="w-5/12 flex items-center">
                        <input type="number" id="" name="bikou_prop_fee_${number}" value=0 class="text-right border-none w-3/4 bg-sky-50">
                        <span class="w-1/4 block text-left ml-1">円</span>
                    </div>
                    <div class="w-2/12 flex items-center">
                        <p class="text-right border-none w-3/4">0</p>
                        <span class="w-1/4 block text-left ml-1">円</span>
                    </div>
                </div>`;
            $('.add_bikou_prop').append(insert);
            $('#count_bikou_prop').val(number)
        })



        $('#new_rent_button').on('click',function(){
            function body_num(name,val,type="number"){
                let body = ""
                if(type == "select"){
                    body =`<td class="border">
                                <select name="${name}" id="${name}" class="border-none w-full bg-sky-50">
                                    <option value="">選択する</option>`
                    for(let i=0;i<@json($layouts).length;i++){
                        body +=`<option value="${@json($layouts)[i]["name"]}">${@json($layouts)[i]["name"]}</option>`
                    }
                    body +=`</select>
                            </td>`
                }else{
                    body = `<td class="border"><input type="number" step="0.01" name="${name}" id="${name}" value="${val}" class="w-full text-center border-none h-full bg-sky-50"></td>`
                }
                return body;
            }
            const total_rooms = Number(@json($floor_total_num))
            const each_floor_num = @json($each_floor_total_num);
            let table_body = "";
            let name_count = 0;

            for(let i = 0;i<each_floor_num.length;i++){
                for(let n = 0;n<each_floor_num[i];n++){
                    let room_number = n + 1
                    if(room_number<10){
                        room_number = '0' + String(room_number)
                    }
                    room_number = String(i)+String(room_number)
                    table_body += `<tr>
                                        ${body_num('room_no_'+ String(name_count),room_number)}
                                        ${body_num("room_plan_"+ String(name_count),"","select")}
                                        ${body_num("room_area_"+ String(name_count),"")}
                                        ${body_num("room_rent_"+ String(name_count),"")}
                                        ${body_num("room_common_"+ String(name_count),"")}
                                    </tr>`
                    name_count ++
                }
            }
            // const insert = `<table class="table-fixed w-full text-xs">
            //                     <thead>
            //                         <tr>
            //                             <th class="bg-gray-100 border px-4 py-2">部屋No</th>
            //                             <th class="bg-gray-100 border px-4 py-2">間取り</th>
            //                             <th class="bg-gray-100 border px-4 py-2">㎡</th>
            //                             <th class="bg-gray-100 border px-4 py-2">賃料</th>
            //                             <th class="bg-gray-100 border px-4 py-2">管理費</th>
            //                         </tr>
            //                     </thead>
            //                     <tbody>
            //                         ${table_body}
            //                     </tbody>
            //                     </table>
            //                     <input type="hidden" name="rent_rooms_count" value="${total_rooms}">`
            $('#insert_table_rent').html(table_body);
            $('#rent_rooms_count').val(total_rooms);

        })

        function format_num(number){
            let change_val = number.replace(/[^0-9.]/g, '')
            return change_val
        }


        // 登録免許税
        // 計算式
        // 切り捨て
        function floor_hundred(num){
            let result = Math.floor(num/100)*100
            return result
        }
        // 土地所有権移転登記
        function calc_land_ownership_transfer(){
            let property_tax_area = document.getElementById('property_tax_area').value
            property_tax_area = format_num(property_tax_area)
            let result = floor_hundred(property_tax_area*20/1000)
            return result
        }
        // 建物所有権移転登記
        function calc_prop_ownership_transfer(){
            let property_tax_prop = document.getElementById('property_tax_prop').value;
            property_tax_prop = format_num(property_tax_prop)
            const prop_cat = @json($project->property->category);
            let result = 0;
            if(prop_cat =="新築"){
                result = floor_hundred(property_tax_prop*4/1000)
            }else if(prop_cat == "中古"){
                result = floor_hundred(property_tax_prop*20/1000)
            }
            return result
        }
        // 抵当権設定費用
        function calc_mortgage_setting_costs(){
            let debt = document.getElementById('debt').value
            debt = format_num(debt)
            let result = floor_hundred(debt*4/1000)
            return result
        }
        // 土地不動産取得税
        function calc_estate_tax_area(){
            let property_tax_area = document.getElementById('property_tax_area').value;
            const estate_tax_jutaku = document.getElementById('estate_tax_jutaku').value;
            property_tax_area = format_num(property_tax_area)
            let result = 0;
            if(estate_tax_jutaku =="特例あり"){
                result = floor_hundred(property_tax_area*0.015)
            }else if(estate_tax_jutaku == "特例なし"){
                result = floor_hundred(property_tax_area*0.015)
            }
            return result
        }

        // 建物不動産取得税
        function calc_estate_tax_prop(ratio){
            let property_tax_prop = document.getElementById('property_tax_prop').value;
            property_tax_prop = format_num(property_tax_prop)
            let result = floor_hundred(property_tax_prop*ratio)
            return result
        }

        // 根抵当権設定料（事業計画）
        function calc_jigyou_neteitou(){
            let property_tax_prop = document.getElementById('jigyuo_debt').value;
            property_tax_prop = format_num(property_tax_prop)
            let result = floor_hundred(property_tax_prop*1.2*0.004)
            return result
        }
        // 不動産取得税（事業計画）
        function calc_jigyuo_fudousan_syutoku(){
            let property_tax_area = document.getElementById('property_tax_area').value;
            property_tax_area = format_num(property_tax_area)
            let result = floor_hundred(property_tax_area*0.015)
            return result
        }
        // 仲介料（事業計画）
        function calc_chukai(){
            let area_cost = document.getElementById('jigyuo_area_cost').value;
            area_cost = format_num(area_cost)
            let result = 0;
            if(area_cost <=2000000){
                result = area_cost * 0.05;
            }else if(area_cost >2000000 && area_cost <=4000000){
                result = area_cost * 0.04 + 60000;
            }else if(area_cost > 4000000){
                result = area_cost * 0.03 + 60000;
            }
            return result
        }
        function calc_kotei(){
            let area_cost = document.getElementById('property_tax_area').value;
            const days = document.getElementById('debt_days').textContent;
            area_cost = format_num(area_cost)
            let result = Math.round((area_cost * 0.014 + area_cost * 0.03)/365 * Number(days));
            return result
        }





        $(".btn_calc").on("click",function(){
            const calc_area = this.dataset.id
            let set_val = 0
            let set_area = ""
            if(calc_area == "land_ownership_transfer"){ // 土地所有権移転登記
                set_val = calc_land_ownership_transfer()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "prop_ownership_transfer"){ // 建物所有権移転登記
                set_val = calc_prop_ownership_transfer()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "mortgage_setting_costs"){ // 抵当権設定費用
                set_val = calc_mortgage_setting_costs()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "estate_tax_area"){ // 土地不動産取得税
                set_val = calc_estate_tax_area()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "estate_tax_prop"){ // 建物不動産取得税
                const ratio = this.dataset.num
                set_val = calc_estate_tax_prop(ratio)
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "jigyuo_neteitou"){ // 根抵当権設定料（事業計画）
                set_val = calc_jigyou_neteitou()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "jigyuo_tourokumenkyo"){ // 登録免許税（事業計画）
                set_val = calc_land_ownership_transfer()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "jigyuo_fudousansyutoku"){ // 不動産取得税（事業計画）
                set_val = calc_estate_tax_area()
                set_area = document.getElementById(calc_area)
            }else if(calc_area =="jigyuo_kentiku_fee_tubo"){
                set_val = document.getElementById('jigyuo_kentiku_fee_tubo').value;
                set_val = format_num(set_val)
                set_val = Math.round(set_val*Number(@json($floor_total_area))*0.3025)
                set_area = document.getElementById('jigyuo_kentiku_fee')
            }else if(calc_area =="jigyuo_kentiku_fee"){
                set_val = document.getElementById('jigyuo_kentiku_fee').value;
                set_val = format_num(set_val)
                set_val = Math.round(set_val/Number(@json($floor_total_area))/0.3025)
                set_area = document.getElementById('jigyuo_kentiku_fee_tubo')
            }else if(calc_area =="jigyuo_kaitai_fee_tubo"){
                set_val = document.getElementById('jigyuo_kaitai_fee_tubo').value;
                console.log(set_val)
                set_val = format_num(set_val)
                console.log(set_val)
                set_val = Math.round(set_val*Number(@json($floor_total_area))*0.3025)
                console.log(set_val)
                set_area = document.getElementById('jigyuo_kaitai_fee')
            }else if(calc_area =="jigyuo_kaitai_fee"){
                set_val = document.getElementById('jigyuo_kaitai_fee').value;
                console.log(set_val)
                set_val = format_num(set_val)
                console.log(set_val)
                set_val = Math.round(set_val/Number(@json($floor_total_area))/0.3025)
                console.log(set_val)
                set_area = document.getElementById('jigyuo_kaitai_fee_tubo')
            }else if(calc_area == "jigyuo_brokerage_fee"){ // 仲介料（事業計画）
                set_val = calc_chukai()
                set_area = document.getElementById(calc_area)
            }else if(calc_area == "jigyuo_koteisisan"){ // 固定資産（事業計画）
                set_val = calc_kotei()
                set_area = document.getElementById(calc_area)
            }
            set_area.value = set_val.toLocaleString()


        })

        $(".data_copy").on("click",function(){
            const area = this.dataset.id
            const val = document.getElementById(area + '_0').value;

            const num = document.getElementById('rent_rooms_count').value;
            for(i=0;i<num;i++){
                $('#'+area+'_'+i).val(val)
            }
        })


    </script>
</x-app-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <style type="text/css">
            @font-face {
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
            }
            @font-face {
                font-family: ipag;
                font-style: bold;
                font-weight: bold;
                src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
            }
            @page {
                margin: 10px;
            }
            body {
                font-family: ipag !important;
            }
        </style>
    </head>
    @php
        function m_tubo_conv($num){
            $tubo = 0;
            if($num > 0){
                $tubo = round($num *0.3025,2);
            }
            return $tubo;
        }
        function calc_tax($num){
            return number_format(round($num *1.1));
        }
        $area_tubo = m_tubo_conv($project->property->land_area);

        $floor_total_tenant_num = 0;
        $floor_total_tenant_area = 0;
        $floor_total_house_num = 0;
        $floor_total_house_area = 0;
        $floor_total_num = 0;
        $floor_total_area = 0;
        foreach ($project->floors as $floor) {
            $floor_total_tenant_num += $floor->tenant_num;
            $floor_total_tenant_area += $floor->tenant_area;
            $floor_total_house_num += $floor->house_num;
            $floor_total_house_area += $floor->house_area;
            $floor_total_num += $floor->tenant_num + $floor->house_num;
            $floor_total_area += $floor->tenant_area + $floor->house_area;
        }

        function total_fee($array,$val,$type= "room",$cycle = ""){
            $cost = 0;
            foreach ($array as $fee) {
                if($type == "room"){
                    $cost += $fee->$val;
                }else if($type == "park"){
                    $park = $fee->$val;
                    $cost += $park * $fee->count;
                }else if($type == "other_fee"){
                    if($fee->cycle == $cycle){
                        $cost += $fee->$val;
                    }
                }
            }
            return $cost;
        }
        $total_fee_rent = total_fee($project->rooms,"room_rent");
        $total_fee_kanri = total_fee($project->rooms,"room_common");
        $total_fee_other = 0;
        $total_fee_parking = total_fee($project->parkings,"fee","park");
        $total_fee_all = $total_fee_rent + $total_fee_kanri + $total_fee_other + $total_fee_parking;

        $price_prop_tax =round($project->price_prop *0.1);
        $price_prop_total = $project->price_prop + $price_prop_tax;
        $total_price = $project->price_prop + $project->price_land;
        $plan_totla_price_tax = $total_price+$price_prop_tax;

        $syohiyou = 0;
        $syohiyou += $project->display_registration;
        $syohiyou += $project->land_ownership_transfer;
        $syohiyou += $project->prop_ownership_transfer;
        $syohiyou += $project->mortgage_setting_costs;
        $syohiyou += $project->estate_tax_area;
        $syohiyou += $project->estate_tax_prop;
        $syohiyou += $project->judicial_scrivener_fee;
        $syohiyou += $project->loan_fees;
        $syohiyou += $project->loan_guarantee_fee;
        $syohiyou += $project->brokerage_fee;
        $syohiyou += total_fee($project->others,"fee","other_fee","1回限り");
        // $syohiyou += $project->housing_insurance_cost;
        // $syohiyou += $project->earthquake_insurance_cost;

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
        // 20240813修正
        // $jigyou_total_area_fee_tax += $jigyou_total_area_fee-$project->jigyuo_ginkou_fee;
        $jigyou_total_area_fee_tax += $jigyou_total_area_fee;


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
        $total_genka_tax = $jigyou_total_prop_fee_tax + $jigyou_total_area_fee_tax;
        $arari = $total_price-$total_genka;
        $arari_ratio = 0;

        $rimawari = 0;
        $rimawari_tax = 0;
        if($total_price > 0){
            $arari_ratio = $arari/$total_price *100;
            $rimawari=($total_fee_all * 12)/$total_price *100;
            $rimawari_tax = ($total_fee_all * 12)/$plan_totla_price_tax *100;
        }

        function calc_date($start,$end){
            $day = new DateTime($start);
            $day2 = new DateTime($end);
            $diff = $day->diff($day2);
            return $diff->days +1;
        }
    @endphp
    <body class="text-sm">
        <main class="px-5">
            <div class="pdf_page">
                @include('project.parts.pdf_haed',["name"=>$project->name,"updated_at"=>$project->updated_at])
                <div class="pdf_main">
                    <div class="pdf_table pdf_table_gaiyou" style="float:left; font-size:12px">
                        <h2>物件概要</h2>
                        <h3>物件概要</h3>
                        <table class="w-full pdf_table_gai_left">
                            <tbody>
                                <tr>
                                    <th>所在地</th>
                                    <td colspan="3">{{$project->property->address}}</td>
                                </tr>
                                <tr>
                                    <th>顧客名</th>
                                    <td>{{$project->client}}</td>
                                    <th>新築中古区分</th>
                                    <td>{{$project->property->category}}</td>
                                </tr>
                                <tr>
                                    <th>完成予定</th>
                                    <td>{{$project->open_date ? $project->open_date->format(config('const.format.date')) : ""}}</td>
                                    <th>家賃送金開始日</th>
                                    <td>{{$project->start_date ? $project->start_date->format(config('const.format.date')) : ""}}</td>
                                </tr>
                                <tr>
                                    <th>館名</th>
                                    <td colspan="3">{{$project->house_name}}</td>
                                </tr>
                                <tr>
                                    <th rowspan="{{count($project->property->stations)}}">交通</th>
                                    @php
                                        $count=0;
                                    @endphp
                                    @if (count($project->property->stations)>0)
                                        @foreach ($project->property->stations as $station)
                                            @if ($count >0)
                                                <tr>
                                            @endif
                                                <td>{{$station->route}}</td>
                                                <td>{{$station->station}}</td>
                                                <td><span>徒歩</span>{{$station->time}} <span>分</span></td>
                                                @if ($count >0)
                                                <tr>
                                            @endif
                                            @php
                                                $count ++;
                                            @endphp
                                        @endforeach
                                    @else
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>地積</th>
                                    <td colspan="3">
                                        {{number_format($project->property->land_area,2)}} <span class="mr-5">㎡</span>
                                        {{number_format($area_tubo,2)}} <span>坪</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>地目</th>
                                    <td colspan="3">{{$project->property->ground}}</td>
                                </tr>
                                <tr>
                                    <th>都市計画</th>
                                    <td colspan="3">{{$project->property->city_planning}}</td>
                                </tr>
                                <tr>
                                    <th>用途地域</th>
                                    <td colspan="3">{{$project->property->use_district}}</td>
                                </tr>
                                <tr>
                                    <th>建ぺい率</th>
                                    <td>{{$project->property->building_coverage_ratio}} <span>%</span></td>
                                    <th>容積率</th>
                                    <td>{{$project->property->floor_area_ratio}} <span>%</span></td>
                                </tr>
                                <tr>
                                    <th rowspan="{{count($project->property->roads)}}">道路</th>
                                    @php
                                        $count=0;
                                    @endphp
                                    @if (count($project->property->roads)>0)
                                        @foreach ($project->property->roads as $road)
                                            @if ($count >0)
                                                <tr>
                                            @endif
                                                <td>{{$road->road_kind}}</td>
                                                <td>{{$road->direction}}</td>
                                                <td>{{$road->length}} <span>m</span></td>
                                                @if ($count >0)
                                                <tr>
                                            @endif
                                            @php
                                                $count ++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>備考</th>
                                    <td colspan="3">{{$project->property->text}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>建築プラン</h3>
                        <table class="w-full pdf_table_kentiku">
                            <tbody>
                                <tr>
                                    <th>種類</th>
                                    <td>{{$project->plan_kind}}</td>
                                    <td>{{$floor_total_num}}<span>世帯入</span></td>
                                </tr>
                                <tr>
                                    <th rowspan="{{count($project->plans)}}">間取</th>
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($project->plans as $plan)
                                        @if ($count >0)
                                            <tr>
                                        @endif
                                            <td>{{$plan->plan}}</td>
                                            <td>{{$plan->count}} <span>戸</span></td>
                                            @if ($count >0)
                                            <tr>
                                        @endif
                                        @php
                                            $count ++;
                                        @endphp
                                    @endforeach
                                </tr>
                                <tr>
                                    <th rowspan="{{count($project->parkings)}}">駐車</th>
                                    @php
                                        $count=0;
                                    @endphp
                                    @if (count($project->parkings)>0)
                                        @foreach ($project->parkings as $parking)
                                            @if ($count >0)
                                                <tr>
                                            @endif
                                                <td>{{$parking->plan}}</td>
                                                <td>{{$parking->count}} <span>台分</span></td>
                                                @if ($count >0)
                                                <tr>
                                            @endif
                                            @php
                                                $count ++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>構造</th>
                                    <td>{{$project->structure}}</td>
                                    <td>{{$project->floor}} <span>階建て</span></td>
                                </tr>
                                <tr>
                                    <th>設備</th>
                                    <td colspan="2">{{$project->equipment}}</td>
                                </tr>
                                <tr class="kentiku_area">
                                    <th rowspan="3">面積</th>
                                    <td colspan="2">
                                        @if ($floor_total_tenant_area != 0)
                                            <span>テナント</span>
                                            <span>{{$floor_total_tenant_area}}㎡</span>
                                            <span>{{m_tubo_conv($floor_total_tenant_area)}}坪</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="kentiku_area">
                                    <td colspan="2">
                                        <span>居住</span>
                                        <span>{{number_format($floor_total_house_area,2)}}㎡</span>
                                        <span>{{number_format(m_tubo_conv($floor_total_house_area),2)}}坪</span>
                                    </td>
                                </tr>
                                <tr class="kentiku_area">
                                    <td colspan="2">
                                        <span>延床</span>
                                        <span>{{number_format($floor_total_area,2)}}㎡</span>
                                        <span>{{number_format(m_tubo_conv($floor_total_area),2)}}坪</span>
                                    </td>
                                </tr>
                                {{-- <tr class="kentiku_area">
                                    <td colspan="2">
                                        <span>地階（車庫）</span>
                                        <span>100㎡</span>
                                        <span>100坪</span>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <h3>家賃収入</h3>
                        <table class="w-full pdf_table_yatin">
                            <tbody class="">
                                <tr>
                                    <th>家賃</th>
                                    <td>{{number_format($total_fee_rent)}}<span>円/月</span></td>
                                    <th>月額</th>
                                    <th>年額</th>
                                </tr>
                                <tr>
                                    <th>その他計</th>
                                    <td>{{number_format($total_fee_kanri)}}<span>円/月</span></td>
                                    <td rowspan="2">{{number_format($total_fee_all)}}<span>円</span></td>
                                    <td rowspan="2">{{number_format($total_fee_all *12)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>駐車場計</th>
                                    <td>{{number_format($total_fee_parking)}}<span>円/月</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>販売価格</h3>
                        <table class="w-full pdf_table_yatin">
                            <tbody class="">
                                <tr>
                                    <th>土地</th>
                                    <td colspan="3">{{number_format($project->price_land)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th rowspan="2">建物</th>
                                    <td rowspan="2">{{number_format($project->price_prop)}}<span>円</span></td>
                                    <td colspan="2"><span class="mr-3">税込価格</span>{{number_format($price_prop_total)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="mr-3">(内消費税)</span>{{number_format($price_prop_tax)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>合計（税抜）</th>
                                    <td>{{number_format($total_price)}}<span>円</span></td>
                                    <th>利回り</th>
                                    <td>{{round($rimawari,2)}}<span>%(税抜)</span></td>
                                </tr>
                                <tr>
                                    <th>合計（税込）</th>
                                    <td>{{number_format($plan_totla_price_tax)}}<span>円</span></td>
                                    <th>利回り</th>
                                    <td>{{round($rimawari_tax,2)}}<span>%(税込)</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pdf_table pdf_table_kiso" style="float:left">
                        <h2>基礎情報</h2>
                        <h3>賃金・借入金内訳</h3>
                        <table class="w-full pdf_table_gai">
                            <tbody class="w-full">
                                <tr>
                                    <th>借入金</th>
                                    <td>{{number_format($project->debt)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>自己資金</th>
                                    <td>{{number_format($project->own_resources)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>総事業合計</th>
                                    <td>{{number_format($project->total_expenses)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>返済方法</th>
                                    <td>{{$project->repayment_method}}</td>
                                </tr>
                                <tr>
                                    <th>借入期間</th>
                                    <td>{{$project->borrowing_period}}<span>年</span></td>
                                </tr>
                                <tr>
                                    <th>据置期間</th>
                                    <td>{{$project->deferred_period}}<span>ヶ月</span></td>
                                </tr>
                                <tr>
                                    <th>借入金利</th>
                                    <td>{{$project->interest_rate}}<span>%</span></td>
                                </tr>
                                <tr>
                                    <th>諸費用合計</th>
                                    <td>{{number_format($syohiyou)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>月額返済額</th>
                                    <td>{{number_format($project->monthly_repayment_amount)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>固定資産税評価額</h3>
                        <table class="w-full pdf_table_gai">
                            <tbody class="w-full">
                                <tr>
                                    <th>土地評価額</th>
                                    <td>{{number_format($project->property_tax_area)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>建物評価額</th>
                                    <td>{{number_format($project->property_tax_prop)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>不動産取得税</h3>
                        <table class="w-full pdf_table_gai">
                            <tbody class="w-full">
                                <tr>
                                    <th>住宅用地に対する標準課税の特例</th>
                                    <td>{{$project->estate_tax_jutaku}}</td>
                                </tr>
                                <tr>
                                    <th>新築住宅に対する減額措置</th>
                                    <td>{{$project->estate_tax_shintiku}}</td>
                                </tr>
                                <tr>
                                    <th>土地不動産取得税</th>
                                    <td>{{number_format($project->estate_tax_area)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>建物不動産取得税</th>
                                    <td>{{number_format($project->estate_tax_prop)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>登録免許税</h3>
                        <table class="w-full pdf_table_gai">
                            <tbody class="w-full">
                                <tr>
                                    <th>表示登記</th>
                                    <td>{{number_format($project->display_registration)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>土地所有権移転登記</th>
                                    <td>{{number_format($project->land_ownership_transfer)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>建物所有権移転登記</th>
                                    <td>{{number_format($project->prop_ownership_transfer)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>抵当権設定費用</th>
                                    <td>{{number_format($project->mortgage_setting_costs)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>手数料、保証料</h3>
                        <table class="w-full pdf_table_gai">
                            <tbody class="w-full">
                                <tr>
                                    <th>司法書士手数料</th>
                                    <td>{{number_format($project->judicial_scrivener_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>ローン手数料</th>
                                    <td>{{number_format($project->loan_fees)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>ローン保証料</th>
                                    <td>{{number_format($project->loan_guarantee_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>仲介料</th>
                                    <td>{{number_format($project->brokerage_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th rowspan="{{count($project->others)}}">その他雑費</th>
                                    @if (count($project->others) >0)
                                        @php
                                            $count=0;
                                        @endphp
                                        @foreach ($project->others as $other)
                                            @if ($count >0)
                                                <tr>
                                            @endif
                                                <td>
                                                    <span class="mr-2">{{$other->cycle}}</span>
                                                    <span class="mr-2">{{$other->name}}</span>
                                                    <span class="mr-1">{{$other->fee}}円</span>
                                                </td>
                                            @if ($count >0)
                                                <tr>
                                            @endif
                                            @php
                                                $count ++;
                                            @endphp
                                        @endforeach
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>住宅総合保険</th>
                                    <td>
                                        @if ($project->housing_insurance_case == "入る")
                                            {{number_format($project->housing_insurance_year)}}<span>年分</span>
                                            {{number_format($project->housing_insurance_cost)}}<span>円</span>
                                        @else
                                            なし
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>地震保険</th>
                                    <td>
                                        @if ($project->earthquake_insurance_case == "入る")
                                            {{number_format($project->earthquake_insurance_year)}}<span>年分</span>
                                            {{number_format($project->earthquake_insurance_cost)}}<span>円</span>
                                        @else
                                            なし
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pdf_table pdf_table_fee" style="float:left">
                        <h2>家賃明細</h2>
                        <h3>家賃</h3>
                        <table class="w-full pdf_table_feedetail">
                            <thead>
                                <th class="w-2/12">部屋No.</th>
                                <th class="w-2/12">間取り</th>
                                <th class="w-2/12">㎡</th>
                                <th class="w-3/12">賃料</th>
                                <th class="w-3/12">管理費</th>
                            </thead>
                            <tbody>
                                @if (count($project->rooms)>0)
                                    @foreach ($project->rooms as $room)
                                    <tr>
                                        <td>{{$room->room_no}}</td>
                                        <td>{{$room->room_plan}}</td>
                                        <td class="table_right">{{number_format($room->room_area,2)}}</td>
                                        <td class="table_right">{{number_format($room->room_rent)}}</td>
                                        <td class="table_right">{{number_format($room->room_common)}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <h3>駐車料</h3>
                        <table class="w-full pdf_table_feedetail">
                            <thead>
                                <th class="w-1/5">タイプ</th>
                                <th class="w-1/5">台数</th>
                                <th class="w-1/5">単価</th>
                                <th class="w-2/5">小計</th>
                            </thead>
                            <tbody>
                                @if (count($project->parkings)>0)
                                    @foreach ($project->parkings as $parking)
                                    <tr>
                                        <td>{{$parking->plan}}</td>
                                        <td class="table_right">{{$parking->count}}</td>
                                        <td class="table_right">{{number_format($parking->fee)}}</td>
                                        <td class="table_right">{{number_format($parking->fee * $parking->count)}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pdf_page" style="clear: both;">
                @include('project.parts.pdf_haed',["name"=>$project->name,"updated_at"=>$project->updated_at])
                <div class="page_2 mb-3">
                    <table class="w-full pdf_table">
                        <tbody>
                            <tr>
                                <th>所在地</th>
                                <td>{{$project->property->address}}</td>
                                <th>お客様名</th>
                                <td>{{$project->client}}</td>
                                <th>担当</th>
                                <td>{{$project->user->name}}</td>
                            </tr>
                            <tr>
                                <th>摘要</th>
                                <td colspan="5">{{$project->property->text}}</td>
                            </tr>
                            <tr>
                                <th>借入先</th>
                                <td>{{$project->bank_name}}</td>
                                <th>借入期間</th>
                                <td>{{$project->borrowing_period}}年</td>
                                <th>金利</th>
                                <td>{{$project->interest_rate}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pdf_main">
                    <section style="float:left" class="pdf_table pdf_table_jigyou">
                        <h3>事業計画</h3>
                        <div class="pdf_table_jigyou_flex mb-5">
                            <div class="pdf_table_sammary">
                                <table class="w-full pdf_td_right">
                                    <thead>
                                        <th class="w-2/12"></th>
                                        <th class="w-2/12"></th>
                                        <th class="text-center w-4/12">月収</th>
                                        <th class="text-center w-4/12">年収</th>
                                    </thead>
                                    <tbody class="w-full">
                                        <tr>
                                            <th rowspan="4">家賃</th>
                                            <th>家賃</th>
                                            <td>{{number_format($total_fee_rent)}}<span>円</span></td>
                                            <td>{{number_format($total_fee_rent *12)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>管理費</th>
                                            <td>{{number_format($total_fee_kanri)}}<span>円</span></td>
                                            <td>{{number_format($total_fee_kanri *12)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>その他</th>
                                            <td>{{number_format($total_fee_other)}}<span>円</span></td>
                                            <td>{{number_format($total_fee_other *12)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>車庫</th>
                                            <td>{{number_format($total_fee_parking)}}<span>円</span></td>
                                            <td>{{number_format($total_fee_parking *12)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">合計</th>
                                            <td>{{number_format($total_fee_all)}}<span>円</span></td>
                                            <td>{{number_format($total_fee_all *12)}}<span>円</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="w-full mt-5 pdf_td_right">
                                    <thead>
                                        <th class="w-2/12"></th>
                                        <th class="w-2/12"></th>
                                        <th class="text-center w-4/12"></th>
                                        <th class="text-center w-4/12"></th>
                                    </thead>
                                    <tbody class="w-full">
                                        <tr>
                                            <th colspan="2">利回り</th>
                                            <td>{{number_format(round($rimawari,2),2)}}<span>%(税抜)</span></td>
                                            <td>{{number_format(round($rimawari_tax,2),2)}}<span>%(税込)</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="pdf_table_sammary_price">
                                <table class="w-full pdf_td_right">
                                    <tbody class="w-full">
                                        <tr>
                                            <th class="w-1/3">販売価格</th>
                                            <td class="w-2/3">{{number_format($total_price)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>原価</th>
                                            <td>{{number_format($total_genka)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>粗利額</th>
                                            <td>{{number_format($arari)}}<span>円</span></td>
                                        </tr>
                                        <tr>
                                            <th>粗利率</th>
                                            <td>{{number_format(round($arari_ratio, 2),2)}}<span>%</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <table class="w-full pdf_td_right">
                            <thead>
                                <th class="w-1/3"></th>
                                <th class="text-center w-1/3">【税抜】</th>
                                <th class="text-center w-1/3">【税込】</th>
                            </thead>
                            <tbody class="w-full">
                                <tr>
                                    <th>土地代金 {{$area_tubo > 0 ? "(坪単価：".number_format(round($project->jigyuo_area_cost/$area_tubo,2))."円)" : ""}}</th>
                                    <td>{{number_format($project->jigyuo_area_cost)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_area_cost)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>仲介料</th>
                                    <td>{{number_format($project->jigyuo_brokerage_fee)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_brokerage_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>紹介料</th>
                                    <td>{{number_format($project->jigyuo_syoukai_fee)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_syoukai_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>根抵当権設定料</th>
                                    <td>{{number_format($project->jigyuo_neteitou)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_neteitou)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>登録免許税</th>
                                    <td>{{number_format($project->jigyuo_tourokumenkyo)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_tourokumenkyo)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>不動産取得税</th>
                                    <td>{{number_format($project->jigyuo_fudousansyutoku)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_fudousansyutoku)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>司法書士報酬</th>
                                    <td>{{number_format($project->jigyuo_sihousyosi)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_sihousyosi)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>銀行手数料・印紙</th>
                                    <td>{{number_format($project->jigyuo_ginkou_fee)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_ginkou_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>固定資産税等</th>
                                    <td>{{number_format($project->jigyuo_koteisisan)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_koteisisan)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>支払利息</th>
                                    <td>{{number_format($project->jigyuo_risoku_fee)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_risoku_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>解体費用</th>
                                    <td>{{number_format($project->jigyuo_kaitai_fee)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_kaitai_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>立ち退き費用</th>
                                    <td>{{number_format($project->jigyuo_tatinoki)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_tatinoki)}}<span>円</span></td>
                                </tr>
                                @foreach ($project->bikous_kind("area",$project->id) as $bikou)
                                <tr>
                                    <th>{{$bikou->name}}</th>
                                    <td>{{number_format($bikou->fee)}}<span>円</span></td>
                                    <td>{{calc_tax($bikou->fee)}}<span>円</span></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th>土地費用合計</th>
                                    <td>{{number_format($jigyou_total_area_fee)}}<span>円</span></td>
                                    <td>{{number_format($jigyou_total_area_fee_tax)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <section style="float:left" class="pdf_table pdf_table_jigyou">
                        <h3 class="opacity-0">-</h3>
                        <table class="w-full mb-5">
                            <tbody>
                                <tr>
                                    <th class="w-1/4">建築工期</th>
                                    <td class="w-2/4">
                                        <span>{{$project->structure_start_date ? $project->structure_start_date->format(config('const.format.date')) : ""}}</span>
                                        <span class="px-8">~</span>
                                        <span>{{$project->structure_end_date ? $project->structure_end_date->format(config('const.format.date')) : ""}}</span>
                                    </td>
                                    <td class="w-1/4">{{calc_date($project->structure_start_date,$project->structure_end_date)}}<span>日</span></td>
                                </tr>
                                <tr>
                                    <th class="w-1/4">借入期間</th>
                                    <td class="w-2/4">
                                        <span>{{$project->debt_start_date ? $project->debt_start_date->format(config('const.format.date')) : ""}}</span>
                                        <span class="px-8">~</span>
                                        <span>{{$project->debt_end_date ? $project->debt_end_date->format(config('const.format.date')) : ""}}</span>
                                    </td>
                                    <td class="w-1/4">{{calc_date($project->debt_start_date,$project->debt_end_date)}}<span>日</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full mb-5 pdf_td_right">
                            <tbody class="w-full">
                                <tr>
                                    <th class="w-1/3">借入金</th>
                                    <td class="w-2/3">{{number_format($project->jigyuo_debt)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th class="w-1/3">自己資金</th>
                                    <td class="w-2/3">{{number_format($jigyou_total_area_fee -$project->jigyuo_debt)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th class="w-1/3">土地費用合計</th>
                                    <td class="w-2/3">{{number_format($jigyou_total_area_fee_tax)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full mb-5 pdf_td_right">
                            <thead>
                                <th class="w-1/3"></th>
                                <th class="text-center w-1/3">【税抜】</th>
                                <th class="text-center w-1/3">【税込】</th>
                            </thead>
                            <tbody class="w-full">
                                <tr>
                                    <th>建築本体工事 {{$project->jigyuo_kentiku_fee_tubo > 0 ? "(税込坪単価：".calc_tax($project->jigyuo_kentiku_fee_tubo)."円)" : ""}}</th>
                                    <td>{{number_format($project->jigyuo_kentiku_fee)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_kentiku_fee)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>杭工事費用</th>
                                    <td>{{number_format($project->jigyuo_kui)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_kui)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>設計管理費用</th>
                                    <td>{{number_format($project->jigyuo_sekkeikanri)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_sekkeikanri)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>インターネット工事</th>
                                    <td>{{number_format($project->jigyuo_net)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_net)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>JIO検査・保険料</th>
                                    <td>{{number_format($project->jigyuo_jio)}}<span>円</span></td>
                                    <td>{{number_format($project->jigyuo_jio)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>都市ガス工事</th>
                                    <td>{{number_format($project->jigyuo_gas*$floor_total_num)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_gas*$floor_total_num)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th>広告料</th>
                                    <td>{{number_format($project->jigyuo_ad*$floor_total_num)}}<span>円</span></td>
                                    <td>{{calc_tax($project->jigyuo_ad*$floor_total_num)}}<span>円</span></td>
                                </tr>
                                @foreach ($project->bikous_kind("prop",$project->id) as $bikou)
                                <tr>
                                    <th>{{$bikou->name}}</th>
                                    <td>{{number_format($bikou->fee)}}<span>円</span></td>
                                    <td>{{calc_tax($bikou->fee)}}<span>円</span></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th>建築費用合計</th>
                                    <td>{{number_format($jigyou_total_prop_fee)}}<span>円</span></td>
                                    <td>{{number_format($jigyou_total_prop_fee_tax)}}<span>円</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full pdf_td_right">
                            <thead>
                                <th class="w-1/3"></th>
                                <th class="text-center w-1/3">【税抜】</th>
                                <th class="text-center w-1/3">【税込】</th>
                            </thead>
                            <tbody class="w-full text-lg">
                                <tr>
                                    <th class="py-3">土地・建物費用合計</th>
                                    <td>{{number_format($total_genka)}}<span>円</span></td>
                                    <td>{{number_format($total_genka_tax)}}<span>円</span></td>
                                </tr>
                                <tr>
                                    <th class="py-3">販売利益</th>
                                    <td>{{number_format($arari)}}<span>円</span></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                    </section>

                </div>
            </div>

            @php
                $start_num = 1;
                $start_year = date('Y',strtotime($project->project_start_date));
                $project_debt = $project->debt;
                function roop_val($item,$r){
                    $values = [];
                    for($n = 0;$n<$r;$n++){
                        array_push($values,$item);
                    }
                    return $values;
                }
                function calc_zero($item){
                    $val = 1;
                    if($item>0){
                        $val = $item;
                    }
                    return $val;
                }
                function hoken($type,$project,$roop){
                    $year = $type.'_year';
                    $cost = $type.'_cost';
                    $array = [];
                    if($project->$year != 0 && $project->$cost != 0){
                        $array = roop_val($project->$cost / $project->$year,$roop);
                    }else{
                        $array = roop_val(0,$roop);
                    }
                    return $array;
                }
                function calc_zan($zan,$item){
                    $val = $item;
                    if($zan < $item && $zan > 0){
                        $val = $zan;
                    }elseif(round($zan) == 0){
                        $val = 0;
                    }
                    return $val;
                }
                $start_month = date('n',strtotime($project->project_start_date));
                $after_start = $start_month + $project->deferred_period -1;
                $after_start_cost = 12 - $start_month +1;
                $year = date('Y',strtotime($project->project_start_date));
                $date = strval($year) . '-12-31';
                $diff_days = calc_date($project->project_start_date,$date);
                $equipment_price = round($project->equipment_ratio/100 * $project->price_prop *1.1);
                $prop_price = $project->price_prop - $equipment_price;
                $geturi = $project->interest_rate /100 /12;
                $zandaka = $project->debt;
                $loop_count = 0;
                $zan_hoken_h = $project->housing_insurance_cost;
                $zan_hoken_e = $project->earthquake_insurance_cost;
                $zan_genka_p = $project->building_depreciation_ratio * $prop_price * $project->building_depreciation_year;
                $zan_genka_e = $project->equipment_depreciation_ratio * $equipment_price * $project->equipment_depreciation_year;

            @endphp
            @for ($c = 0;$c<4;$c++)
                <div class="pdf_page"  style="clear: both;">
                    @php
                        $roop = 10;
                        $yatin_m = roop_val($total_fee_all,$roop);
                        $yatin_y = roop_val($total_fee_all * 12,$roop);
                        $hensai_m = roop_val($project->monthly_repayment_amount,$roop);
                        $hensai_y = roop_val($project->monthly_repayment_amount * 12,$roop);
                        $kanri_m = roop_val($project->management_fee*$floor_total_num,$roop);
                        $kanri_y = roop_val($project->management_fee*$floor_total_num * 12,$roop);
                        $electric_m = roop_val($project->common_electricity,$roop);
                        $electric_y = roop_val($project->common_electricity * 12,$roop);
                        $clean_m = roop_val($project->cleaning_fee,$roop);
                        $clean_y = roop_val($project->cleaning_fee * 12,$roop);
                        $net_m = roop_val($project->internet_fee*$floor_total_num,$roop);
                        $net_y = roop_val($project->internet_fee*$floor_total_num * 12,$roop);
                        $furikomi_m = roop_val($project->transfer_fee,$roop);
                        $furikomi_y = roop_val($project->transfer_fee * 12,$roop);
                        $koteisisan_m = roop_val($project->property_tax,$roop);
                        $toshikeikaku_m = roop_val($project->city_planning_tax,$roop);
                        $genka_p = roop_val($project->building_depreciation_ratio * $prop_price,$roop);
                        $genka_e = roop_val($project->equipment_depreciation_ratio * $equipment_price,$roop);
                        $hoken_h = hoken("housing_insurance",$project,$roop);
                        $hoken_e = hoken("earthquake_insurance",$project,$roop);
                        $hoken = [];
                        $sonota = roop_val(total_fee($project->others,"fee","other_fee","毎年"),$roop);

                        if($loop_count == 0){
                            if($after_start < 12){
                                $yatin_y[0] = $total_fee_all * (12 - $after_start);
                                $hensai_m[0] = $project->debt * $geturi;
                                $hensai_y[0] = $hensai_m[0] *$project->deferred_period + $project->monthly_repayment_amount *(12 - $after_start);
                            }elseif ($after_start >= 12) {
                                $yatin_m[0] = 0;
                                $yatin_y[0] = 0;
                                $yatin_y[1] = $total_fee_all * (24 - $after_start);
                            }
                            $kanri_y[0] =$kanri_m[0] * $after_start_cost;
                            $electric_y[0] =$electric_m[0] * $after_start_cost;
                            $clean_y[0] =$clean_m[0] * $after_start_cost;
                            $net_y[0] =$net_m[0] * $after_start_cost;
                            $furikomi_y[0] =$furikomi_m[0] * $after_start_cost;
                            // $koteisisan_m[0] = $koteisisan_m[0]/calc_zero(365*$diff_days);
                            $koteisisan_m[0] = $koteisisan_m[0]*calc_zero($diff_days)/365;
                            // $toshikeikaku_m[0] = $toshikeikaku_m[0]/calc_zero(365*$diff_days);
                            $toshikeikaku_m[0] = $toshikeikaku_m[0]*calc_zero($diff_days)/365;
                            $genka_p[0] =$genka_p[0] /12 * $after_start_cost;
                            $genka_e[0] =$genka_e[0] /12 * $after_start_cost;
                            $sonota[0] += $syohiyou;
                            $hoken_h[0] =$hoken_h[0] /12 * $after_start_cost;
                            $hoken_e[0] =$hoken_e[0] /12 * $after_start_cost;


                        }
                        $nyukin_m = [];
                        $nyukin_y = [];

                        $kinnri = roop_val(0,$roop);
                        $gankin = roop_val(0,$roop);
                        $loan_zan = roop_val($zandaka,$roop);
                        for($l = 0;$l<$roop;$l++){
                            $l_month = 12;
                            if($zandaka == 0){
                                $hensai_m[$l] = 0;
                                $hensai_y[$l] = 0;
                            }elseif($zandaka>0 && $zandaka <= $project->monthly_repayment_amount * 12){
                                $hensai_y[$l] = $zandaka;
                            }
                            if($c == 0 && $l ==0){
                                $l_month = $after_start_cost;
                            }
                            for($p = 0;$p<$l_month;$p++){
                                if($c == 0 && $l ==0 && $p < $project->deferred_period){
                                    $kinnri[$l] += round($project->debt * $geturi);
                                }else{
                                    if($zandaka > $project->monthly_repayment_amount){
                                        $calc_kinnri = round($zandaka * $geturi);
                                        $calc_gankin = round($project->monthly_repayment_amount - $calc_kinnri);
                                    }elseif($zandaka > 0 && $zandaka <=$project->monthly_repayment_amount){
                                        $calc_kinnri = round($zandaka * $geturi);
                                        $calc_gankin = $zandaka - $calc_kinnri;
                                    }elseif($zandaka ==0){
                                        $calc_kinnri = 0;
                                        $calc_gankin = 0;
                                    }
                                    $kinnri[$l] += $calc_kinnri;
                                    $gankin[$l] += $calc_gankin;
                                    $loan_zan[$l] -= $calc_gankin;
                                    $zandaka -= $calc_gankin;

                                }
                                if($l != 9){
                                    $loan_zan [$l +1 ] = $zandaka;
                                }
                            }
                            if($zandaka == 0){
                                $hensai_y[$l] += $kinnri[$l];
                            }
                        }

                        $kinnri_a = [];
                        $kinnri_p = [];
                        $keihi = [];
                        $soneki = [];
                        $ratio_a = $project->price_land/calc_zero($project->price_land + $project->price_prop);
                        $ratio_p = 1 - $ratio_a;

                        for($a = 0;$a<$roop; $a++){
                            array_push($nyukin_m,$yatin_m[$a]-$hensai_m[$a]-$kanri_m[$a]-$electric_m[$a]-$clean_m[$a]-$net_m[$a]-$furikomi_m[$a]);
                            array_push($nyukin_y,$yatin_y[$a]-$hensai_y[$a]-$kanri_y[$a]-$electric_y[$a]-$clean_y[$a]-$net_y[$a]-$furikomi_y[$a]);
                            array_push($kinnri_a,$kinnri[$a]*$ratio_a);
                            array_push($kinnri_p,$kinnri[$a]*$ratio_p);
                            $hoken_h[$a] = calc_zan($zan_hoken_h,$hoken_h[$a]);
                            $hoken_e[$a] = calc_zan($zan_hoken_e,$hoken_e[$a]);
                            $genka_p[$a] = calc_zan($zan_genka_p,$genka_p[$a]);
                            $genka_e[$a] = calc_zan($zan_genka_e,$genka_e[$a]);

                            array_push($hoken,$hoken_h[$a] + $hoken_e[$a]);
                            array_push($keihi,$kanri_y[$a]+$electric_y[$a]+$clean_y[$a]+$net_y[$a]+$furikomi_y[$a]+$koteisisan_m[$a]+$toshikeikaku_m[$a]+$genka_p[$a]+$genka_e[$a]+$hoken[$a]+$kinnri[$a]+$sonota[$a]);
                            array_push($soneki,$yatin_y[$a]-$keihi[$a]);
                            $loop_count ++;
                            $zan_hoken_h -= round($hoken_h[$a]);
                            $zan_hoken_e -= round($hoken_e[$a]);
                            $zan_genka_p -= round($genka_p[$a]);
                            $zan_genka_e -= round($genka_e[$a]);

                        }

                    @endphp
                    <div class="px-5">
                        <section class="plan_flex">
                            <table style="width:33%; float: left;">
                                <tr><td>所在地：{{$project->property->address}}</td></tr>
                                <tr><td>最終更新日：{{$project->updated_at}}</td></tr>
                            </table>
                            {{-- <div class="head_add w-1/3">
                                <p></p>
                                <p></p>
                            </div> --}}
                            <div style="width:33%; float: left;" class="head_ttl w-1/3 text-center">
                                <h2 class="text-base">収支計算表（{{strval($c * 10 + 1)."〜".strval(($c+1) * 10)}}）</h2>
                            </div>
                            <div style="width:33%; float: left;" class="head_info w-1/3 text-xs">
                                <table class="w-full">
                                    <tbody class="w-full">
                                        <tr class="w-full">
                                            <td class="w-1/4 border">顧客名</td>
                                            <td colspan="3" class="w-3/4 border">{{$project->client}}</td>
                                        </tr>
                                        <tr class="w-full">
                                            <td class="w-1/4 border">金利</td>
                                            <td class="w-1/4 border">{{$project->interest_rate}}<span>%</span></td>
                                            <td class="w-1/4 border">借入期間</td>
                                            <td class="w-1/4 border">{{$project->borrowing_period}}<span>年</span></td>
                                        </tr>
                                        <tr class="w-full">
                                            <td class="w-1/4 border">銀行返済開始日</td>
                                            <td class="w-1/4 border">{{$project->return_debt_date}}</td>
                                            <td class="w-1/4 border">据置期間</td>
                                            <td class="w-1/4 border">{{$project->deferred_period}}<span>ヶ月</span></td>
                                        </tr>
                                        <tr class="w-full">
                                            <td class="w-1/4 border">家賃送金開始日</td>
                                            <td class="w-1/4 border">{{$project->start_date}}</td>
                                            <td class="w-1/4 border">返済方法</td>
                                            <td class="w-1/4 border">{{$project->repayment_method}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <div class="text-sm"  style="font-size: 12px !important; clear: both;">
                            @include("project.parts.table",["project"=>$project,"roop"=>$roop,"start_num"=>$start_num,"start_year"=>$start_year,"count"=>$c,"project_debt"=>$project_debt])
                            <p>※この収支計算表はシミュレーションです。実際の収支と相違する場合があります。固定資産税の負担調整措置は考慮していません。</p>
                        </div>
                    </div>
                </div>
                @php
                    $start_num += $roop;
                    $start_year += $roop;
                @endphp

            @endfor
        </main>
    </body>
</html>

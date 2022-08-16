@php
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

        $add_class ="fixed01";
        $add_class2 = "fixed02"
@endphp
    <div>

        <div class="plan_table plan_table_head plan_bt_b plan_bx_b plan_bb_r">
            <p class="plan_table_fix_left_1"></p>
            <p class="plan_table_fix_left_2"></p>
            @for ($i = 0;$i<$roop;$i++)
                <p>{{$i + $start_num}}年度</p>
            @endfor
        </div>
        <div class="plan_table plan_table_head plan_bx_b plan_bb_b">
            <p class="plan_table_fix_left_1"></p>
            <p class="plan_table_fix_left_2">西暦</p>
            @for ($i = 0;$i<$roop;$i++)
                <p>{{$i + $start_year}}</p>
            @endfor
        </div>
    </div>




        {{-- <section>

            <table>
                <thead>
                    <tr>
                        <th class="w-32">0年度</th>
                        <th class="w-32">0年度</th>
                        @for ($i = 0;$i<$roop;$i++)
                            <th class="w-32">{{$i + $start_num}}年度</th>
                        @endfor
                    </tr>
                </thead>
            </table>
        </section>
        <section class="w-full mt-3">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    <tr class="w-full">
                        <td class="w-1/12 border_inner text-center px-10 {{$add_class}}">0年度</td>
                        <td class="w-1/12 border_inner text-center px-10 {{$add_class}}">0年度</td>
                        @for ($i = 0;$i<$roop;$i++)
                            <td class="w-1/12 border_inner text-center px-10">{{$i + $start_num}}年度</td>
                        @endfor
                    </tr>
                    <tr class="w-full table_under_line">
                        <td class="w-1/12 border_inner {{$add_class}}"></td>
                        <td class="w-1/12 border_inner text-center {{$add_class}}">西暦</td>
                        @for ($i = 0;$i<$roop;$i++)
                            <td class="w-1/12 border_inner text-center {{$add_class2}}">{{$i + $start_year}}</td>
                        @endfor
                    </tr>
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"家賃収入","val"=>$total_fee_all])
                    @include('project.parts.space')
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"返済額","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"管理手数料","val"=>$project->management_fee*$floor_total_num])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"共用電気料","val"=>$project->common_electricity])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"定期清掃料","val"=>$project->cleaning_fee])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"インターネット使用料","val"=>$project->internet_fee*$floor_total_num])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"振込手数料","val"=>$project->transfer_fee])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"差額入金額","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline border_bottom_none">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"固定資産税","val"=>$project->property_tax])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"都市計画税","val"=>$project->city_planning_tax])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"保険料（年）","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"減価償却","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal',["roop"=>$roop,"ttl"=>"借入金利","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"その他経費","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"経費合計","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"税務上損益","val"=>0])
                </tbody>
            </table>
        </section>
        <section class="mt-5">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"ローン残高","val"=>0])
                </tbody>
            </table>
        </section> --}}




@php


@endphp
        <section class="w-full mt-1">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    <tr class="w-full">
                        <td class="w-1/12 border_inner text-center"></td>
                        <td class="w-1/12 border_inner text-center"></td>
                        @for ($i = 0;$i<$roop;$i++)
                            <td class="w-1/12 border_inner text-center">{{$i + $start_num}}年度</td>
                        @endfor
                    </tr>
                    <tr class="w-full table_under_line">
                        <td class="w-1/12 border_inner"></td>
                        <td class="w-1/12 border_inner text-center">西暦</td>
                        @for ($i = 0;$i<$roop;$i++)
                            <td class="w-1/12 border_inner text-center">{{$i + $start_year}}</td>
                        @endfor
                    </tr>
                    @include('project.parts.row',["ttl"=>"家賃収入","vals"=>$yatin_m,"vals2"=>$yatin_y])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"返済額","vals"=>$hensai_m,"vals2"=>$hensai_y])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"管理手数料","vals"=>$kanri_m,"vals2"=>$kanri_y])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"共用電気料","vals"=>$electric_m,"vals2"=>$electric_y])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"定期清掃料","vals"=>$clean_m,"vals2"=>$clean_y])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"インターネット使用料","vals"=>$net_m,"vals2"=>$net_y])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"振込手数料","vals"=>$furikomi_m,"vals2"=>$furikomi_y])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"差額入金額","vals"=>$nyukin_m,"vals2"=>$nyukin_y])

                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline border_bottom_none">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"固定資産税","vals"=>$koteisisan_m])
                </tbody>
            </table>
            <table class="w-full table_outline border_top_none">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"都市計画税","vals"=>$toshikeikaku_m])

                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.normal_1',["roop"=>$roop,"ttl"=>"保険料（年）","val"=>0,"start_cost"=>$after_start_cost,"count"=>$count,"project"=>$project])
                    @include('project.parts.row_1',["ttl"=>"保険料（年）","vals"=>$hoken])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"減価償却","vals"=>$genka_p,"vals2"=>$genka_e])

                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row',["ttl"=>"借入金利","vals"=>$kinnri_p,"vals2"=>$kinnri_a])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"その他経費","vals"=>$sonota])

                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"経費合計","vals"=>$keihi])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"税務上損益","vals"=>$soneki])
                </tbody>
            </table>
        </section>
        <section class="mt-2">
            <table class="w-full table_outline">
                <tbody class="w-full">
                    @include('project.parts.row_1',["ttl"=>"ローン残高","vals"=>$loan_zan])
                    {{-- @include('project.parts.row_1',["ttl"=>"ローン残高","vals"=>$kinnri])
                    @include('project.parts.row_1',["ttl"=>"ローン残高","vals"=>$gankin]) --}}
                </tbody>
            </table>
        </section>




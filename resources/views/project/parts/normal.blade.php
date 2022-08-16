@php
    $first = "月額";
    $second = "年額";
    if($ttl == "減価償却"){
        $first = "建物";
        $second = "設備";
    }else if($ttl == "借入金利"){
        $first = "建物";
        $second = "土地";
    }
@endphp

<tr class="w-full">
    @if ($ttl == "インターネット使用料")
        <td rowspan="2" class="w-1/12 border_inner border_top_none text-center wordwrap">インターネット<br>使用料</td>
    @else
        <td rowspan="2" class="w-1/12 border_inner border_top_none text-center wordwrap">{{$ttl}}</td>
    @endif
    <td class="w-1/12 border_inner text-center border_top_none">{{$first}}</td>
    @for ($i = 0;$i<$roop;$i++)
        @if ($ttl == "家賃収入" && isset($start) && $count == 0)
            @if($start >= 12 && $i == 0)
                <td class="w-1/12 border_inner text-right border_top_none">0</td>
            @else
                <td class="w-1/12 border_inner text-right border_top_none">{{number_format($val)}}</td>
            @endif
        @else
            <td class="w-1/12 border_inner text-right border_top_none">{{number_format($val)}}</td>
        @endif
    @endfor
</tr>
<tr class="w-full table_under_line">
    <td class="w-1/12 border_inner text-center">{{$second}}</td>
    @for ($i = 0;$i<$roop;$i++)
        @php
            $month = 12;
            if($ttl == "家賃収入" && isset($start) && $count == 0){
                if($start < 12 && $i == 0){
                    $month = $month - $start;
                }elseif ($start >= 12 && $i == 0) {
                    $month = 0;
                }elseif ($start >= 12 && $i == 1) {
                    $month = 24 - $start;
                }
            }elseif($ttl == "管理手数料" || $ttl == "共用電気料" || $ttl == "定期清掃料" || $ttl == "インターネット使用料" || $ttl == "振込手数料"){
                if($count == 0 && $i == 0){
                    $month = $start_cost;
                }
            }
        @endphp
        <td class="w-1/12 border_inner text-right">{{number_format($val *$month)}}</td>
    @endfor
</tr>

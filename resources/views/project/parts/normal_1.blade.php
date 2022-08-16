@php
    $year = date('Y',strtotime($project->project_start_date));
    $day = new DateTime($project->project_start_date);
    $date = strval($year) . '-12-31';
    $day2 = new DateTime($date);
    $diff = $day->diff($day2);
    $diff = $diff->days +1;

@endphp
<tr class="w-full">
    <td colspan="2" class="w-2/12 border_inner border_top_none text-center">{{$ttl}}</td>
    @for ($i = 0;$i<$roop;$i++)
        @php
            $value = $val;
            if($ttl == "固定資産税" || $ttl == "都市計画税"){
                if($i == 0 && $count == 0){
                    $value = $val/365*$diff;
                }
            }
        @endphp
        <td class="w-1/12 border_inner text-right border_top_none">{{number_format($value)}}</td>
    @endfor
</tr>

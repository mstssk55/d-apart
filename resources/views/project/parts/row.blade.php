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
    @foreach ($vals as $val)
        <td class="w-1/12 border_inner text-right border_top_none">{{number_format($val)}}</td>
    @endforeach
</tr>
<tr class="w-full table_under_line">
    <td class="w-1/12 border_inner text-center">{{$second}}</td>
    @foreach ($vals2 as $val2)
        <td class="w-1/12 border_inner text-right">{{number_format($val2)}}</td>
    @endforeach
</tr>

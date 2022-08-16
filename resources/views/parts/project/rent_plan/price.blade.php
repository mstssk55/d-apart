@php
    $unit = "円";
    if($head == "税抜" || $head == "税込み"|| $head == "粗利率"){
        $unit = "%";
    }
@endphp
<tr class="w-full text-center">
    <th class="border font-normal bg-gray-100 w-1/3">{{$head}}</th>
    <td class="border w-2/3">
        <div class="flex items-center">
            <p class="w-1/3 text-right">{{$price}}</p>
            <p class="w-1/3">{{$unit}}</p>
        </div>
    </td>
</tr>

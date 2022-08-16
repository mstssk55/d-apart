@php
    $year = $month*12;
@endphp
<tr class="w-full text-center">
    <th class="border font-normal bg-gray-100">{{$head}}</th>
    <td class="border">
        <div class="flex items-center">
            <p class="w-3/4 text-right">{{number_format($month)}}</p>
            <p class="w-1/4">円</p>
        </div>
    </td>
    <td class="border">
        <div class="flex items-center">
            <p class="w-3/4 text-right">{{number_format($year)}}</p>
            <p class="w-1/4">円</p>
        </div>
    </td>
</tr>

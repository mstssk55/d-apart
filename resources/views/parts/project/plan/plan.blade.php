@php
    $tenant_num = "";
    $tenant_area = "";
    $house_num = "";
    $house_area = "";
    $total_num ="";
    $total_area="";
    if(isset($val)){
        $tenant_num = $val->tenant_num;
        $tenant_area = $val->tenant_area;
        $house_num = $val->house_num;
        $house_area = $val->house_area;
        $total_num =$tenant_num + $house_num;
        $total_area=$tenant_area + $house_area;

    }
@endphp
<tr class="w-full">
    <th class="px-2 py-1 border font-normal bg-gray-100">{{$head}}</th>
    <td class="border">
        <div class="flex">
            <div class="w-1/4 border-r border-gray-300">
                <input type="number" step="0.01" name="tenant_num_{{$count}}" value="{{$tenant_num}}" class="w-full border-none bg-sky-50">
            </div>
            <div class="w-3/4">
                <input type="number" step="0.01" name="tenant_area_{{$count}}" value="{{$tenant_area}}" class="w-full border-none bg-sky-50">
            </div>
        </div>
    </td>
    <td class="border">
        <div class="flex">
            <div class="w-1/4 border-r border-gray-300">
                <input type="number" step="0.01" name="house_num_{{$count}}" value="{{$house_num}}" class="w-full border-none bg-sky-50">
            </div>
            <div class="w-3/4">
                <input type="number" step="0.01" name="house_area_{{$count}}" value="{{$house_area}}" class="w-full border-none bg-sky-50">
            </div>
        </div>
    </td>
    <td class="border">
        <div class="flex">
            <div class="w-1/4 border-r border-gray-300">
                <p class="w-full text-center" id="floor_num_{{$count}}">{{number_format($total_num)}}</p>
            </div>
            <div class="w-3/4">
                <p class="w-full text-center" id="floor_area_{{$count}}">{{number_format(round($total_area,2),2)}}</p>
            </div>
        </div>
    </td>
</tr>

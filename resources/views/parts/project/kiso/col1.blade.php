@php
    $tanni = "円";
    if(isset($unit)){
        $tanni = $unit;
    }
@endphp
<tr class="w-full">
    <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-4/5 border">
        <div class="flex items-center">
            <input type="number" name="{{$name}}" value="{{$project->$name}}" class="text-right border-none w-5/6 text-xs h-full px-4 py-1">
            <span class="w-1/6 block text-left ml-1">{{$tanni}}</span>
        </div>
    </td>
</tr>

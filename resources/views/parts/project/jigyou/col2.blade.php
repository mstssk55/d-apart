@php
    if($kind == "棟"){
        $total = $project->$id;
    }else{
        $total = $project->$id * $rooms;
    }
@endphp
<tr class="w-full">
<th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">{{$title}}</th>
<td class="w-2/3 border">
    <div class="flex items-center">
        <div class="w-2/6 flex items-center">
            <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-3/4 bg-sky-50">
            <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}/{{$kind}}</span>
        </div>
        <div class="w-2/6 flex items-center">
            <p class="text-right border-none w-3/4">{{number_format($total)}}</p>
            <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
        </div>
        @if (isset($type))
            <div class="w-2/6 flex items-center">
                <p class="text-right border-none w-3/4">{{number_format(round($total *1.1))}}</p>
                <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
            </div>
        @endif
    </div>
</td>
</tr>

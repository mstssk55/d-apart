@php
    $head_class = "text-left";
    if(isset($right)){
        $head_class = "text-right text-sm";
    }
@endphp
<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border {{$head_class}} font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 bg-sky-50">
            <span class="w-2/6 block text-left ml-1 {{$id}}">{{$unit}}</span>
        </div>
        {{-- <div class="flex items-center">
            <input id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 h-full bg-sky-50">
            <span class="w-2/6 block text-left ml-1">{{$unit}}</span>
        </div> --}}
    </td>
</tr>

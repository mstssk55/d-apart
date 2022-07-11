@php
    $input_type = "text";
    if(isset($type)){
        $input_type = $type;
    }
@endphp
<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <input type="{{$input_type}}" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="border-none w-full h-full px-4 py-1 bg-sky-50">
        </div>
    </td>
</tr>

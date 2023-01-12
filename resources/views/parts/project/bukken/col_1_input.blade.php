@php
    $input_type = "text";
    $default_val = $project->$id;
    if(isset($type)){
        $input_type = $type;
        if($type == "date" && $default_val != null){
            $default_val = $project->$id->format(config('const.format.input_date'));
        }
    }
@endphp
<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <input type="{{$input_type}}" id="{{$id}}" name="{{$id}}" value="{{$default_val}}" class="border-none w-full h-full px-4 py-1 bg-sky-50">
        </div>
    </td>
</tr>

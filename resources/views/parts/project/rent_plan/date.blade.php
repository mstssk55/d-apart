@php
    $start = $id."_start_date";
    $end = $id."_end_date";
    $start_val = $project->$start;
    $end_val = $project->$end;

    $day = new DateTime($start_val);
    $day2 = new DateTime($end_val);
    $diff = $day->diff($day2);
@endphp
<tr class="w-full">
    <th class="px-2 py-1 border font-normal bg-gray-100 w-1/3 text-left">{{$head}}</th>
    <td class="border w-2/3">
        <div class="flex">
            <div class="w-5/12 border-l border-gray-300">
                <input type="date" id="{{$id}}_start_date" name="{{$id}}_start_date" value="{{$start_val != null ? $start_val->format(config('const.format.input_date')) : ""}}" class="text-right border-none w-full bg-sky-50">
            </div>
            <div class="w-5/12 border-l border-gray-300">
                <input type="date" id="{{$id}}_end_date" name="{{$id}}_end_date" value="{{$end_val != null ? $end_val->format(config('const.format.input_date')) : ""}}" class="text-right border-none w-full bg-sky-50">
            </div>
            <div class="w-2/12 flex items-center border-l border-gray-300">
                <p id="{{$id}}_days" class="text-right w-2/3">{{$diff->days + 1;}}</p>
                <span class="w-1/3 block ml-1 text-xs">日</span>
            </div>
        </div>
    </td>
</tr>

<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <input id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 text-xs h-full px-4 py-1">
            <span class="w-2/6 block text-left ml-1">{{$unit}}</span>
        </div>
    </td>
</tr>

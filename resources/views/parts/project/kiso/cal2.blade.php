<tr  class="w-full">
    <th class="w-1/5 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-4/5 border">
        <div class="flex">
            <div class="w-1/2 my-1 flex items-center">
                <input type="number" name="{{$name1}}" value="{{$project->$name1}}" class="text-right w-9/12 border-none text-xs h-full px-4 py-1">
                <span class="block ml-1 w-3/12 text-left">年分</span>
            </div>
            <div class="w-1/2 my-1 flex items-center">
                <input type="number" name="{{$name2}}" value="{{$project->$name2}}" class="text-right w-9/12 border-none text-xs h-full px-4 py-1">
                <span class="block ml-1 w-3/12 text-left">円</span>
            </div>
        </div>
    </td>
</tr>

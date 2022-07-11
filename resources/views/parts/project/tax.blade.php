<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <div class="w-1/3 flex items-center">
                <input type="number" id="" name="" value="" class="text-right border-none w-4/6 bg-sky-50">
                <span class="w-2/6 block text-left ml-1">%</span>
            </div>
            <div class="w-2/3 flex items-center">
                <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-5/6 bg-sky-50">
                <span class="w-1/6 block text-left ml-1">円</span>
            </div>
        </div>
    </td>
</tr>

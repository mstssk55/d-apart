<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border text-left font-normal bg-gray-100">{{$title}}</th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            <div class="w-1/2 flex items-center border-l border-gray-300">
                <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 bg-sky-50">
                <span class="w-2/6 block text-left ml-1 text-xs">円/月</span>
            </div>
            <div class="w-1/2 flex items-center border-l border-gray-300">
                <span class="w-1/3 block text-left ml-1 text-xs">全戸</span>
                <p id="{{$id}}_totla" class="text-right w-1/3">10,000</p>
                <span class="w-1/3 block text-left ml-1 text-xs">円/月</span>
            </div>
        </div>
    </td>
</tr>

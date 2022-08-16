{{-- <tr>
    <td class="border px-2 py-1"><input type="number" name="{{$name1.'_'.$count}}" value="{{$room->$name1}}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>
    <td class="border px-2 py-1"><input type="number" name="{{$name2.'_'.$count}}" value="{{$room->$name2}}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>
    <td class="border px-2 py-1"><input type="number" name="{{$name3.'_'.$count}}" value="{{$room->$name3}}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>
    <td class="border px-2 py-1"><input type="number" name="{{$name4.'_'.$count}}" value="{{$room->$name4}}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>
    <td class="border px-2 py-1"><input type="number" name="{{$name5.'_'.$count}}" value="{{$room->$name5}}" class="w-full text-center border-none text-xs h-full px-4 py-1"></td>
</tr> --}}
<tr>
    <td class="border"><input type="number" name="{{$name1.'_'.$count}}" value="{{$room->$name1}}" class="w-full text-center border-none h-full bg-sky-50"></td>
    <td class="border">
        <select name="{{$name2.'_'.$count}}" id="{{$name2.'_'.$count}}" class="border-none w-full bg-sky-50">
            <option value="">選択する</option>
            @foreach ($layouts as $item)
                @php
                    $selected = "";
                    if($item->name == $room->$name2){
                        $selected = "selected";
                    }
                @endphp
                <option value="{{$item->name}}" {{$selected}}>{{$item->name}}</option>
            @endforeach
        </select>
    </td>
    <td class="border"><input type="number" name="{{$name3.'_'.$count}}" step="0.01" id="{{$name3.'_'.$count}}" value="{{$room->$name3}}" class="w-full text-center border-none h-full bg-sky-50"></td>
    <td class="border"><input type="number" name="{{$name4.'_'.$count}}" step="0.01" id="{{$name4.'_'.$count}}" value="{{$room->$name4}}" class="w-full text-center border-none h-full bg-sky-50"></td>
    <td class="border"><input type="number" name="{{$name5.'_'.$count}}" step="0.01" id="{{$name5.'_'.$count}}" value="{{$room->$name5}}" class="w-full text-center border-none h-full bg-sky-50"></td>
</tr>

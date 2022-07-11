<div class="flex items-center h-full">
    <div class="w-5/12 h-full border-r border-gray-300">
        <select name="{{$name1}}" id="" class="border-none w-full bg-sky-50">
            <option value="">選択</option>
            @foreach ($parking_item_list as $item)
                @php
                    $selected = "";
                    if($item == $parking->plan){
                        $selected = "selected";
                    }
                @endphp
                <option value="{{$item}}" {{$selected}}>{{$item}}</option>
            @endforeach
        </select>
    </div>
    <div class="w-3/12 h-full flex items-center">
        <input type="number" name="{{$name2}}" value="{{$val2}}" class="text-right w-9/12 border-none bg-sky-50">
        <span class="block ml-1 w-3/12 text-left text-xs">{{$unit}}</span>
    </div>
    <div class="w-4/12 h-full flex items-center">
        <input type="number" name="{{$name3}}" value="{{$val3}}" class="text-right w-9/12 border-none bg-sky-50">
        <span class="block ml-1 w-3/12 text-left text-xs">円</span>
    </div>
</div>

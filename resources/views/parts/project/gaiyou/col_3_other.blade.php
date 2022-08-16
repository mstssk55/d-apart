<div class="flex items-center h-full">
    <div class="w-5/12 h-full border-r border-gray-300">
        <select name="{{$name1}}" id="{{$name1}}" class="border-none w-full bg-sky-50">
            @php
                $onece = "selected";
                $everyyear = "";
                if(isset($other->cycle) && $other->cycle =="毎年"){
                    $onece = "";
                    $everyyear = "selected";
                }
            @endphp
            <option value="1回限り" {{$onece}}>1回限り</option>
            <option value="毎年" {{$everyyear}}>毎年</option>
        </select>
    </div>
    <div class="w-3/12 h-full flex items-center border-r border-gray-300">
        <input type="text" name="{{$name2}}" value="{{$val2}}" class=" w-full border-none bg-sky-50" placeholder="名称">
    </div>
    <div class="w-4/12 h-full flex items-center">
        <input type="number" name="{{$name3}}" value="{{$val3}}" class="text-right w-9/12 border-none bg-sky-50">
        <span class="block ml-1 w-3/12 text-left text-xs">円</span>
    </div>
</div>

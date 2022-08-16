@php
    $selectbox = "";
    $check = "";
    if($name1 == "structure"){
        $selectbox = $crs;
        $check = $project->$name1;
    }else{
        $selectbox = $layouts;
        if(isset($plan)){
            $check = $plan->plan;
        }
    }
@endphp

<div class="flex items-center h-full">
    <div class="w-3/5 h-full border-r border-gray-300">
        <select name="{{$name1}}" id="{{$name1}}" class="border-none w-full bg-sky-50">
            <option value="">選択して下さい</option>
            @foreach ($selectbox as $item)
                @php
                    $selected = "";
                    if($item->name == $check){
                        $selected = "selected";
                    }
                @endphp
                <option value="{{$item->name}}" {{$selected}}>{{$item->name}}</option>
            @endforeach
        </select>
        {{-- <input type="text" name="{{$name1}}" value="{{$val1}}" class="border-none w-full bg-sky-50"> --}}
    </div>
    <div class="w-2/5 h-full flex items-center">
        <input type="number" name="{{$name2}}" value="{{$val2}}" class="border-none  w-9/12 text-right bg-sky-50">
        <span class="block pl-1 w-3/12 text-left text-xs">{{$unit}}</span>
    </div>

    {{-- <div class="w-2/5 h-full my-1 pr-1 mr-1 border-r">
        <input type="text" name="{{$name1}}" value="{{$val1}}" class="border-none text-xs w-full h-full px-4 py-1">
    </div>
    <div class="w-3/5 my-1 flex items-center h-full">
        <input type="number" name="{{$name2}}" value="{{$val2}}" class="text-right w-9/12 border-none text-xs h-full px-4 py-1">
        <span class="block ml-1 w-3/12 text-left h-full">{{$unit}}</span>
    </div> --}}
</div>

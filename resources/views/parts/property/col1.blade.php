@php
    $val = "";
    if(isset($value)){
        $val = $value;
    }
@endphp
<div class="w-full flex items-center mb-5 text-sm">
    <label class="w-1/5">{{$title}}</label>
    @if (isset($type) && $type === 'textarea')
        <textarea name="{{$name}}" cols="30" rows="10"  class="w-4/5 rounded text-sm border-gray-400">{{$val}}</textarea>
    @elseif (isset($type) && $type === 'number')
        <div class="w-4/5 flex items-center">
            <input name="{{$name}}" type="number" id="{{$name}}" class="rounded mr-3 text-sm border-gray-400" value="{{$val}}">
            <span class="mr-5">㎡</span>
            <div class="land_area_tubo w-1/5 text-right mr-1"></div>
            <span>坪</span>
        </div>
    @else
        <input name="{{$name}}" type="text" class="w-4/5 text-sm rounded border-gray-400" value="{{$val}}">
    @endif
</div>

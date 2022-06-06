@php
    $class = 'border-b';
    if(isset($last)){
        $class = "";
    }
@endphp
<div class="flex items-center py-1 px-1 {{$class}}">
    <p class="w-1/5 text-left">{{$title}}</p>
    <div class="w-2/5 flex items-center">
        <input id="m-{{$name}}" type="number" name="{{$name}}" value="{{$project->$name}}" class="border-none w-2/3 text-xs h-full px-4 py-1">
        <span>㎡</span>
    </div>
    <div class="w-2/5 flex items-center">
        <p class="border-none w-2/3 text-xs h-full px-4 py-1" id="t-{{$name}}"></p>
        <span>坪</span>
    </div>
</div>

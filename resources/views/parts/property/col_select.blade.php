@php
    $val = "";
    if(isset($value)){
        $val = $value;
    }
@endphp
<div class="w-full flex items-center mb-5 text-sm">
    <label class="w-1/5">{{$title}}</label>
    <select name="{{$name}}" id="{{$name}}" class="w-4/5 text-sm rounded border-gray-400">
        <option value="">選択してください</option>
        @foreach ($items as $item)
            <option value="{{$item}}" {{$item == $val ? 'selected' : ''}}>{{$item}}</option>
        @endforeach
    </select>
</div>

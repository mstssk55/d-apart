@php
    $head_class = "text-left";
    if(isset($right)){
        $head_class = "text-right text-sm";
    }
@endphp
<tr class="w-full">
    <th class="w-1/3 px-2 py-1 border {{$head_class}} font-normal bg-gray-100 text-sm">
        {{$title}}
        @if(isset($calc) && $calc ==0)
            <span class="btn_calc inline-block cursor-pointer" data-id="{{$id}}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 0h-288C22.38 0 0 22.38 0 48v416C0 489.6 22.38 512 48 512h288c25.62 0 48-22.38 48-48v-416C384 22.38 361.6 0 336 0zM64 208C64 199.2 71.2 192 80 192h32C120.8 192 128 199.2 128 208v32C128 248.8 120.8 256 112 256h-32C71.2 256 64 248.8 64 240V208zM64 304C64 295.2 71.2 288 80 288h32C120.8 288 128 295.2 128 304v32C128 344.8 120.8 352 112 352h-32C71.2 352 64 344.8 64 336V304zM224 432c0 8.801-7.199 16-16 16h-128C71.2 448 64 440.8 64 432v-32C64 391.2 71.2 384 80 384h128c8.801 0 16 7.199 16 16V432zM224 336c0 8.801-7.199 16-16 16h-32C167.2 352 160 344.8 160 336v-32C160 295.2 167.2 288 176 288h32C216.8 288 224 295.2 224 304V336zM224 240C224 248.8 216.8 256 208 256h-32C167.2 256 160 248.8 160 240v-32C160 199.2 167.2 192 176 192h32C216.8 192 224 199.2 224 208V240zM320 432c0 8.801-7.199 16-16 16h-32c-8.799 0-16-7.199-16-16v-32c0-8.801 7.201-16 16-16h32c8.801 0 16 7.199 16 16V432zM320 336c0 8.801-7.199 16-16 16h-32c-8.799 0-16-7.199-16-16v-32C256 295.2 263.2 288 272 288h32C312.8 288 320 295.2 320 304V336zM320 240C320 248.8 312.8 256 304 256h-32C263.2 256 256 248.8 256 240v-32C256 199.2 263.2 192 272 192h32C312.8 192 320 199.2 320 208V240zM320 144C320 152.8 312.8 160 304 160h-224C71.2 160 64 152.8 64 144v-64C64 71.2 71.2 64 80 64h224C312.8 64 320 71.2 320 80V144z"/></svg>
            </span>
        @elseif (isset($calc) &&$calc ==1)
            <div>
                <button type="button" class="btn_calc py-1 px-2 bg-gray-300 text-xs rounded" data-id="{{$id}}" data-num=0.03>3%</button>
                <button type="button" class="btn_calc py-1 px-2 bg-gray-300 text-xs rounded" data-id="{{$id}}" data-num=0.04>4%</button>
            </div>
        @endif
    </th>
    <td class="w-2/3 border">
        <div class="flex items-center">
            @if(!isset($type))
            <input type="number" step="0.01" onclick="this.select()" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 bg-sky-50">
            <span class="w-2/6 block text-left ml-1 {{$id}}">{{$unit}}</span>
            @else
            <p id="{{$id}}" class="text-right border-none w-4/6 pr-3">{{number_format($project->$id)}}</p>
            <span class="w-2/6 block text-left ml-1 {{$id}}">{{$unit}}</span>
            @endif
            @if (isset($tax))
            <div class="w-1/4 flex items-center">
                <p class="text-right border-none w-3/4">{{number_format(round($project->$id *1.1))}}</p>
                <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
            </div>

            @endif
        </div>
    </td>
</tr>

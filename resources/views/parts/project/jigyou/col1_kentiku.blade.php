<tr class="w-full">
<th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">
    {{$title}}
    <span class="btn_calc inline-block cursor-pointer" data-id="{{$id}}">
        @if ($title == "建築本体費（坪）" ||$title == "解体費用（坪）")
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256c0 141.4 114.6 256 256 256s256-114.6 256-256C512 114.6 397.4 0 256 0zM382.6 302.6l-103.1 103.1C270.7 414.6 260.9 416 256 416c-4.881 0-14.65-1.391-22.65-9.398L129.4 302.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 306.8V128c0-17.69 14.33-32 32-32s32 14.31 32 32v178.8l49.38-49.38c12.5-12.5 32.75-12.5 45.25 0S395.1 290.1 382.6 302.6z"/></svg>
        @else
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256c0 141.4 114.6 256 256 256s256-114.6 256-256C512 114.6 397.4 0 256 0zM382.6 254.6c-12.5 12.5-32.75 12.5-45.25 0L288 205.3V384c0 17.69-14.33 32-32 32s-32-14.31-32-32V205.3L174.6 254.6c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l103.1-103.1C241.3 97.4 251.1 96 256 96c4.881 0 14.65 1.391 22.65 9.398l103.1 103.1C395.1 221.9 395.1 242.1 382.6 254.6z"/></svg>
        @endif
    </span>
</th>
<td class="w-2/3 border">
    <div class="flex items-center">
        <div class="w-3/4 flex items-center">
            <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-3/4 bg-sky-50">
            <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
        </div>
        <div class="w-1/4 flex items-center">
            <p class="text-right border-none w-3/4">{{number_format(round($project->$id *1.1))}}</p>
            <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
        </div>
    </div>
</td>
</tr>

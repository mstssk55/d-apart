<tr class="w-full">
<th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100 text-left">{{$title}}</th>
<td class="w-2/3 border">
    <div class="flex items-center">
        <div class="w-3/4 flex items-center">
            <input type="number" id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-3/4 bg-sky-50">
            <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
        </div>
        @if (isset($type))
            <div class="w-1/4 flex items-center">
                <p class="text-right border-none w-3/4">{{number_format(round($project->$id *1.1))}}</p>
                <span class="w-1/4 block text-left ml-1 {{$id}}">{{$unit}}</span>
            </div>
        @endif
    </div>
    {{-- <div class="flex items-center">
        <input id="{{$id}}" name="{{$id}}" value="{{$project->$id}}" class="text-right border-none w-4/6 h-full bg-sky-50">
        <span class="w-2/6 block text-left ml-1">{{$unit}}</span>
    </div> --}}
</td>
</tr>

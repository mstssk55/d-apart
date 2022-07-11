@php
    $insert_unit = "";
    if(isset($unit)){
        $insert_unit = $unit;
    }
@endphp
<tr class="w-full">
    <th class="bg-gray-100 w-1/3 px-2 py-1 border text-left font-normal">{{$title}}</th>
    @if ($title == "物件名")
        <td class="w-2/3 border px-4 py-1"><a href="{{ route('propertyDetail', ['id' => $project->property->id]) }}">{{$val}} <span>{{$insert_unit}}</span></a></td>
    @elseif($title == "交通")
        <td class="w-2/3 border px-4 py-1">
            @foreach ($val as $station)
                <div class="flex">
                    <p class="mr-2">{{$station->route}}</p>
                    <p class="mr-2">{{$station->station}}</p>
                    <p><span>徒歩</span> {{$station->time}} <span>分</span></p>
                </div>
            @endforeach
        </td>
    @elseif($title == "道路")
        <td class="w-2/3 border px-4 py-1">
            @foreach ($val as $road)
                <div class="flex">
                    <p class="mr-2">{{$road->road_kind}}</p>
                    <p class="mr-2">{{$road->direction}}</p>
                    <p>{{$road->length}} <span>m</span></p>
                </div>
            @endforeach
        </td>
    @else
        <td class="w-2/3 border px-4 py-1">{{$val}} <span>{{$insert_unit}}</span></td>
    @endif
</tr>

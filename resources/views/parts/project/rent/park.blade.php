<tr>
    <td class="border px-2 py-1"><p class="w-full text-center border-none text-xs h-full px-4 py-1">{{$park_count + 1}}</p></td>
    <td class="border px-2 py-1"><p class="w-full text-center border-none text-xs h-full px-4 py-1">{{$park->plan}}</p></td>
    <td class="border px-2 py-1"><p class="w-full text-center border-none text-xs h-full px-4 py-1">{{$park->count}}</p></td>
    <td class="border px-2 py-1"><p class="w-full text-center border-none text-xs h-full px-4 py-1">{{number_format($park->fee)}}</p></td>
    <td class="border px-2 py-1"><p class="w-full text-center border-none text-xs h-full px-4 py-1">{{number_format($park->count*$park->fee)}}</p></td>
</tr>

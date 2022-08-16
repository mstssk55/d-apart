<tr class="w-full">
    <td colspan="2" class="w-2/12 border_inner border_top_none text-center">{{$ttl}}</td>
    @foreach ($vals as $val)
        <td class="w-1/12 border_inner text-right border_top_none">{{number_format($val)}}</td>
    @endforeach
</tr>

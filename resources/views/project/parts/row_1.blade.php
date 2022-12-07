<tr class="w-full">
    <td style="width:16.6%" colspan="2" class="w-2/12 border_inner border_top_none text-center">{{$ttl}}</td>
    @foreach ($vals as $val)
        <td style="width:8.3%" class="w-1/12 border_inner text-right border_top_none">{{number_format($val)}}</td>
    @endforeach
</tr>

{{-- @php
    $fee = $id.'_fee';
@endphp --}}
{{-- <tr class="w-full">
<th class="w-1/3 px-2 py-1 border  font-normal bg-gray-100">{{$title}}</th> --}}
{{-- <td class="w-2/3 border"> --}}
    <div class="flex items-center">
        <div class="w-5/12">
            <input type="text" id="{{$name1}}" name="{{$name1}}" value="{{$val1}}" class="text-left border-none bg-sky-50">
        </div>
        <div class="w-5/12 flex items-center">
            <input type="number" id="{{$name2}}" name="{{$name2}}" value="{{$val2}}" class="text-right border-none w-3/4 bg-sky-50">
            <span class="w-1/4 block text-left ml-1">円</span>
        </div>
        <div class="w-2/12 flex items-center">
            <p class="text-right border-none w-3/4">{{number_format(round($val2 *1.1))}}</p>
            <span class="w-1/4 block text-left ml-1">円</span>
        </div>
    </div>
{{-- </td> --}}
{{-- </tr> --}}

<x-app-layout>
    @include('parts.property.station')
    @php
        $stations = json_encode(stations());
        $lines = json_encode(lines())
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <style>
                        input[type="number"]::-webkit-outer-spin-button,
                        input[type="number"]::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                    </style>

<div>
    <div class="">
        <div class="max-w-3xl mx-auto">
            <form  action={{route('propertyStore')}} method="POST">
                {{ csrf_field() }}
                @include('parts.property.col1',['title'=>'物件名','name'=>'name'])
                @include('parts.property.col1',['title'=>'所在地','name'=>'address'])
                <div class="w-full flex items-center mb-5 text-sm">
                    <label class="w-1/5">新築中古区分</label>
                    <select name="category" id="" class="w-4/5 text-sm rounded border-gray-400">
                        <option value="">選択して下さい</option>
                        <option value="新築">新築</option>
                        <option value="中古">中古</option>
                    </select>
                </div>

                <div class="w-full flex items-center mb-5">
                    <label for="" class="w-1/5 flex items-center text-sm">
                        交通
                        <svg xmlns="http://www.w3.org/2000/svg" class="add_button_access ml-2 cursor-pointer h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </label>
                    <div class="add_access">
                        <div class="flex items-center text-sm mb-2">
                            <select id="route_0" name="route_0" class="w-1/3 mr-1 rounded text-sm border-gray-400 select_route">
                                <option value="">路線を選択</option>
                                @foreach (lines() as $line)
                                    <option value="{{$line}}">{{$line}}</option>
                                @endforeach
                            </select>
                            <select id="station_0" name="station_0" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                                <option value="">駅名を選択</option>
                            </select>
                            {{-- <input id="route" name="route_0" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400"> --}}
                            {{-- <input id="station" name="station_0" type="text" class="w-1/3 mr-2 rounded text-sm border-gray-400"> --}}
                            <span class="mr-2">徒歩</span>
                            <input id="time_0" name="time_0" type="number" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                            <span>分</span>
                        </div>
                    </div>
                    <input type="hidden" value="0" name="count_access" id="count_access">
                </div>
                @include('parts.property.col1',['title'=>'地積','name'=>'land_area','type'=>'number'])
                @include('parts.property.col1',['title'=>'地目','name'=>'ground'])
                {{-- @include('parts.property.col1',['title'=>'都市計画','name'=>'city_planning']) --}}
                @include('parts.property.col_select',['title'=>'都市計画','name'=>'city_planning',"items"=>city_plan()])
                {{-- @include('parts.property.col1',['title'=>'用途地域','name'=>'use_district']) --}}
                @include('parts.property.col_select',['title'=>'用途地域','name'=>'use_district',"items"=>youto_area()])


                <div class="w-full flex items-center mb-5 text-sm">
                    <label for="building_coverage_ratio" class="w-1/5">建ぺい率／容積率</label>
                    <div class="flex items-center">
                        <input name="building_coverage_ratio" type="number" class="w-2/5 mr-3 rounded text-sm border-gray-400">
                        <span class="w-1/5 mr-3 text-sm">%</span>
                        <span class="w-1/5 mr-3 text-sm">／</span>
                        <input name="floor_area_ratio" type="number" class="w-2/5 mr-3 text-sm rounded border-gray-400">
                        <span class="w-1/5 text-sm">%</span>
                    </div>
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="" class="w-1/5 flex items-center text-sm">
                        道路
                        <svg xmlns="http://www.w3.org/2000/svg" class="add_button_road ml-2 cursor-pointer h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </label>
                    <div class="add_road">
                        <div class="flex items-center text-sm mb-2">
                            <input id="road_kind" name="road_kind_0" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                            <input id="direction" name="direction_0" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                            <input id="length" name="length_0" type="number" step="0.01" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                            <span>m</span>
                        </div>
                    </div>
                    <input type="hidden" value="0" name="count_road" id="count_road">
                </div>

                @include('parts.property.col1',['title'=>'備考','name'=>'text','type'=>'textarea'])

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保存する</button>
                </div>
            </form>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
    <script>
        $('#land_area').on('change',function(){
            $('.land_area_tubo').text(($(this).val() * 0.3025).toFixed(2));
        })
        $('body').on('change','.select_route',function(){
            const num = this.id.split('_')[1]
            const id = "#station_" + num
            console.log(id)
            $(id).empty()
            $(id).append(`<option value="">駅名を選択</option>`)
            const station = JSON.parse(@json($stations))[$(this).val()];
            station.forEach(element => {
                $(id).append(`<option value="${element}">${element}</option>`)
            });
        })
        function add_button(kind,name1,name2,name3){
            $('.add_button_'+kind).on('click',function(){
                let number = Number($('#count_'+kind).val()) + 1
                let insert = ""

                if(kind == "access"){
                    const line = JSON.parse(@json($lines));
                    let insert_line = "";
                    line.forEach(element => {
                        insert_line +=`<option value="${element}">${element}</option>`
                    });
                    insert = `<div class="flex items-center text-sm mb-2">
                            <select id="${name1}_${number}" name="${name1}_${number}" class="w-1/3 mr-1 rounded text-sm border-gray-400 select_route">
                                <option value="">路線を選択</option>
                                ${insert_line}
                            </select>
                            <select id="${name2}_${number}" name="${name2}_${number}" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                                <option value="">駅名を選択</option>
                            </select>
                            <span class="mr-2">徒歩</span>
                            <input id="${name3}" name="${name3}_${number}" type="text" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                            <span>分</span>
                        </div>`;
                }else{
                    insert = `<div class="flex items-center text-sm mb-2">
                            <input id="${name1}" name="${name1}_${number}" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                            <input id="${name2}" name="${name2}_${number}" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                            <input id="${name3}" name="${name3}_${number}" type="number" step="0.01" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                            <span>m</span>
                        </div>`;
                }

                $('.add_'+kind).append(insert);
                $('#count_'+kind).val(number)
            })
        }
        add_button("access","route","station","time")
        add_button("road","road_kind","direction","length")

    </script>
</x-app-layout>

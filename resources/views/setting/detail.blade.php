<x-app-layout>
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
                            <div class="">
                                @include('parts.project.h2',['title'=>'設定'])
                                <div class="flex">
                                    <div class="w-1/4 mr-3">
                                        @include('parts.project.h3',['title'=>'構造'])
                                        <form action="{{route('constructionStore')}}" method="POST" class="mt-2 mb-4">
                                            {{ csrf_field() }}
                                            <input type="text" name="cr_name" class="rounded mr-3 text-sm border-gray-400">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">追加</button>
                                        </form>
                                        <div>
                                            @foreach ($crs as $cr)
                                                <div class="flex items-center justify-between border-b pb-1 mb-1">
                                                    <p>{{$cr->name}}</p>
                                                    <form action="{{route('constructionDelete',['id'=>$cr->id])}}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="ml-1 text-xs">削除</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="w-1/4 mr-3">
                                        @include('parts.project.h3',['title'=>'間取り'])
                                        <form action="{{route('layoutStore')}}" method="POST" class="mt-2 mb-4">
                                            {{ csrf_field() }}
                                            <input type="text" name="cr_name" class="rounded mr-3 text-sm border-gray-400">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">追加</button>
                                        </form>
                                        <div>
                                            @foreach ($layouts as $layout)
                                                <div class="flex items-center justify-between border-b pb-1 mb-1">
                                                    <p>{{$layout->name}}</p>
                                                    <form action="{{route('layoutDelete',['id'=>$layout->id])}}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="ml-1 text-xs">削除</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                {{-- <form  action={{route('propertyStore')}} method="POST">
                                    {{ csrf_field() }}
                                    @include('parts.property.col1',['title'=>'物件名','name'=>'name'])
                                    @include('parts.property.col1',['title'=>'所在地','name'=>'address'])
                                    @include('parts.property.col1',['title'=>'新築中古区分','name'=>'category'])
                                    <div class="w-full flex items-center mb-5">
                                        <label for="" class="w-1/5 flex items-center text-sm">
                                            交通
                                            <svg xmlns="http://www.w3.org/2000/svg" class="add_button_access ml-2 cursor-pointer h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </label>
                                        <div class="add_access">
                                            <div class="flex items-center text-sm mb-2">
                                                <input id="route" name="route_0" type="text" class="w-1/3 mr-1 rounded text-sm border-gray-400">
                                                <input id="station" name="station_0" type="text" class="w-1/3 mr-2 rounded text-sm border-gray-400">
                                                <span class="mr-2">徒歩</span>
                                                <input id="time" name="time_0" type="number" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                                                <span>分</span>
                                            </div>
                                        </div>
                                        <input type="hidden" value="0" name="count_access" id="count_access">
                                    </div>
                                    @include('parts.property.col1',['title'=>'地積','name'=>'land_area','type'=>'number'])
                                    @include('parts.property.col1',['title'=>'地目','name'=>'ground'])
                                    @include('parts.property.col1',['title'=>'都市計画','name'=>'city_planning'])
                                    @include('parts.property.col1',['title'=>'用途地域','name'=>'use_district'])


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
                                                <input id="length" name="length_0" type="number" class="w-1/6 mr-2 rounded text-sm border-gray-400">
                                                <span>m</span>
                                            </div>
                                        </div>
                                        <input type="hidden" value="0" name="count_road" id="count_road">
                                    </div>

                                    @include('parts.property.col1',['title'=>'備考','name'=>'text','type'=>'textarea'])

                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保存する</button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

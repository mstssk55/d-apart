<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

<div>
    <div class="">
        <div class="max-w-3xl mx-auto">
            <form  action={{route('propertyStore')}} method="POST">
                {{ csrf_field() }}
                <div class="w-full flex items-center mb-5">
                    <label for="name" class="w-1/5">館名</label>
                    <input id="name" name="name" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="address" class="w-1/5">所在地</label>
                    <input id="address" name="address" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="category" class="w-1/5">新築中古区分</label>
                    <input id="category" name="category" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="open_date" class="w-1/5">完成予定</label>
                    <input id="open_date" name="open_date" type="date" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="start_date" class="w-1/5">家賃送金開始日</label>
                    <input id="start_date" name="start_date" type="date" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="" class="w-1/5">交通</label>
                    <div class="flex">
                        <input id="route" name="route" type="text" class="w-1/3">
                        <input id="station" name="station" type="text" class="w-1/3">
                        <input id="time" name="time" type="text" class="w-1/3">
                    </div>
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="land_area" class="w-1/5">地積</label>
                    <input id="land_area" name="land_area" type="number" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="ground" class="w-1/5">地目</label>
                    <input id="ground" name="ground" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="city_planning" class="w-1/5">都市計画</label>
                    <input id="city_planning" name="city_planning" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="use_district" class="w-1/5">用途地域</label>
                    <input id="use_district" name="use_district" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="building_coverage_ratio" class="w-1/5">建ぺい率</label>
                    <input id="building_coverage_ratio" name="building_coverage_ratio" type="number" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="floor_area_ratio" class="w-1/5">容積率</label>
                    <input id="floor_area_ratio" name="floor_area_ratio" type="number" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="road" class="w-1/5">道路</label>
                    <input id="road" name="road" type="text" class="w-4/5">
                </div>
                <div class="w-full flex items-center mb-5">
                    <label for="text" class="w-1/5">備考</label>
                    <textarea name="text" id="text" cols="30" rows="10"  class="w-4/5"></textarea>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>

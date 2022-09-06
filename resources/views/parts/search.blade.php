<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
        <div class="flex pt-6 pl-8 items-center mb-5">
            <h2 class="text-lg mr-5">絞り込み</h2>
        </div>
        <div class="px-8 mb-6">
            <form action={{route($route)}} method="POST" class="flex items-end">
                {{ csrf_field() }}
                <div class="w-3/12 mr-3">
                    <p class="mb-2">作成者</p>
                    <select name="search_user" id="" class="w-full border-gray-400 rounded">
                        <option value="">選択してください</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" {{ $user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                @if(Request::is('list') or Request::is('list/search') )
                    <div class="w-4/12">
                        <p class="mb-2">物件</p>
                        <select name="search_property" id="" class="w-full border-gray-400 rounded">
                            <option value="">物件で絞り込む</option>
                            @foreach ($properties as $property)
                                <option value="{{$property->id}}"  {{ $property_id == $property->id ? 'selected' : '' }}>{{$property->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif (Request::is('property/list') or Request::is('property/list/search'))
                @endif
                <button type="submit" class="w-2/12 bg-cyan-600 hover:bg-cyan-700 rounded py-2 text-white ml-3">検索する</button>
                @php
                    $reset = "/";
                    if(Request::is('list') or Request::is('list/search')){
                        $reset = "/list";
                    }elseif(Request::is('property/list') or Request::is('property/list/search')){
                        $reset = "/property/list";
                    }
                @endphp
                <a href="{{$reset}}" class="block text-center w-2/12 bg-white hover:bg-gray-200 rounded py-2 text-gray-500 ml-3 border border-gray-500">リセットする</a>
            </form>
        </div>
    </div>
</div>

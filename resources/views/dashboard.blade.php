<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg mb-5">新規収支計画作成</h2>
                    <div>
                        <form  action={{route('projectNew')}} method="POST">
                            {{ csrf_field() }}
                            <div class="flex items-center w-full">
                                <div class="w-1/4 mr-3">
                                    <select name="id" id="" class="w-full">
                                        <option hidden>物件を選択してください</option>
                                        @foreach ($property_list as $property)
                                            <option value="{{$property->id}}">{{$property->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="w-2/4 mr-3">
                                    <input type="text" name="name" placeholder="タイトルを入力して下さい" class="w-full">
                                </div> --}}
                                <div><button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">新規作成する</button></div>
                            </div>
                        </form>
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        @if ($errors->has('id'))
                            <div class="text-red-500 mt-2">
                                ※物件の選択は必須です。
                            </div>
                        @endif


                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="flex pt-6 pl-8 items-center mb-5">
                    <h2 class="text-lg mr-5">収支一覧</h2>
                    <a href="{{route('projectList')}}">すべてを見る</a>
                </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th scope="col" class="w-5/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    タイトル
                                </th>
                                <th scope="col" class="w-4/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    物件名
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    更新日
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    作成日
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    作成者
                                </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($projects as $project)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a class="block" href="{{ route('projectDetail', ['id' => $project->id]) }}">
                                            <p>{{$project->name}}</p>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p>{{$project->property->name}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$project->updated_at}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$project->created_at}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$project->user->name}}</p>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex pt-6 pl-8 items-center mb-5">
                    <h2 class="text-lg mr-5">物件一覧</h2>
                    <a href="{{route('propertyList')}}">すべてを見る</a>
                </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th scope="col" class="w-5/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    物件名
                                </th>
                                <th scope="col" class="w-5/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    住所
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    作成日
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    作成者
                                </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($properties as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a class="block" href="{{ route('propertyDetail', ['id' => $property->id]) }}">
                                            <p>{{$property->name}}</p>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p>{{$property->address}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$property->created_at}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$property->user->name}}</p>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>

        </div>
    </div>
</x-app-layout>

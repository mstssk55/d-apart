<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @include('parts.search',["route"=>"projectSearch"])
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="flex pt-6 pl-8 items-center mb-5">
                    <h2 class="text-lg mr-5">収支一覧</h2>
                </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th scope="col" class="w-4/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    タイトル
                                </th>
                                <th scope="col" class="w-4/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    物件名
                                </th>
                                <th scope="col" class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    物件番号
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
                                            <p>{{Str::limit($project->name, 20)}}</p>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p>{{Str::limit($project->property->name, 20)}}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        <p>{{$project->project_cat."-".$project->project_type}}</p>
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
            {!! $projects->links() !!}

        </div>
    </div>
</x-app-layout>

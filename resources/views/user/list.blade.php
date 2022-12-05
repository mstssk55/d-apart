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
                                @include('parts.project.h2',['title'=>'ユーザー追加'])
                                <div class="flex">
                                    <form action="{{route('constructionStore')}}" method="POST" class="mt-2 mb-4" autocomplete="off">
                                        {{ csrf_field() }}
                                        <input type="email" id="newemail" name="newemail" autocomplete="off" placeholder="メールアドレス" class="rounded mr-3 text-sm border-gray-400">
                                        <input type="password" id="newpassword" name="newpassword" autocomplete="new-password" placeholder="パスワード" class="rounded mr-3 text-sm border-gray-400">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">追加</button>
                                    </form>

                                </div>

                            </div>
                            <div class="">
                                @include('parts.project.h2',['title'=>'ユーザー一覧'])
                                <div class="flex">

                                    @foreach ($users as $user)
                                        <p>{{$user->name}}</p>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // const form1 = document.getElementById('newemail')
        // form1.value = ""
    </script>
</x-app-layout>

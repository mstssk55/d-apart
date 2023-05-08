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
                                    <form action="{{route('userStore')}}" method="POST" class="mt-2 mb-4" autocomplete="off">
                                        {{ csrf_field() }}
                                        <input type="text" id="newname" name="newname" autocomplete="off" placeholder="名前" class="rounded mr-3 text-sm border-gray-400">
                                        <input type="email" id="newemail" name="newemail" autocomplete="off" placeholder="メールアドレス" class="rounded mr-3 text-sm border-gray-400">
                                        <input type="password" id="newpassword" name="newpassword" autocomplete="new-password" placeholder="パスワード" class="rounded mr-3 text-sm border-gray-400">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">追加</button>
                                    </form>

                                </div>

                            </div>
                            <div class="">
                                @include('parts.project.h2',['title'=>'ユーザー一覧'])
                                <div class="max-w-[700px]">
                                    @foreach ($users as $user)
                                        <div class="flex items-center justify-between border-b pb-1 mb-1">
                                            <p class="w-5/12">{{$user->name}}</p>
                                            <p class="w-5/12">{{$user->is_admin === 0 ? "一般" : "管理者"}}</p>
                                            <form id="delete-form-{{$user->id}}" class="w-2/12" action="{{route('userDelete',['id'=>$user->id])}}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="button" onclick="deleteUser({{$user->id}},'{{$user->name}}')" class="ml-1 text-xs">削除</button>
                                            </form>
                                        </div>
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
        function deleteUser(userId,userName) {
            if (confirm(userName + 'を削除しますか？')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
</x-app-layout>

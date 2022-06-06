<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <div class="py-5">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="">
                        <div class="flex">
{{--------------------------- 物件概要 -----------------------------------------------}}
                            <div class="w-4/12 text-center mr-1">
                                <h2>a</h2>
                                <table class="table-fixed w-full">
                                    <tbody class="text-sm">
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">所在地</th>
                                            <td class="w-3/5 border px-4 py-1">Adam</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">新築中古区分</th>
                                            <td class="w-3/5 border px-4 py-1">Adam</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">完成予定</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">家賃送金開始日</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">館名</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">交通</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">地積</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">地目</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">都市計画</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">用途地域</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">建ぺい率/容積率</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">道路</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>
                                        <tr>
                                            <th class="w-2/5 px-4 py-1 border text-left font-normal">備考</th>
                                            <td class="w-3/5 border px-4 py-1">Chris</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
{{--------------------------- 基礎情報 -----------------------------------------------}}
                            <div class="w-4/12 text-center mr-1">
                                <h2>a</h2>
                                <table class="table-fixed w-full">
                                    {{-- <thead>
                                        <th class="border" colspan ="2">賃金、借入金内訳</th>
                                    </thead> --}}
                                    <tbody class="text-sm w-full">
                                        <tr  class="w-full" class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">借入金</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 h-full px-4 py-1"><span class="w-1/6">円</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">自己資金</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">円</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">総事業合計</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">円</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">返済方法</th>
                                            <td class="w-4/5 border">
                                                <select name="" id="" class="border-none w-full h-full px-4 py-1">
                                                    <option value="">選択してください</option>
                                                    <option value="元利均等">元利均等</option>
                                                    <option value="元金均等">元金均等</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">借入期間</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">年</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">措置期間</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">か月</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">借入金利</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">％</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">諸費用合計</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">円</span></td>
                                        </tr>
                                        <tr  class="w-full">
                                            <th class="w-1/5 px-2 py-1 border text-left font-normal">月学返済額</th>
                                            <td class="w-4/5 border"><input type="number" class="border-none w-5/6 w-full h-full px-4 py-1"><span class="w-1/6">円</span></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                            <div class="w-4/12 text-center">
                                <h2>a</h2>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

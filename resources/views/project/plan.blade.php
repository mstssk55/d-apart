<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @php
        $roop = 10;
        $start_num = 1;
        $start_year = 2021;
    @endphp
    <div class="px-5">
        <section class="flex">
            <div class="head_add w-1/3">
                <p>a</p>
                <p></p>
            </div>
            <div class="head_ttl w-1/3 text-center">
                <h2>収支計算表</h2>
            </div>
            <div class="head_info w-1/3">
                <table class="w-full">
                    <tbody class="w-full">
                        <tr class="w-full">
                            <td class="w-1/4">顧客名</td>
                            <td colspan="3" class="w-3/4">{{$project->client}}</td>
                        </tr>
                        <tr class="w-full">
                            <td class="w-1/4">金利</td>
                            <td class="w-1/4">{{$project->interest_rate}}<span>%</span></td>
                            <td class="w-1/4">借入期間</td>
                            <td class="w-1/4">{{$project->borrowing_period}}<span>年</span></td>
                        </tr>
                        <tr class="w-full">
                            <td class="w-1/4">銀行返済開始日</td>
                            <td class="w-1/4">{{$project->return_debt_date}}</td>
                            <td class="w-1/4">据置期間</td>
                            <td class="w-1/4">{{$project->deferred_period}}<span>ヶ月</span></td>
                        </tr>
                        <tr class="w-full">
                            <td class="w-1/4">家賃送金開始日</td>
                            <td class="w-1/4">{{$project->start_date}}</td>
                            <td class="w-1/4">返済方法</td>
                            <td class="w-1/4">{{$project->repayment_method}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="">
            @include("project.parts.table",["project"=>$project,"roop"=>$roop,"start_num"=>$start_num,"start_year"=>$start_year])
        </div>
    </div>
</x-app-layout>

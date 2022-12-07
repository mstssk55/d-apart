<html lang="ja">
    <head>
        <title>pdf output test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            @font-face {
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
            }
            body {
                font-family: migmix;
                line-height: 100%;
                font-size: 10px
            }
            .main_image {
                width: 100%;
                text-align: center;
                margin: 10px 0;
            }
            .main_image img{
                width: 90%;
            }
            .sushiTable {
                border: 1px solid #000;
                border-collapse: collapse;
                width: 50%;
            }
            .sushiTable tr th{
                background: #87cefa;
                padding: 5px;
                border: 1px solid #000;
            }
            .sushiTable tr td{
                padding: 5px;
                border: 1px solid #000;
            }

        </style>
    </head>
    <body>
        PDFの出力テスト！<br>
        <div style="font-weight:bold">ここは太字！</div>
        <div class="main_image">
            <img src="https://codelikes.com/wp-content/uploads/2019/06/PHP-e1601051806241.jpg" />
        </div>
        お寿司のテーブル
        {{-- <table class="sushiTable">
            <tr>
                <th>名前</th>
                <th>価格</th>
            </tr>
            @foreach ($sushiTable as $key => $value)
            <tr>
                <td>{{ $key }}</td><td>{{ $value }}</td>
            </tr>
            @endforeach
        </table> --}}

<div style="grid-template-columns: repeat(3, minmax(0, 1fr));" class="grid grid-cols-3 gap-4">
    <div>a</div>
    <div>b</div>
    <div>c</div>
</div>
    </body>
</html>

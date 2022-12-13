@php
    function city_plan(){
        $city=[
            "市街化区域",
            "市街化調整区域",
            "非線引区域",
            "準都市計画区域",
            "都市計画区域外",
        ];
        return $city;
    }
    function load_kind(){
        $kind=[
            "公道",
            "私道",
        ];
        return $kind;
    }
    function load_direction(){
        $direction=[
            "北",
            "南",
            "西",
            "東",
            "北東",
            "北西",
            "南東",
            "南西",
        ];
        return $direction;
    }
    function youto_area(){
        $city=[
            "第一種低層住居専用地域",
            "第二種低層住居専用地域",
            "第一種中高層住居専用地域",
            "第二種中高層住居専用地域",
            "第一種住居地域",
            "第二種住居地域",
            "準住居地域",
            "近隣商業地域",
            "商業地域",
            "準工業地域",
            "工業地域",
            "工業専用地域",
    ];
        return $city;
    }

    function lines(){
        $lines = [
            "地下鉄東西線",
            "地下鉄東豊線",
            "地下鉄南北線",
            "札幌市電"
        ];
        return $lines;
    }

    function stations(){
        $lines = lines();
        $stations = [
            $lines[0]=>[
                "宮の沢",
                "発寒南",
                "琴似",
                "二十四軒",
                "西２８丁目",
                "円山公園",
                "西１８丁目",
                "西１１丁目",
                "大通",
                "バスセンター前",
                "菊水",
                "東札幌",
                "白石",
                "南郷７丁目",
                "南郷１３丁目",
                "南郷１８丁目",
                "大谷地",
                "ひばりが丘",
                "新さっぽろ"
            ],
            $lines[1]=>[
                "栄町",
                "新道東",
                "元町",
                "環状通東",
                "東区役所前",
                "北１３条東",
                "さっぽろ",
                "大通",
                "豊水すすきの",
                "学園前",
                "豊平公園",
                "美園",
                "月寒中央",
                "福住",
            ],
            $lines[2]=>[
                "麻生",
                "北３４条",
                "北２４条",
                "北１８条",
                "北１２条",
                "さっぽろ",
                "大通",
                "すすきの",
                "中島公園",
                "幌平橋",
                "中の島",
                "平岸",
                "南平岸",
                "澄川",
                "自衛隊前",
                "真駒内",
            ],
            $lines[3]=>[
                "西４丁目",
                "西８丁目",
                "中央区役所前",
                "西１５丁目",
                "西線６条",
                "西線９条旭山公園通",
                "西線１１条",
                "西線１４条",
                "西線１６条",
                "ロープウェイ入口",
                "電車事業所前",
                "中央図書館前",
                "石山通",
                "東屯田通",
                "幌南小学校前",
                "山鼻１９条",
                "静修学園前",
                "行啓通",
                "中島公園通",
                "山鼻９条",
                "東本願寺前",
                "資生館小学校前",
                "すすきの",
                "狸小路",
            ]
    ];

        return $stations;
    }
@endphp






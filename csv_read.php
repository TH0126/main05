<?php

$trend = array(0, 0, 0, 0, 0, 0, 0);

$L_S = array(0, 0, 0, 0, 0, 0);

$indi = array(0, 0, 0, 0, 0);

$file = fopen("csv/input.csv", "r");

flock($file, LOCK_EX);

if ($file) {
    while ($line = fgets($file)) {
        $data = explode(",", $line);

        for ($i = 1; $i < 8; $i++) {
            if ($data[0] === "parts1_" . $i . "_input") {
                $trend[$i - 1]++;
                break;
            }
        }
        for ($i = 1; $i < 7; $i++) {
            if ($data[1] === "parts2_" . $i . "_input") {
                $L_S[$i - 1]++;
                break;
            }
        }
        for ($i = 1; $i < 6; $i++) {
            if (str_replace(array("\r\n", "\r", "\n"), '', $data[2]) === "parts3_" . $i . "_input") {
                $indi[$i - 1]++;
                break;
            }
        }
    }
}

flock($file, LOCK_UN);

fclose($file);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>textファイル書き込み型todoリスト（一覧画面）</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <legend>アンケート結果</legend>
    <a href="index.php">アンケート入力画面</a>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div id="piechart2" style="width: 900px; height: 500px;"></div>
    <div id="piechart3" style="width: 900px; height: 500px;"></div>

    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);
        google.charts.setOnLoadCallback(drawChart3);

        function drawChart() {

            const data = google.visualization.arrayToDataTable([
                ['トレンド', '人数'],
                ["上昇トレンド（強）", <?= $trend[0] ?>],
                ["上昇トレンド（中）", <?= $trend[1] ?>],
                ["上昇トレンド（弱）", <?= $trend[2] ?>],
                ["下落トレンド（強）", <?= $trend[3] ?>],
                ["下落トレンド（中）", <?= $trend[4] ?>],
                ["下落トレンド（弱）", <?= $trend[5] ?>],
                ["レンジ", <?= $trend[6] ?>]
            ]);

            const options = {
                title: "どのような形のチャートが好きですか？"
            };

            const chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

        function drawChart2() {

            const data = google.visualization.arrayToDataTable([
                ['ロングかショートか', '人数'],
                ["断然ロング！！", <?= $L_S[0] ?>],
                ["ロングかなぁ？", <?= $L_S[1] ?>],
                ["ロングは苦手", <?= $L_S[2] ?>],
                ["断然ショート！！", <?= $L_S[3] ?>],
                ["ショートかなぁ？", <?= $L_S[4] ?>],
                ["ショートは苦手", <?= $L_S[5] ?>]
            ]);

            const options = {
                title: "ロングとショートどちらが好きですか？"
            };

            const chart = new google.visualization.PieChart(document.getElementById('piechart2'));

            chart.draw(data, options);
        }

        function drawChart3() {

            const data = google.visualization.arrayToDataTable([
                ['インジケーター', '人数'],
                ["ボリンジャーバンド", <?= $indi[0] ?>],
                ["ＭＡＣＤ", <?= $indi[1] ?>],
                ["ＲＳＩ", <?= $indi[2] ?>],
                ["移動平均線", <?= $indi[3] ?>],
                ["一目均衡表", <?= $indi[4] ?>]
            ]);

            const options = {
                title: "好きなインジケーターはありますか？"
            };

            const chart = new google.visualization.PieChart(document.getElementById('piechart3'));

            chart.draw(data, options);
        }
    </script>
</body>

</html>
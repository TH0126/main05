<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>条件入力</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div id="main">
        <form action="csv_create.php" method="POST" id="set">
            <a href="csv_read.php">アンケート結果画面</a>
            <div>
                <button>submit</button>
            </div>
            <p>どのような形のチャートが好きですか？（ピンクの中から選んでください。）</p>
        </form>
        <div class="wrap" id="w2">
            <div class="parts1">
                <div class="move red" id="parts1_1">
                    上昇トレンド（強）
                </div>
                <div class="move red" id="parts1_2">
                    上昇トレンド（中）
                </div>
                <div class="move red" id="parts1_3">
                    上昇トレンド（弱）
                </div>
                <div class="move red" id="parts1_4">
                    下落トレンド（強）
                </div>
                <div class="move red" id="parts1_5">
                    下落トレンド（中）
                </div>
                <div class="move red" id="parts1_6">
                    下落トレンド（弱）
                </div>
                <div class="move red" id="parts1_7">
                    レンジ
                </div>
            </div>
            <hr id="hr1">
            <div class="parts2">
                <div class="move2 green" id="parts2_1">
                    断然ロング！！
                </div>
                <div class="move2 green" id="parts2_2">
                    ロングかなぁ？
                </div>
                <div class="move2 green" id="parts2_3">
                    ロングは苦手
                </div>
                <div class="move2 green" id="parts2_4">
                    断然ショート！！
                </div>
                <div class="move2 green" id="parts2_5">
                    ショートかなぁ？
                </div>
                <div class="move2 green" id="parts2_6">
                    ショートは苦手
                </div>
            </div>
            <hr id="hr2">
            <div class="parts3">
                <div class="move3 blue" id="parts3_1">
                    ボリンジャーバンド
                </div>
                <div class="move3 blue" id="parts3_2">
                    ＭＡＣＤ
                </div>
                <div class="move3 blue" id="parts3_3">
                    ＲＳＩ
                </div>
                <div class="move3 blue" id="parts3_4">
                    移動平均線
                </div>
                <div class="move3 blue" id="parts3_5">
                    一目均衡表
                </div>
            </div>
            <hr id="hr3">
            <img src="" id="img_main">
        </div>
    </div>


    <script>
        //画面情報のすべてが読み込まれる前にいくつかの要素を隠す
        $(document).ready(function() {
            $(".parts2").hide();
            $(".parts3").hide();
            $("#hr2").hide();
            $("#hr3").hide();
            $("#img_main").hide();
        });
        //HTMLの読み込みが終わった後、処理開始
        $(window).load(function() {

            let cnt = 0;
            // ドロップした時に呼ばれる関数。
            // ドロップされたら、落とされた要素の内容を自身に追加してみる。
            function drop_callback(event, ui) { // ドロップした時に呼ばれる関数。
                $("#set").append(ui.draggable.clone()); // cloneしないと元の要素がdrop後に消える。
                for (let i = 1; i < 8; i++) {
                    if ($("#set div:last").attr("id") === "parts1_" + i) {
                        $("#set div:last").removeAttr("id");
                        $("#set div:last").attr("id", "parts1_" + i + "_input");
                    }
                }
                for (let i = 1; i < 7; i++) {
                    if ($("#set div:last").attr("id") === "parts2_" + i) {
                        $("#set div:last").removeAttr("id");
                        $("#set div:last").attr("id", "parts2_" + i + "_input");
                    }
                }
                for (let i = 1; i < 6; i++) {
                    if ($("#set div:last").attr("id") === "parts3_" + i) {
                        $("#set div:last").removeAttr("id");
                        $("#set div:last").attr("id", "parts3_" + i + "_input");
                    }
                }
                //phpのPOST用にINPUT用意
                $("#set").append('<input type="hidden" name=' + $("#set div:last").attr("id").slice(0, 6) + ' value=' + $("#set div:last").attr("id") + '>');

                //回答するたびに質問を追加
                if (cnt === 0) {
                    $("#set").append('<hr>');
                    $("#set").append('<p>ロングとショートどちらが好きですか？（緑の中から選んでください。）</p>');
                    $(".parts1").hide("slow");
                    $(".parts2").show("slow");
                    $("#hr2").show();
                } else if (cnt === 1) {
                    $("#set").append('<hr>');
                    $("#set").append('<p>好きなインジケーターはありますか？（青い中から選んでください。）</p>');
                    $(".parts2").hide("slow");
                    $("#hr2").hide();
                    $(".parts3").show("slow");
                    $("#hr3").show();
                }
                cnt++
            }

            //ドラッグ処理
            $(".move").draggable({
                helper: 'clone',
                opacity: 0.5,
                revert: "invalid"
            });
            $(".move2").draggable({
                helper: 'clone',
                opacity: 0.5,
                revert: "invalid"
            });
            $(".move3").draggable({
                helper: 'clone',
                opacity: 0.5,
                revert: "invalid"
            });
            $("#set").droppable({
                drop: drop_callback
            });

            //回答パーツに合わせた画像を表示
            const img_off = $("#img_main").attr("src");
            $("#parts1_1").hover(
                function() {
                    const img_on = img_off.replace("", "./img/UP1.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_2").hover(
                function() {
                    const img_on = img_off.replace("", "./img/UP2.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_3").hover(
                function() {
                    const img_on = img_off.replace("", "./img/UP3.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_4").hover(
                function() {
                    const img_on = img_off.replace("", "./img/DOWN1.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_5").hover(
                function() {
                    const img_on = img_off.replace("", "./img/DOWN2.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_6").hover(
                function() {
                    const img_on = img_off.replace("", "./img/DOWN3.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts1_7").hover(
                function() {
                    const img_on = img_off.replace("", "./img/range.png");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts3_1").hover(
                function() {
                    const img_on = img_off.replace("", "./img/bori.jpg");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts3_2").hover(
                function() {
                    const img_on = img_off.replace("", "./img/MACD.jpg");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts3_3").hover(
                function() {
                    const img_on = img_off.replace("", "./img/RSI.jpg");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts3_4").hover(
                function() {
                    const img_on = img_off.replace("", "./img/average.jpg");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );
            $("#parts3_5").hover(
                function() {
                    const img_on = img_off.replace("", "./img/itimoku.jpg");
                    $("#img_main").attr("src", img_on);
                    $("#img_main").show();
                },
                function() {
                    $("#img_main").attr("src", img_off);
                    $("#img_main").hide();
                }
            );



            // $('#posi').on("mousemove", function () {
            //     var left = $('#posi').css("left");
            //     var top = $('#posi').css("top");
            //     $('#left').val(left);
            //     $('#top').val(top);
            // });
        });
    </script>

</body>

</html>
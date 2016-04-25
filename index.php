<?php
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <div id="title">スライドパズル4 * 4</div>
    <canvas id="canvas" width="320" height="320"></canvas>
    <script type="text/javascript">
      //パズル画像
      var main_image = "mario.png";
      //パネルの縦横
      var main_w = 320, main_h = 320;
      //パネルの列行数
      var col_num = 4, row_num = 4;
      //パネルに該当する画像番号の配列
      var panels = [];
      //パネルブロック１個の縦横サイズ
      var panel_w = main_w / col_num, panel_h = main_h / row_num;
      //キャンバス
      var canvas = document.getElementById("canvas");

      //画像の読み込み
      var image = new Image();
      image.src = main_image;
      //2dコンテクスト
      var context = canvas.getContext("2d");

      image.onload = function() {
        //完成画像表示
        context.drawImage(image, 0, 0, main_w, main_h, 0, 0, main_w, main_h);
        //3秒後シャッフル画像を表示
        setTimeout(shufflePanel, 1000);
      }

      function shufflePanel() {

        //パネルに初期値を入れる
        for (var i = 0; i < (col_num * row_num); i++) {
          panels[i] = i;
        }

        //交換回数が偶数であればパズルを解くことができる
        for (var change = 0; change < (col_num * row_num); change++) {
          //ランダム
          var random = Math.floor(Math.random() * (col_num * row_num));

          //配列の中身を入れ替える(交換)
          var was_value  = panels[random];
          panels[random] = panels[change];
          panels[change] = was_value;
        }
        drawPanels();
      }


      function drawPanels() {
        //画像を消す
        context.clearRect(0, 0, main_w, main_h)

        for (var i = 0; i < (col_num * row_num); i++) {
          //パネル描画位置
          var show_x = (i % col_num) * panel_w;
          var show_y = Math.floor(i / 4) * panel_h;

          //パネル列行の位置
          var panel_col = panels[i] % col_num;
          var panel_row = Math.floor(panels[i] / row_num);

          //パネルのxy開始終了位置
          var panel_x = panel_col * panel_w, panel_y = panel_row * panel_h;

          //パネル１５が穴
          if (panels[i] == 15) {
            context.beginPath();
            context.fillStyle = "black";
            context.fillRect(show_x, show_y, panel_w, panel_h);
          } else {
            context.drawImage(
              image,
              panel_x, panel_y, panel_w, panel_h,
              show_x , show_y, panel_w, panel_h
            )
          }
          //枠を描画する
          context.beginPath();
          context.moveTo(show_x, show_y);
          context.lineTo(show_x + panel_w, show_y);
          context.lineTo(show_x + panel_w, show_y + panel_h);
          context.lineTo(show_x, show_y + panel_h);
          context.closePath();
          context.stroke();
        }
      }

    </script>
  </body>
</html>

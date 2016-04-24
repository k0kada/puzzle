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
      //パネルブロック１個の縦横サイズ
      var panel_w = main_w / col_num, panel_h = main_h / row_num;
      //キャンバス
      var canvas = document.getElementById("canvas");

      //画像の読み込み
      var image = new Image();
      image.src = main_image;

      image.onload = function() {
        //2dコンテクスト
        var con = canvas.getContext("2d");

con.drawImage(image, 160, 160, 240, 240, 0, 0, 80, 80);

        var panels = []
        panels = shufflePanel(panels, col_num, row_num);
console.log(panels);
       // drawPanels(con);
      }

      function shufflePanel(panels, col_num, row_num) {
        for (var i = 0; i < (col_num * row_num); i++) {
          //ランダム
          var random = Math.floor(Math.random() * 16);
          panels[i] = random;
        }
        return panels;
      }


      function drawPanels(context) {
        for (var i = 0; i < (col_num * row_num); i++) {
          //列行の位置
          var panel_col = (i + col_num) % col_num;
          var panel_row = Math.floor(i / row_num);
          //パネルのxy位置
          var panel_x = panel_col * panel_w, panel_y = panel_row * panel_h;
          context.drawImage(
            image,
            panel_x, panel_y, panel_x + panel_w, panel_y + panel_h,
            panel_x, panel_y, panel_x + panel_w, panel_y + panel_h
          )
        }
      }
    </script>
  </body>
</html>

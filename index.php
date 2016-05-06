<?php
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body id="body">
    <div id="title">スライドパズル4 * 4</div>
    <canvas id="canvas" width="320" height="320"></canvas>
    <div>完成図</div>
    <canvas id="com_canvas" width="320" height="320"></canvas>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
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
      //見本(完成図)のキャンバス
      var com_canvas = document.getElementById("com_canvas");
      //divタイトルの高さ
      var title_h = document.getElementById("title").clientHeight;
      //上下左右の座標(row, col)
      var position_arr = [[-1, 0], [1, 0], [0, -1], [0, 1]];

      //画像の読み込み
      var image = new Image();
      image.src = main_image;
      //2dコンテクスト
      var context = canvas.getContext("2d");

      var com_context = com_canvas.getContext("2d");

      image.onload = function() {
        //完成画像表示
        var com_panels = [];
        initialPanel(com_context, com_panels);
        drawPanels(com_context, com_panels);

        //シャッフル画像を表示
        shufflePanel(context, panels);
      }

      function initialPanel(con, panels) {
        for (var i = 0; i < (col_num * row_num); i++) {
          panels[i] = i;
        }
      }

      //パネルをシャッフル
      function shufflePanel(con, panels) {
        initialPanel(con, panels);

        //交換回数が偶数であればパズルを解くことができる
        for (var change = 0; change < (col_num * row_num); change++) {
          //ランダム
          var random = Math.floor(Math.random() * (col_num * row_num));

          //配列の中身を入れ替える(交換)
          var was_value  = panels[random];
          panels[random] = panels[change];
          panels[change] = was_value;
        }
        drawPanels(con, panels);
      }

      function drawPanels(con, panels) {
        //画像を消す
        con.clearRect(0, 0, main_w, main_h)

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
            con.beginPath();
            con.fillStyle = "black";
            con.fillRect(show_x, show_y, panel_w, panel_h);
          } else {
            con.drawImage(
              image,
              panel_x, panel_y, panel_w, panel_h,
              show_x , show_y, panel_w, panel_h
            )
          }
          //枠を描画する
          con.beginPath();
          con.moveTo(show_x, show_y);
          con.lineTo(show_x + panel_w, show_y);
          con.lineTo(show_x + panel_w, show_y + panel_h);
          con.lineTo(show_x, show_y + panel_h);
          con.closePath();
          con.stroke();
        }
      }

      //iphoneでのタッチ
      canvas.ontouchstart = function(event) {
        if (event.touches.length > 0) {
          var touch = e.touches[0];
          checkPanelXY(touch.x, touch.y);
        }
        event.preventDefault();
      };
      //pcでのタッチ
      canvas.onmousedown = function(event) {
        checkPanelXY(event.x, event.y);
      };

      //bodyのmarginを取得
      var margin_top = parseInt($('#body').css('margin-top'));
      var margin_left = parseInt($('#body').css('margin-left'));

      //タッチしたパネルの位置
      function checkPanelXY(x, y) {
        var col = Math.floor((x - margin_left) / panel_w);
        var row = Math.floor((y - (title_h + margin_top)) / panel_h);
        var no = row * 4 + col;
        //穴だったら何もしない
        if (panels[no] == 15) {
          return;
        }

        //選んだパネルの上下左右を調べる
        for (var i = 0; i < position_arr.length; i++) {
          var row2 = position_arr[i][0] + row;
          var col2 = position_arr[i][1] + col;

          var check = getPanelNo(row2, col2);
          if (check == 15) {
            changePanel(row, col, row2, col2);
          }
        }
      }

      //行と列からパネル番号を返す
      function getPanelNo(row, col) {
        //座標が0〜4の範囲内か判定
        if (col < 0 || row < 0 || col >= 4 || row >= 4) {
          return;
        }
        return panels[row * 4 + col];
      }

      function changePanel(select_row, select_col, hole_row, hole_col) {
        var select_no = select_row * 4 + select_col;
        var hole_no = hole_row * 4 + hole_col;
        var was_panels = panels[select_no];
        panels[select_no] = panels[hole_no];
        panels[hole_no] = was_panels;
        drawPanels(context, panels);
      }

    </script>
  </body>
</html>

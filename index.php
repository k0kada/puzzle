<?php
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <div id="title">puzzle</div>
    <canvas id="canvas" width="320" height="320"></canvas>
    <script type="text/javascript">
      //パズル画像
      var main_image = "mario.png";
      //Canvas
      var canvas = document.getElementById("canvas");

      //画像の読み込み
      var image = new Image();
      image.src = main_image;

      image.onload = function() {
        //2dコンテクスト
        var con = canvas.getContext("2d");
        con.drawImage(image, 0, 0, 320, 320, 0, 0, 320, 320);
      }
    </script>
  </body>
</html>

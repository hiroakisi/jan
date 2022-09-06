<?php
//データベース情報の指定
$db['dbname'] = "jan";  // データベース名
$db['user'] = "root";  // ユーザー名
$db['pass'] = "rootroot";  // ユーザー名のパスワード
$db['host'] = "localhost";  // DBサーバのURL

//エラーメッセージの初期化
$errorMessage = "";
//フラグの初期化
$o = false;
$user_id = array();

//dsnを作成
$dsn = sprintf('mysql:host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
try {
  //PDOを使ってMySQLに接続
  $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  //SQLを作成
  $sql_2 = "SELECT * FROM stage";
  $stmt = $pdo->query($sql_2);
  $row = $stmt->fetchAll();
  //出力結果をそれぞれの配列に格納
  $stage_list_name = array_column($row, 'stage_name');
  $stage_list_id = array_column($row, 'stage_id');

  //SQLを作成
  $sql_3 = "SELECT * FROM rank_master";
  $stmt = $pdo->query($sql_3);
  $row = $stmt->fetchAll();
  //出力結果をそれぞれの配列に格納
  $rank_list_name = array_column($row, 'rank_name');
  $rank_list_id = array_column($row, 'rank_id');
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
}
?>

<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>スコア登録</title>
  <style>
    body {
      background: lightgreen url('./janjan.jpg');
      /* background: lightgreen url('./jan.png'); */
      /* background: lightgreen ; */
      background-size: cover;
      background-repeat: no-repeat;
      margin-left: 5%;
      margin-right: 5%;
    }

    table {
      background-color: lightgreen;
      border-color: green;
      border-collapse: collapse;
      height: 20vh;
    }

    td {
      text-align: center;
    }

    input[type="text"],
    input[type="date"] {
      width: 90%;
      height: 50%;
    }

    input[type="number"] {
      width: 2vw;
    }

    /* .container {
      width: 100%;
      height: 90vh;
      display: flex;
      align-items: center;
    } */
    .container {
      margin-top: 40vh;
    }

    a.btn {
      color: #fff;
      background-color: #eb6100;
      padding: 5%;
      text-decoration: none;
    }

    .spinner-container {
      display: flex;
      justify-content: center;
      user-select: none;
      -ms-user-select: none;
      -moz-user-select: none;
      -webkit-user-select: none;
      -webkit-touch-callout: none;
    }

    .spinner {
      width: 70px;
      padding: 0;
      text-align: center;
      border: none;
      background: none;
      outline: none;
      pointer-events: none;
    }

    .spinner::-webkit-inner-spin-button,
    .spinner::-webkit-outer-spin-button {
      -webkit-appearance: none;
    }

    .spinner-sub,
    .spinner-add {
      display: block;
      width: 35px;
      height: 35px;
      text-align: center;
      border: 1px solid #000;
      border-radius: 50%;
      cursor: pointer;
      line-height: 35px;
    }

    .disabled {
      opacity: 0.3;
      cursor: inherit;
    }

    .btn-border {
      border: 2;
      background: #eee;
      border-radius: 50px;
      position: relative;
      justify-content: space-around;
      align-items: center;
      margin: 0 auto;
      padding: 1%;
      color: #313131;
      transition: 0.3s ease-in-out;
      width: 10%;
    }

    .btn-border:hover {
      padding: 1%;
      width: 10%;
      background: green;
      color: #FFF;
    }
  </style>
</head>

<body>
  <!-- <a href="./dbsample.php">スコア一覧</a> -->
  <form id="outputForm" name="outputForm" action="save_score.php" method="POST">
    <div>
      <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
    </div>
    <div class="container">
      <div style="width:100%">
        <table border="2" style="width:100%">
          <tr>
            <th>日付</th>
            <th>ランク</th>
            <th>間</th>
            <th>順位</th>
            <th>点数</th>
            <th>ツモ上がり</th>
            <th>ロン上がり</th>
            <th>ツモられ</th>
            <th>自放銃</th>
            <th>他放銃</th>
            <th>流局</th>
          </tr>

          <tr>
            <!-- <label for="username">スコア</label> -->
            <td>
              <input class="userform" type="date" min="2021-10-10" height="48">
            </td>
            <!-- <label for="order-select">順位:</label> -->
            <td style="width: 10%;">
              <select name="order" id="order-select">
                <?php for ($i = 1; $i < 5; $i++) { ?>
                  <option value=<?= $i ?>><?= $i ?></option>
                <?php } ?>
              </select>
              <!-- <label for="stage-select">間:</label> -->
            </td>
            <td style="width: 10%;">
              <select name="stage" id="stage-select">
                <option value="">----</option>
                <?php for ($i = 0; $i < count($stage_list_name); $i++) { ?>
                  <option value=<?= $stage_list_id[$i] ?>><?= $stage_list_name[$i] ?></option>
                <?php } ?>
              </select>
              <!-- <label for="rank-select">ランク:</label> -->
            </td>
            <td style="width: 10%;">
              <select name="rank" id="rank-select">
                <option value="">----</option>
                <?php for ($i = 0; $i < count($rank_list_name); $i++) { ?>
                  <option value=<?= $rank_list_id[$i] ?>><?= $rank_list_name[$i] ?></option>
                <?php } ?>
              </select>
            </td>
            <td style="width: 15%;">
              <input type="text" name="score" required size="10">
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="tumo" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="ron" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="rare" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="hoju" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="tahoju" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
            <td style="width: 7%;">
              <div class="spinner-container">
                <span class="spinner-sub disabled">-</span>
                <input class="spinner" type="number" name="ryukyoku" min="0" max="100" value="0" title="tumo">
                <span class="spinner-add">+</span>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div style="text-align: center;">
      <input class="btn-border" type="submit" id="search" name="search" value="登録">
      <a href="./dbsample.php" class="btn-border" style="border: 2px solid #000;">一覧に戻る</a>
    </div>
  </form>
  <script type="text/javascript" src="./js/jquery-3.6.1.js"></script>
  <script>
    $(function() {
      $('.spinner').each(function() {
        var el = $(this);
        var add = $('.spinner-add');
        var sub = $('.spinner-sub');

        // substract
        el.parent().on('click', '.spinner-sub', function() {
          console.log("tmp")
          if (el.val() > parseInt(el.attr('min'))) {
            el.val(function(i, oldval) {
              return --oldval;
            });
          }
          // disabled
          if (el.val() == parseInt(el.attr('min'))) {
            el.prev(sub).addClass('disabled');
          }
          if (el.val() < parseInt(el.attr('max'))) {
            el.next(add).removeClass('disabled');
          }
        });

        // increment
        el.parent().on('click', '.spinner-add', function() {
          if (el.val() < parseInt(el.attr('max'))) {
            el.val(function(i, oldval) {
              return ++oldval;
            });
          }
          // disabled
          if (el.val() > parseInt(el.attr('min'))) {
            el.prev(sub).removeClass('disabled');
          }
          if (el.val() == parseInt(el.attr('max'))) {
            el.next(add).addClass('disabled');
          }
        });
      });
    });
  </script>
</body>

</html>
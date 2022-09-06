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
//入力チェック
$and_str = " Where 1 = 1";
if (!empty($_POST["rank"])) {
  $and_str .= " AND r.rank_id = " . $_POST["rank"];
}
if (!empty($_POST["stage"])) {
  $and_str .= " AND s.stage_id = " . $_POST["stage"];
}
$post_rank = $_POST ? $_POST["rank"] :"";
$post_stage = $_POST ? $_POST["stage"] :"";

//dsnを作成
$dsn = sprintf('mysql:host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

try {
  //PDOを使ってMySQLに接続
  $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

  //SQLを作成
  $sql = "SELECT 
      score_id,
      r.rank_name ,
      s.stage_name ,
      sum_count,
      win_self_pick,
      win_other_throw,
      other_pick,
      self_throw,
      other_throw,
      draw,
      battle_date,
      battle_rank,
      score,
      move_point,
      total_point
      FROM score
      join rank_master r on score.rank_id = r.rank_id 
      join stage s on score.stage_id = s.stage_id" . $and_str
    . " order by score_id";


  //$pdoにあるqueryメソッドを呼び出してSQLを実行
  $stmt = $pdo->query($sql);

  //出力結果を$rowに代入
  $row = $stmt->fetchAll();

  //出力結果をそれぞれの配列に格納
  $score_id = array_column($row, 'score_id');
  $rank_id = array_column($row, 'rank_name');
  $stage_id = array_column($row, 'stage_name');
  $sum_count = array_column($row, 'sum_count');
  $win_self_pick = array_column($row, 'win_self_pick');
  $win_other_throw = array_column($row, 'win_other_throw');
  $other_pick = array_column($row, 'other_pick');
  $self_throw = array_column($row, 'self_throw');
  $other_throw = array_column($row, 'other_throw');
  $draw = array_column($row, 'draw');
  $battle_date = array_column($row, 'battle_date');
  $battle_rank = array_column($row, 'battle_rank');
  $score = array_column($row, 'score');
  $move_point = array_column($row, 'move_point');
  $total_point = array_column($row, 'total_point');

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
  <title>検索</title>
  <style>
    .button002 {
      border-radius: 50px;
      position: relative;
      justify-content: space-around;
      align-items: center;
      margin: 0 auto;
      padding: 10px 25px;
      transition: 0.3s ease-in-out;
      font-size: x-large;
    }
    
    input[type="submit"] {
      border: 0;
      border-radius: 50px;
      position: relative;
      justify-content: space-around;
      align-items: center;
      margin: 0 auto;
      padding: 5px 25px;
      color: #313131;
      transition: 0.3s ease-in-out;
      font-size: x-large;
    }

    .button003 a{
      background: #eee;
      border-radius: 50px;
      position: relative;
      justify-content: space-around;
      align-items: center;
      margin: 0 auto;
      padding: 5px 25px;
      color: #313131;
      transition: 0.3s ease-in-out;
    }

    .button003 a:hover {
      background: green;
      color: #FFF;
    }

    .button003 a:after {
      content: '';
      width: 5px;
      height: 5px;
      border-top: 3px solid #313131;
      border-right: 3px solid #313131;
      transform: rotate(45deg) translateY(-50%);
      position: absolute;
      top: 50%;
      right: 20px;
      border-radius: 1px;
      transition: 0.3s ease-in-out;
    }

    .button003 a:hover:after {
      border-color: #FFF;
    }

    td {
      text-align: center;
    }

    label {
      font-size: x-large;
      color: white;
    }

    .userform {
      height: 2em;
    }

    body {
      /* background: lightgreen url('./jan_back.jpeg'); */
      background: lightgreen url('./jan.png');
      /* background: lightgreen ; */
      background-size: cover;
      background-repeat: no-repeat;
      margin-left: 5%;
      margin-right: 5%;
    }

    table {
      background-color: lightgreen;
      border-color: green;
      border-collapse: collapse
    }
  </style>
</head>

<body height='100%'>
  <div style="margin-top: 10%;"></div>
  <div style="padding-top: 3%;">
    <!-- <div style="float:right;">
      <div class="button003">
        <a href="./regist.php">スコア登録</a>
        <a href="./graph.php">戦績</a>
      </div>
    </div> -->
    <div class="button002">
      <form id="outputForm" name="outputForm" action="" method="POST">
        <div>
          <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
        </div>
        <div style="float:left;">
        <label for="username ">日付</label>
        <input class="userform" type="date" min="2021-10-10" height="48">
        <label for="stage-select ">間:</label>
        <select class="userform" name="stage" id="stage-select">
          <option value="">----</option>
          <?php for ($i = 0; $i < count($stage_list_name); $i++) { ?>
            <option value=<?= $stage_list_id[$i] ?> <?= $stage_list_id[$i] == $post_stage ? "selected" : "" ?>><?= $stage_list_name[$i] ?></option>
          <?php } ?>
        </select>
        <label for="rank-select ">ランク:</label>
        <select class="userform" name="rank" id="rank-select">
          <option value="">----</option>
          <?php for ($i = 0; $i < count($rank_list_name); $i++) { ?>
            <option value=<?= $rank_list_id[$i] ?> <?= $rank_list_id[$i] == $post_rank ? "selected" : "" ?>><?= $rank_list_name[$i] ?></option>
          <?php } ?>
        </select>
        <input class="button003" type="submit" id="search" name="search" value="検索">
        </div>

        <div style="float:right;">
          <div class="button003">
            <a href="./regist.php">スコア登録</a>
            <a href="./graph.php">戦績</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div style="height:60vh; width:100%; overflow-y:scroll;">
    <table border="2" border-color width="100%">
      <tr>
        <th>No</th>
        <th>日付</th>
        <th>ランク</th>
        <th>間</th>
        <th>局数</th>
        <th>ツモ上がり</th>
        <th>ロン上がり</th>
        <th>ツモられ</th>
        <th>自放銃</th>
        <th>他放銃</th>
        <th>流局</th>
        <th>順位</th>
        <th>点数</th>
        <th>増減ポイント</th>
        <th>ポイント</th>
      </tr>
      <?php for ($i = 0; $i < count($rank_id); $i++) { ?>
        <tr>
          <td>
            <?= $score_id[$i] ?>
          </td>
          <td>
            <?= $battle_date[$i] ?>
          </td>
          <td>
            <?= $rank_id[$i] ?>
          </td>
          <td>
            <?= $stage_id[$i] ?>
          </td>
          <td>
            <?= $sum_count[$i] ?>
          </td>
          <td>
            <?= $win_self_pick[$i] ?>
          </td>
          <td>
            <?= $win_other_throw[$i] ?>
          </td>
          <td>
            <?= $other_pick[$i] ?>
          </td>
          <td>
            <?= $self_throw[$i] ?>
          </td>
          <td>
            <?= $other_throw[$i] ?>
          </td>
          <td>
            <?= $draw[$i] ?>
          </td>
          <td>
            <?= $battle_rank[$i] ?>
          </td>
          <td>
            <?= $score[$i] ?>
          </td>
          <td>
            <?= $move_point[$i] ?>
          </td>
          <td>
            <?= $total_point[$i] ?>
          </td>
        </tr>
      <?php } ?>
    </table>


  </div>
</body>

</html>
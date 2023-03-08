<?php
var_dump($_POST);
$order = $_POST["order"];
$stage = $_POST["stage"];
$rank = $_POST["rank"];
$score = $_POST["score"];
$tumo = $_POST["tumo"];
$ron = $_POST["ron"];
$rare = $_POST["rare"];
$hoju = $_POST["hoju"];
$tahoju = $_POST["tahoju"];
$ryukyoku = $_POST["ryukyoku"];
$sum_count = $_POST["tumo"] + $_POST["ron"] + $_POST["rare"] + $_POST["hoju"] + $_POST["tahoju"] + $_POST["ryukyoku"];
//データベース情報の指定
$db['dbname'] = "jan";  // データベース名
$db['user'] = "root";  // ユーザー名
$db['pass'] = "rootroot";  // ユーザー名のパスワード
$db['host'] = "localhost";  // DBサーバのURL

//エラーメッセージの初期化
$errorMessage = "";
//フラグの初期化
$o = false;

//dsnを作成
$dsn = sprintf('mysql:host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

try {
  //PDOを使ってMySQLに接続
  $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

  $select_sql = "
  SELECT 
      total_point
      FROM score
      order by  score_id  desc  LIMIT 1
    ;
";
  //$pdoにあるqueryメソッドを呼び出してSQLを実行
  $stmt = $pdo->query($sql);

  //出力結果を$rowに代入
  $row = $stmt->fetchAll();

  //出力結果をそれぞれの配列に格納
  $total_point = array_column($row, 'total_point');
  $total_point +=
    //SQLを作成
    $sql = "INSERT INTO score(
    rank_id,
    stage_id,
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
    ) VALUES(
:rank,
:stage,
:sum_count,
:tumo,
:ron,
:rare,
:hoju,
:tahoju,
:ryukyoku,
SYSDATE(),
:order
    )";


  // SQL文をセット
  $stmt = $pdo->prepare($sql);

  // 値をセット
  $stmt->bindValue(':rank', $rank);
  $stmt->bindValue(':stage', $stage);
  $stmt->bindValue(':sum_count', $sum_count);
  $stmt->bindValue(':tumo', $tumo);
  $stmt->bindValue(':ron', $ron);
  $stmt->bindValue(':rare', $rare);
  $stmt->bindValue(':hoju', $hoju);
  $stmt->bindValue(':tahoju', $tahoju);
  $stmt->bindValue(':ryukyoku', $ryukyoku);

  // SQL実行
  $stmt->execute();
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
}
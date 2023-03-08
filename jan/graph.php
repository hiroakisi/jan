<?php 
$data = [[29, 1, 2, 10, 0, 3, 2, 1, 2, 2, 2022-06-20, 1, 42400, 73, 511],
[30, 1, 2, 12, 0, 1, 3, 3, 3, 2, 2022-06-20, 3, 7200, -22, 489],
[31, 1, 2, 10, 1, 1, 1, 4, 3, 0, 2022-06-20, 4, -6500, -66, 423],
[32, 1, 2, 10, 0, 0, 4, 1, 3, 2, 2022-06-20, 3, 13100, -16, 407],
[33, 1, 2, 9, 0, 0, 2, 3, 2, 2, 2022-06-20, 4, -4500, -64, 343]];
var_dump($data);
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
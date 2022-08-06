<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約表</title>
    <style>
    table,tr,td,th{
        border: solid 1px black; border-collapse: collapse;
    }
    td,th{
        min-width: 32px;
    }
    th{
        background: silver;
    }
    </style>
</head>
<body>
    <table>
        <tr>
           <th>時間(時)</th><?php for($i=0;$i<24;$i++) print '<th>'.$i.'</th>'; ?>
        </tr>
        <tr>
           <th>会議室A</th><?php for($i=0;$i<24;$i++) print '<td></td>'; ?>
        </tr>
        <tr>
           <th>会議室B</th><?php for($i=0;$i<24;$i++) print '<td></td>'; ?>
        </tr>
        <tr>
           <th>会議室C</th><?php for($i=0;$i<24;$i++) print '<td></td>'; ?>
        </tr>
    </table>
</body>
</html>
<?php
require_once('../config.php');
require_once('../functions.php');

mb_language("uni");
mb_internal_encoding("utf-8"); //内部文字コードを変更
mb_http_input("auto");
mb_http_output("utf-8");

$dbh = connectDb();

//ページの管理
if (preg_match('/^[1-9][0-9]*$/', $_GET['num'])) {
    $page = (int)$_GET['num'];
} else {
    $page = 1;
}


//GETメソッドで受け取った値によって動作を切り替え
if (preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM `events` WHERE `id` = $id LIMIT 1";
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
        $data[] = array(
          'id'=> $row['id'],
          'event_name'=> $row['event_name'],
          'date'=> $row['start_date'],
          'place'=> $row['address'],
          'tag'=> "アウトドア",
          'pictureurl'=> 'http://placehold.jp/150x150.png'
        );
      }
    } else {
      $data = null;
    }
} else if($_GET['id']) {
    $data = null;
}

if (!$_GET) {
  $sql = "SELECT * FROM `events`";
  $data = array();
  if($dbh->query($sql)) {
    foreach($dbh->query($sql) as $row) {
      $data[] = array(
        'id'=> $row['id'],
        'event_name'=> $row['event_name'],
        'date'=> $row['start_date'],
        'place'=> $row['address'],
        'tag'=> "アウトドア",
        'pictureurl'=> 'http://placehold.jp/150x150.png'
      );
    }
  } else {
    $data = null;
  }
}

header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
exit(json_encode($data));
?>

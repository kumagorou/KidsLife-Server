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

if ($_GET['event'] && $_GET['state']) {
  $user = 1;
  $event = $_GET['event'];
  $state = $_GET['state'];
  $sql = "INSERT INTO `events-users`
           (user_id, event_id, state_id)
           VALUES
           (:user_id, :event_id, :state_id)
           ON DUPLICATE KEY UPDATE
            state_id = :state_id
           ";

  $stmt = $dbh->prepare($sql);
  $params = array(
     ":user_id" => $user,
     ":event_id" => $event,
     ":state_id" =>  $state
  );
  try {
    $stmt->execute($params);
    $data = "success";
  } catch (PDOException $e) {
    $data = 'Connection failed: ' . $e->getMessage();
  }
}

//GETメソッドで受け取った値によって動作を切り替え
if (preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM events LEFT JOIN categories ON events.category_id = categories.id WHERE events.id = $id LIMIT 1";
    $data = [];
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
        $data[] = array(
          'id'=> $row['id'],
          'event_name'=> $row['event_name'],
          'capacity'=> $row['capacity'],
          'pay'=> $row['pay'],
          'date'=> $row['start_date'],
          'place'=> $row['address'],
          'tag'=> $row['name'],
          'image'=> $row['image'] ? SITE_URL."image/event/".$row['image'] : 'http://placehold.jp/150x150.png'
        );
      }
    }
    $sql = "SELECT * FROM `events-users` WHERE event_id = $id AND user_id = 1 LIMIT 1";
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
        $data = $data[0] + array('state' => $row['state_id']);
      }
    }
} else if($_GET['id']) {
    $data = null;
}



if (!$_GET) {
  $sql = "SELECT * FROM `events` LEFT JOIN categories ON events.category_id = categories.id";
  $data = array();
  if($dbh->query($sql)) {
    foreach($dbh->query($sql) as $row) {
      $data[] = array(
        'id'=> $row[0],
        'event_name'=> $row['event_name'],
        'date'=> $row['start_date'],
        'place'=> $row['address'],
        'tag'=> $row['name'],
        'pictureurl'=> $row['image'] ? SITE_URL."image/event/".$row['image'] : 'http://placehold.jp/150x150.png'
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

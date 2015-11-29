<?php
require_once('../config.php');
require_once('../functions.php');

mb_language("uni");
mb_internal_encoding("utf-8"); //内部文字コードを変更
mb_http_input("auto");
mb_http_output("utf-8");

$dbh = connectDb();

//GETメソッドで受け取った値によって動作を切り替え
if ($_GET['id'] && preg_match('/^[1-9][0-9]*$/', $_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM `medals` WHERE `id` = $id LIMIT 1";
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
        $data[] = array(
          'id'=> $row['id'],
          'name'=> $row['name'],
          'image'=> SITE_URL."image/medal/". $row['image'],
          'text'=> $row['text']
        );
      }
    } else {
      $data = null;
    }
}

if ($_GET['user_id'] && preg_match('/^[1-9][0-9]*$/', $_GET['user_id'])) {
    $id = (int)$_GET['user_id'];
    $sql = "SELECT * FROM `medals` WHERE `user_id` = $id LIMIT 1";
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
        $data[] = array(
          'id'=> $row['id'],
          'name'=> $row['name'],
          'image'=> SITE_URL."image/medal/". $row['image'],
          'text'=> $row['text']
        );
      }
    } else {
      $data = null;
    }
}

if (!$_GET) {
  $sql = "SELECT * FROM `medals`";
  $data = array();
  if($dbh->query($sql)) {
    foreach($dbh->query($sql) as $row) {
      $data[] = array(
        'id'=> $row['id'],
        'name'=> $row['name'],
        'image'=> SITE_URL."image/medal/". $row['image'],
        'text'=> $row['text']
      );
    }
  } else {
    $data = null;
  }
}


if($_GET['medal_id'] && $_GET['user_id']) {
    $medal_id = $_GET['medal_id'];
    $user_id = $_GET['user_id'];
    $sql = "INSERT INTO `users-medal`
       (user_id, medal_id, state_id)
       VALUES
       (:user_id, :medal_id, :state_id)";

    $stmt = $dbh->prepare($sql);
    $params = array(
       ":user_id" => $_POST['user_id'],
       ":medal_id" => $_POST['event_id'],
    );
}

if($_GET['favorite_id'] && $_GET['user_id']) {
  $favorite_id = $_GET['favorite_id'];
  $id = $_GET['user_id'];
  $sql = "UPDATE users SET favorite_id = :favorite_id WHERE user_id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':favorite_id', $favorite_id, PDO::PARAM_INT);
  $stmt->bindValue(':id', $id);
  if($stmt->execute()){
    $data[] = array(
        'is_success' => "true",
        'data' => "null"
      );
  } else {
    $data[] = array(
        'is_success' => "false",
        'data' => "null"
      );
  }
}



header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
exit(json_encode($data));

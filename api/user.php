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
    $sql = "SELECT user_id,user_name,gender.name,uuid,image,favorite_id FROM users LEFT JOIN gender ON users.gender_id = gender.id WHERE `id` = $id LIMIT 1";
    if($dbh->query($sql)) {
      foreach($dbh->query($sql) as $row) {
          $data[] = array(
            'id'=> $row['user_id'],
            'name'=> $row['user_name'],
            'gender'=> $row['name'],
            'uuid'=> $row['uuid'],
            'image'=> "http://192.168.100.150/image/user/".$row['image'],
            'favorite_id'=> $row['favorite_id']
          );
      }
    } else {
      $data = null;
    }
}

if (!$_GET) {
  $sql = "SELECT user_id,user_name,gender.name,uuid,image FROM users LEFT JOIN gender ON users.gender_id = gender.id";
  $data = array();
  if($dbh->query($sql)) {
    foreach($dbh->query($sql) as $row) {
        $data[] = array(
          'id'=> $row['user_id'],
          'name'=> $row['user_name'],
          'gender'=> $row['name'],
          'uuid'=> $row['uuid'],
          'image'=> "http://192.168.100.150/image/user/".$row['image']
        );
    }
  } else {
    $data = null;
  }
}


header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
exit(json_encode($data));

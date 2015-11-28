<?php
require_once('config.php');
require_once('functions.php');

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
if (!$_GET) {
	$sql = "SELECT * FROM `events`";
}

$data = array();
if($dbh->query($sql)) {
	foreach($dbh->query($sql) as $row) {
		array_push($data,$row);
	}
} else {
	$infos = null;
}
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
exit(json_encode($data));
?>

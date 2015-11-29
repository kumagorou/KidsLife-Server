<?php

function connectDb() {
  try {
    return new PDO(DSN, DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES,'UTF-8');
}

function getUrlquery($par=Array(),$op=0){
    $url = parse_url($_SERVER["REQUEST_URI"]);
    if(isset($url["query"])) parse_str($url["query"],$query);
    else $query = Array();
    foreach($par as $key => $value){
        if($key && is_null($value)) unset($query[$key]);
        else $query[$key] = $value;
    }
    $query = str_replace("=&", "&", http_build_query($query));
    $query = preg_replace("/=$/", "", $query);
    return $query ? (!$op ? "?" : "").htmlspecialchars($query, ENT_QUOTES) : "";
}

//全てのカラムを取得
function getColmns($table,$dbh) {
    $sql =  "SHOW COLUMNS FROM `$table`";
    $columns = array();
    foreach($dbh->query($sql) as $row) {
        array_push($columns,$row[0]);
    }
    return $columns;
}

function rrmdir($dir) {
    //ファイルがディレクトリかどうか調べる
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                //ファイルタイプがディレクトリの場合
                if (filetype($dir . "/" . $object) == "dir") {
                    //再帰的に処理
                    rrmdir($dir . "/" . $object);
                } else {
                    //ファイルを削除
                    unlink($dir . "/" . $object);
                }
            }
        }
        //配列のポインタを先頭に
        reset($objects);
        //ディレクトリの消去
        rmdir($dir);
    }
}

function get_fav($coolkieName,$dbh) {
    if(isset($_COOKIE[$cookieName])) {
        $favoriteList = explode(",", $_COOKIE[$cookieName]);
        $sql = "SELECT * FROM t_job_info WHERE";
        foreach ($favoriteList as $key => $id) {
            if ($key == 0) {
                $sql.= " t_job_info_id = $id";
            } else {
                $sql.= " OR t_job_info_id = $id";
            }
        }
    }
    $favorites = array();
    if($dbh->query($sql)) {
        foreach($dbh->query($sql) as $row) {
            array_push($favorites,$row);
        }
    } else {
        $favorites = null;
    }
    return $favorites;
}

# ログインしているかどうかを判定
function login_check() {
    session_start();
    $login_url = "http://".$_SERVER['HTTP_HOST']."/admin/login.php";
    if (!isset($_SESSION["user"])) {
        header("Location: ".$login_url);
    }
}

function block_access() {
    if (! isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
        die(json_encode(array('status' => "不正な呼び出しです")));
    }
}

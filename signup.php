<?php
   require_once('config.php');
   require_once('functions.php');

   session_start();

   if ($_SERVER['REQUEST_METHOD'] != 'POST'){
      setToken();
   }else{
      checkToken();
   
      $name     = $_POST['user_name'];
      $email    = $_POST['email'];
      $password = $_POST['password'];

      $dbh = connectDB();
      $err = array();
 
      if ($name == ''){
         $err['user_name'] = '名前を入力してください。';
      }
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $err['email'] = 'メールアドレスの形式に間違いがあります。';
      }
      if($email = ''){
        $err['email'] = 'メールアドレスを入力してください。';
      }
      if(!emailExists($email,$dbh)){
        $err['email'] = '既に登録されています。';
      }
      if ($password == ''){
         $err['password'] = 'パスワードを入力してください。';
      }
      if(empty($err)){
         $sql = "insert into users
                 (user_name, password, email, created, modified)
                 values
                 (:user_name, :password, :email, now(),now())";

        $stmt = $dbh->prepare($sql);

        $params = array(
           ":user_name" => $name,
           ":password"  => getSha1Password($password),
           ":email"     => $email
        );

        $stmt->execute($params);
        header('Location: '.SITE_URL.'login.php');
        exit;
      }
   }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ENTRY</title>
    <link rel="styleSheet" type="text/css" href="css/signup.css">
  </head>
  <body>
  <header>
   <div class="title">サインイン</div>
  </header>
  <form action="" method="POST">
    <div class="position">
      <p>名前: <input type="text" name="user_name" value=""><?php echo h($err['user_name']); ?></p>
      <p>メール: <input type="text" name="email" value=""><?php echo h($err['email']); ?></p>
      <p>パスワード: <input type="password" name="password" value=""><?php echo h($err['password']); ?></p>
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <p><input class ="button "type="submit" value="登録"> <a class="button" href="index.php"style="font-size:10pt">戻る</a></p>
    </div>
  </form>
</html>


<?php
//session_start();
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
//DB接続する↓↓
$dsn = 'mysql:dbname=aoaohabu;host=localhost';
$user = 'aoaohabu2';
$password = 'aoaohabu3';
    
    try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
//DB接続する↑↑

//パスワードをハッシュ化
     
    $sql = 'SELECT * FROM users WHERE mail=:mail';
    $stmt = $dbh->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindValue(':mail', $mail);//, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定し（数値なので  PDO::PARAM_INT）、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetch();  
    //var_dump($results);
 
    
    if($results["mail"] == $mail){//mailが存在してたら
    echo "そのメールアドレスは既に登録されています。";
    echo '<a href="新規登録.php">戻る</a>';//新規登録画面に飛ぶ
        
    }else{//mailが存在していなかったら
         //【POST送信の各値の変数を定義。
        $mail = $_POST["mail"];
        $password = $_POST["password"];
        $name = $_POST["name"];
       
        $sql = "INSERT INTO users (mail, password, name) VALUES (:mail, :pass, :name)";
    $stmt = $dbh->prepare($sql);
    //プレースホルダに変数を宛がう
    $stmt->bindValue(':mail', $mail);//, PDO::PARAM_STR);
    $stmt->bindValue(':pass', $pass);//, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name);//, PDO::PARAM_STR);

    //実行
    $stmt->execute();
   
    echo "新規登録に成功しました";
    echo '<a href="ログイン.php">ログイン画面へ</a>';
    }
    
    
   
?>
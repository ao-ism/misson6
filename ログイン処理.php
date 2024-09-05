<?php
session_start();
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
     

$mail = $_POST['mail'];

$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);//, PDO::PARAM_INT);
$stmt->execute();
$member = $stmt->fetch();
//var_dump($member);

if (password_verify($_POST['password'] , $member['password'])) {//入力されたパスワードと登録されているハッシュ化パスワードが一致しているか
    //DBのユーザー情報をセッションに保存
    $_SESSION['mail'] = $member['mail'];//$_SESSION[ ]は、現在のセッションに登録されている値の変数のことで、配列。
    $_SESSION['name'] = $member['name'];
    $_SESSION['id'] = $member['id'];
    echo "ログインしました。";
    echo '<a href="掲示板.php">掲示板</a>';
} else {
    echo 'メールアドレスもしくはパスワードが間違っています。';
    echo '<a href="ログイン.php">戻る</a>';
}

    
?>
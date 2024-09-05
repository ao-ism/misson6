<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>mission6</title>
    <style>
        .class1{
            font-size: 25px;
            font-weight: bold;
        }
        
    </style>
  </head>
  <body>
      
      <!---->
      <h1><div class="class1">新規登録</div></h1><br>
      
      <form method = "POST" action ="新規登録処理.php">
            <input type = "text" name ="name" placeholder = "お名前" ><br>
            <input type = "email" name ="mail" placeholder = "メールアドレス" ><br>
            <input type = "password" name ="password" placeholder = "パスワード" ><br>
            <input type = "submit" name ="submit" value="新規登録">
    　</form>
    　<p>すでに登録済みの方は<a href="ログイン画面.php">こちら</a></p>

  </body>
</html>
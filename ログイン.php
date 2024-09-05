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
      <!--ログインできたら掲示板に飛ぶ-->
      <h1 id = "midashi_1"><div class="class1">ゼミ意見掲示板ログイン画面</div></h1><br>
      <form method = "POST" action ="ログイン処理.php">
            <!--【既存の新規投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる】-->
            <input type = "text" name ="name" placeholder = "お名前" ><br>
            <input type = " email" name ="mail" placeholder = "メールアドレス" ><br>
            <input type = "password" name ="password" placeholder = "パスワード" ><br>
            <input type = "submit" name ="submit" value="ログイン">
            <!--登録していない人用の新規登録フォームへ移動-->
            <p>登録されていない方は<a href="新規登録.php">こちら</a></p>
  </body>
</html>
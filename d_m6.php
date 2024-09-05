<?php
//記入例；以下はPHP領域に記載すること。
    //4-2以降でも毎回接続は必要。
    //$dsnの式の中にスペースを入れないこと！

   
    
    // DB接続設定
    $dsn = 'mysql:dbname=aoaohabu;host=localhost';
    $user = 'aoaohabu2';
    $password = 'aoaohabu3';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
   // echo "OK";
   
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    // 【！この SQLは tbtest テーブルを削除します！】 

    $sql = 'DROP TABLE idea';
    $stmt = $pdo->query($sql);
     ?>
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
   
   //テーブルの作製
    $sql = "CREATE TABLE IF NOT EXISTS idea"//「idea」という名前のテーブル作製
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "comment CHAR(32),"
    . "col_timestamp TIMESTAMP,"
    . "password TEXT,"
    . "quote TEXT"	
    .");"; 
    $stmt = $pdo->query($sql);
   
    
    //."col_"//. "time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP"
    //create_date DATE
     ?>
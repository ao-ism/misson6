<!DOCTYPE html>
<head>
    <title>mission5-4</title>
     <style>
        .class1{
            font-size: 25px;
            font-weight: bold;
        }
        
    </style>
</head>
    <body>
        <h1 id = "midashi_1"><div class="class1">ゼミ意見掲示板</div></h1><br>
        <?php
        session_start();

if (!empty($_SESSION['id'])) {//ログインしているとき、isset
$username = $_SESSION['name'];

//htmlspecialcharsを設定することで「XSS攻撃(ランサムウェア)」を防ぐ。特殊記号も抽出するから、プログラムがプログラムとして認識されないようになる。
    echo 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8')  . 'さん<br>';
    echo "編集・削除した際、設定したパスワード以外を入力して、編集・削除が行われた場合は";
    echo "<a href='mailto:c2h31025@bunkyo.ac'>ご連絡</a>";
    echo "ください<br>";
    echo '<a href="ログアウト.php">ログアウト</a>'; 
    echo "はこちらから<br>";
    echo "<hr>";
    
    $E_name = "";
    $E_comment = "";
    $h_number= "";
    
    // DB接続設定
    $dsn = 'mysql:dbname=aoaohabu;host=localhost';
$user = 'aoaohabu2';
$password = 'aoaohabu3';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
   // echo "OK";
   
   //編集番号を取得
   if(!empty($_POST["e-number"])){
       //【SELECT文で該当の1行だけを取得し、「名前」と「コメント」の内容を取得する】
        $id =  $_POST["e-number"]; // idがこの値のデータだけを抽出したい、とする 

    //$rowの添字（[ ]内）は4-2でどんな名前のカラムを設定したかで変える必要がある。
    $sql = 'SELECT comment,password FROM idea WHERE id=:id ';
    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定し（数値なので  PDO::PARAM_INT）、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetchAll();  
    
    $h_number = $_POST["e-number"];
    //ループして、取得したデータを表示
    foreach ($results as $row){
       if($row["password"] == $_POST["e-password"]){
        //$E_name = $row['name'];
        $E_comment = $row['comment'];
       }
    }
   }
   
   //【既存の投稿フォーム内に「いま送信された場合は新規投稿か、編集か（新規登録モード／編集モード）」を判断する情報を追加する】
   if(!empty($_POST["comment"]) && !empty($_POST["password"]) && isset($_POST["submit"])){
       
    if(!empty($_POST["h-number"])){//編集モード
        
    $id = $_POST["h-number"]; //変更する投稿番号 

    //$name = $_POST["name"];
    $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること 
    $date = date("Y/m/d H:i:s");
    
    $sql = 'UPDATE idea SET comment=:comment, col_timestamp=:col_timestamp WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    //プレースホルダに変数を宛がう
    //$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->bindParam(':col_timestamp', $date, PDO::PARAM_STR);

    //実行
    $stmt->execute();
     //var_dump($stmt);
     echo '<b>編集に成功しました</b>';
     //パスワードが一致したら編集、不一致だと変更されなくなった！
        
    }
         else{//新規投稿モード
            if(!empty($_POST["quote"])){
                 $comment = $_POST["comment"];
        $date = date("Y/m/d H:i:s");
        $password = $_POST["password"];
        $quote = $_POST["quote"];
       
        $sql = "INSERT INTO idea ( comment, col_timestamp,password,quote) VALUES (:comment, :col_timestamp,:password,:quote)";
    $stmt = $pdo->prepare($sql);
    //プレースホルダに変数を宛がう
    //$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
    $stmt->bindParam(':col_timestamp', $date, PDO::PARAM_STR); 
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':quote', $quote, PDO::PARAM_STR);
 //var_dump($stmt);
    //実行
    $stmt->execute();
    //var_dump($stmt);
    echo "<b>新規投稿に成功しました</b>";
            }else{
        //【POST送信の各値の変数と「投稿日時」を扱う変数を用意し、定義。
        //$name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date("Y/m/d H:i:s");
        $password = $_POST["password"];
       
        $sql = "INSERT INTO idea ( comment, col_timestamp,password) VALUES (:comment, :col_timestamp,:password)";
    $stmt = $pdo->prepare($sql);
    //プレースホルダに変数を宛がう
    //$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
    $stmt->bindParam(':col_timestamp', $date, PDO::PARAM_STR); 
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
 //var_dump($stmt);
    //実行
    $stmt->execute();
    //var_dump($stmt);
    echo "<b>新規投稿に成功しました</b>";
            }
         }
   }
         //削除
         if(!empty($_POST["d-number"]) && !empty($_POST["d-password"])){
             $id = $_POST["d-number"]; //削除したい投稿番号
             
             $sql = 'SELECT * FROM idea WHERE id=:id ';
             $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
             $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定し（数値なので  PDO::PARAM_INT）、
             $stmt->execute();                             // ←SQLを実行する。
             $results = $stmt->fetchAll(); 
             
             foreach($results as $result){
             if($result["password"]== $_POST["d-password"]){//パスワードが一致したら削除
                 $sql = 'delete from idea where id=:id';
                 $stmt = $pdo->prepare($sql);
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
                 //実行
                 $stmt->execute();
                 echo "<b>削除に成功しました</b>";
             }
                 
             }
    
         }
         
         
         
        
} else {//ログインしていない時
    echo "ログインしていないため、書き込み・閲覧はできません。<br>";
    echo 'ログインは';
    echo '<a href="ログイン.php">こちら</a>';
    echo 'から';
    echo '<hr>';
}
?>
        


         
    <!--【フォーム：「名前」「コメント」の入力と「送信」ボタンが1つあるフォームを作成】-->
        <form method = "POST" action ="">
            <!--【既存の新規投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる】-->
            <!--<input type = "text" name ="name" placeholder = "名前入力欄" value = "<?php //if(isset($_SESSION['id'])){echo "$E_name";}?>"><br>-->
             <input type = "text" name ="comment" placeholder = "コメント入力欄" value ="<?php if(isset($_SESSION['id'])){echo "$E_comment";}?>"><br>
             <!--textarea は、VALUE対応していない-->
           <!--<textarea  name="comment" placeholder = "コメント入力欄" ></textarea><br>-->
           <input type = "number" name ="quote" placeholder = "引用投稿番号" ><br>
            <input type = "password" name ="password" placeholder = "パスワード" >
            
            <!--<form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
    </form>-->
           <input type = "submit" name ="submit" style="background-color:#81FFFF" value="投稿"><br>
            <!--新規投稿 & 編集投稿 -->
            投稿する際の注意点:<br>
            ・投稿の際は、コメント・パスワードの入力は必須です。引用投稿番号の入力は任意です。<br><br>
            ・パスワードは一投稿ずつに付与できます。そのため、各投稿に対して異なるパスワードを設定できます。<br>
            ・ただし、パスワードを忘れた場合、その投稿の編集・削除はできません。この点はご留意ください。
            
            <hr>
            <input type = "number" name ="d-number" placeholder = "削除したい投稿番号" ><br>
            <input type = "password" name ="d-password" placeholder = "パスワード" >
            <input type = "submit" name ="delete" style="background-color:#81FFFF" value="削除"><br>
            <!--削除-->
            削除する場合:<br>
            削除したい投稿の番号および投稿時に設定したパスワードを入力し、削除ボタンを押してください。<br>
            <hr>
            <input type = "number" name ="e-number" placeholder = "編集したい投稿番号" ><br>
            <input type = "password" name ="e-password" placeholder = "パスワード" >
            <input type = "submit" name ="edit" style="background-color:#81FFFF" value="編集"><br>
            <!--編集-->
            編集する場合:<br>
            編集したい投稿の番号および投稿時に設定したパスワードを入力し、編集ボタンを押してください。<br>
            その後、新たな「名前・コメント・パスワード」を入力し、投稿ボタンを押してください。
            <hr>
            <input type = "hidden" name ="h-number" value = "<?php echo "$h_number";?>">
            <!--編集分岐させるためのテキストボックス-->
        </form>
        
    <?php
    if("idea" && isset($_SESSION['id'])){
    //読み出し
       
       echo "<table border = 1>
           <tr>
           <th>投稿番号</th>
           <th>引用No.</th>
           <th>コメント</th>
           <th>投稿時刻</th>
           </tr>";
    
      $sql = 'SELECT * FROM idea';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(); 
          
    //ループして、取得したデータを表示
    foreach ($results as $row){
        
        if(!empty($row['quote'])){
            //$rowの中にはテーブルのカラム名が入る
        //var_dump($row["password"]);
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        //echo "<td>".$row['name']."</td>";
        echo "<td>-->".$row['quote']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "<td>".$row['col_timestamp']."</td>";
        
        echo "</tr>";
        }else{
            echo "<tr>";
        echo "<td>".$row['id']."</td>";
        //echo "<td>".$row['name']."</td>";
        echo "<td>".$row['quote']."</td>";
       echo "<td>".$row['comment']."</td>";
        echo "<td>".$row['col_timestamp']."</td>";
        
        echo "</tr>";
            
            }
        
    }
    echo "</table>";
   
    }
    ?>
    このページの<a href="#midashi_1">TOP</a>へ 
     
    </body>
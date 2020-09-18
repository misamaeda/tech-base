<html lang "ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-36</title>
</head>  
<body>
    <span style="font-size: 50px;">掲示板</span>
     
    <form action=""method="post">
        <span style="font-size: 15px;">削除フォーム</span><br>
        <input type="number"name="id1"placeholder="削除IDを入力してください"><br>
        <input type="text"name="name1"placeholder="名前を入力してください"><br>
        <button type="submit"name="delete"> 削除</button><br>
    </form>
    
    <form action=""method="post">
        <span style="font-size: 15px;">編集フォーム</span><br> 
        <input type="number"name="id2"placeholder="編集IDを入れてください"><br>
        <input type="text"name="name2"placeholder="名前を入れてください"><br>
        <input type="text"name="comment2"placeholder="コメントを入力してください"><br>
        <button type="submit"name="edit">編集</button><br>
    </form>
    
    <form action=""method="post">
      <span style="font-size: 15px;">追加フォーム</span><br>
     <input type="number"name="id3"placeholder="IDを入れてください"><br>
     <input type="text"name="name3"placeholder="名前を入れてください"><br>
    <input type="text"name="comment3"placeholder="投稿コメントを入力してください"><br>
    <button type="submit"name="add">追加</button><br>
    </form>
    
     <form action=""method="post">
    <button type="submit"name="display">表示</button><br>
    </form>
      <?php
    
    //DB接続設定
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成
	$sql = "CREATE TABLE IF NOT EXISTS tbtest" 
    ." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	.");";        
    $stmt = $pdo->query($sql); 
    
     if(isset($_POST['display'])){
         //SELECT文で、テーブルに登録されたデータを取得し、表示する
        $sql =$pdo->query('SELECT * FROM tbtest');
	    $results = $sql->fetchAll();
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['comment'].'<br>';
	        echo "<hr>";
	                                }                              
	                                }
	
	if(isset($_POST['add'])){
        //INSERT文 で、データ（レコード）を登録する(追加)
        $sql = $pdo->prepare('insert into tbtest (id,name, comment) values (:id,:name, :comment)');  //実行準備
        //INSERT INTO テーブル名 (列名,列名) VALUES (列に入れる値,列に入れる値)
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
	    $sql->bindParam(':name', $name, PDO::PARAM_STR);  //バインド変数⇒データベースで使う変数のこと⇒この行の場合は:nameがバインド変数
	    //bindParam(データベースで使う変数名,変数に入れる値または文字,変数の型)
	    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);    //bindparamを使ってデータベース用変数を作成する。::は->とだいたい同じ意味
        $id=$_POST['id3'];
	    $name=$_POST['name3'];
	    $comment=$_POST['comment3'];
	    $sql->execute();  //データベースへの処理の実行 
	                        }
	 
	 
	if(isset($_POST['delete'])){
	    //データベースのテーブルに登録したデータレコードをDELETE文で削除する
	    $sql = $pdo->prepare('delete from tbtest where id=:id and name=:name');
	    $sql->bindParam(':id', $id, PDO::PARAM_INT);
	    $sql->bindParam(':name', $name, PDO::PARAM_STR);
	    $id=$_POST['id1'];
	    $name=$_POST['name1'];
	    $sql->execute();
	                            }
 
    if(isset($_POST['edit'])){
        //データベースのテーブルに登録したデータレコードは、UPDATE文 で更新する事が可能
	    $sql = $pdo->prepare('UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id');
	    $sql->bindParam(':name', $name, PDO::PARAM_STR);
	    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $sql->bindParam(':id', $id, PDO::PARAM_INT);
	    $name=$_POST['name2'];
	    $comment=$_POST['comment2'];
	    $id=$_POST['id2'];
	    $sql->execute();
                            }
    ?>
</body>
</html>
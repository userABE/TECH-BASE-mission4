<!DOCTYPE html>
<html="ja">
<head>
<meta charset="UTF-8">
</head>
<body>

<form method="post" action="mission_4_seki.php"> 
<input type="text" name="name" placeholder="名前" value="<?php echo $name;?>"><br/>
<input type="text" name="message" placeholder="コメント" value="<?php echo $message;?>"><br/>
<input type="text" name="pass" placeholder="パスワード">
<input type="submit"><br/><br/>
<input type="hidden" name="hidden"><br/>

<input type="text" name="del" placeholder="削除番号"><br/>
<input type="text" name="delpass" placeholder="パスワード">
<input type="submit" value="削除"><br/><br/>
</form>


<form action="mission_4_1_seki.php" method="post">	//編集は別ページ
<input type="text" name="editing" placeholder="編集番号"><br/>
<input type="text" name="edipass" placeholder="パスワード">
<input type="submit" value="編集"><br/>
</form>

<?php


//データベースの取得？
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


$name1=$_POST['name'];
$message1=$_POST['message'];
$editing=$_POST['editing'];
$pass1=$_POST['pass'];
$delpass=$_POST['delpass'];
$del=$_POST['del'];	


//テーブル作成	
$sql="CREATE TABLE IF NOT EXISTS test5"
."("
."id INT AUTO_INCREMENT NOT NULL primary key,"
."name char(32),"
."message TEXT,"
."date DATETIME,"
."password TEXT"
.");";
$stmt=$pdo->query($sql);

//確認
// $sql='SHOW TABLES';
// $result=$pdo->query($sql);
// foreach($result as $row){
// echo $row[0];
// echo '<br>';
//}
//echo "<hr>";


//新規投稿
if(!empty($name1) and !empty($message1)){
	//データベースの取得？
	$dsn='データベース名';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql=$pdo->prepare("INSERT INTO test5 (name,message,date,password) VALUES (:name,:message,:date,:password)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':message',$message,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':password',$pass,PDO::PARAM_STR);
	
	$del=$_POST['del'];
	$name=$_POST['name'];
	$message=$_POST['message'];
	$editing=$_POST['editing'];
	$date=date("Y/m/d H:i:s");	//データベースに漢字は使えない
	$pass=$_POST['pass'];
	
	$sql->execute();

//削除番号が送信されたとき
}elseif(!empty($del) and !empty($delpass)){

	//データベースの取得
	$dsn='データベース名';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


	$sql='SELECT * FROM test5 ORDER BY id ASC';	//消した後昇順になるように
	$results1=$pdo->query($sql);
	foreach ($results1 as $row1){
		if($row1['id']==$del and $row1['password']==$delpass){ 
			$id=$del;
			$sql="delete from test5 where id=$id";
			$result=$pdo->query($sql);
		}
	}
}else{
}

//編集したものの上書き
$editing=$_POST['editing'];
$edipass=$_POST['edipass'];

//別ページで使った変数
$name2=$_POST['name2'];
$message2=$_POST['message2'];
$hidden2=$_POST['hidden2'];
$pass2=$_POST['pass2'];
$date=date("Y/m/d H:i:s");

if(!empty($hidden2)){	//hiddenが空欄でない時に上書き
	
	//データベースの取得？
	$dsn='データベース名';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql="update test5 set name='$name2' , message='$message2' , date='$date' , password='$pass2' where id='$hidden2'";
	$result=$pdo->query($sql);
}else{
}

//表示
$sql='SELECT * FROM test5';
$results=$pdo->query($sql);
foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['message'].',';
	echo $row['date'].'<br>';
}
?>
</body>
</html>
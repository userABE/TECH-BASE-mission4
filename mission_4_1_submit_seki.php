<!DOCTYPE html>
<html="ja">
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
$message1=$_POST['message'];
$name1=$_POST['name'];
$editing=$_POST['editing'];
$comment=$message.$name;
$date1=date("Y年m月d日 H時i分");


$edipass=$_POST['edipass'];


//編集番号が送信された場合のみ動く
if(!empty($editing)){

	//データベースの取得？
	$dsn='データベース名';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


	$sql='SELECT * FROM test5 ORDER BY id ASC';
	$results1=$pdo->query($sql);
	foreach ($results1 as $row1){			
				if($row1['id']==$editing and $row1['password']==$edipass){ //投稿番号・パスワードが両方あってる場合
					$hidden=$row1['id'];
					$ediname=$row1['name'];
					$edimessage=$row1['message'];
					$edipass=$row1['password'];

				}elseif($row1['id'] == $editing && $edipass != $row1['password']){//投稿番号とパスワードが違う場合
					echo "パスワードが違います。";
				}else{
				}
	}
	
} 
?>

<form method="post" action="mission_4_seki.php"> 
<input type="text" name="name2" placeholder="名前" value="<?php echo $ediname;?>"><br/>
<input type="text" name="message2" placeholder="コメント" value="<?php echo $edimessage;?>"><br/>
<input type="text" name="pass2" placeholder="パスワード" value="<?php echo $edipass;?>">
<input type="submit"><br/><br/>
<input type="hidden" name="hidden2" value="<?php echo $hidden;?>"><br/>

<input type="text" name="del" placeholder="削除番号"><br/>
<input type="text" name="delpass" placeholder="パスワード"  >
<input type="submit" value="削除"><br/><br/>
</form>


<form action="mission_4_seki.php" method="post">
<input type="text" name="editing" placeholder="編集番号"><br/>
<input type="text" name="edipass" placeholder="パスワード" >
<input type="submit" value="編集"><br/>
</form>

<?php

//データベースの取得？
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

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

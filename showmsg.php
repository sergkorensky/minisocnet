<?php 
require('checklog.php');
session_start();
header('content-type: text/html; charset=utf-8');
if (checklog()) {//отправитель авторизован
$id_l=$_GET['q'];
require('connect.php');
mysql_select_db($db);
$sql0="select * from letters where id_l=\"$id_l\"";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
$n0=mysql_num_rows($res0);
//echo $n0;
if ($n0 > 0) {//it is
$row=mysql_fetch_array($res0,MYSQL_ASSOC);
echo "<h3>Message #".$row['id_l']."</h3>";
echo "<h4>From: ".$row['fromN']."</h4>";
echo "<h4>To: ".$row['toN']."</h4>";
echo $row['body'];
echo '<hr><br>Вернуться <a href="index.php">Назад</a>';
}else{
echo 'Сообщение не найдено';}
mysql_close($conn);
}else{//
session_unset(); session_destroy();
 echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}

?>


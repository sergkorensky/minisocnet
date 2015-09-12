<?php 
require('checklog.php');// function checklog() that check whether $_SESSION['login'] and $_SESSION['passw'] are the same as in db or not
session_start();
header('content-type: text/html; charset=utf-8');
if (checklog()) {//пользователь авторизован
$login=$_SESSION['login'];
$text=$_GET['Q'];
$text=mysql_escape_string($text);
require('connect.php');
mysql_select_db($db);
$sql0="update users set prispace=\"$text\" where login=\"$login\"";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
if ($res0) {//it is
echo "Text saved.";
echo '<br>Вернуться <a href="index.php">Назад</a>';
mysql_close($conn);
}else{
echo 'Текст не сохранен';}//
}else{ echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}

?>


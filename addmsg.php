<?php 
if (isset($_GET['send'])) {//0 попытка отправить сообщение
session_start();
header('content-type: text/html; charset=utf-8');
if (isset($_SESSION['login'])) {//1 у отправителя начата сессия с зарег. переменной но 
///по $_SESSION['login'] надо еще проверить пароль в БД
$login=$_SESSION['login'];
$passw=$_SESSION['passw'];

$patt='/^\w+$/';
if (!preg_match($patt,''.$login)) {die('Плохой логин), вернуться <a href="index.php">Назад</a>');}else{//3 check in db
require('connect.php');
mysql_select_db($db);

$sql="select password from users where login=\"$login\"";
$res=mysql_query($sql, $conn) or die(mysql_error());
$n1=mysql_num_rows($res);
if (!($n1 > 0 and $passw == mysql_result($res,0,'password'))) {//4 login is wrong
mysql_close($conn);
die('Вы здесь не авторизованы), вернуться <a href="index.php">Назад</a>');}else{//5 отправитель авторизован

$fromN=$_SESSION['login'];
$toN= $_GET['toN'];
$body=$_GET['body'];
$patt='/^\w+$/';
if (preg_match($patt,''.$toN)) {//n1 запись в БД

$sql0="select * from users where login=\"$toN\"";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
$n0=mysql_num_rows($res0);
if ($n0 > 0) {//n0 address is true
$body=strip_tags($body);
$body=mysql_escape_string($body);
$sql="insert into letters (fromN, toN, body, unread) values (\"$fromN\",\"$toN\",\"$body\", 1)";
$res=mysql_query($sql, $conn) or die();
if ($res!=false) echo 'Сообщение отправлено, вернуться <a href="index.php">Назад</a>';
else echo 'Сообщение не отправлено, вернуться <a href="index.php">Назад</a>';

}else{//address is false
echo 'Такого адресата нет, вернуться <a href="index.php">Назад</a>';}
//n0
}else{//n1
echo 'Недопустимые символы в имени адресата';
echo '<br><a href="index.php">Назад</a>';
}//n1
mysql_close($conn);
}//5&4 end 4 case 'отправитель авторизован'
}//3
}else{session_unset(); session_destroy(); echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}//1
}//0
?>


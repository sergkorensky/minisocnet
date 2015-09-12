<?php 
require('checklog.php');
session_start();
header('content-type: text/html; charset=utf-8');
if (checklog()) {
$login=$_SESSION['login'];
require('connect.php');
mysql_select_db($db);
$sql="select id from users where login=\"$login\"";
$res=mysql_query($sql, $conn) or die(mysql_error());

if (1 == mysql_result($res,0,'id')) 
{
$sql0="select id, login, ip, datereg from users";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
$n0=mysql_num_rows($res0);

if ($n0 > 0) 
while ($row=mysql_fetch_array($res0,MYSQL_ASSOC)){
echo $row['id']." \t \t";
echo $row['login'].' '.$row['ip'].' '.$row['datereg'].'<br>';
}
else echo 'Пользователи не найдены';
}
else echo "Недостаточно прав";
mysql_close($conn);
}
else{//
session_unset(); session_destroy();
 echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}

?>


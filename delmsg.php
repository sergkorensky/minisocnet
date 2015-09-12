<?php 
require('checklog.php');
session_start();
header('content-type: text/html; charset=utf-8');
if (checklog()) {//отправитель авторизован
$login=$_SESSION['login'];
$dmsg=$_GET['dmsg'];
require('connect.php');
mysql_select_db($db);
$sql="delete low_priority from letters where id_l in (";//                    \"$id_l\"
//print_r($dmsg);
$b=0;
foreach($dmsg as $key=>$id)
if ($b==0) {$sql.="$id"; $b=1;
}else $sql.=", $id";
$sql.=") and toN=\"$login\"";
//echo $sql; echo date('h:i:s') . "\n";
$res=mysql_query($sql, $conn);
mysql_close($conn); header('location: index.php');
}else{
session_unset(); session_destroy();
 echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}

?>


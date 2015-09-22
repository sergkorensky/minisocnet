<?php
header('content-type:text/html; charset=utf-8');
if (!isset($_GET['install'])) {
$str="<h4>Перед началом установки проверьте доступность для записи (777) файла connect.php</h4>
<form>DB server<input name='dbserver' value='localhost'><br>DB name<input name='dbname'><br>DB user<input name='dbuser'><br>
DB passw<input name='dbpassw'><br><input type='submit' name='install'></form>";
echo $str;
} else {
$dbserver=$_GET['dbserver'].'';
$dbname=$_GET['dbname'].'';
$dbuser=$_GET['dbuser'].'';
$dbpassw=$_GET['dbpassw'].'';
$patt='/^\w+$/';//допустимы только лат буквы и цифры
if (preg_match($patt,$dbserver.$dbname.$dbuser.$dbpassw)) { 
$db=$dbname;
$conn=mysql_connect($dbserver,$dbuser,$dbpassw) or die("Невозможно установить соединение: ". mysql_error());
mysql_select_db($db);
$sql='create table IF NOT EXISTS users (id int primary key auto_increment,name varchar(50) default "",login varchar(50) default "noname",';
$sql.= 'password varchar(50), prispace mediumtext default "", ip char(24), datereg datetime)';
$result= mysql_query($sql,$conn);

$sql2='create table IF NOT EXISTS letters (id_l int primary key auto_increment,fromN varchar(50),toN varchar(50), body text, unread tinyint(1))';
$result2= mysql_query($sql2,$conn);

if ($result and $result2){//таблицы созданы
$str2="<?php 
\$db=\"$dbname\";
\$conn=mysql_connect(\"$dbserver\",\"$dbuser\",\"$dbpassw\") or die( mysql_error());
?>";
$h=fopen('connect.php','w');
if (fwrite($h,$str2)) echo "Запись конфигурации прошла успешно. Не забудьте удалить вручную файл install.php!";
else 
  echo "Произошла ошибка при записи данных";
fclose($h);
}else{//no
 echo "Произошла ошибка при создании таблиц";}

mysql_close($conn);
} else {echo "Недопустимые символы"; exit(); }

}
?>


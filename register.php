<meta http-equiv='content-type' content='text/html; charset=utf-8' >
<?php 
function fulldat($time){
return date('Y-m-d H:i:s',$time);
}

if (isset($_GET['newgo'])) {//check and write in DB
$login=$_GET['login'];
$passw=$_GET['passw'];
$patt='/^\w+$/';
if (preg_match($patt,''.$login.$passw)) {//запись в БД
require('connect.php');
mysql_select_db($db);
$sql0="select id from users where login=\"$login\"";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
$n0=mysql_num_rows($res0);
if ($n0 > 0) {//it is such user already
echo 'Пользователь с таким именем уже есть, вернуться ';
echo '<a href="index.php">Назад</a>'; mysql_close($conn); exit();}else{
$date=fulldat(time());
$ip=getenv('REMOTE_ADDR');


$sql="insert into users (login, password, prispace, ip, datereg) values (\"$login\",\"$passw\",'<h2>Blog</h2>',\"$ip\",\"$date\")";
$res=mysql_query($sql, $conn) or die();
if ($res!=false) echo 'Пользователь создан успешно, вернуться <a href="index.php">Назад</a>';
else echo 'Пользователь не создан, вернуться <a href="index.php">Назад</a>';
mysql_close($conn);}
}else{
echo 'Недопустимые символы в имени или пароле';
echo '<br><a href="index.php">Назад</a>';
}
}else{
?>
<h3>Регистрация пользователя</h3>
<form action='register.php' onsubmit='validate()'>
login:<input name='login'>
password:<input type=password name='passw'>
<input type=submit name='newgo' value='create'>
</form>
<?php }
?>

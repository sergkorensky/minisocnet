<?php 
require('checklog.php');// function checklog() that check whether $_SESSION['login'] and $_SESSION['passw'] are the same as in db or not
$flag=1;//security
if (isset($_GET['go'])) {//check login
$login=$_GET['login'];
$passw=$_GET['passw'];
require('connect.php');
mysql_select_db($db);
$patt='/^\w+$/';
if (preg_match($patt,''.$login)) {
$sql="select password from users where login=\"$login\"";
$res=mysql_query($sql, $conn) or die(mysql_error());
$n1=mysql_num_rows($res);
if ($n1 > 0) {//login is true
if ($passw == mysql_result($res,0,'password')) {//passw is true
session_start();
$_SESSION['login']=$login;
$_SESSION['passw']=$passw;

}else{$flag=-1;}//passw is wrong

}else{$flag=-1;}//login is wrong
}else{$flag=-1;}//login is wrong - having not allowed symbols
mysql_close($conn);}

else{session_start();
if (!checklog()) { session_unset(); session_destroy();$flag=-1;} else $login=$_SESSION['login'];}//<-- проверка на совпадение пароля из сессии с паролем в БД, сделана в функции checklog()
?>
<html><head><title>Welcome</title>
<meta http-equiv='content-type' content='text/html; charset=utf-8' >
<style>

#header, #footer {width:100%;height:50px;clear:both;background:cyan;padding-left:10px;}
#left		 {width:200px;float:left;border-right:3px solid cyan;margin-right:-53px;padding-right:50px;}
#main		 {min-width:400px;float:left;margin-left:50px;margin-top:5px;border-left:3px solid cyan;padding-left:20px;min-height:200px;}
h1 		{text-align:center;}
</style>
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
$('#make_user').click(function(){
$("#main").html("<h3>Регистрация пользователя</h3>"+"<form action='register.php'>"+
"логин : <input name='login'><br> пароль:<input type='password' name='passw'>"+
"<input type='submit' name='newgo' value='create'></form>");
});
$('#newmsg').click(function(){
$("#main").html("<h3>Новое сообщение</h3>"+"<form action='addmsg.php'>"+
"Кому (логин): <input name='toN'><br>Сообщение :<textarea style='margin-left:13px' name='body' cols=43 rows=20></textarea>"+
"<br><input type='submit' name='send' value='Send'></form>");
});
$('.msg').click(function(){
$("#main").load('showmsg.php','q='+this.id);

});
$('#prispace').click(function(){
$("#main").load('showblog.php');

});
$('#delmsg').click(function(){
return confirm('Delete these messages?');
});
});
</script>
</head>
<body>
<div id='header'><h1>Welcome<?php if ($flag>0) echo ', '.$login=$_SESSION['login'].' '; ?>!</h1></div>
<div id='left'>
<?php 
if (isset($_GET['go']) && $flag<0) {//check login
echo 'login incorrect, try again!';
}

if ($flag<0) {
echo "<h3>Вход</h3>
<form name='enter'>
login:<input name='login'>
password:<input type=password name='passw'>
<input type=submit name='go' value='Go'><br><br>
</form>
<button id='make_user'>Создать нового пользователя</button>";
 }
else {
//cp of user
$login=$_SESSION['login'];
require('connect.php');
mysql_select_db($db);
echo '<form action="delmsg.php" ><h5>Входящие сообщения от:</h5><hr>';
$sql2="select id_l, fromN from letters where toN=\"$login\"";
$res2=mysql_query($sql2, $conn) or die('error');
while($row=mysql_fetch_array($res2,MYSQL_NUM)){
$id_l=$row[0]; $fromN=$row[1];
echo "<h5 class='msg' id=".$id_l.' ><input type="checkbox" name="dmsg[]" value='.$id_l.'>from: '.$fromN." </h5>";
}
echo "<input type='submit' id='delmsg' value='Delete selected messages' ></form>"."<h5 id='newmsg'>Создать сообщение</h5>";
echo "<h5 id='prispace'>Личное пространство</h5>";
//cp of admin
$sql="select id from users where login=\"$login\"";
$res=mysql_query($sql, $conn) or die(mysql_error());
$n1=mysql_num_rows($res);

if (1 == mysql_result($res,0,'id')) 
{
echo "<button id='adminka' >Список пользователей</button>";?>
<script type='text/javascript'>
//$(document).ready(function(){
$('#adminka').click(function(){
$("#main").load('adminka.php');
});
//});
</script>
<?php
}
mysql_close($conn);
}
?>
</div>
<div id='main'></div>
<div id='footer'><br>The system is working in test mode. You may register and try it.<br><br><a href='index.php'>Refresh</a> or <a href='exit.php'>Exit</a></div>
</body>
</html>

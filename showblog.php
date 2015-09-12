<?php 
require('checklog.php');// function checklog() that check whether $_SESSION['login'] and $_SESSION['passw'] are the same as in db or not
session_start();
header('content-type: text/html; charset=utf-8');
if (checklog()) {//пользователь авторизован
$login=$_SESSION['login'];
require('connect.php');
mysql_select_db($db);
$sql0="select prispace from users where login=\"$login\"";
$res0=mysql_query($sql0, $conn) or die(mysql_error());
$n0=mysql_num_rows($res0);
if ($n0 > 0) {//it is
$text=mysql_result($res0,0,'prispace');
echo "<div id='old'>".$text."</div>";
echo "<div id='log'></div>";
echo "<h4></h4>";
echo "<span id='edit'><b>Добавить </b></span> ";
//echo "<span id='add'><b>Add </b></span>";
echo "<span id='save'><b>Сохранить </b></span>";
echo "<span id='clear'><b>Очистить </b></span>";
echo "<script>
$('#edit').click(function(){
$('#log').html('<textarea id=-2 cols=50 rows=10><br></textarea>');/*new*/

});

$('#add').click(function(){
var text=$('#-2').val();
 $('#old').html(text); 

});
$('#save').click(function(){
if ($('#-2').val()){
var text=$('#old').html() + $('#-2').val();


//var text=$('#old').html();
 $('#main').load('savelog.php','Q='+ text); }

});

$('#clear').click(function(){
var x='уверены?';
if (confirm(x)) {

 $('#main').load('savelog.php','Q=<h2>Blog</h2>'); }

});
</script>";
echo '<hr><br>Вернуться <a href="index.php">Назад</a>';
mysql_close($conn);
}else{
echo 'user не найден';}//
}else{ echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}

?>


<?php
function checklog(){//check login & passw from Session and those from db
session_start();
$login=$_SESSION['login'];
$passw=$_SESSION['passw'];
if (!isset($login) or !isset($passw) ) return false;//
$patt='/^\w+$/';
if (preg_match($patt,''.$login)) {
require('connect.php');
mysql_select_db($db);
/*echo $db;*/
$sql="select password from users where login=\"$login\"";
$res=mysql_query($sql, $conn);
$n1=mysql_num_rows($res);

if ($n1 < 1) {mysql_close($conn); return false;}
if ($passw == mysql_result($res,0,'password')) $a= true; else $a=  false;

}else  $a=false;
return $a;
}

/* var_dump(checklog()); */

?>

<?php 
session_start();
header('content-type: text/html; charset=utf-8');
if (isset($_SESSION['login'])) {//user авторизован
session_unset(); session_destroy(); header('location: index.php'); exit();
}else{session_unset(); session_destroy(); header('location: index.php');
// echo 'Вы не авторизованы, вернуться <a href="index.php">Назад</a>';
}
?>


<?php
session_start();
if (!isset($_GET['go'])){
  echo "<form>
    Login: <input type=text name=login>
    Password: <input type=password name=passwd>
    <input type=submit name=go value=Go>
  </form>";
} else {
   $_SESSION['login']=$_GET['login'];
   $_SESSION['passwd']=$_GET['passwd'];
    if ($_GET['login']=="pit" &&
        $_GET['passwd']=="123") {
        Header("Location: secret_info.php");
    } else echo "Неверный ввод, попробуйте еще раз<br>";
} 
print_r($_SESSION);
?>
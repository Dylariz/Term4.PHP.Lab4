<?php 
session_start();
print_r($_SESSION);
if (!($_SESSION['login']=="pit" && $_SESSION['passwd']==123))
    Header("Location: authorize.php");
?>
<html>

<head>
 <title>Secret info</title>
</head>

<body>
 <p>Здесь я хочу делиться секретами с другом Васей.
</body>

</html>
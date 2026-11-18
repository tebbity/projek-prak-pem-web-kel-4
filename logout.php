<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>

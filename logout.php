<?php
session_start();
<<<<<<< HEAD
session_destroy();
header("Location: login.php");
exit;
?>
=======
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
>>>>>>> origin/main

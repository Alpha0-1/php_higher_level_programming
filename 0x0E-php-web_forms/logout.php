<?php
session_start();
session_destroy();
header("Location: 8-login_form.php");
exit();
?>

<?php
// Integrantes
session_start();
$_SESSION = [];
session_destroy();
header("Location: form_login.php");
exit();
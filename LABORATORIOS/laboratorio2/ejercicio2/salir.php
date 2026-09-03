<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
// cierra la sesion del cliente y borra las cookies
session_start();
$_SESSION = [];
session_destroy();

setcookie("cliente", "", time() - 3600, "/");
setcookie("tema", "", time() - 3600, "/");

header("Location: tienda.php");
exit();

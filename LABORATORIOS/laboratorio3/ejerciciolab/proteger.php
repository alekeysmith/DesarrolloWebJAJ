<?php
// integrantes : Julian Joan Alexander
//               Jimenez Amachuy Franco Milton
session_start();
if (!isset($_SESSION["correo"])) {
    header("Location: form_login.php?error=2");
    exit();
}
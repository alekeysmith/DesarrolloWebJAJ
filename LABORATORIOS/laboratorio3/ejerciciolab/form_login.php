<?php
// Integrantes:Julian Joan Alexander
//             Jimenez Amachuy Franco Milton 
$error = isset($_GET["error"]) ? $_GET["error"] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso - Consultorio USFX</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="login">
    <h1>Consultorio USFX</h1>
    <p class="sub">Sistema de pacientes y citas - SIS 256</p>

    <?php if ($error == "1"): ?>
        <div class="aviso aviso-error">Correo o contrasena incorrectos.</div>
    <?php elseif ($error == "2"): ?>
        <div class="aviso aviso-error">Debe iniciar sesion para ver esa pagina.</div>
    <?php endif; ?>

    <form method="POST" action="autenticar.php">
        <div class="campo">
            <label>Correo electronico</label>
            <input type="email" name="correo" placeholder="usuario@sis256.edu" required>
        </div>
        <div class="campo">
            <label>Contrasena</label>
            <input type="password" name="clave" required>
        </div>
        <input type="submit" value="Ingresar" class="boton">
    </form>

    <div class="ayuda">
        Usuarios de prueba:<br>
        admin@sis256.edu / 123 (rol admin)<br>
        recepcion@sis256.edu / 123 (rol user)
    </div>
</div>
</body>
</html>
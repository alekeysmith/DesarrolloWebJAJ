<?php
// api/contacto.php - Recibe los formularios (JSON) y los guarda en un archivo.
header("Content-Type: application/json; charset=UTF-8");

function responder(int $codigo, array $cuerpo): void {
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

function texto(array $data, string $campo): string {
    return trim((string)($data[$campo] ?? ""));
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responder(405, ["exito" => false, "error" => "Metodo no permitido"]);
}

// Los datos llegan como JSON desde fetch()
$data = json_decode(file_get_contents("php://input"), true);
if (!is_array($data)) {
    responder(400, ["exito" => false, "error" => "Datos invalidos"]);
}

$tipo = texto($data, "tipo");

// Validacion en el SERVIDOR (la del navegador no es suficiente)
if ($tipo === "mensaje") {
    $nombre  = texto($data, "nombre");
    $email   = texto($data, "email");
    $mensaje = texto($data, "mensaje");
    $fecha   = texto($data, "fecha");
    $sexo    = texto($data, "sexo");
    $pelicula = texto($data, "pelicula");

    if ($nombre === "" || $email === "" || $mensaje === "") {
        responder(422, ["exito" => false, "error" => "Completa nombre, email y mensaje"]);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        responder(422, ["exito" => false, "error" => "Correo invalido"]);
    }
    if (mb_strlen($nombre) > 80 || mb_strlen($email) > 120 || mb_strlen($mensaje) > 1000) {
        responder(422, ["exito" => false, "error" => "Algun campo es demasiado largo"]);
    }
    if ($fecha !== "" && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        responder(422, ["exito" => false, "error" => "Fecha invalida"]);
    }
    if (!in_array($sexo, ["", "masculino", "femenino"], true) ||
        !in_array($pelicula, ["", "fantasia", "historia"], true)) {
        responder(422, ["exito" => false, "error" => "Opcion invalida"]);
    }

    $registro = compact("tipo", "nombre", "email", "fecha", "sexo", "pelicula", "mensaje");

} elseif ($tipo === "conexion") {
    $manera = texto($data, "manera");
    $area   = texto($data, "area");

    if (!in_array($manera, ["email", "telefono", "redes_sociales"], true) ||
        !in_array($area, ["medicina", "ciencias_exactas", "deportes"], true)) {
        responder(422, ["exito" => false, "error" => "Elige una opcion en cada lista"]);
    }

    $registro = compact("tipo", "manera", "area");

} else {
    responder(400, ["exito" => false, "error" => "Tipo de formulario desconocido"]);
}

$registro = ["fecha_envio" => date("Y-m-d H:i:s")] + $registro;
$linea = json_encode($registro, JSON_UNESCAPED_UNICODE) . PHP_EOL;

if (file_put_contents(__DIR__ . "/mensajes.jsonl", $linea, FILE_APPEND | LOCK_EX) === false) {
    responder(500, ["exito" => false, "error" => "No se pudo guardar"]);
}

responder(200, ["exito" => true]);

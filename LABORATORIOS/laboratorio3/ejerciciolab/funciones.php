<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
// Devuelve: "" si no eligio archivo, "ERROR: ..." si algo fallo, o el nombre nuevo
function subirFotografia($campo) {
    if ($_FILES[$campo]["error"] === UPLOAD_ERR_NO_FILE) {
        return "";
    }
    if ($_FILES[$campo]["size"] > 2 * 1024 * 1024) {
        return "ERROR: la foto pesa mas de 2 MB";
    }
    $ext = strtolower(pathinfo($_FILES[$campo]["name"], PATHINFO_EXTENSION));
    $permitidas = ["jpg", "jpeg", "png", "webp"];
    if (!in_array($ext, $permitidas)) {
        return "ERROR: solo se permite jpg, jpeg, png o webp";
    }
    $nuevo = uniqid() . "." . $ext;
    if (!move_uploaded_file($_FILES[$campo]["tmp_name"], "images/" . $nuevo)) {
        return "ERROR: no se pudo guardar la foto";
    }
    return $nuevo;
}
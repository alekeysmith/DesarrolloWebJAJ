<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $operacion = $_POST["operacion"];
    $n = intval($_POST['n']);

    if ($n < 1   || $n > 10 ) {
        echo "El numero debe estar entre a y 10. ";
        exit;
    }
    

  //definir titulo y simbolo segun la operacion

  switch ($operacion) {
    case 'suma':
        $simbolo = '+';
        break;
    case 'resta':
        $simbolo = '-';
        break;
    case 'multiplicacion' :
        $simbolo = '*';
        break;
    case 'division' :
        $simbolo = '/' ;
        break;
  }
} else {
    header("Location : Tabla.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
            font-family Arial, sans-serif;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-aling : center;
            width :40px;
            height: 40px;
        }
        .gris {
            background-color: #D9D9D9;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2><?php echo $titulo; ?></h2>

    <table>
        <!-- Fila de cabecera -->
        <tr>
            <td class="gris"><?php echo $simbolo; ?></td>
            <?php for ($j = 1; $j <= $n; $j++): ?>
                <td class="gris"><?php echo $j; ?></td>
            <?php endfor; ?>
        </tr>

        <!-- Filas de la tabla -->
        <?php for ($i = 1; $i <= $n; $i++): ?>
            <tr>
                <!-- Primera columna con fondo gris y negrita -->
                <td class="gris"><?php echo $i; ?></td>
                
                <!-- Celdas de resultados -->
                <?php for ($j = 1; $j <= $n; $j++): ?>
                    <td>
                        <?php 
                        switch ($operacion) {
                            case 'suma':
                                echo $i + $j;
                                break;
                            case 'resta':
                                echo $i - $j;
                                break;
                            case 'multiplicacion':
                                echo $i * $j;
                                break;
                            case 'division':
                                echo number_format($i / $j, 2);
                                break;
                        }
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <br>
    <a href="tabla.html">Volver al formulario</a>
    
</body>
</html>

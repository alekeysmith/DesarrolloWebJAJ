<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tabla de <?php echo ucfirst($_GET["operacion"]); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            margin: 30px auto;
        }
        td, th {
            border: 1px solid #ccc;
            width: 50px;
            height: 35px;
            text-align: center;
        }
        th {
            background-color: #F79646;
            color: white;
        }
        h2 {
            text-align: center;
            color: #F79646;
        }
    </style>
</head>
<body>

<?php
    $operacion = $_GET["operacion"];
    $n = $_GET["n"];

    var_dump($operacion); // <-- línea temporal de diagnóstico
    
    echo "<h2>Tabla de " . ucfirst($operacion) . "</h2>";
?>

<table>
    <tr>
        <th></th>
        <?php for ($col = 1; $col <= $n; $col++) { ?>
            <th><?php echo $col; ?></th>
        <?php } ?>
    </tr>

    <?php for ($fila = 1; $fila <= $n; $fila++) { ?>
        <tr>
            <th><?php echo $fila; ?></th>
            <?php for ($col = 1; $col <= $n; $col++) {
                switch ($operacion) {
                    case "suma":
                        $resultado = $fila + $col;
                        break;
                    case "resta":
                        $resultado = $fila - $col;
                        break;
                    case "multiplicacion":
                        $resultado = $fila * $col;
                        break;
                    case "division":
                        $resultado = $col != 0 ? round($fila / $col, 2) : "N/A";
                        break;
                }
                echo "<td>" . $resultado . "</td>";
            } ?>
        </tr>
    <?php } ?>
</table>

</body>
</html>


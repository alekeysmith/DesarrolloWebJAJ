<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero</title>

    <style>
        table {
            border-collapse: collapse;
            margin:40px auto;

        }
        td {
            width: 50px;
            height: 50px;
        }
        .blanco {
            background-color: #f0d9b5;
        }
        .negro {
            background-color: #b58863;
        }
    </style>
</head>
<body>

    <table>
           
       <?php
           $filas=$_GET["filas"];
           $columnas=$_GET["columnas"];

           for ($i=0;$i<$filas;$i++) {
            echo "<tr>";
            for ($j = 0; $j <$columnas; $j++) {
                if (($i+$j) %2 == 0) {
                    echo "<td class='blanco'> &nbsp;</td>";

                } else {
                    echo "<td class='negro'> &nbsp;</td>";
                }
            }
            echo "</tr>";
           }
        ?> 
    </table>
</body>
</html>
<?php
require_once "conexion.php";

$sql = "SELECT id, titulo, autor, anio, editorial FROM libros";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Libros</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: center;
        }
        /* Encabezado con fondo #2C3E50 y texto blanco */
        th {
            background-color: #2C3E50;
            color: white;
        }
        /* Filas intercaladas: impares blancas, pares #F2F2F2 */
        .fila-impar {
            background-color: #FFFFFF;
        }
        .fila-par {
            background-color: #F2F2F2;
        }
        a {
            color: blue;
        }
        .btn-nuevo {
            display: inline-block;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Listado de Libros</h2>

    <a href="form-insertar.html" class="btn-nuevo">Nuevo Libro</a>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Año</th>
                <th>Editorial</th>
                <th>Operación</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            while ($fila = $resultado->fetch_assoc()): 
                // Intercalado de colores según el índice de la fila
                $claseFila = ($i % 2 == 0) ? "fila-par" : "fila-impar";
                $i++;
            ?>
                <tr class="<?= $claseFila ?>">
                    <td><?= htmlspecialchars($fila["titulo"]) ?></td>
                    <td><?= htmlspecialchars($fila["autor"]) ?></td>
                    <td><?= htmlspecialchars($fila["anio"]) ?></td>
                    <td><?= htmlspecialchars($fila["editorial"]) ?></td>
                    <td>
                        <a href="eliminar.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que desea eliminar este libro?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
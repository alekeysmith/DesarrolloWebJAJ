<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
         body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        width: 250px;
    }

    input[type="number"] {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
    </style>
</head>
<body>
    
 <?php
   $n= $_GET["n"];
?>

<form action="resultados.php" method="post">
    <?php
    for($i=1;$i<=$n;$i++) {
        echo '<input type="number" name="numeros[]" required><br>';
    }
    ?>

   <input type="submit" value="Sumar">
</form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    

<?php
  $numeros = $_POST["numeros"];
  $suma = 0;
  foreach($numeros as $num) {
    $suma += $num ;
  }
  echo "<h2>La suma es:" . $suma . "</h2>";
?>
</body>
</html>

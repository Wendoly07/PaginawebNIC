<?php
// Inicia el bloque de código PHP

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON

$host = "srvdbcacdev.database.windows.net";
// Define el nombre del servidor de la base de datos

$db   = "dblotocacdev";
// Define el nombre de la base de datos

$user = "LotoAdmin";
// Define el nombre de usuario para la conexión a la base de datos

$pass = "LotAdmin1.";
// Define la contraseña para la conexión a la base de datos

try {
    // Inicia un bloque try para manejar excepciones

    $conn = new PDO("sqlsrv:server=$host;Database=$db", $user, $pass);
    // Crea una nueva conexión PDO a SQL Server usando el host, base de datos, usuario y contraseña

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura PDO para lanzar excepciones en caso de errores

    // Tomamos solo el último sorteo del juego 2 (Super Premio)
    // Comentario original: Selecciona solo el último sorteo del juego 2 (Super Premio)

    $stmt = $conn->prepare("SELECT TOP 1 * FROM loto_sorteos_sv WHERE juego = 2 ORDER BY id DESC");
    // Prepara una consulta SQL para seleccionar el primer registro (el más reciente) de la tabla loto_sorteos_sv donde juego es 2, ordenado por id descendente

    $stmt->execute();
    // Ejecuta la consulta preparada

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Obtiene el resultado de la consulta como un array asociativo

    if($row){
        // Si se encontró un resultado (row no es null)

        echo json_encode([
            // Codifica y envía un array JSON con los resultados formateados

            "par1" => str_pad($row["par1"], 2, "0", STR_PAD_LEFT),
            // Formatea par1 con ceros a la izquierda hasta tener 2 dígitos

            "par2" => str_pad($row["par2"], 2, "0", STR_PAD_LEFT),
            // Formatea par2 con ceros a la izquierda hasta tener 2 dígitos

            "par3" => str_pad($row["par3"], 2, "0", STR_PAD_LEFT),
            // Formatea par3 con ceros a la izquierda hasta tener 2 dígitos

            "par4" => str_pad($row["par4"], 2, "0", STR_PAD_LEFT),
            // Formatea par4 con ceros a la izquierda hasta tener 2 dígitos

            "par5" => str_pad($row["par5"], 2, "0", STR_PAD_LEFT)
            // Formatea par5 con ceros a la izquierda hasta tener 2 dígitos

        ]);

    } else {
        // Si no se encontró ningún resultado

        echo json_encode(["error" => "No hay resultados"]);
        // Envía un JSON con un mensaje de error indicando que no hay resultados

    }

} catch(PDOException $e){
    // Captura cualquier excepción de PDO

    echo json_encode(["error" => $e->getMessage()]);
    // Envía un JSON con el mensaje de error de la excepción

}

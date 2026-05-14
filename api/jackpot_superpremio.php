<?php
// Inicia el bloque de código PHP

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON
// Define el nombre del servidor de la base de datos
// Define el nombre de la base de datos
// Define el nombre de usuario para la conexión a la base de datos
// Define la contraseña para la conexión a la base de datos

try {
    // Inicia un bloque try para manejar excepciones

    // Conexión a SQL Server
    require_once __DIR__ . '/../config/connection.php';
    // Crea una nueva conexión PDO a SQL Server usando el servidor, base de datos, usuario y contraseña

    // Configura PDO para lanzar excepciones en caso de errores

    // Obtener el jackpot del último sorteo
    $stmt = $conn->query("SELECT TOP 1 jackpot FROM loto_jackpot_superpremio ORDER BY nsorteo DESC");
    // Ejecuta una consulta directa para seleccionar el primer registro (el más reciente) de la columna jackpot de la tabla loto_jackpot_superpremio, ordenado por nsorteo descendente

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    // Obtiene el resultado de la consulta como un array asociativo

    // Devolver JSON
    echo json_encode([
        // Codifica y envía un array JSON con el valor del jackpot

        "jackpot" => $resultado['jackpot'] ?? 0
        // El valor del jackpot, o 0 si no existe

    ]);

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO

    // Si hay error en la conexión o la consulta
    echo json_encode([
        // Envía un JSON con el mensaje de error

        "error" => $e->getMessage()
        // El mensaje de error de la excepción

    ]);
}

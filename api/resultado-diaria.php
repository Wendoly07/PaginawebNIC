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
    // PDO para SQL Server
    $conn = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
    // Crea una nueva conexión PDO a SQL Server usando el host, base de datos, usuario y contraseña
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura PDO para lanzar excepciones en caso de errores
    // Consulta último resultado de Diaria
    $stmt = $conn->query("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE TRY_CONVERT(int, game_name) = 13
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC, id DESC");
    // Ejecuta una consulta directa para seleccionar el primer registro (el mÃ¡s reciente) de la tabla loto_sorteos_sv donde juego es 1, ordenado por id descendente
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Obtiene el resultado de la consulta como un array asociativo
    if (!$row) {
        // Si no se encontró ningún resultado (row es null)
        echo json_encode(["error" => "No hay resultados"]);
        // Envía un JSON con un mensaje de error indicando que no hay resultados
        exit;
        // Termina la ejecución del script
    }
    $numero = str_pad($row["par1"], 2, "0", STR_PAD_LEFT);
    // Formatea el valor de par1 con ceros a la izquierda hasta tener 2 dígitos y lo asigna a $numero
    echo json_encode([
        // Codifica y envía un array JSON con los detalles del resultado

        "digito1" => $numero[0],
        // Primer dígito del número formateado

        "digito2" => $numero[1],
        // Segundo dígito del número formateado

        "numero"  => $numero,
        // El número completo formateado

        "sorteo"  => $row["draw_number"],
        // El número del sorteo

        "hora"    => $row["draw_time"],
        // La hora del sorteo

        "fecha"   => $row["draw_date"]
        // La fecha del sorteo

    ]);

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO

    echo json_encode(["error" => $e->getMessage()]);
    // Envía un JSON con el mensaje de error de la excepción

}

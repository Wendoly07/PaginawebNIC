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
    // Inicia un bloque try para intentar la conexión a la base de datos

    $conn = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
    // Crea una nueva conexión PDO a SQL Server usando el host, base de datos, usuario y contraseña

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura PDO para lanzar excepciones en caso de errores

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO durante la conexión

    echo json_encode(['error' => $e->getMessage()]);
    // Envía un JSON con el mensaje de error de la excepción

    exit;
    // Termina la ejecución del script
}

if (!isset($_GET['fecha'])) {
    // Verifica si el parámetro 'fecha' no está presente en la solicitud GET

    echo json_encode(['error' => 'No se proporcionó fecha']);
    // Envía un JSON con un mensaje de error indicando que no se proporcionó la fecha

    exit;
    // Termina la ejecución del script
}

$fecha = $_GET['fecha']; // espera formato YYYY-MM-DD
// Asigna el valor del parámetro 'fecha' de GET a la variable $fecha (espera formato YYYY-MM-DD)

$gameName = 13; // DIARIA
// Establece el identificador del juego Diaria en la columna game_name

$sql = "
SELECT
    DATEPART(HOUR, hora) AS hora_sorteo,
    par1
FROM numeros_ganadores_sorteos_prod
WHERE game_name = :game_name
AND CONVERT(date, fecha) = :fecha
AND UPPER(LTRIM(RTRIM(pais))) IN ('NICARAGUA', 'NI', 'NIC')
";
// Define la consulta SQL para seleccionar la hora del sorteo y par1 de la tabla numeros_ganadores_sorteos_prod donde game_name es 13, el pais es Nicaragua y la fecha coincide

$stmt = $conn->prepare($sql);
// Prepara la consulta SQL para ejecución

$stmt->execute([
    'game_name' => $gameName,
    'fecha' => $fecha
]);
// Ejecuta la consulta preparada, pasando los parametros game_name y fecha

$resultados = [
    '12:00' => null,
    '15:00' => null,
    '18:00' => null,
    '21:00' => null
];
// Inicializa un array asociativo con las horas de sorteo predeterminadas con valores null

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Inicia un bucle while para recorrer cada fila del resultado de la consulta

    $hora = $row['hora_sorteo'];
    // Asigna la hora del sorteo de la fila actual a la variable $hora

    if ($hora == 12) {
        // Si la hora es 12

        $resultados['12:00'] = str_pad($row['par1'], 2, '0', STR_PAD_LEFT);
        // Asigna el valor de par1 formateado con ceros a la izquierda a la clave '12:00' del array resultados

    } elseif ($hora == 15) {
        // Si la hora es 15

        $resultados['15:00'] = str_pad($row['par1'], 2, '0', STR_PAD_LEFT);
        // Asigna el valor de par1 formateado con ceros a la izquierda a la clave '15:00' del array resultados

    } elseif ($hora == 18) {
        // Si la hora es 18

        $resultados['18:00'] = str_pad($row['par1'], 2, '0', STR_PAD_LEFT);
        // Asigna el valor de par1 formateado con ceros a la izquierda a la clave '18:00' del array resultados

    } elseif ($hora == 21) {
        // Si la hora es 21

        $resultados['21:00'] = str_pad($row['par1'], 2, '0', STR_PAD_LEFT);
        // Asigna el valor de par1 formateado con ceros a la izquierda a la clave '21:00' del array resultados

    }
    // Fin del bucle if-elseif
}
// Fin del bucle while

echo json_encode($resultados);
// Codifica el array resultados como JSON y lo envía como respuesta

<?php
// Inicia el bloque de codigo PHP

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON

$host = "srvdbcacdev.database.windows.net";
// Define el nombre del servidor de la base de datos

$db   = "dblotocacdev";
// Define el nombre de la base de datos

$user = "LotoAdmin";
// Define el nombre de usuario para la conexion a la base de datos

$pass = "LotAdmin1.";
// Define la contrasena para la conexion a la base de datos

try {
    // Inicia un bloque try para intentar la conexion a la base de datos

    $conn = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
    // Crea una nueva conexion PDO a SQL Server usando el host, base de datos, usuario y contrasena

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura PDO para lanzar excepciones en caso de errores

} catch (PDOException $e) {
    // Captura cualquier excepcion de PDO durante la conexion

    echo json_encode(['error' => $e->getMessage()]);
    // Envia un JSON con el mensaje de error de la excepcion

    exit;
    // Termina la ejecucion del script
}

if (!isset($_GET['fecha'])) {
    // Verifica si el parametro 'fecha' no esta presente en la solicitud GET

    echo json_encode(['error' => 'No se proporciono fecha']);
    // Envia un JSON con un mensaje de error indicando que no se proporciono la fecha

    exit;
    // Termina la ejecucion del script
}

$fecha = $_GET['fecha']; // espera formato YYYY-MM-DD
// Asigna el valor del parametro 'fecha' de GET a la variable $fecha (espera formato YYYY-MM-DD)

$gameName = 13; // DIARIA
// Establece el identificador del juego Diaria en la columna game_name

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    par1
FROM numeros_ganadores_sorteos_prod
WHERE game_name = :game_name
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
ORDER BY draw_time ASC
";
// Define la consulta SQL para seleccionar la hora del sorteo y par1 de la tabla numeros_ganadores_sorteos_prod donde game_name es 13, el pais es Nicaragua y la fecha coincide

try {
    $stmt = $conn->prepare($sql);
    // Prepara la consulta SQL para ejecucion

    $stmt->execute([
        'game_name' => $gameName,
        'fecha' => $fecha
    ]);
    // Ejecuta la consulta preparada, pasando los parametros game_name y fecha
} catch (PDOException $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        '12:00' => null,
        '15:00' => null,
        '18:00' => null,
        '21:00' => null
    ]);
    exit;
}

$resultados = [
    '12:00' => null,
    '15:00' => null,
    '18:00' => null,
    '21:00' => null
];
// Inicializa un array asociativo con las horas de sorteo predeterminadas con valores null

$filas = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Inicia un bucle while para recorrer cada fila del resultado de la consulta

    $hora = $row['hora_sorteo'];
    // Asigna la hora del sorteo de la fila actual a la variable $hora

    $filas++;

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

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => $gameName,
        'filas' => $filas
    ];
}

echo json_encode($resultados);
// Codifica el array resultados como JSON y lo envia como respuesta

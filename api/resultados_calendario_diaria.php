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

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    UPPER(LTRIM(RTRIM(game_name))) AS game_name,
    par1,
    par2,
    par3
FROM numeros_ganadores_sorteos_prod
WHERE UPPER(LTRIM(RTRIM(game_name))) IN ('13', 'DIARIA', 'MULTI-X-DIARIA', N'MÁS 1', 'MAS 1')
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
ORDER BY draw_time ASC,
CASE
    WHEN UPPER(LTRIM(RTRIM(game_name))) IN ('13', 'DIARIA') THEN 1
    WHEN UPPER(LTRIM(RTRIM(game_name))) = 'MULTI-X-DIARIA' THEN 2
    WHEN UPPER(LTRIM(RTRIM(game_name))) IN (N'MÁS 1', 'MAS 1') THEN 3
    ELSE 4
END,
CASE WHEN UPPER(LTRIM(RTRIM(game_name))) = 'DIARIA' THEN 1 ELSE 0 END
";
// Define la consulta SQL para seleccionar la hora del sorteo y par1 de la tabla numeros_ganadores_sorteos_prod donde game_name es 13, el pais es Nicaragua y la fecha coincide

try {
    $stmt = $conn->prepare($sql);
    // Prepara la consulta SQL para ejecucion

    $stmt->execute([
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

    $hora = (int) $row['hora_sorteo'];
    // Asigna la hora del sorteo de la fila actual a la variable $hora

    $filas++;

    $clave = null;
    if ($hora == 11 || $hora == 12) {
        $clave = '12:00';
    } elseif ($hora == 14 || $hora == 15) {
        $clave = '15:00';
    } elseif ($hora == 17 || $hora == 18) {
        $clave = '18:00';
    } elseif ($hora == 20 || $hora == 21) {
        $clave = '21:00';
    }

    if ($clave !== null) {
        if ($resultados[$clave] === null) {
            $resultados[$clave] = ['0', '0', '0', '0'];
        }

        $gameName = strtoupper(trim((string) $row['game_name']));

        if ($gameName === '13' || $gameName === 'DIARIA') {
            $numero = str_pad($row['par1'], 2, '0', STR_PAD_LEFT);
            $resultados[$clave][0] = $numero[0];
            $resultados[$clave][1] = $numero[1];
            if ($gameName === 'DIARIA') {
                $resultados[$clave][2] = (string) ($row['par2'] ?? '0');
            }
        } elseif ($gameName === 'MULTI-X-DIARIA') {
            $resultados[$clave][2] = (string) ($row['par2'] ?? $row['par1'] ?? '0');
        } elseif ($gameName === 'MÁS 1' || $gameName === 'MAS 1') {
            $resultados[$clave][3] = (string) ($row['par2'] ?? $row['par1'] ?? '0');
        }
    }
    // Fin del bucle if-elseif
}
// Fin del bucle while

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => ['13', 'DIARIA', 'Multi-X-Diaria', 'Más 1'],
        'filas' => $filas
    ];
}

echo json_encode($resultados);
// Codifica el array resultados como JSON y lo envia como respuesta

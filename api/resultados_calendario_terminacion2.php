<?php
header('Content-Type: application/json');

$host = "srvdbcacdev.database.windows.net";
$db   = "dblotocacdev";
$user = "LotoAdmin";
$pass = "LotAdmin1.";

try {
    $conn = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

if (!isset($_GET['fecha'])) {
    echo json_encode(['error' => 'No se proporciono fecha']);
    exit;
}

$fecha = $_GET['fecha'];
$gameName = 5; // Terminacion 2

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    par1
FROM numeros_ganadores_sorteos_prod
WHERE game_name = :game_name
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
AND DATEPART(HOUR, draw_time) = 18
ORDER BY draw_time ASC
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'game_name' => $gameName,
        'fecha' => $fecha
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        '18:00' => null
    ]);
    exit;
}

$resultados = [
    '18:00' => null
];

$filas = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $filas++;
    $numero = isset($row['par1']) ? (string) $row['par1'] : null;

    if ($row['hora_sorteo'] == 18) {
        $resultados['18:00'] = $numero;
    }
}

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => $gameName,
        'filas' => $filas
    ];
}

echo json_encode($resultados);

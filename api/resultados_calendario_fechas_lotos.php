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
$gameName = 12; // Fechas Lotos

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    par1,
    par2
FROM numeros_ganadores_sorteos_prod
WHERE game_name = :game_name
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
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

$filas = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $filas++;
    $resultado = [
        'numero' => str_pad((string) $row['par1'], 2, '0', STR_PAD_LEFT),
        'mes' => $row['par2']
    ];

    $hora = $row['hora_sorteo'];
    if ($hora == 12) {
        $resultados['12:00'] = $resultado;
    } elseif ($hora == 15) {
        $resultados['15:00'] = $resultado;
    } elseif ($hora == 18) {
        $resultados['18:00'] = $resultado;
    } elseif ($hora == 21) {
        $resultados['21:00'] = $resultado;
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

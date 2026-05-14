<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

if (!isset($_GET['fecha'])) {
    echo json_encode(['error' => 'No se proporciono fecha']);
    exit;
}

$fecha = $_GET['fecha'];

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    UPPER(LTRIM(RTRIM(game_name))) AS game_name,
    par1,
    par2
FROM numeros_ganadores_sorteos_prod
WHERE UPPER(LTRIM(RTRIM(game_name))) IN ('12', 'FECHAS')
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
ORDER BY draw_time ASC,
CASE WHEN UPPER(LTRIM(RTRIM(game_name))) = 'FECHAS' THEN 1 ELSE 0 END
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([
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

    $hora = (int) $row['hora_sorteo'];
    if ($hora == 11 || $hora == 12) {
        $resultados['12:00'] = $resultado;
    } elseif ($hora == 14 || $hora == 15) {
        $resultados['15:00'] = $resultado;
    } elseif ($hora == 17 || $hora == 18) {
        $resultados['18:00'] = $resultado;
    } elseif ($hora == 20 || $hora == 21) {
        $resultados['21:00'] = $resultado;
    }
}

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => ['12', 'FECHAS'],
        'filas' => $filas
    ];
}

echo json_encode($resultados);

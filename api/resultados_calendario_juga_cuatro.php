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
$gameName = 10; // Juga Cuatro

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    par1,
    par2,
    par3,
    par4
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
    $numero = [
        isset($row['par1']) ? (string) $row['par1'] : null,
        isset($row['par2']) ? (string) $row['par2'] : null,
        isset($row['par3']) ? (string) $row['par3'] : null,
        isset($row['par4']) ? (string) $row['par4'] : null
    ];

    $hora = $row['hora_sorteo'];
    if ($hora == 12) {
        $resultados['12:00'] = $numero;
    } elseif ($hora == 15) {
        $resultados['15:00'] = $numero;
    } elseif ($hora == 18) {
        $resultados['18:00'] = $numero;
    } elseif ($hora == 21) {
        $resultados['21:00'] = $numero;
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

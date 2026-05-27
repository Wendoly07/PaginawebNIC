<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';
    if (!$conn) {
        throw new PDOException('Database connection unavailable');
    }
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
echo json_encode(['error' => 'Error interno']);
    exit;
}

if (!isset($_GET['fecha'])) {
    echo json_encode(['error' => 'No se proporciono fecha']);
    exit;
}

$fecha = $_GET['fecha'];
$gameNames = ['5', 'TERMINACION 2']; // Terminacion 2

$sql = "
SELECT
    DATEPART(HOUR, draw_time) AS hora_sorteo,
    par1
FROM numeros_ganadores_sorteos_prod
WHERE UPPER(LTRIM(RTRIM(game_name))) IN (:game_name_id, :game_name_texto)
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
AND DATEPART(HOUR, draw_time) IN (17, 18)
ORDER BY draw_time ASC
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'game_name_id' => $gameNames[0],
        'game_name_texto' => $gameNames[1],
        'fecha' => $fecha
    ]);
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
echo json_encode([
        'error' => 'Error interno',
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

    $hora = (int) $row['hora_sorteo'];
    if ($hora == 17 || $hora == 18) {
        $resultados['18:00'] = $numero;
    }
}

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => $gameNames,
        'filas' => $filas
    ];
}

echo json_encode($resultados);
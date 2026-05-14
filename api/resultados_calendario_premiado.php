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
    par2,
    par3,
    par4
FROM numeros_ganadores_sorteos_prod
WHERE UPPER(LTRIM(RTRIM(game_name))) = 'PREMIA 2'
AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
AND CONVERT(date, draw_date) = :fecha
ORDER BY draw_time ASC
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
    $par1 = str_pad((string) $row['par1'], 2, '0', STR_PAD_LEFT);
    $par2 = str_pad((string) $row['par2'], 2, '0', STR_PAD_LEFT);
    $numero = [
        $par1[0],
        $par1[1],
        $par2[0],
        $par2[1]
    ];

    $hora = (int) $row['hora_sorteo'];
    if ($hora == 11 || $hora == 12) {
        $resultados['12:00'] = $numero;
    } elseif ($hora == 14 || $hora == 15) {
        $resultados['15:00'] = $numero;
    } elseif ($hora == 17 || $hora == 18) {
        $resultados['18:00'] = $numero;
    } elseif ($hora == 20 || $hora == 21) {
        $resultados['21:00'] = $numero;
    }
}

if (isset($_GET['debug'])) {
    $resultados['_debug'] = [
        'fecha' => $fecha,
        'game_name' => 'Premia 2',
        'filas' => $filas
    ];
}

echo json_encode($resultados);

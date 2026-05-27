<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';
    if (!$conn) {
        throw new PDOException('Database connection unavailable');
    }

    $stmt = $conn->prepare("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE UPPER(LTRIM(RTRIM(game_name))) IN ('5', 'TERMINACION 2')
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          AND DATEPART(HOUR, draw_time) IN (17, 18)
                          ORDER BY draw_date DESC, draw_time DESC, draw_number DESC");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    $numero = $row["par1"] ?? $row["result_raw"] ?? null;

    echo json_encode([
        "numero" => isset($numero) ? (string) $numero : null,
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
echo json_encode(["error" => 'Error interno']);
}

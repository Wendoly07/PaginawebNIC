<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';

    $stmt = $conn->query("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE UPPER(LTRIM(RTRIM(game_name))) IN ('12', 'FECHAS')
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    echo json_encode([
        "numero" => str_pad((string) $row["par1"], 2, "0", STR_PAD_LEFT),
        "mes" => $row["par2"],
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

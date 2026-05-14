<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';

    $stmt = $conn->query("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE UPPER(LTRIM(RTRIM(game_name))) = 'PREMIA 2'
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    $par1 = str_pad((string) $row["par1"], 2, "0", STR_PAD_LEFT);
    $par2 = str_pad((string) $row["par2"], 2, "0", STR_PAD_LEFT);

    echo json_encode([
        "par1" => $par1[0],
        "par2" => $par1[1],
        "par3" => $par2[0],
        "par4" => $par2[1],
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

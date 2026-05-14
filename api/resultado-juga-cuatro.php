<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';
    if (!$conn) {
        throw new PDOException('Database connection unavailable');
    }

    $stmt = $conn->prepare("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE game_name = 10
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    echo json_encode([
        "par1" => isset($row["par1"]) ? (string) $row["par1"] : null,
        "par2" => isset($row["par2"]) ? (string) $row["par2"] : null,
        "par3" => isset($row["par3"]) ? (string) $row["par3"] : null,
        "par4" => isset($row["par4"]) ? (string) $row["par4"] : null,
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
echo json_encode(["error" => 'Error interno']);
}

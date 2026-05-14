<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../config/connection.php';
    if (!$conn) {
        throw new PDOException('Database connection unavailable');
    }

    $stmt = $conn->prepare("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE UPPER(LTRIM(RTRIM(game_name))) = 'JUGA 3'
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    if ($row["par2"] !== null || $row["par3"] !== null) {
        $numero = sprintf('%s%s%s', (string) $row["par1"], (string) $row["par2"], (string) $row["par3"]);
    } else {
        $numero = str_pad((string) $row["par1"], 3, "0", STR_PAD_LEFT);
    }

    echo json_encode([
        "par1" => $numero[0],
        "par2" => $numero[1],
        "par3" => $numero[2],
        "numero" => $numero,
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
echo json_encode(["error" => 'Error interno']);
}

<?php
header('Content-Type: application/json');

$host = "srvdbcacdev.database.windows.net";
$db   = "dblotocacdev";
$user = "LotoAdmin";
$pass = "LotAdmin1.";

try {
    $conn = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT TOP 1 *
                          FROM numeros_ganadores_sorteos_prod
                          WHERE game_name = 9
                          AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
                          ORDER BY draw_date DESC, draw_time DESC");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    echo json_encode([
        "par1" => isset($row["par1"]) ? (string) $row["par1"] : null,
        "par2" => isset($row["par2"]) ? (string) $row["par2"] : null,
        "par3" => isset($row["par3"]) ? (string) $row["par3"] : null,
        "draw_number" => $row["draw_number"],
        "draw_time" => $row["draw_time"],
        "draw_date" => $row["draw_date"]
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

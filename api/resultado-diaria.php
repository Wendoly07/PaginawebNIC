<?php
// Inicia el bloque de código PHP
header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON
function valorResultRaw($row, $indice, $default = null) {
    if (!isset($row['result_raw']) || $row['result_raw'] === null) {
        return $default;
    }

    $partes = array_map('trim', explode(',', (string) $row['result_raw']));
    return ($partes[$indice] ?? '') !== '' ? $partes[$indice] : $default;
}

// Define el nombre del servidor de la base de datos
// Define el nombre de la base de datos
// Define el nombre de usuario para la conexión a la base de datos
// Define la contraseña para la conexión a la base de datos
try {
    // Inicia un bloque try para manejar excepciones
    // PDO para SQL Server
    require_once __DIR__ . '/../config/connection.php';
    if (!$conn) {
        throw new PDOException('Database connection unavailable');
    }
    // Crea una nueva conexión PDO a SQL Server usando el host, base de datos, usuario y contraseña
    // Configura PDO para lanzar excepciones en caso de errores
    // Consulta último resultado de Diaria
    $stmt = $conn->prepare("
        WITH ultimo_sorteo AS (
            SELECT TOP 1 draw_date, draw_time, draw_number
            FROM numeros_ganadores_sorteos_prod
            WHERE UPPER(LTRIM(RTRIM(game_name))) IN ('13', 'DIARIA')
            AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
            ORDER BY draw_date DESC, draw_time DESC
        )
        SELECT n.*
        FROM numeros_ganadores_sorteos_prod n
        CROSS JOIN ultimo_sorteo u
        WHERE (
            UPPER(LTRIM(RTRIM(n.game_name))) IN ('13', 'DIARIA')
            OR REPLACE(REPLACE(UPPER(LTRIM(RTRIM(n.game_name))) COLLATE Latin1_General_CI_AI, ' ', ''), '-', '') IN ('MULTIXDIARIA', 'MAS1')
        )
        AND UPPER(LTRIM(RTRIM(n.pais))) = 'NICARAGUA'
        AND CONVERT(date, n.draw_date) = CONVERT(date, u.draw_date)
        AND (n.draw_time = u.draw_time OR n.draw_number = u.draw_number)
        ORDER BY
            CASE
                WHEN UPPER(LTRIM(RTRIM(n.game_name))) IN ('13', 'DIARIA') THEN 1
                WHEN REPLACE(REPLACE(UPPER(LTRIM(RTRIM(n.game_name))) COLLATE Latin1_General_CI_AI, ' ', ''), '-', '') = 'MULTIXDIARIA' THEN 2
                WHEN REPLACE(REPLACE(UPPER(LTRIM(RTRIM(n.game_name))) COLLATE Latin1_General_CI_AI, ' ', ''), '-', '') = 'MAS1' THEN 3
                ELSE 4
            END,
            CASE WHEN UPPER(LTRIM(RTRIM(n.game_name))) = 'DIARIA' THEN 1 ELSE 0 END
    ");
    $stmt->execute();
    // Ejecuta una consulta directa para seleccionar el primer registro (el más reciente) de la tabla loto_sorteos_sv donde juego es 1, ordenado por id descendente
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Obtiene el resultado de la consulta como un array asociativo
    if (!$rows) {
        // Si no se encontró ningún resultado (row es null)
        echo json_encode(["error" => "No hay resultados"]);
        // Envía un JSON con un mensaje de error indicando que no hay resultados
        exit;
        // Termina la ejecución del script
    }
    $row = null;
    $multiX = null;
    $mas1 = null;

    foreach ($rows as $fila) {
        $gameName = strtoupper(trim((string) $fila["game_name"]));
        $gameKey = str_replace([' ', '-'], '', strtr($gameName, ['Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U']));

        if ($gameName === "13" || $gameName === "DIARIA") {
            $row = $fila;
            if ($gameName === "DIARIA") {
                $multiX = $fila["par2"] ?? valorResultRaw($fila, 1, $multiX);
            }
        } elseif ($gameKey === "MULTIXDIARIA") {
            $multiX = $fila["par2"] ?? $fila["par1"] ?? valorResultRaw($fila, 1);
        } elseif ($gameKey === "MAS1") {
            $mas1 = $fila["par2"] ?? valorResultRaw($fila, 1, $fila["par1"] ?? null);
        }
    }

    if (!$row) {
        echo json_encode(["error" => "No hay resultados"]);
        exit;
    }

    if ($mas1 === null || $mas1 === '') {
        $stmtMas1 = $conn->prepare("
            SELECT TOP 1 par1, par2, result_raw
            FROM numeros_ganadores_sorteos_prod
            WHERE REPLACE(REPLACE(UPPER(LTRIM(RTRIM(game_name))) COLLATE Latin1_General_CI_AI, ' ', ''), '-', '') = 'MAS1'
            AND UPPER(LTRIM(RTRIM(pais))) = 'NICARAGUA'
            ORDER BY draw_date DESC, draw_time DESC, draw_number DESC
        ");
        $stmtMas1->execute();
        $rowMas1 = $stmtMas1->fetch(PDO::FETCH_ASSOC);
        if ($rowMas1) {
            $mas1 = $rowMas1["par2"] ?? valorResultRaw($rowMas1, 1, $rowMas1["par1"] ?? null);
        }
    }

    $numeroBase = $row["par1"] ?? valorResultRaw($row, 0, "0");
    $numero = str_pad((string) $numeroBase, 2, "0", STR_PAD_LEFT);
    // Formatea el valor de par1 con ceros a la izquierda hasta tener 2 dígitos y lo asigna a $numero
    echo json_encode([
        // Codifica y envía un array JSON con los detalles del resultado

        "digito1" => $numero[0],
        // Primer dígito del número formateado

        "digito2" => $numero[1],
        // Segundo dígito del número formateado

        "multi_x" => isset($multiX) ? (string) $multiX : null,
        "mas_1" => isset($mas1) ? (string) $mas1 : null,

        "numero"  => $numero,
        // El número completo formateado

        "sorteo"  => $row["draw_number"],
        // El número del sorteo

        "hora"    => $row["draw_time"],
        // La hora del sorteo

        "fecha"   => $row["draw_date"]
        // La fecha del sorteo

    ]);

} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
// Captura cualquier excepción de PDO

    echo json_encode(["error" => 'Error interno']);
    // Envía un JSON con el mensaje de error de la excepción

}

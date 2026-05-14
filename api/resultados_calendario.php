<?php
// Inicia el bloque de código PHP

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON
// Define el nombre del servidor de la base de datos

// Define el nombre de la base de datos (comentario original incluido)
// Define el nombre de usuario para la conexión a la base de datos
// Define la contraseña para la conexión a la base de datos

try {
    // Inicia un bloque try para intentar la conexión a la base de datos

    require_once __DIR__ . '/../config/connection.php';
    // Crea una nueva conexión PDO a SQL Server usando el host, base de datos, usuario y contraseña

    // Configura PDO para lanzar excepciones en caso de errores

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO durante la conexión

    echo json_encode(['error' => $e->getMessage()]);
    // Envía un JSON con el mensaje de error de la excepción

    exit;
    // Termina la ejecución del script
}

// Recibir fecha desde GET
if (!isset($_GET['fecha'])) {
    // Verifica si el parámetro 'fecha' no está presente en la solicitud GET

    echo json_encode(['error' => 'No se proporcionó fecha']);
    // Envía un JSON con un mensaje de error indicando que no se proporcionó la fecha

    exit;
    // Termina la ejecución del script
}

$fecha = $_GET['fecha']; // Formato esperado: YYYY-MM-DD
// Asigna el valor del parámetro 'fecha' de GET a la variable $fecha (formato esperado: YYYY-MM-DD)


// Solo para juego 2
$juego = 2;
// Establece el valor del juego a 2 (Super Premio)

// Consulta: obtener resultado del día seleccionado
$sql = "SELECT par1, par2, par3, par4, par5
        FROM loto_sorteos_sv
        WHERE juego = :juego AND CONVERT(date, fecha) = :fecha";
// Define la consulta SQL para seleccionar par1 a par5 de la tabla loto_sorteos_sv donde juego es 2 y la fecha coincide con la proporcionada

$stmt = $conn->prepare($sql);
// Prepara la consulta SQL para ejecución

$stmt->execute(['juego' => $juego, 'fecha' => $fecha]);
// Ejecuta la consulta preparada, pasando los parámetros juego y fecha

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
// Obtiene el resultado de la consulta como un array asociativo

if ($resultado) {
    // Si se encontró un resultado (resultado no es null)

    echo json_encode($resultado);
    // Envía el resultado como JSON

} else {
    // Si no se encontró ningún resultado

    echo json_encode([
        // Envía un JSON con valores predeterminados de '00' para cada par

        'par1' => '00',
        'par2' => '00',
        'par3' => '00',
        'par4' => '00',
        'par5' => '00'
    ]);
}

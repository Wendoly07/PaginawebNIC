<?php
// ================= CONEXIÓN A BASE DE DATOS =================
// Crear conexión PDO a la base de datos Azure SQL Server
try {
    require_once __DIR__ . '/config/connection.php';
} catch (PDOException $e) {
    // Si la conexión falla, mostrar el error y detener la ejecución
    $conn = null;
}

// ================= OBTENER CONTENIDO DINÁMICO =================
// Consultar los datos de la página de selección de país desde la tabla de configuración
$contenido = [];
if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM paginaweb_sv_seleccion_pais WHERE id = ?");
    $stmt->execute([1]);
    $contenido = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loto - Selección de País</title>
    <link rel="icon" type="image/png" href="/imagesSV/icono.png">
    <style>
        /* Definir fuente personalizada usada en toda la página */
        @font-face {
            font-family: 'HelveticaRounded';
            src: url('fonts/HelveticaRoundedLTStd-Bd.ttf') format('truetype');
            font-weight: bold;
        }

        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'HelveticaRounded', Arial, sans-serif;
        }

        body {
            background-color: #fff7eb;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'HelveticaRounded', Arial, sans-serif;
        }

        /* Contenedor principal que centra el contenido verticalmente */
        .main-content {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        /* HEADER */
        header {
            width: 100%;
            height: 100px;
            background-color: #ff7a00;
            display: flex;
            justify-content: center;
            padding: 5px 0;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        header img {
            width: 120px;
            position: relative;
            top: 1.2cm;
            z-index: 5;
        }

        /* CONTENIDO */
        .main-content {
            min-height: calc(100vh - 100px - 35px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 60px;
        }

        /* TEXTO */
        .welcome-text {
            text-align: center;
            margin: 20px 0;
        }

        .welcome-text h1 {
            font-size: 14px;
            color: #0052a5;
            font-weight: bold;
        }

        .welcome-text h2 {
            font-size: 32px;
            color: #ff7a00;
            font-weight: 900;
        }

        /* CONTENEDOR */
        .countries {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 10px 20px;
        }

        /* TARJETA */
        .country-card {
            background-color: #fff;
            border-radius: 20px;
            width: 200px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .country-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        /* NOMBRE */
        .country-card .name {
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
            font-weight: bold;
            color: #0052a5;
        }

        /* IMAGEN */
        .image-wrapper {
            position: relative;
            width: 100%;
            height: 170px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .image-wrapper img.main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        /* BANDERA */
        .image-wrapper img.flag {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #fff;
            background: #fff;
            z-index: 10;
        }

        /* BOTONES */
        .button-wrapper {
            margin-top: 35px;
            text-align: center;
        }

        .country-button-img {
            width: 160px;
            max-width: 100%;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .country-button-img:hover {
            transform: scale(1.03);
        }

        /* Mobile */
        @media (max-width: 480px) {
            .button-wrapper {
                margin-top: 25px;
            }

            .country-button-img {
                width: 140px;
            }
        }

        /* FOOTER */
        footer {
            width: 100%;
            height: 35px;
            background-color: #0052a5;
            margin-top: auto;
        }

    </style>
</head>

<body>

<header>
    <!-- Cabecera superior con logo cargado desde la configuración de la base de datos -->
    <img src="<?= $contenido['logo'] ?>" alt="Loto Logo">
</header>

<div class="main-content">

    <div class="welcome-text">
        <!-- Texto de bienvenida cargado desde la configuración dinámica -->
        <h1><?= htmlspecialchars($contenido['bienvenida_h1']) ?></h1>
        <h2><?= htmlspecialchars($contenido['bienvenida_h2']) ?></h2>
    </div>

    <!-- Contenedor de tarjetas para selección de países -->
    <div class="countries">

        <!-- EL SALVADOR -->
        <div>
            <a href="https://loto.sv/?pag=body" target="_blank" style="text-decoration:none;">
                <div class="country-card">
                    <div class="name">El Salvador</div>
                    <div class="image-wrapper">
                        <!-- Imagen de El Salvador desde la configuración de la base de datos -->
                        <img class="main-image" src="<?= $contenido['imagen_sv'] ?>" alt="El Salvador">
                        <img class="flag" src="<?= $contenido['bandera_sv'] ?>" alt="Bandera El Salvador">
                    </div>
                </div>
            </a>

            <div class="button-wrapper">
                <!-- Botón que abre el sitio de El Salvador en una nueva pestaña -->
                <a href="https://juega.loto.sv/fob/?utm_source=SV_Apostemos_website_botonpais_Trafico_2026&utm_medium=SV_Apostemos_website_botonpais_Trafico_2026&utm_campaign=SV_Apostemos_website_botonpais_Trafico_2026&utm_id=SV_Apostemos_website_botonpais_Trafico_2026"
                   target="_blank">
                    <img src="<?= $contenido['boton_sv'] ?>" alt="Ingresar El Salvador" class="country-button-img">
                </a>
            </div>
        </div>

        <!-- HONDURAS -->
        <div>
            <a href="https://loto.hn/" target="_blank" style="text-decoration:none;">
                <div class="country-card">
                    <div class="name">Honduras</div>
                    <div class="image-wrapper">
                        <!-- Imagen de Honduras desde la configuración de la base de datos -->
                        <img class="main-image" src="<?= $contenido['imagen_hn'] ?>" alt="Honduras">
                        <img class="flag" src="<?= $contenido['bandera_hn'] ?>" alt="Bandera Honduras">
                    </div>
                </div>
            </a>

            <div class="button-wrapper">
                <!-- Botón que abre el sitio de Honduras en una nueva pestaña -->
                <a href="https://juega.loto.hn/fob/?utm_source=HN_Apostemos_website_botonpais_Trafico_2026&utm_medium=HN_Apostemos_website_botonpais_Trafico_2026&utm_campaign=HN_Apostemos_website_botonpais_Trafico_2026&utm_id=HN_Apostemos_website_botonpais_Trafico_2026"
                   target="_blank">
                    <img src="<?= $contenido['boton_hn'] ?>" alt="Ingresar Honduras" class="country-button-img">
                </a>
            </div>
        </div>

        <!-- NICARAGUA -->
        <div>
            <a href="https://paginawebnic.azurewebsites.net/?pag=body" style="text-decoration:none;">
                <div class="country-card">
                    <div class="name">Nicaragua</div>
                    <div class="image-wrapper">
                        <!-- Imagen de Nicaragua desde la configuración de la base de datos -->
                        <img class="main-image" src="<?= $contenido['imagen_ni'] ?>" alt="Nicaragua">
                        <img class="flag" src="<?= $contenido['bandera_ni'] ?>" alt="Bandera Nicaragua">
                    </div>
                </div>
            </a>

            
        </div>

    </div>

</div>

<!-- Footer simple de color de marca, sin contenido adicional -->
<footer></footer>

</body>
</html>

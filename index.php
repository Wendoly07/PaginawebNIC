<?php
// Obtener la página solicitada desde la URL: index.php?pag=<nombre>
// Si no existe el parámetro, se deja vacío para indicar redirección al login
$pag = "";
if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
}

// Si no se especifica ninguna página, redirige al login
if ($pag == "") {
    // Devuelve una cabecera HTTP para cambiar de página
    header("Location: /login.php");
    exit(); // Detiene la ejecución después de la redirección
}

// Incluir la cabecera común que contiene el HTML inicial y la navegación
include 'includes/header.php';

// Enrutador simple: carga el contenido de la página según el valor de 'pag'
// Cada case incluye un archivo PHP diferente para mostrar la sección solicitada
switch ($pag) {
    case 'body':
        // Página de inicio o contenido principal
        include 'includes/body.php';
        break;
    case 'diaria':
        // Página de resultados de La Diaria
        include 'diaria.php';
        break;
    case 'quiero_ser_agente':
        // Página para solicitar ser agente
        include 'quiero_ser_agente.php';
        break;
    case 'noticias':
        // Página de noticias
        include 'noticias.php';
        break;
    case 'noticia_detalle':
        // Página de detalle de una noticia
        include 'noticia_detalle.php';
        break;
    case 'promociones':
        // Pagina de promociones
        include 'promociones.php';
        break;
    case 'promociones_detallado':
        // Pagina de detalle de una promocion
        include 'promociones_detallado.php';
        break;
    case 'apostemos':
        // Página de apuestas deportivas
        include 'apostemos.php';
        break;
    case 'aplica_con_nosotros':
        // Página para aplicar con nosotros
        include 'aplica_con_nosotros.php';
        break;
    case 'contactanos':
        // Página de contacto
        include 'contactanos.php';
        break;
    case 'sobre_nosotros':
        // Página sobre la empresa
        include 'sobre_nosotros.php';
        break;
    case 'rse':
        // Pagina de responsabilidad social empresarial
        include 'rse.php';
        break;
    case 'instacash':
        // Página de Instacash
        include 'instacash.php';
        break;
    case 'suerte':
        // Página de Suerte
        include 'suerte.php';
        break;
    case 'dobletea_tu_suerte':
        // Página de la promoción Dobleteá tu suerte
        include 'dobletea_tu_suerte.php';
        break;
    case 'fechas_lotos':
        // Página de Fechas Lotos
        include 'fechas_lotos.php';
        break;
    case 'juga_tres':
        // Página de Jugá Tres
        include 'juga_tres.php';
        break;
    case 'juga_cuatro':
        // Pagina de Juga Cuatro
        include 'juga_cuatro.php';
        break;
    case 'premiado':
        // Página de Premiado
        include 'premiado.php';
        break;
    case 'terminacion2':
        // Página de Terminación 2
        include 'terminacion2.php';
        break;
    default:
        // Si el valor no coincide con ninguna página conocida, muestra la página principal
        include 'includes/body.php';
        break;
}

// Incluir el pie de página común en todas las páginas
include 'includes/footer.php';
?>

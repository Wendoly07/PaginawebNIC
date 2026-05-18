<?php
// En producci�n no se muestran errores al usuario; se registran en logs.
$debug = getenv('APP_DEBUG') === 'true';
ini_set('display_errors', $debug ? '1' : '0');
ini_set('log_errors', '1');
error_reporting($debug ? E_ALL : 0);

// Conexión a SQL Server para obtener datos dinámicos de la página
try {
    // Intenta establecer conexión con la base de datos
    require_once __DIR__ . '/config/connection.php';
} catch (PDOException $e) {
    // Si falla la conexión, termina el script con mensaje de error
    $conn = null;
}

// Obtener contenido dinámico de la página desde la base de datos
$contenido = [];
if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM paginaweb_nic_aplica_loto WHERE id = ?");
    $stmt->execute([1]);
    $contenido = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}
// Obtiene el registro como array asociativo

$mensajeExito = "";
// Variable para almacenar mensajes de éxito o error del formulario

// Procesar el formulario cuando se envía por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica que la solicitud sea de tipo POST (envío de formulario)

    try {
        // Intenta procesar el envío del formulario

        if (empty($_FILES['cv']['tmp_name']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Debe adjuntar su CV en formato PDF.");
        }

        $extension = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
        $mimeType = mime_content_type($_FILES['cv']['tmp_name']);
        if ($extension !== 'pdf' || $mimeType !== 'application/pdf') {
            throw new Exception("Solo se permite adjuntar archivos PDF.");
        }

        $cvNombre = basename($_FILES['cv']['name']);
        $cvRuta = $cvNombre;
        $cvTipo = $_FILES['cv']['type'] ?: 'application/pdf';
        $cvArchivo = file_get_contents($_FILES['cv']['tmp_name']);
        if ($cvArchivo === false || $cvArchivo === '') {
            throw new Exception("No se pudo leer el archivo PDF adjunto.");
        }
        $cvContenido = base64_encode($cvArchivo);

        // Conexión a SQL Server (se vuelve a conectar por seguridad)
        require_once __DIR__ . '/config/connection.php';

        // Insertar los datos del formulario en la base de datos
        $sql = "INSERT INTO aplica_con_nostros_NI
        (nombre, genero, identidad, telefono, email, direccion, departamento, estudios, titulo, posicion, transporte, cv)
        VALUES
        (:nombre, :genero, :identidad, :telefono, :email, :direccion, :departamento, :estudios, :titulo, :posicion, :transporte, :cv)";
        // SQL para insertar los datos del candidato en la tabla

        $stmt = $conn->prepare($sql);
        // Prepara la consulta SQL con parámetros preparados para evitar inyección SQL

        $stmt->execute([
            // Ejecuta la consulta con los valores del formulario
            ':nombre' => $_POST['nombre'],
            ':genero' => $_POST['genero'],
            ':identidad' => $_POST['identidad'],
            ':telefono' => $_POST['telefono'],
            ':email' => $_POST['email'],
            ':direccion' => $_POST['direccion'],
            ':departamento' => $_POST['departamento'],
            ':estudios' => $_POST['estudios'],
            ':titulo' => $_POST['titulo'],
            ':posicion' => $_POST['posicion'],
            ':transporte' => $_POST['transporte'],
            ':cv' => $cvRuta
        ]);

        // LLAMADA A LOGIC APP CORRECTA PARA PROCESAR LA APLICACIÓN
        $logicAppUrl = getenv('APLICA_LOGIC');
        // URL del Logic App de Azure que procesa las aplicaciones

        $data = [
            // Datos a enviar al Logic App
            "nombre" => $_POST['nombre'],
            "genero" => $_POST['genero'],
            "identidad" => $_POST['identidad'],
            "telefono" => $_POST['telefono'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion'],
            "departamento" => $_POST['departamento'],
            "estudios" => $_POST['estudios'],
            "titulo" => $_POST['titulo'],
            "posicion" => $_POST['posicion'],
            "transporte" => $_POST['transporte'],
            "cv" => $cvRuta,
            "cv_nombre" => $cvNombre,
            "cv_tipo" => $cvTipo,
            "cv_contenido" => $cvContenido
        ];

        // Enviar datos al Logic App usando cURL
        if ($logicAppUrl) {
            $ch = curl_init($logicAppUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($ch);
            curl_close($ch);
        }

        $mensajeExito = "Formulario enviado correctamente ✅";
        // Establece mensaje de éxito

    } catch (Exception $e) {
        // Captura errores de base de datos
        $mensajeExito = "Error: " . $e->getMessage();
        // Establece mensaje de error
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario LOTO</title>
<!DOCTYPE html>
<!-- Declaración del tipo de documento HTML5 -->
<html lang="es">
<!-- Elemento raíz del documento HTML, idioma español -->
<head>
<!-- Sección de metadatos del documento -->
<meta charset="UTF-8">
<!-- Codificación de caracteres UTF-8 -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Configuración de viewport para dispositivos móviles -->
<title>Formulario LOTO</title>
<!-- Título de la página que aparece en la pestaña del navegador -->
<style>
  /* Estilos CSS para la página de aplicación */

  body {
    /* Estilos base del cuerpo de la página */
    margin: 0;
    background: #f6eedd;
    /* Color de fondo beige claro */
    font-family: 'HelveticaRounded', sans-serif;
    /* Fuente personalizada */
  }

  .container {
    /* Contenedor principal del contenido */
    width: 860px;
    max-width: 95%;
    /* Ancho máximo responsive */
    background: white;
    /* Fondo blanco */
    margin: 50px auto;
    /* Centrado horizontal con margen superior */
    border-radius: 18px;
    /* Bordes redondeados */
    padding: 40px 50px;
    /* Padding interno */
    box-sizing: border-box;
    /* El padding se incluye en el ancho total */
  }

  .title-main {
    /* Estilo del título principal */
    font-size: 40px;
    font-weight: 800;
    color: #ff6a00;
    /* Color naranja */
    line-height: 1.1;
    margin: 22px auto 22px;
    text-align: center;
    max-width: 560px;
  }

  .banner {
    /* Estilo del banner superior */
    position: relative;
    background: linear-gradient(135deg, #0070d9 0%, #0062c4 100%);
    /* Fondo azul */
    min-height: 230px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 34px;
    /* Espacio para la imagen */
    border-radius: 8px;
    box-sizing: border-box;
    color: white;
    width: calc(100% + 36px);
    /* Ancho extendido */
    margin-left: -18px;
    /* Compensación del margen del contenedor */
  }

  .banner-img {
    /* Imagen del banner */
    position: relative;
    top: auto;
    /* Posicionamiento para que sobresalga */
    left: auto;
    width: 190px;
    flex: 0 0 190px;
    align-self: center;
    z-index: 2;
    /* Asegura que esté sobre otros elementos */
  }

  .banner-content {
    /* Contenido de texto del banner */
    max-width: 470px;
    margin-left: 0;
  }

  .banner-text {
    /* Texto principal del banner */
    color: white;
    font-size: 16px;
    line-height: 1.4;
    font-weight: 600;
    text-wrap: pretty;
  }

  .banner-description {
    /* Descripción adicional debajo del banner */
    max-width: 780px;
    margin: 34px auto 0;
    font-size: 16px;
    line-height: 1.55;
    color: #005bbb;
    /* Color azul más oscuro */
    font-weight: 600;
    text-align: center;
  }

  h2.section-title {
    /* Títulos de sección */
    text-align: center;
    color: #ff6a00;
    /* Color naranja */
    font-size: 26px;
    margin-top: 35px;
  }

  .beneficios {
    /* Contenedor de la sección de beneficios */
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
    margin-top: 20px;
  }

  .beneficios-list li {
    /* Elementos de la lista de beneficios */
    font-weight: 600;
    color: #005bbb;
    margin-bottom: 12px;
    list-style: none;
    /* Sin viñetas por defecto */
    padding-left: 32px;
    /* Espacio para el ícono personalizado */
    position: relative;
    font-size: 17px;
  }

  .beneficios-list li::before {
    /* Ícono personalizado (check) antes de cada beneficio */
    content: "✔";
    color: white;
    background: #ff6a00;
    /* Fondo naranja */
    width: 23px;
    height: 23px;
    border-radius: 50%;
    /* Círculo */
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    top: 0;
    font-size: 14px;
  }

  .beneficios img {
    /* Imagen de beneficios */
    width: 170px;
    margin: auto;
    /* Centrada */
  }

  h3.form-title {
    /* Título del formulario */
    text-align: center;
    color: #ff6a00 ;
    font-size: 28px;
    margin: 42px auto 12px;
    letter-spacing: 0;
  }

  form {
    /* Estilos del formulario */
    padding: 28px;
    max-width: 760px;
    /* Ancho máximo del formulario */
    margin: 24px auto 36px;
    /* Centrado */
    box-sizing: border-box;
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 8px;
    box-shadow: 0 18px 45px rgba(15, 61, 117, 0.12);
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
  }

  .form-field {
    min-width: 0;
  }

  .form-field.full {
    grid-column: 1 / -1;
  }

  form label,
  .main-label {
    display: block;
    color: #1a2f4f;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 8px;
  }

  form label.required::after {
    /* Asterisco rojo para campos requeridos */
    content: "*";
    color: #ff6a00;
    margin-left: 3px;
  }

  form input[type="text"],
  form input[type="email"],
  form input[type="number"],
  form select {
    /* Estilos para inputs y select del formulario */
    width: 100%;
    min-height: 48px;
    padding: 12px 14px;
    margin-top: 0;
    border: 1px solid #c7d4e4;
    /* Borde gris claro */
    border-radius: 6px;
    /* Bordes redondeados */
    font-size: 16px;
    color: #14243d;
    background: #f8fbff;
    box-sizing: border-box;
    transition: border-color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
    /* Transición suave del borde */
  }

  form input:focus,
  form select:focus {
    /* Estilos cuando los campos están enfocados */
    border-color: #005bbb;
    /* Borde azul */
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 91, 187, 0.12);
    outline: none;
    /* Sin outline por defecto */
  }

  .radio-group {
    /* Grupo de botones radio */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    margin-top: 0;
    gap: 10px;
    /* Espacio entre opciones */
  }

  .radio-group label {
    /* Etiquetas de los radio buttons */
    min-height: 44px;
    padding: 10px 12px;
    border: 1px solid #d6e1ef;
    border-radius: 6px;
    background: #f8fbff;
    font-weight: 700;
    color: #243955;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    box-sizing: border-box;
    cursor: pointer;
    transition: border-color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
  }

  .radio-group label:has(input:checked) {
    border-color: #1a8cff;
    background: #edf6ff;
    box-shadow: inset 4px 0 0 #ff6a00;
  }

  .radio-group input {
    accent-color: #ff6a00;
  }

  .file-upload {
    display: block;
    margin-top: 0;
  }

  .file-upload input[type="file"] {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
  }

  .file-upload-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    width: 100%;
    min-height: 96px;
    padding: 20px;
    border: 1px dashed #1a8cff;
    border-radius: 8px;
    background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%);
    box-sizing: border-box;
    cursor: pointer;
    transition: border-color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
  }

  .file-upload-box:hover,
  .file-upload input[type="file"]:focus + .file-upload-box {
    border-color: #005bbb;
    background: #eaf4ff;
    box-shadow: 0 8px 20px rgba(0, 91, 187, 0.12);
  }

  .file-upload-copy {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
  }

  .file-upload-title {
    color: #005bbb;
    font-size: 18px;
    font-weight: 800;
  }

  .file-upload-help,
  .file-upload-name {
    color: #606b7b;
    font-size: 14px;
    line-height: 1.35;
  }

  .file-upload-name {
    color: #27364a;
    font-weight: 600;
    overflow-wrap: anywhere;
  }

  .file-upload-action {
    flex: 0 0 auto;
    padding: 12px 18px;
    border-radius: 6px;
    background: #ff6a00;
    color: white;
    font-size: 14px;
    font-weight: 800;
    white-space: nowrap;
    transition: background 0.25s ease;
  }

  .file-upload-box:hover .file-upload-action,
  .file-upload input[type="file"]:focus + .file-upload-box .file-upload-action {
    background: #1a8cff;
  }

  .file-upload-error {
    display: none;
    margin-top: 8px;
    color: #b00020;
    font-size: 14px;
    font-weight: 700;
  }

  .file-upload.has-error .file-upload-box {
    border-color: #b00020;
    background: #fff3f5;
  }

  .file-upload.has-error .file-upload-error {
    display: block;
  }

  .btn-submit {
    /* Botón de envío del formulario */
    position: relative;
    overflow: hidden;
    background: #ff6a00;
    /* Fondo azul */
    color: white;
    display: block;
    width: 100%;
    max-width: 300px;
    padding: 14px 24px;
    font-size: 16px;
    font-weight: 800;
    border-radius: 6px;
    /* Bordes muy redondeados */
    border: none;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.25s ease;
    /* Transiciones suaves */
    margin: 28px auto 0 auto;
    /* Centrado con margen superior */
    box-shadow: 0 10px 22px rgba(255, 106, 0, 0.26);
  }

  .btn-submit::before {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
    transform: skewX(-18deg);
    transition: left 0.55s ease;
  }

  .btn-submit:hover {
    /* Efecto hover del botón */
    background: #1a8cff;
    /* Azul más oscuro */
    transform: translateY(-3px);
    /* Efecto de elevación */
    box-shadow: 0 16px 30px rgba(26, 140, 255, 0.34);
  }

  .btn-submit:hover::before {
    left: 125%;
  }

  .btn-submit:active {
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(26, 140, 255, 0.26);
  }

  .alert-success {
    /* Estilo de la alerta de éxito */
    background-color: #d4edda;
    /* Fondo verde claro */
    border-left: 6px solid #28a745;
    /* Borde izquierdo verde */
    color: #155724;
    /* Texto verde oscuro */
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    /* Sombra sutil */
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    /* Centrado */
    animation: fadeIn 0.5s ease-in-out;
    /* Animación de aparición */
  }

  @keyframes fadeIn {
    /* Animación de desvanecimiento */
    from { opacity: 0; }
    to { opacity: 1; }
  }

/* ===================== FIX BANNER – SOLO MÓVIL ===================== */
/* Estilos específicos para dispositivos móviles (ancho máximo 768px) */
@media (max-width: 768px) {

  /* TÍTULO */
  .title-main {
    /* Título principal más pequeño en móviles */
    font-size: 30px;
    margin-bottom: 20px;
  }

  /* BANNER */
  .banner {
    /* Banner adaptado para móviles */
    flex-direction: column;
    /* Disposición vertical */
    align-items: center;
    justify-content: center;
    min-height: 0;
    /* Altura automática */
    padding: 28px 20px 30px;
    /* Padding ajustado */
    width: 100%;
    margin: 0;
    border-radius: 12px;
    text-align: center;
  }

  /* IMAGEN */
  .banner-img {
    /* Imagen del banner en móviles */
    position: relative;
    top: 0;
    left: 0;
    width: 160px;
    flex-basis: auto;
    /* Más pequeña */
    margin-bottom: 15px;
  }

  /* TEXTO DEL BANNER */
  .banner-content {
    /* Contenido del banner en móviles */
    margin: 0;
    max-width: 100%;
    /* Ancho completo */
  }

  .banner-text {
    /* Texto del banner en móviles */
    font-size: 16px;
    line-height: 1.4;
  }

  /* DESCRIPCIÓN */
  .banner-description {
    /* Descripción en móviles */
    margin-top: 25px;
    font-size: 15px;
    line-height: 1.5;
    padding: 0 10px;
  }

  form {
    padding: 20px;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }

  .file-upload-box {
    align-items: stretch;
    flex-direction: column;
  }

  .file-upload-action {
    text-align: center;
  }
}

/* ===== BAJAR CONTENIDO POR HEADER FIJO – SOLO MÓVIL ===== */
/* Ajustes para compensar el header fijo en móviles */
@media (max-width: 768px) {

  .container {
    /* Contenedor con margen superior adicional */
    margin-top: 120px; /* ajustá este valor si tu header es más alto */
  }
  /* Opcional: reduce tamaño del título y margen inferior */
  .title-main {
    margin-top: 50px; /* aumenta este valor para bajarlo más */
    font-size: 28px;  /* mantiene tamaño compacto en móvil */
    text-align: center;
  }

}
@media (max-width: 768px) {
  .file-upload-box {
    align-items: flex-start;
    flex-direction: column;
    gap: 12px;
  }
}

@media (max-width: 480px) {
  .container {
    max-width: calc(100% - 16px);
    margin: 92px auto 24px;
    padding: 24px 16px;
    border-radius: 10px;
  }

  .title-main {
    font-size: 26px;
    line-height: 1.12;
  }

  .banner {
    padding: 22px 16px;
  }

  .banner-img {
    width: 140px;
  }

  .banner-text,
  .banner-description {
    font-size: 14px;
  }

  h3.form-title {
    font-size: 22px;
  }

  form {
    padding: 18px 14px;
  }

  .radio-group {
    grid-template-columns: 1fr;
  }

  .btn-submit {
    max-width: none;
  }
}
</style>
</head>
<body>
<!-- Inicio del cuerpo del documento HTML -->

<div class="container">
  <!-- Contenedor principal de toda la página -->

  <div class="title-main">
    <!-- Título principal de la página -->
    Formá parte de<br>
    la familia LOTO
  </div>

  <div class="banner">
    <!-- Banner superior con imagen y texto -->
    <img src="<?= htmlspecialchars($contenido['imagen1'] ?? '/ImagesSV/Foto Moni.png') ?>" class="banner-img">
    <!-- Imagen del banner obtenida dinámicamente de la base de datos -->
    <div class="banner-content">
      <!-- Contenido de texto del banner -->
      <p class="banner-text">
        <!-- Texto descriptivo del banner -->
        <?= nl2br(htmlspecialchars($contenido['titulo'] ?? 'En LOTO promovemos el desarrollo del talento humano, impulsando el crecimiento profesional de nuestros colaboradores y ofreciendo beneficios orientados a su bienestar integral. Nos consolidamos como una empresa sólida, que brinda estabilidad laboral y fomenta un ambiente de trabajo positivo, respaldado por nuestra certificación como Great Place to Work. Nuestra cultura organizacional se sustenta en pilares fundamentales que guían nuestras acciones y hacen nuestra dinámica laboral más motivadora, como son la Pasión, el Profesionalismo, el Balance Vida-Trabajo y la Alegría.')) ?>
        <!-- Contenido dinámico de la base de datos con saltos de línea preservados -->
      </p>
    </div>
  </div>

  <p class="banner-description">
    <!-- Descripción adicional debajo del banner -->
    <?= nl2br(htmlspecialchars($contenido['descripcion'] ?? 'INTERLOTO...')) ?>
    <!-- Contenido dinámico de la base de datos -->
  </p>

  <?php if (false): ?>
  <h2 class="section-title">CONOCÉ ALGUNOS DE NUESTROS BENEFICIOS</h2>
  <!-- Título de la sección de beneficios -->

  <div class="beneficios">
    <!-- Contenedor de beneficios con lista e imagen -->
    <ul class="beneficios-list">
      <!-- Lista de beneficios obtenidos dinámicamente -->
      <?php
      // Procesar la lista de beneficios desde la base de datos
      $beneficios = explode("\n", $contenido['beneficios'] ?? "EMPRESA SOLIDA CON ESTABILIDAD LABORAL\nSEGURO MEDICO PRIVADO\nSEGURO DE VIDA\nEXCELENTE AMBIENTE LABORAL");
      // Divide el texto por saltos de línea para crear elementos de lista
      foreach($beneficios as $b):
        // Itera sobre cada beneficio
      ?>
        <li><?= htmlspecialchars($b) ?></li>
        <!-- Elemento de lista con beneficio individual -->
      <?php endforeach; ?>
    </ul>
    <img src="<?= htmlspecialchars($contenido['imagen2'] ?? '/ImagesSV/icono beneficios.png') ?>">
    <!-- Imagen de beneficios obtenida dinámicamente -->
  </div>

  <?php endif; ?>

  <h3 class="form-title">LLENÁ EL SIGUIENTE FORMULARIO</h3>
  <!-- Título del formulario de aplicación -->

  <?php if($mensajeExito): ?>
    <!-- Mostrar mensaje de éxito si existe -->
  <div class="alert-success" id="alert-success">
    <!-- Alerta verde de éxito con animación -->
    <?= $mensajeExito ?>
    <!-- Mensaje dinámico de éxito o error -->
  </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <!-- Formulario de aplicación enviado por POST -->
    <!-- Formulario de aplicación con adjunto de CV -->
    <label class="required">Nombre completo:</label>
    <!-- Campo requerido para nombre -->
    <input type="text" name="nombre" required>
    <br><br>

    <label class="required main-label">Género:</label>
    <!-- Grupo de radio buttons para género -->
    <div class="radio-group">
      <label><input type="radio" name="genero" value="Masculino" required> Masculino</label>
      <label><input type="radio" name="genero" value="Femenino"> Femenino</label>
    </div>
    <br>

    <label class="required">Número de identidad:</label>
    <!-- Campo para número de identidad -->
    <input type="text" name="identidad" required>
    <br><br>

    <label class="required">Teléfono celular:</label>
    <!-- Campo para teléfono -->
    <input type="text" name="telefono" required>
    <br><br>

    <label class="required">Correo electrónico:</label>
    <!-- Campo de email -->
    <input type="email" name="email" required>
    <br><br>

    <label class="required">Dirección domiciliar:</label>
    <!-- Campo para dirección -->
    <input type="text" name="direccion" required>
    <br><br>

    <label class="required">Departamento:</label>
    <!-- Select para departamento -->
    <select name="departamento" required>
      <option value="">Seleccione…</option>
      <!-- Opciones de departamentos de Nicaragua -->
      <option value="Chinandega">Chinandega</option>
      <option value="León">León</option>
      <option value="Managua">Managua</option>
      <option value="Masaya">Masaya</option>
      <option value="Granada">Granada</option>
      <option value="Rivas">Rivas</option>
      <option value="Carazo">Carazo</option>
      <option value="Matagalpa">Matagalpa</option>
      <option value="Jinotega">Jinotega</option>
      <option value="Boaco">Boaco</option>
      <option value="Chontales">Chontales</option>
      <option value="Estelí">Estelí</option>
      <option value="Nueva Segovia">Nueva Segovia</option>
      <option value="Madriz">Madriz</option>
      <option value="Río San Juan">Río San Juan</option>
    </select>
    <br><br>

    <label class="required main-label">Formación académica:</label>
    <!-- Grupo de radio buttons para estudios -->
    <div class="radio-group">
      <label><input type="radio" name="estudios" value="Primaria" required> Primaria</label>
      <label><input type="radio" name="estudios" value="Secundaria"> Secundaria</label>
      <label><input type="radio" name="estudios" value="Universidad completa"> Universidad completa</label>
    </div>
    <br>

    <label class="required">Título obtenido:</label>
    <!-- Campo para título académico -->
    <input type="text" name="titulo" required>
    <br><br>

    <label class="required">Posición a la que aplica:</label>
    <!-- Campo para posición deseada -->
    <input type="text" name="posicion" required>
    <br><br>

    <label class="required main-label">¿Tiene vehículo propio?</label>
    <!-- Grupo de radio buttons para transporte -->
    <div class="radio-group">
      <label><input type="radio" name="transporte" value="Sí" required> Sí</label>
      <label><input type="radio" name="transporte" value="No"> No</label>
    </div>
    <br>

    <label class="required" for="cv">Adjuntar CV:</label>
    <label class="file-upload" id="cv-upload">
      <input type="file" id="cv" name="cv" accept="application/pdf,.pdf" required>
      <span class="file-upload-box">
        <span class="file-upload-copy">
          <span class="file-upload-title">Subir CV en PDF</span>
          <span class="file-upload-help">Selecciona un archivo PDF.</span>
          <span class="file-upload-name" id="cv-file-name">Ningun archivo seleccionado</span>
        </span>
        <span class="file-upload-action">Elegir PDF</span>
      </span>
      <span class="file-upload-error" id="cv-file-error">Solo se permite adjuntar un archivo PDF.</span>
    </label>
    <br><br>

    <button type="submit" class="btn-submit">Enviar información</button>
    <!-- Botón para enviar el formulario -->
  </form>

</div>

<script>
  const cvInput = document.getElementById('cv');
  const cvUpload = document.getElementById('cv-upload');
  const cvFileName = document.getElementById('cv-file-name');

  if (cvInput && cvUpload && cvFileName) {
    cvInput.addEventListener('change', () => {
      const file = cvInput.files[0];
      cvUpload.classList.remove('has-error');

      if (!file) {
        cvFileName.textContent = 'Ningun archivo seleccionado';
        return;
      }

      const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
      if (!isPdf) {
        cvInput.value = '';
        cvFileName.textContent = 'Ningun archivo seleccionado';
        cvUpload.classList.add('has-error');
        return;
      }

      cvFileName.textContent = file.name;
    });
  }
  // Script para manejar la alerta de éxito
  const alertBox = document.getElementById('alert-success');
  // Obtiene la referencia al elemento de alerta

  if (alertBox) {
    // Si existe la alerta
    setTimeout(() => {
      // Espera 5 segundos
      alertBox.style.transition = 'opacity 0.5s ease';
      // Agrega transición de opacidad
      alertBox.style.opacity = '0';
      // Hace la alerta transparente
      setTimeout(() => alertBox.remove(), 500);
      // Remueve el elemento después de la transición
    }, 5000); // desaparece después de 5 segundos
  }

  if (window.history.replaceState) {
    // Si el navegador soporta replaceState
    window.history.replaceState(null, null, window.location.href);
    // Reemplaza la entrada del historial para evitar reenvío del formulario al recargar
  }
</script>

</body>
</html>

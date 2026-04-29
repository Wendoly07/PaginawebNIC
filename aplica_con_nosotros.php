<?php
// Configuración inicial para mostrar errores durante el desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a SQL Server para obtener datos dinámicos de la página
try {
    // Intenta establecer conexión con la base de datos
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        // Configura PDO para lanzar excepciones en caso de error
    );
} catch (PDOException $e) {
    // Si falla la conexión, termina el script con mensaje de error
    die("Error de conexión: " . $e->getMessage());
}

// Obtener contenido dinámico de la página desde la base de datos
$stmt = $conn->query("SELECT * FROM paginaweb_nic_aplica_loto WHERE id = 1");
// Consulta la tabla que contiene la configuración de la página "Aplica con nosotros"
$contenido = $stmt->fetch(PDO::FETCH_ASSOC);
// Obtiene el registro como array asociativo

$mensajeExito = "";
// Variable para almacenar mensajes de éxito o error del formulario

// Procesar el formulario cuando se envía por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica que la solicitud sea de tipo POST (envío de formulario)

    try {
        // Intenta procesar el envío del formulario

        // Conexión a SQL Server (se vuelve a conectar por seguridad)
        $conn = new PDO(
            "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
            "LotoAdmin",
            "LotAdmin1.",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Insertar los datos del formulario en la base de datos
        $sql = "INSERT INTO aplica_con_nostros_sv
        (nombre, genero, edad, identidad, telefono, email, direccion, departamento, estudios, titulo, ingles, posicion, experiencia, transporte, juegos, salario, cv)
        VALUES
        (:nombre, :genero, :edad, :identidad, :telefono, :email, :direccion, :departamento, :estudios, :titulo, :ingles, :posicion, :experiencia, :transporte, :juegos, :salario, :cv)";
        // SQL para insertar los datos del candidato en la tabla

        $stmt = $conn->prepare($sql);
        // Prepara la consulta SQL con parámetros preparados para evitar inyección SQL

        $stmt->execute([
            // Ejecuta la consulta con los valores del formulario
            ':nombre' => $_POST['nombre'],
            ':genero' => $_POST['genero'],
            ':edad' => $_POST['edad'],
            ':identidad' => $_POST['identidad'],
            ':telefono' => $_POST['telefono'],
            ':email' => $_POST['email'],
            ':direccion' => $_POST['direccion'],
            ':departamento' => $_POST['departamento'],
            ':estudios' => $_POST['estudios'],
            ':titulo' => $_POST['titulo'],
            ':ingles' => $_POST['ingles'],
            ':posicion' => $_POST['posicion'],
            ':experiencia' => $_POST['experiencia'],
            ':transporte' => $_POST['transporte'],
            ':juegos' => $_POST['juegos'],
            ':salario' => $_POST['salario'],
            ':cv' => 'sin_cv' // Valor por defecto ya que no se maneja CV en este formulario
        ]);

        // LLAMADA A LOGIC APP CORRECTA PARA PROCESAR LA APLICACIÓN
        $logicAppUrl = "https://prod-23.canadacentral.logic.azure.com:443/workflows/f6f527d5cddc437bb4c3314a76cb6feb/triggers/When_an_HTTP_request_is_received/paths/invoke?api-version=2016-10-01&sp=%2Ftriggers%2FWhen_an_HTTP_request_is_received%2Frun&sv=1.0&sig=Umo2mZGViHzrmZZPNRcpezHcWJ1mKiG9Ml0pPwxDWS4";
        // URL del Logic App de Azure que procesa las aplicaciones

        $data = [
            // Datos a enviar al Logic App (sin el campo cv)
            "nombre" => $_POST['nombre'],
            "genero" => $_POST['genero'],
            "edad" => $_POST['edad'],
            "identidad" => $_POST['identidad'],
            "telefono" => $_POST['telefono'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion'],
            "departamento" => $_POST['departamento'],
            "estudios" => $_POST['estudios'],
            "titulo" => $_POST['titulo'],
            "ingles" => $_POST['ingles'],
            "posicion" => $_POST['posicion'],
            "experiencia" => $_POST['experiencia'],
            "transporte" => $_POST['transporte'],
            "juegos" => $_POST['juegos'],
            "salario" => $_POST['salario']
        ];

        // Enviar datos al Logic App usando cURL
        $ch = curl_init($logicAppUrl);
        // Inicializa la sesión cURL

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Configura cURL para devolver el resultado como string

        curl_setopt($ch, CURLOPT_POST, true);
        // Configura la solicitud como POST

        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        // Establece el header Content-Type como JSON

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // Envía los datos en formato JSON

        curl_exec($ch);
        // Ejecuta la solicitud cURL

        curl_close($ch);
        // Cierra la sesión cURL

        $mensajeExito = "Formulario enviado correctamente ✅";
        // Establece mensaje de éxito

    } catch (PDOException $e) {
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
    font-size: 42px;
    font-weight: 800;
    color: #ff6a00;
    /* Color naranja */
    line-height: 1.1;
    margin-bottom: 25px;
    text-align: center;
  }

  .banner {
    /* Estilo del banner superior */
    position: relative;
    background: #0070d9;
    /* Fondo azul */
    height: 150px;
    display: flex;
    align-items: center;
    padding-left: 250px;
    /* Espacio para la imagen */
    border-radius: 1px;
    box-sizing: border-box;
    color: white;
    width: calc(100% + 100px);
    /* Ancho extendido */
    margin-left: -50px;
    /* Compensación del margen del contenedor */
  }

  .banner-img {
    /* Imagen del banner */
    position: absolute;
    top: -100px;
    /* Posicionamiento para que sobresalga */
    left: 20px;
    width: 200px;
    z-index: 2;
    /* Asegura que esté sobre otros elementos */
  }

  .banner-content {
    /* Contenido de texto del banner */
    max-width: 500px;
    margin-left: 50px;
  }

  .banner-text {
    /* Texto principal del banner */
    color: white;
    font-size: 18px;
    line-height: 1.4;
    font-weight: 600;
  }

  .banner-description {
    /* Descripción adicional debajo del banner */
    margin-top: 40px;
    font-size: 16px;
    line-height: 1.5;
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
    color: #005bbb;
    font-size: 24px;
    margin-top: 35px;
  }

  form {
    /* Estilos del formulario */
    padding: 0;
    max-width: 700px;
    /* Ancho máximo del formulario */
    margin: 30px auto;
    /* Centrado */
    box-sizing: border-box;
  }

  form label.required::after {
    /* Asterisco rojo para campos requeridos */
    content: "*";
    color: red;
    margin-left: 3px;
  }

  form input[type="text"],
  form input[type="email"],
  form input[type="number"],
  form select {
    /* Estilos para inputs y select del formulario */
    width: 100%;
    padding: 12px 15px;
    margin-top: 6px;
    border: 1px solid #bbb;
    /* Borde gris claro */
    border-radius: 10px;
    /* Bordes redondeados */
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s;
    /* Transición suave del borde */
  }

  form input:focus,
  form select:focus {
    /* Estilos cuando los campos están enfocados */
    border-color: #005bbb;
    /* Borde azul */
    outline: none;
    /* Sin outline por defecto */
  }

  .radio-group {
    /* Grupo de botones radio */
    display: flex;
    flex-direction: column;
    margin-top: 6px;
    gap: 6px;
    /* Espacio entre opciones */
  }

  .radio-group label {
    /* Etiquetas de los radio buttons */
    font-weight: normal;
    color: #333;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .btn-submit {
    /* Botón de envío del formulario */
    background: #1a8cff;
    /* Fondo azul */
    color: white;
    display: block;
    padding: 12px 28px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 25px;
    /* Bordes muy redondeados */
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    /* Transiciones suaves */
    margin: 25px auto 0 auto;
    /* Centrado con margen superior */
  }

  .btn-submit:hover {
    /* Efecto hover del botón */
    background: #006fd6;
    /* Azul más oscuro */
    transform: translateY(-2px);
    /* Efecto de elevación */
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
    height: auto;
    /* Altura automática */
    padding: 80px 20px 30px 20px;
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
        <?= nl2br(htmlspecialchars($contenido['titulo'] ?? 'En LOTO somos una empresa dónde valoramos el talento y nos caracterizamos por brindar oportunidades de crecimiento y desarrollo profesional a nuestros colaboradores además de muchos beneficios.')) ?>
        <!-- Contenido dinámico de la base de datos con saltos de línea preservados -->
      </p>
    </div>
  </div>

  <p class="banner-description">
    <!-- Descripción adicional debajo del banner -->
    <?= nl2br(htmlspecialchars($contenido['descripcion'] ?? 'INTERLOTO...')) ?>
    <!-- Contenido dinámico de la base de datos -->
  </p>

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

  <form method="POST">
    <!-- Formulario de aplicación enviado por POST -->
    <!-- Aquí va todo tu formulario tal como lo tenías, con los inputs y radios, sin CV -->
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

    <label class="required">Edad:</label>
    <!-- Campo numérico para edad -->
    <input type="number" name="edad" required>
    <br><br>

    <label class="required">Número de identidad (DUI):</label>
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

    <label class="required">Dirección:</label>
    <!-- Campo para dirección -->
    <input type="text" name="direccion" required>
    <br><br>

    <label class="required">Departamento:</label>
    <!-- Select para departamento -->
    <select name="departamento" required>
      <option value="">Seleccione…</option>
      <!-- Opciones de departamentos de El Salvador -->
      <option value="Ahuachapán">Ahuachapán</option>
      <option value="Santa Ana">Santa Ana</option>
      <option value="Sonsonate">Sonsonate</option>
      <option value="Chalatenango">Chalatenango</option>
      <option value="La Libertad">La Libertad</option>
      <option value="San Salvador">San Salvador</option>
      <option value="Cuscatlán">Cuscatlán</option>
      <option value="La Paz">La Paz</option>
      <option value="Cabañas">Cabañas</option>
      <option value="San Vicente">San Vicente</option>
      <option value="Usulután">Usulután</option>
      <option value="San Miguel">San Miguel</option>
      <option value="Morazán">Morazán</option>
      <option value="La Unión">La Unión</option>
    </select>
    <br><br>

    <label class="required main-label">Formación académica:</label>
    <!-- Grupo de radio buttons para estudios -->
    <div class="radio-group">
      <label><input type="radio" name="estudios" value="Primaria" required> Primaria</label>
      <label><input type="radio" name="estudios" value="Secundaria"> Secundaria</label>
      <label><input type="radio" name="estudios" value="Pasante universitario"> Pasante universitario</label>
      <label><input type="radio" name="estudios" value="Universidad completa"> Universidad completa</label>
      <label><input type="radio" name="estudios" value="Pasante maestria"> Pasante maestría</label>
      <label><input type="radio" name="estudios" value="Maestria completa"> Maestría completa</label>
    </div>
    <br>

    <label class="required">Título obtenido:</label>
    <!-- Campo para título académico -->
    <input type="text" name="titulo" required>
    <br><br>

    <label class="required main-label">Manejo del idioma inglés:</label>
    <!-- Grupo de radio buttons para nivel de inglés -->
    <div class="radio-group">
      <label><input type="radio" name="ingles" value="Basico" required> Básico</label>
      <label><input type="radio" name="ingles" value="Intermedio"> Intermedio</label>
      <label><input type="radio" name="ingles" value="Avanzado"> Avanzado</label>
    </div>
    <br>

    <label class="required">Posición a la que aplica:</label>
    <!-- Campo para posición deseada -->
    <input type="text" name="posicion" required>
    <br><br>

    <label class="required main-label">Años en puestos similares:</label>
    <!-- Grupo de radio buttons para experiencia -->
    <div class="radio-group">
      <label><input type="radio" name="experiencia" value="Sin experiencia" required> Sin experiencia</label>
      <label><input type="radio" name="experiencia" value="0-6 meses"> 0 - 6 meses</label>
      <label><input type="radio" name="experiencia" value="6 meses - 1 año"> 6 meses - 1 año</label>
      <label><input type="radio" name="experiencia" value="1 - 3 años"> 1 - 3 años</label>
      <label><input type="radio" name="experiencia" value="3 - 5 años"> 3 - 5 años</label>
      <label><input type="radio" name="experiencia" value="Más de 5 años"> Más de 5 años</label>
    </div>
    <br>

    <label class="required main-label">¿Tiene transporte propio?</label>
    <!-- Grupo de radio buttons para transporte -->
    <div class="radio-group">
      <label><input type="radio" name="transporte" value="Sí" required> Sí</label>
      <label><input type="radio" name="transporte" value="No"> No</label>
    </div>
    <br>

    <label class="required main-label">¿Ha jugado nuestros juegos?</label>
    <!-- Grupo de radio buttons para conocimiento de juegos -->
    <div class="radio-group">
      <label><input type="radio" name="juegos" value="Sí" required> Sí</label>
      <label><input type="radio" name="juegos" value="No"> No</label>
    </div>
    <br>

    <label class="required">¿Cuál es tu pretensión salarial?</label>
    <!-- Campo para pretensión salarial -->
    <input type="text" name="salario" required>
    <br><br>

    <button type="submit" class="btn-submit">Enviar información</button>
    <!-- Botón para enviar el formulario -->
  </form>

</div>

<script>
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

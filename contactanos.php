<?php
// Configuración para mostrar errores durante desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Variable para almacenar mensajes de éxito o error
$mensajeExito = "";

// Verificar si se envió el formulario por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Conexión a la base de datos SQL Server en Azure
        $conn = new PDO(
            "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
            "LotoAdmin",
            "LotAdmin1.",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Consulta SQL para insertar datos del formulario en la tabla contactanos_sv
        $sql = "INSERT INTO contactanos_sv (nombre, correo, asunto, mensaje)
                VALUES (:nombre, :correo, :asunto, :mensaje)";

        // Preparar y ejecutar la consulta con parámetros para evitar inyección SQL
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre'  => $_POST['nombre'],
            ':correo'  => $_POST['correo'],
            ':asunto'  => $_POST['asunto'],
            ':mensaje' => $_POST['mensaje']
        ]);

        // ===== LLAMAR LOGIC APP =====
        // URL del Logic App de Azure para procesar el formulario
        $logicAppUrl = "https://prod-16.canadacentral.logic.azure.com:443/workflows/dcb005e10f144cdbb81f91672f4127b9/triggers/When_an_HTTP_request_is_received/paths/invoke?api-version=2016-10-01&sp=%2Ftriggers%2FWhen_an_HTTP_request_is_received%2Frun&sv=1.0&sig=T3Nx2FS1LQdRDKtocoeWf4HAnHsPCf7S_vgrfqyWASY";

        // Datos a enviar al Logic App
        $data = [
            "nombre"  => $_POST['nombre'],
            "correo"  => $_POST['correo'],
            "asunto"  => $_POST['asunto'],
            "mensaje" => $_POST['mensaje']
        ];

        // Inicializar cURL para enviar datos al Logic App
        $ch = curl_init($logicAppUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_exec($ch);
        curl_close($ch);
        // ===== FIN LOGIC APP =====

        // Mensaje de éxito si todo salió bien
        $mensajeExito = "Mensaje enviado correctamente ✅";

    } catch (PDOException $e) {
        // Capturar errores de base de datos y mostrar mensaje
        $mensajeExito = "Error: " . $e->getMessage();
    }
}
?>
<?php
try {
    // Conexión a la base de datos para obtener datos dinámicos
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Consulta para obtener información de lotocentros desde la base de datos
    $sqlLoto = "SELECT texto FROM paginaweb_sv_contactanos_acordeon ORDER BY id DESC";
    $stmtLoto = $conn->query($sqlLoto);
    $lotocentros = $stmtLoto->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obtener la URL del mapa desde la configuración
    $sqlMapa = "SELECT mapa_url FROM paginaweb_sv_config WHERE id = 1 AND secciones = 'mapa_contactanos'" ;
    $stmtMapa = $conn->query($sqlMapa);
    $mapa = $stmtMapa->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // En caso de error, inicializar array vacío para evitar romper la página
    $lotocentros = []; // evita que producción se rompa
}
?>

<!DOCTYPE html>  
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Loto - Lotocentros</title>

<style>
/* Definición de fuente personalizada HelveticaRounded */
@font-face {
    font-family: 'HelveticaRounded';
    src: url('fonts/HelveticaRoundedLTStd-Bd.ttf') format('truetype'); /* Ruta relativa al archivo de la fuente */
    font-weight: bold;
    font-style: normal;
}

 /* Estilos base del cuerpo de la página */
 body {
  margin: 0;
   font-family: 'HelveticaRounded', Arial, sans-serif;  /* Mantén la fuente personalizada aquí */
  color: #333;
  background: linear-gradient(to bottom,
              white 0cm,
              white 2cm,
              #f6eedd 2cm,
              #f6eedd calc(100% - 2cm),
              white calc(100% - 2cm),
              white 100%);
}

/* Contenedor principal de la página */
.container {
  max-width: 1200px;
  margin: 100px auto 0 auto;
  padding: 20px;
}

/* MAPA */
/* Estilos para la sección del mapa */
.map-section {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  text-align: center;
}

.map-section h2 {
  color: #ff7f00;
  font-weight: 900;
  font-size: 28px;
}

.map-section img {
  width: 80%;
  display: block;
  margin: auto;
}

/* ACORDEÓN */
/* Estilos para el botón del acordeón */
.accordion {
  background: #0b52c3;
  color: #fff;
  cursor: pointer;
  padding: 12px 20px;
  border: none;
  border-radius: 6px;
  width: 100%;
  font-size: 17px;
  font-weight: bold;
  margin-top: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.accordion:after {
  content: "▼";
  position: absolute;
  right: 20px;
  font-size: 18px;
}

.accordion.active:after {
  content: "▲";
}

/* Estilos para el panel desplegable del acordeón */
.panel {
  display: none;
  background: #fffef7;
  border-radius: 10px;
  margin-top: 10px;
  padding: 15px 20px;
  font-size: 15px;
  color: #333;
  border: 1px solid #e2d9c3;
  line-height: 1.5;
}

.panel p {
  background: #ffffff;
  padding: 10px 12px;
  border-radius: 6px;
  margin-bottom: 12px;
  border-left: 4px solid #ff7f00;
}

/* OFICINAS Y CONTACTO */
/* Estilos para la sección de oficinas y contacto */
.offices-contact {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 30px;
}

.office, .contact {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  flex: 1 1 48%;
  box-sizing: border-box;
}

.office h3, .contact h3 {
  color: #ff7f00;
  text-align: center;
  font-weight: 900;
  font-size: 22px;
}

/* CIUDADES */
/* Estilos para las secciones de ciudades */
.city {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #0b52c3;
  font-weight: 900;
  font-size: 20px;
  margin-top: 15px;
}

.city img {
  width: 40px;
  margin-bottom: 5px;
}

/* TELÉFONOS */
/* Estilos para la información de contacto */
.contact-info {
  text-align: center;
  color: #0b52c3;
  font-weight: 700;
  font-size: 18px;
  margin-top: 15px;
}

.contact-info img {
  width: 26px;
  margin-right: 5px;
  vertical-align: middle;
}

/* FORMULARIO ESTILO SIMPLE */
/* Estilos para el texto informativo del formulario */
.contact .info-text {
  text-align: center;
  color: #0b52c3;
  font-weight: 700;
  font-size: 14px;
  margin-bottom: 15px;
}

/* Estilos para el formulario de contacto */
.contact form {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.contact input,
.contact textarea {
  width: 100%;
  max-width: 500px;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease;
  box-sizing: border-box;
  margin: 0 auto;
  display: block;
}

.contact input:focus, .contact textarea:focus {
  border-color: #0b52c3;
  outline: none;
}

/* Estilos para el botón de envío */
.contact .submit-button {
  background: #0b52c3;
  color: #fff;
  border: none;
  padding: 12px 0;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  width: 200px;
  display: block;
  margin: 10px auto 0 auto;
}

.contact .submit-button:hover {
  background: #093e8c;
  transform: translateY(-2px);
}

/* Viñeta de éxito */
/* Estilos para la alerta de éxito */
.alert-success {
  background-color: #d4edda;
  border-left: 6px solid #28a745;
  color: #155724;
  padding: 12px 20px;
  border-radius: 8px;
  margin-bottom: 15px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  font-weight: bold;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  animation: fadeIn 0.5s ease-in-out;
}

/* Animación opcional */
/* Animación de fade in para la alerta */
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

/* RESPONSIVE */
/* Media queries para dispositivos móviles */
@media (max-width: 767px) {
  .offices-contact {
    flex-direction: column;
  }
}

@media (max-width: 767px) {
  .map-section {
    padding-top: 70px; /* Ajusta este valor */
  }
}
</style>
</head>

<body>

<div class="container">

  <!-- MAPA -->
  <!-- Sección que muestra el mapa de lotocentros a nivel nacional -->
  <div class="map-section">
    <h2>LOTOCENTROS A NIVEL NACIONAL</h2>
    <!-- Mostrar mapa dinámico desde la base de datos o imagen por defecto -->
    <?php if(!empty($mapa['mapa_url'])): ?>

<img src="<?= $mapa['mapa_url'] ?>?v=<?= time(); ?>" alt="Mapa">

<?php else: ?>

<img src="ImagesSV/Mapa Loto.SV.svg" alt="Mapa">

<?php endif; ?>

    <!-- Botón del acordeón para mostrar horarios -->
    <button class="accordion">VER HORARIOS</button>

    <!-- Panel desplegable con información de lotocentros -->
    <div class="panel">
    <?php foreach ($lotocentros as $loto): ?>
        <p>
            <?= htmlspecialchars($loto['texto'] ?? '') ?>
        </p>
    <?php endforeach; ?>
</div>
  </div>

  <!-- OFICINAS Y CONTACTO -->
  <!-- Sección con información de oficinas y formulario de contacto -->
  <div class="offices-contact">

    <!-- Información de oficinas LOTO -->
    <div class="office">
      <h3>OFICINAS LOTO</h3>

      <!-- Oficina Central -->
      <div class="city">
        <img src="ImagesSV/pin ubicación.svg">
        Oficina Central
      </div>
      <p style="text-align:center;">Carretera al Puerto de La Libertad, KM 11 ½, Antiguo Cuscatlán.</p>

      <!-- Lotocentro Metrocentro -->
      <div class="city">
        <img src="ImagesSV/pin ubicación.svg">
        Lotocentro Metrocentro
      </div>
      <p style="text-align:center;">Centro Comercial Metrocentro, 1ra etapa. Frente a Teatro Luis Poma.</p>

      <!-- Información de contacto -->
      <div class="contact-info">
        <img src="ImagesSV/icono telefono.svg">
        +(503) 2555-7900<br>
        loto@loto.sv
      </div>
    </div>

    <!-- Formulario de contacto -->
    <div class="contact">
      <h3>CONTACTANOS</h3>
      <div class="info-text">
        LLENA TODOS LOS CAMPOS PARA PODER ATENDERTE.
      </div>

      <!-- Mostrar mensaje de éxito si existe -->
      <?php if ($mensajeExito): ?>
  <div class="alert-success" id="alert-success">
    <?= $mensajeExito ?>
  </div>
<?php endif; ?>

      <!-- Formulario para enviar mensaje -->
      <form method="post">
        <input type="text" name="nombre" placeholder="Nombre completo *" required>
        <input type="email" name="correo" placeholder="Correo electrónico *" required>
        <input type="text" name="asunto" placeholder="Asunto *" required>
        <textarea name="mensaje" rows="5" placeholder="Mensaje *" required></textarea>
        <button type="submit" class="submit-button">Enviar</button>
      </form>
    </div>

  </div>

</div>

<script>
  // Script para manejar la funcionalidad del acordeón
  const acc = document.getElementsByClassName("accordion");
  for (let i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      const panel = this.nextElementSibling;
      panel.style.display = panel.style.display === "block" ? "none" : "block";
    });
  }
</script>

<script>
  // Script para manejar la alerta de éxito
  // Selecciona la viñeta
  const alertBox = document.getElementById('alert-success');

  if (alertBox) {
    // Después de 5 segundos, desaparece
    setTimeout(() => {
      alertBox.style.opacity = '0';       // hacemos fade out
      alertBox.style.transition = 'opacity 0.5s ease';
      setTimeout(() => {
        alertBox.remove();               // eliminamos el elemento del DOM
      }, 500); // espera la transición antes de remover
    }, 5000); // 5000 ms = 5 segundos
  }

  // Prevenir reenvío del formulario al recargar la página
  if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
  }
</script>
</body>
</html>






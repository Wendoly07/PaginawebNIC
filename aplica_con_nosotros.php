<?php
$debug = getenv('APP_DEBUG') === 'true';
ini_set('display_errors', $debug ? '1' : '0');
ini_set('log_errors', '1');
error_reporting($debug ? E_ALL : 0);

try {
    require_once __DIR__ . '/config/connection.php';
} catch (PDOException $e) {
    $conn = null;
}

$contenido = [];
if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM paginaweb_nic_aplica_loto WHERE id = ?");
    $stmt->execute([1]);
    $contenido = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

$mensajeExito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
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

        require_once __DIR__ . '/config/connection.php';

        $sql = "INSERT INTO aplica_con_nostros_NI
        (nombre, genero, identidad, telefono, email, direccion, departamento, estudios, titulo, posicion, transporte, cv)
        VALUES
        (:nombre, :genero, :identidad, :telefono, :email, :direccion, :departamento, :estudios, :titulo, :posicion, :transporte, :cv)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre'       => $_POST['nombre'],
            ':genero'       => $_POST['genero'],
            ':identidad'    => $_POST['identidad'],
            ':telefono'     => $_POST['telefono'],
            ':email'        => $_POST['email'],
            ':direccion'    => $_POST['direccion'],
            ':departamento' => $_POST['departamento'],
            ':estudios'     => $_POST['estudios'],
            ':titulo'       => $_POST['titulo'],
            ':posicion'     => $_POST['posicion'],
            ':transporte'   => $_POST['transporte'],
            ':cv'           => $cvRuta
        ]);

        $logicAppUrl = getenv('APLICA_LOGIC');
        $data = [
            "nombre"       => $_POST['nombre'],
            "genero"       => $_POST['genero'],
            "identidad"    => $_POST['identidad'],
            "telefono"     => $_POST['telefono'],
            "email"        => $_POST['email'],
            "direccion"    => $_POST['direccion'],
            "departamento" => $_POST['departamento'],
            "estudios"     => $_POST['estudios'],
            "titulo"       => $_POST['titulo'],
            "posicion"     => $_POST['posicion'],
            "transporte"   => $_POST['transporte'],
            "cv"           => $cvRuta,
            "cv_nombre"    => $cvNombre,
            "cv_tipo"      => $cvTipo,
            "cv_contenido" => $cvContenido
        ];

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

    } catch (Exception $e) {
        $mensajeExito = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario LOTO</title>
<style>

  /* ── Reset base ── */
  *, *::before, *::after { box-sizing: border-box; }

  body {
    margin: 0;
    background: #f6eedd;
    font-family: 'HelveticaRounded', Arial, sans-serif;
  }

  /* ── Contenedor ── */
  .container {
    width: 860px;
    max-width: 95%;
    background: white;
    margin: 50px auto;
    border-radius: 18px;
    padding: 40px 50px;
  }

  /* ── Título principal ── */
  .title-main {
    font-size: 40px;
    font-weight: 800;
    color: #ff6a00;
    line-height: 1.1;
    margin: 22px auto 24px;
    text-align: center;
    max-width: 560px;
  }

  /* ── Banner ── */
  .banner {
    position: relative;
    background: #0070d9;
    height: 150px;
    display: flex;
    align-items: center;
    padding-left: 250px;
    border-radius: 1px;
    box-sizing: border-box;
    color: white;
    width: calc(100% + 100px);
    margin-left: -50px;
  }

  .banner-img {
    position: absolute;
    bottom: -30px;
    left: 0px;
    width: 250px;
    max-height: 300px;
    object-fit: contain;
    object-position: bottom center;
    flex: 0 0 auto;
    z-index: 2;
  }

  .banner-content {
    max-width: 560px;
  }

  .banner-text {
    color: white;
    font-size: 17px;
    line-height: 1.45;
    font-weight: 600;
  }

  .banner-description {
    max-width: 780px;
    margin: 50px auto 0;
    font-size: 16px;
    line-height: 1.55;
    color: #005bbb;
    font-weight: 600;
    text-align: center;
  }

  /* ── Secciones ── */
  h2.section-title {
    text-align: center;
    color: #ff6a00;
    font-size: 26px;
    margin-top: 35px;
  }

  h3.form-title {
    text-align: center;
    color: #ff6a00;
    font-size: 28px;
    margin: 42px auto 12px;
  }

  /* ── Formulario ── */
  form {
    padding: 28px;
    max-width: 760px;
    margin: 24px auto 36px;
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 8px;
    box-shadow: 0 18px 45px rgba(15,61,117,0.12);
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap: 18px 20px;
  }

  .form-field { min-width: 0; }
  .form-field.full { grid-column: 1 / -1; }

  form label,
  .main-label {
    display: block;
    color: #1a2f4f;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 8px;
  }

  form label.required::after {
    content: "*";
    color: #ff6a00;
    margin-left: 3px;
  }

  form input[type="text"],
  form input[type="email"],
  form input[type="number"],
  form select {
    width: 100%;
    min-height: 48px;
    padding: 12px 14px;
    border: 1px solid #c7d4e4;
    border-radius: 6px;
    font-size: 16px;
    color: #14243d;
    background: #f8fbff;
    transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
  }

  form input:focus,
  form select:focus {
    border-color: #005bbb;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(0,91,187,0.12);
    outline: none;
  }

  .radio-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px,1fr));
    gap: 10px;
  }

  .radio-group label {
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
    cursor: pointer;
    transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
  }

  .radio-group label:has(input:checked) {
    border-color: #1a8cff;
    background: #edf6ff;
    box-shadow: inset 4px 0 0 #ff6a00;
  }

  .radio-group input { accent-color: #ff6a00; }

  /* ── File upload ── */
  .file-upload { display: block; }

  .file-upload input[type="file"] {
    position: absolute;
    width: 1px; height: 1px;
    opacity: 0; overflow: hidden; pointer-events: none;
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
    background: linear-gradient(135deg,#f8fbff 0%,#eef6ff 100%);
    cursor: pointer;
    transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
  }

  .file-upload-box:hover {
    border-color: #005bbb;
    background: #eaf4ff;
    box-shadow: 0 8px 20px rgba(0,91,187,0.12);
  }

  .file-upload-copy { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
  .file-upload-title { color: #005bbb; font-size: 18px; font-weight: 800; }
  .file-upload-help, .file-upload-name { color: #606b7b; font-size: 14px; line-height: 1.35; }
  .file-upload-name { color: #27364a; font-weight: 600; overflow-wrap: anywhere; }

  .file-upload-action {
    flex: 0 0 auto;
    padding: 12px 18px;
    border-radius: 6px;
    background: #ff6a00;
    color: white;
    font-size: 14px;
    font-weight: 800;
    white-space: nowrap;
    transition: background 0.25s;
  }

  .file-upload-box:hover .file-upload-action { background: #1a8cff; }

  .file-upload-error { display: none; margin-top: 8px; color: #b00020; font-size: 14px; font-weight: 700; }
  .file-upload.has-error .file-upload-box { border-color: #b00020; background: #fff3f5; }
  .file-upload.has-error .file-upload-error { display: block; }

  /* ── Botón enviar ── */
  .btn-submit {
    position: relative;
    overflow: hidden;
    background: #ff6a00;
    color: white;
    display: block;
    width: 100%;
    max-width: 300px;
    padding: 14px 24px;
    font-size: 16px;
    font-weight: 800;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s, box-shadow 0.25s;
    margin: 28px auto 0;
    box-shadow: 0 10px 22px rgba(255,106,0,0.26);
  }

  .btn-submit:hover {
    background: #1a8cff;
    transform: translateY(-3px);
    box-shadow: 0 16px 30px rgba(26,140,255,0.34);
  }

  /* ── Alerta éxito ── */
  .alert-success {
    background-color: #d4edda;
    border-left: 6px solid #28a745;
    color: #155724;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 0 auto 15px;
    text-align: center;
    font-weight: bold;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    max-width: 500px;
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

  /* ══════════════════════════════════════
     RESPONSIVE — TABLET (≤ 768px)
  ══════════════════════════════════════ */
  @media (max-width: 768px) {

    .container {
      margin: 24px auto;
      padding: 24px 20px;
      border-radius: 14px;
    }

    .title-main {
      font-size: 30px;
      margin: 16px auto 20px;
    }

    /* Banner apilado verticalmente */
    .banner {
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 20px 20px 28px;
      min-height: 0;
      height: auto;
      width: 100%;
      margin-left: 0;
      border-radius: 12px;
      overflow: hidden;
    }

    /* Imagen dentro del flujo normal */
    .banner-img {
      position: relative;
      bottom: auto;
      left: auto;
      width: 160px;
      max-height: 200px;
      margin-bottom: 14px;
    }

    .banner-content {
      margin: 0;
      max-width: 100%;
    }

    .banner-text {
      font-size: 15px;
      line-height: 1.4;
    }

    .banner-description {
      margin-top: 28px;
      font-size: 15px;
      padding: 0 8px;
    }

    .form-grid { grid-template-columns: 1fr; }

    .file-upload-box {
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }

    .file-upload-action { text-align: center; width: 100%; }
    .btn-submit { max-width: none; }
  }

  /* ══════════════════════════════════════
     RESPONSIVE — MÓVIL PEQUEÑO (≤ 480px)
  ══════════════════════════════════════ */
  @media (max-width: 480px) {

    .container {
      max-width: calc(100% - 16px);
      margin: 16px auto;
      padding: 20px 14px;
      border-radius: 10px;
    }

    .title-main {
      font-size: 26px;
      line-height: 1.12;
    }

    .banner {
      padding: 20px 14px 24px;
      border-radius: 10px;
    }

    .banner-img { width: 130px; }

    .banner-text,
    .banner-description { font-size: 14px; }

    h3.form-title { font-size: 22px; }

    form { padding: 16px 12px; }

    .radio-group { grid-template-columns: 1fr; }
  }

</style>
</head>
<body>

<div class="container">

  <div class="title-main">
    Formá parte de<br>la familia LOTO
  </div>

  <div class="banner">
    <img src="<?= htmlspecialchars($contenido['imagen1'] ?? '/ImagesSV/Foto Moni.png') ?>" class="banner-img" alt="Colaborador LOTO">
    <div class="banner-content">
      <p class="banner-text">
        <?= nl2br(htmlspecialchars($contenido['titulo'] ?? 'En LOTO promovemos el desarrollo del talento humano, impulsando el crecimiento profesional de nuestros colaboradores y ofreciendo beneficios orientados a su bienestar integral.')) ?>
      </p>
    </div>
  </div>

  <p class="banner-description">
    <?= nl2br(htmlspecialchars($contenido['descripcion'] ?? 'INTERLOTO...')) ?>
  </p>

  <h3 class="form-title">LLENÁ EL SIGUIENTE FORMULARIO</h3>

  <?php if ($mensajeExito): ?>
  <div class="alert-success" id="alert-success">
    <?= $mensajeExito ?>
  </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">

    <label class="required">Nombre completo:</label>
    <input type="text" name="nombre" required>
    <br><br>

    <label class="required main-label">Género:</label>
    <div class="radio-group">
      <label><input type="radio" name="genero" value="Masculino" required> Masculino</label>
      <label><input type="radio" name="genero" value="Femenino"> Femenino</label>
    </div>
    <br>

    <label class="required">Número de identidad:</label>
    <input type="text" name="identidad" required>
    <br><br>

    <label class="required">Teléfono celular:</label>
    <input type="text" name="telefono" required>
    <br><br>

    <label class="required">Correo electrónico:</label>
    <input type="email" name="email" required>
    <br><br>

    <label class="required">Dirección domiciliar:</label>
    <input type="text" name="direccion" required>
    <br><br>

    <label class="required">Departamento:</label>
    <select name="departamento" required>
      <option value="">Seleccione…</option>
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
    <div class="radio-group">
      <label><input type="radio" name="estudios" value="Primaria" required> Primaria</label>
      <label><input type="radio" name="estudios" value="Secundaria"> Secundaria</label>
      <label><input type="radio" name="estudios" value="Universidad completa"> Universidad completa</label>
    </div>
    <br>

    <label class="required">Título obtenido:</label>
    <input type="text" name="titulo" required>
    <br><br>

    <label class="required">Posición a la que aplica:</label>
    <input type="text" name="posicion" required>
    <br><br>

    <label class="required main-label">¿Tiene vehículo propio?</label>
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
  </form>

</div>

<script>
  const cvInput    = document.getElementById('cv');
  const cvUpload   = document.getElementById('cv-upload');
  const cvFileName = document.getElementById('cv-file-name');

  if (cvInput && cvUpload && cvFileName) {
    cvInput.addEventListener('change', () => {
      const file = cvInput.files[0];
      cvUpload.classList.remove('has-error');
      if (!file) { cvFileName.textContent = 'Ningun archivo seleccionado'; return; }
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

  const alertBox = document.getElementById('alert-success');
  if (alertBox) {
    setTimeout(() => {
      alertBox.style.transition = 'opacity 0.5s ease';
      alertBox.style.opacity = '0';
      setTimeout(() => alertBox.remove(), 500);
    }, 5000);
  }

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

</body>
</html>
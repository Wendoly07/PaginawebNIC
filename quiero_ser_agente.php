<?php
// Mostrar errores en pantalla para facilitar la depuración.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Crear conexión PDO con SQL Server.
try {
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Traer la configuración de contenido de la página desde la tabla correspondiente.
$stmt = $conn->query("SELECT * FROM paginaweb_quiero_ser_agente WHERE id=1");
$config = $stmt->fetch(PDO::FETCH_ASSOC);

$mensajeExito = "";

// Procesar el formulario solo cuando se envía vía POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recibir los datos del formulario
    $Nombre = $_POST['Nombre'] ?? null;
    $Apellidos = $_POST['Apellidos'] ?? null;
    $Identidad = $_POST['Identidad'] ?? null;
    $Telefono = $_POST['Telefono'] ?? null;
    $Correo = $_POST['Correo'] ?? null;

    $Negocio = $_POST['Negocio'] ?? null;
    $Direccion = $_POST['Direccion'] ?? null;
    $TipoNegocio = $_POST['TipoNegocio'] ?? null;
    $Departamento = $_POST['Departamento'] ?? null;
    $Ciudad = $_POST['Ciudad'] ?? null;
    $Municipio = $_POST['Municipio'] ?? null;
    $Barrio = $_POST['Barrio'] ?? null;

    // Inicializar la ruta de la foto del negocio.
   $FotoNegocio = null;

// Si el usuario subió una imagen, guardarla en el servidor.
if (!empty($_FILES['FotoNegocio']['tmp_name'])) {

    $extension = pathinfo($_FILES['FotoNegocio']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = uniqid("negocio_") . "." . $extension;

    // Ruta física donde se guarda el archivo
    $rutaDestino = "ImagesSV/uploads/agentes/" . $nombreArchivo;

    move_uploaded_file($_FILES['FotoNegocio']['tmp_name'], $rutaDestino);

    // Guardar la ruta de la imagen en la base de datos.
    $FotoNegocio = $rutaDestino;
}

    try {
        //  Guardar los datos del formulario en SQL Server
        $conn = new PDO(
            "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
            "LotoAdmin",
            "LotAdmin1.",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $sql = "INSERT INTO quiero_ser_agente_sv 
                (Nombre, Apellidos, Identidad, Telefono, Correo, Negocio, Direccion, TipoNegocio, Departamento, Ciudad, Municipio, Barrio, FotoNegocio)
                VALUES 
                (:Nombre, :Apellidos, :Identidad, :Telefono, :Correo, :Negocio, :Direccion, :TipoNegocio, :Departamento, :Ciudad, :Municipio, :Barrio, :FotoNegocio)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':Nombre' => $Nombre,
            ':Apellidos' => $Apellidos,
            ':Identidad' => $Identidad,
            ':Telefono' => $Telefono,
            ':Correo' => $Correo,
            ':Negocio' => $Negocio,
            ':Direccion' => $Direccion,
            ':TipoNegocio' => $TipoNegocio,
            ':Departamento' => $Departamento,
            ':Ciudad' => $Ciudad,
            ':Municipio' => $Municipio,
            ':Barrio' => $Barrio,
            ':FotoNegocio' => $FotoNegocio
        ]);

        //  Enviar los datos guardados a una Logic App externa para procesamiento adicional.
        $logicAppUrl = "https://prod-21.canadacentral.logic.azure.com:443/workflows/35394d22c95147bd8fa955926a9b5ff2/triggers/When_an_HTTP_request_is_received/paths/invoke?api-version=2016-10-01&sp=%2Ftriggers%2FWhen_an_HTTP_request_is_received%2Frun&sv=1.0&sig=d9Eo7PIHW2ELfGPfd-OHWzlQEy8KeKYY6uZOEJH5CGo";

        $data = [
            "Nombre" => $Nombre,
            "Apellidos" => $Apellidos,
            "Identidad" => $Identidad,
            "Telefono" => $Telefono,
            "Correo" => $Correo,
            "Negocio" => $Negocio,
            "Direccion" => $Direccion,
            "TipoNegocio" => $TipoNegocio,
            "Departamento" => $Departamento,
            "Ciudad" => $Ciudad,
            "Municipio" => $Municipio,
            "Barrio" => $Barrio,
            "FotoNegocio" => $FotoNegocio
        ];

        $ch = curl_init($logicAppUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            // Respuesta exitosa de la Logic App.
            $mensajeExito = "✅ Formulario enviado correctamente y Logic App ejecutada.";
        } else {
            // Si la llamada a la Logic App no fue exitosa, mostrará un mensaje de advertencia.
            $mensajeExito = "⚠️ Formulario guardado, pero hubo un problema enviando la Logic App. HTTP code: $httpCode";
        }

    } catch (PDOException $e) {
        $mensajeExito = "❌ Error al guardar en SQL: " . $e->getMessage();
    }
}

// Mostrar el estado del envío al usuario.
echo $mensajeExito;

// Arreglo de municipios por departamento para llenar el combo dinámicamente.
$municipiosSV = [
    "Ahuachapán" => ["Ahuachapán", "Apaneca", "Atiquizaya", "Concepción de Ataco", "El Refugio", "Guaymango", "Jujutla", "San Francisco Menéndez", "San Lorenzo", "San Pedro Puxtla", "Tacuba", "Turín"],
    "Cabañas" => ["Cinquera", "Dolores", "Guacotecti", "Jutiapa", "Sensuntepeque", "Tejutepeque", "Victoria"],
    "Chalatenango" => ["Agua Caliente", "Arcatao", "Azacualpa", "Chalatenango", "Comalapa", "Concepción Quezaltepeque", "Dulce Nombre de María", "El Carrizal", "El Paraíso", "La Laguna", "La Palma", "La Reina", "Las Flores", "Las Vueltas", "Nombre de Jesús", "Nueva Concepción", "Nueva Trinidad", "San Antonio de la Cruz", "San Antonio Los Ranchos", "San Fernando", "San Francisco Lempa", "San Francisco Morazán", "San Ignacio", "San Isidro Labrador", "San Luis del Carmen", "San Miguel de Mercedes", "San Rafael", "Santa Rita", "Tejutla"],
    "Cuscatlán" => ["Candelaria", "Cojutepeque", "El Carmen", "El Rosario", "Monte San Juan", "Oratorio de Concepción", "San Bartolomé Perulapía", "San Cristóbal", "San José Guayabal", "San Pedro Perulapán", "San Rafael Cedros", "San Ramón", "Santa Cruz Analquito", "Santa Cruz Michapa", "Suchitoto", "Tenancingo"],
    "La Libertad" => ["Antiguo Cuscatlán", "Chiltiupán", "Ciudad Arce", "Colón", "Comasagua", "Huizúcar", "Jayaque", "Jicalapa", "La Libertad", "Santa Tecla", "Nuevo Cuscatlán", "Quezaltepeque", "Sacacoyo", "San José Villanueva", "San Juan Opico", "Talnique", "Tamanique", "Teotepeque", "Tepecoyo", "Zaragoza"],
    "La Paz" => ["Cuyultitán", "El Rosario", "Jerusalén", "Mercedes La Ceiba", "Olocuilta", "Paraíso de Osorio", "San Antonio Masahuat", "San Emigdio", "San Francisco Chinameca", "San Juan Nonualco", "San Juan Talpa", "San Juan Tepezontes", "San Luis Talpa", "San Luis La Herradura", "San Miguel Tepezontes", "San Pedro Masahuat", "San Pedro Nonualco", "San Rafael Obrajuelo", "Santa María Ostuma", "Santiago Nonualco", "Tapalhuaca"],
    "La Unión" => ["Anamorós", "Bolívar", "Concepción de Oriente", "Conchagua", "El Carmen", "El Sauce", "Intipucá", "La Unión", "Lislique", "Meanguera del Golfo", "Nueva Esparta", "Pasaquina", "Polorós", "San Alejo", "San José", "Santa Rosa de Lima", "Yayantique", "Yucuaiquín"],
    "Morazán" => ["Arambala", "Cacaopera", "Chilanga", "Corinto", "Delicias de Concepción", "El Divisadero", "El Rosario", "Gualococti", "Guatajiagua", "Joateca", "Jocoaitique", "Jocoro", "Lolotique", "Meanguera", "Osicala", "Perquín", "San Carlos", "San Fernando", "San Francisco Gotera", "San Isidro", "San Simón", "Sensembra", "Sociedad", "Torola", "Yamabal", "Yoloaiquín"],
    "San Miguel" => ["Chinameca", "Chirilagua", "Ciudad Barrios", "Comacarán", "El Tránsito", "Lolotique", "Moncagua", "Nuevo Edén de San Juan", "Quelepa", "San Antonio", "San Gerardo", "San Jorge", "San Luis de la Reina", "San Miguel", "Sesori", "Uluazapa"],
    "San Salvador" => ["Aguilares", "Apopa", "Ayutuxtepeque", "Cuscatancingo", "Delgado", "El Paisnal", "Guazapa", "Ilopango", "Mejicanos", "Nejapa", "Panchimalco", "Rosario de Mora", "San Marcos", "San Martín", "San Salvador", "Santiago Texacuangos", "Santo Tomás", "Soyapango", "Tonacatepeque"],
    "San Vicente" => ["Apastepeque", "Guadalupe", "San Cayetano Istepeque", "San Esteban Catarina", "San Ildefonso", "San Lorenzo", "San Sebastián", "San Vicente", "Santa Clara", "Santo Domingo", "Tecoluca", "Tepetitán", "Verapaz"],
    "Santa Ana" => ["Candelaria de la Frontera", "Chalchuapa", "Coatepeque", "El Congo", "El Porvenir", "Masahuat", "Metapán", "San Antonio Pajonal", "San Sebastián Salitrillo", "Santa Ana", "Santa Rosa Guachipilín", "Santiago de la Frontera", "Texistepeque"],
    "Sonsonate" => ["Acajutla", "Armenia", "Caluco", "Cuisnahuat", "Izalco", "Juayúa", "Nahuizalco", "Nahulingo", "Salcoatitán", "San Antonio del Monte", "San Julián", "Santa Catarina Masahuat", "Santa Isabel Ishuatán", "Santo Domingo de Guzmán", "Sonsonate", "Sonzacate"],
    "Usulután" => ["Alegría", "Berlín", "California", "Concepción Batres", "El Triunfo", "Ereguayquín", "Estanzuelas", "Jiquilisco", "Jucuapa", "Jucuarán", "Mercedes Umaña", "Nueva Granada", "Ozatlán", "Puerto El Triunfo", "San Agustín", "San Buenaventura", "San Dionisio", "San Francisco Javier", "Santa Elena", "Santa María", "Santiago de María", "Tecapán", "Usulután"]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario Vendedor</title>
<style>
  body {
  font-family: 'HelveticaRounded', sans-serif; /* Aplicar la fuente personalizada */
  margin: 0;
  padding: 0;
  background: white;
  color: #333;
  text-align: center;
}
  /* ===== HERO ===== */
  /* Estilos de la sección inicial de presentación de la página. */
  .hero {
    background: #FF9800;
    padding: 40px 20px;
  }
  .hero-content {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 30px;
    max-width: 1000px;
    margin: 0 auto;
  }
  .hero-img { max-width: 300px; width: 100%; border-radius: 12px; margin-left: -20px; }
  .hero-text-container { display: flex; flex-direction: column; align-items: flex-start; }
  .hero-text-img { max-width: 400px; width: 100%; }
  .hero-subtitle { text-align: center; font-weight: 800; font-size: 34px; line-height: 1.2; color: white; }

  /* ===== CONTENEDOR BEIGE PRINCIPAL ===== */
  /* Contenedor principal que agrupa requisitos, formulario y beneficios. */
  .info-container {
    background: #FFEFD9; /* beige */
    padding: 40px 20px;
    border-radius: 16px;
    max-width: 1100px;
    margin: -1cm auto 40px auto;
    display: flex;
    flex-direction: column;
    gap: 40px;
    position: relative;   /* habilita z-index */
  z-index: 10;          /* lo trae al frente */
  margin-top: -50px;   /* lo sube encima del hero */
  }

  /* ===== REQUISITOS ===== */
  /* Estilos del bloque que muestra los requisitos para ser agente. */
  .requisitos-container {
    display: flex;
    gap: 20px;
    align-items: flex-start; /* alineado arriba con la imagen */
    flex-wrap: wrap; /* para móviles */
}

.requisitos-container .requisitos-texto {
    flex: 1;
}

.requisitos-container img {
    max-width: 300px; /* tamaño hero 2 */
    border-radius: 15px;
}

.requisitos-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requisitos-list li {
    display: flex;              /* fila con círculo y texto */
    align-items: center;        /* verticalmente centrados */
    gap: 10px;                  /* espacio entre círculo y texto */
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #0077CC;
}

.requisitos-list li::before {
    content: '✔';               /* check blanco */
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background-color: #ff9f43;  /* círculo naranja */
    border-radius: 50%;
    color: white;               /* check blanco */
    flex-shrink: 0;             /* no se encoge */
    font-size: 12px;
}

/* Móvil */
@media (max-width: 768px) {
  .requisitos-container {
      flex-direction: column;
      gap: 15px;
  }
  .requisitos-list li {
      font-size: 15px;
  }
  .requisitos-container img {
      max-width: 90%;
      margin: 0 auto;
  }
}

  /* ===== FORMULARIO ===== */
  /* Estilo del formulario principal donde el usuario ingresa su información. */
  .form-container {
    background: #ffffff;
    padding: 40px 35px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    max-width: 1000px;
    width: 95%;
    margin: 0 auto;
    animation: fadeIn .6s ease-out;
}

.form-section-title {
  font-size: 26px;
  font-weight: 800;
  color: #0077CC;
  margin-bottom: 25px;
  text-align: left;
  background: none;     /* elimina cualquier color de fondo */
  padding: 0;           /* elimina el bloque que parecía un rectángulo */
  border-left: 6px solid #FF9800; /* barra moderna a la izquierda */
  padding-left: 12px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px 35px;
}

@media (max-width: 700px) {
    .form-grid { grid-template-columns: 1fr; }
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
  font-weight: 700;
  margin-bottom: 5px;
  color: #333;
  font-size: 15px;
  text-align: left;    /* <- asegura que siempre estén a la izquierda */
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 14px;
    border-radius: 12px;
    border: 1px solid #dcdcdc;
    font-size: 15px;
    background: #fafafa;
    transition: all .25s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #0077CC;
    background: white;
    box-shadow: 0 0 0 4px rgba(0,119,204,0.15);
    outline: none;
}

.file-upload input[type="file"] {
    margin-top: 10px;
    border: none;
    padding: 10px;
    border-radius: 10px;
    background: linear-gradient(135deg, #0077CC, #005fa3);
    color: white;
    cursor: pointer;
    font-size: 14px;
    transition: .25s;
}

.file-upload input[type="file"]:hover {
    transform: scale(1.03);
}

.btn-submit {
    background: linear-gradient(135deg, #FF9800, #ff7a00);
    color: white;
    border: none;
    padding: 16px 40px;
    font-size: 18px;
    border-radius: 50px;
    cursor: pointer;
    margin: 30px auto 0 auto;
    display: block;
    transition: .35s ease;
    font-weight: 700;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #ff7a00, #FF9800);
    transform: translateY(-4px);
}

/* EFECTO DE APARICIÓN */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
  /* ===== BENEFICIOS ===== */
  /* Estilos del bloque que muestra los beneficios de ser agente. */
  .beneficios-title { text-align: center; color: #0077CC; font-size: 32px; font-weight: 800; margin-bottom: 20px; }
  .beneficios-container { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px 30px; }
  .beneficio { display: flex; align-items: flex-start; gap: 15px; text-align: left; padding: 20px; border-radius: 12px; background: #ffffff; box-shadow: 0 6px 20px rgba(0,0,0,0.05); transition: transform 0.3s, box-shadow 0.3s; }
  .beneficio:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
  .beneficio img { width: 50px; flex-shrink: 0; }
  .beneficio-text h4 { color: #0077CC; font-weight: 700; font-size: 16px; margin: 0 0 5px 0; }
  .beneficio-text p { font-size: 14px; opacity: 0.85; margin: 0; }
  @media (max-width: 700px) { .beneficios-container, .form-grid, .requisitos { grid-template-columns: 1fr; } }
  /* ===============================
   FIX HERO IMAGEN - MÓVIL
   =============================== */
@media (max-width: 768px) {

  .hero-content {
    flex-direction: column;
    justify-content: center;
    text-align: center;
  }

  .hero-img {
    max-width: 220px;
    width: 90%;
    margin: 0 auto 20px auto; /* centrada */
    display: block;
  }

  .hero-text-container {
    align-items: center;
  }

  .hero-text-img {
    max-width: 280px;
    margin: 0 auto;
  }

  .hero-subtitle {
    font-size: 22px;
  }
}
/* ===============================
   FIX FORMULARIO - MÓVIL
   =============================== */
@media (max-width: 768px) {

  .form-container {
    padding: 25px 18px;
    border-radius: 16px;
  }

  .form-section-title {
    font-size: 20px;
  }

  .form-grid {
    grid-template-columns: 1fr; /* una columna */
    gap: 18px;
  }

  .form-group input,
  .form-group select {
    font-size: 16px; /* mejor para teclado móvil */
    padding: 14px;
  }

  .btn-submit {
    width: 100%;
    font-size: 17px;
    padding: 15px;
  }
}
/* =================================
   BAJAR IMAGEN HERO EN MÓVIL
   ================================= */
@media (max-width: 768px) {

  .hero {
    padding-top: 180px; /* empuja todo el hero hacia abajo */
  }
  .hero-img {
    margin-top: 100px; /* baja SOLO la imagen */
  }
}
/* =================================
   REQUISITOS ALINEADOS A LA IZQUIERDA EN MÓVIL
   ================================= */
@media (max-width: 768px) {

  .requisitos {
    text-align: left;
  }

  .requisitos ul {
    padding-left: 0;   /* quita sangría rara */
  }

  .requisitos li {
    text-align: left;
    justify-content: flex-start;
    align-items: flex-start;
    font-size: 15px;
  }

}


</style>
</head>
<body>

<!-- HERO -->
<!-- Sección de cabecera con imágenes y mensaje principal de la página. -->
<section class="hero">
  <div class="hero-content">
    <img src="<?= htmlspecialchars($config['hero_imagen1']) ?>" class="hero-img">
<img src="<?= htmlspecialchars($config['hero_imagen2']) ?>" class="hero-text-img">
<p class="hero-subtitle">
  <?= nl2br(htmlspecialchars($config['hero_titulo'])) ?>
</p>
      </p>
    </div>
  </div>
</section>

<!-- CONTENEDOR PRINCIPAL BEIGE -->
<!-- Bloque principal con fondo claro que contiene requisitos, formulario y beneficios. -->
<div class="info-container">

  <!-- REQUISITOS -->
  <!-- Sección que muestra los requisitos necesarios para postularse como agente. -->
<section class="requisitos-section">
  <h2 class="requisitos-title">REQUISITOS</h2>

  <div class="requisitos-container">
    <div class="requisitos-texto">
      
      <ul class="requisitos-list">
      <?php 
      if(!empty($config['requisitos_texto'])) {
          // Separar cada requisito por salto de línea
          $puntos = preg_split("/\r\n|\n|\r/", $config['requisitos_texto']);
          foreach($puntos as $punto) {
              if(trim($punto) !== "") { // Ignorar líneas vacías
                  echo "<li>" . htmlspecialchars($punto) . "</li>";
              }
          }
      }
      ?>
      </ul>
    </div>

    <?php if(!empty($config['requisitos_imagen'])): ?>
      <img src="<?= htmlspecialchars($config['requisitos_imagen']) ?>" alt="Imagen Requisitos">
    <?php endif; ?>
  </div>
</section>

  <!-- FORMULARIO -->
  <!-- Formulario para capturar los datos personales y comerciales del postulante. -->
  <section class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">

      <h2 class="form-section-title">Ingresar información del propietario del negocio</h2>
      <div class="form-grid">
        <div class="form-group"><label>Nombre</label><input type="text" name="Nombre" placeholder="Nombre" required></div>
        <div class="form-group"><label>Apellidos</label><input type="text" name="Apellidos" placeholder="Apellidos" required></div>
        <div class="form-group"><label>Número de Identidad</label><input type="text" name="Identidad" placeholder="Número de Identidad" ></div>
        <div class="form-group"><label>Teléfono</label><input type="tel" name="Telefono" placeholder="Teléfono" required></div>
        <div class="form-group"><label>Correo Electrónico</label><input type="email" name="Correo" placeholder="Correo Electrónico" required></div>
      </div>

      <h2 class="form-section-title">Ingresar información del negocio</h2>
      <div class="form-grid">
        <div class="form-group"><label>Nombre del negocio</label><input type="text" name="Negocio" placeholder="Nombre del negocio" required></div>
        <div class="form-group"><label>Dirección actual del negocio</label><input type="text" name="Direccion" placeholder="Dirección del negocio" required></div>
        <div class="form-group"><label>Tipo de negocio</label>
          <select name="TipoNegocio" required>
  <option value="">Seleccione</option>
  <option value="Abarrotería">Abarrotería</option>
  <option value="Bares/Canchas">Bares / Canchas</option>
  <option value="Cafetería/restaurante">Cafetería / Restaurante</option>
  <option value="Carwash/Taller">Carwash / Taller</option>
  <option value="Farmacia">Farmacia</option>
  <option value="Ferretería">Ferretería</option>
  <option value="Internet/Celulares">Internet / Celulares</option>
  <option value="Kiosko/Supermercado">Kiosko / Supermercado</option>
  <option value="Laboratorio">Laboratorio</option>
  <option value="Librería">Librería</option>
  <option value="LNB">LNB</option>
  <option value="Loteria">Lotería</option>
  <option value="Mini Súper">Mini Súper</option>
  <option value="Salon de Belleza">Salón de Belleza</option>
  <option value="Tienda de conveniencia">Tienda de conveniencia</option>
  <option value="Tienda en general">Tienda en general</option>
  <option value="Otros">Otros</option>
</select>

        </div>
        <div class="form-group"><label>Departamento</label>
          <select name="Departamento" required>
  <option value="">Seleccione Departamento</option>
  <option value="Ahuachapán">Ahuachapán</option>
  <option value="Cabañas">Cabañas</option>
  <option value="Chalatenango">Chalatenango</option>
  <option value="Cuscatlán">Cuscatlán</option>
  <option value="La Libertad">La Libertad</option>
  <option value="La Paz">La Paz</option>
  <option value="La Unión">La Unión</option>
  <option value="Morazán">Morazán</option>
  <option value="San Miguel">San Miguel</option>
  <option value="San Salvador">San Salvador</option>
  <option value="San Vicente">San Vicente</option>
  <option value="Santa Ana">Santa Ana</option>
  <option value="Sonsonate">Sonsonate</option>
  <option value="Usulután">Usulután</option>
</select>

        </div>
        <div class="form-group"><label>Ciudad</label><input type="text" name="Ciudad" placeholder="Ciudad" required></div>
        <div class="form-group">
    <label>Municipio</label>
    <select name="Municipio" id="municipio" required>
        <option value="">Seleccione Municipio</option>
    </select>
</div>
        <div class="form-group"><label>Barrio / Colonia</label><input type="text" name="Barrio" placeholder="Barrio / Colonia" required></div>
      </div>

      <button type="submit" class="btn-submit">Enviar mensaje</button>
    </form>
  </section>

  <!-- BENEFICIOS -->
  <!-- Sección que lista los beneficios que ofrece la empresa a los agentes. -->
  <h2 class="beneficios-title">BENEFICIOS</h2>
  <section class="beneficios-container">
  <?php for($i=1;$i<=6;$i++): ?>
    <div class="beneficio">
      <img src="<?= htmlspecialchars($config["beneficio{$i}_imagen"]) ?>" alt="Beneficio <?= $i ?>">
      <div class="beneficio-text">
        <h4><?= htmlspecialchars($config["beneficio{$i}_titulo"]) ?></h4>
        <p><?= nl2br(htmlspecialchars($config["beneficio{$i}_texto"])) ?></p>
      </div>
    </div>
  <?php endfor; ?>
</section>

</div>
</body>
</html>

<script>
// Datos de municipios para cargar de forma dinámica según el departamento seleccionado.
const municipiosSV = <?php echo json_encode($municipiosSV); ?>;

const departamentoSelect = document.querySelector('select[name="Departamento"]');
const municipioSelect = document.getElementById('municipio');

// Actualizar la lista de municipios cuando el usuario elige un departamento.
departamentoSelect.addEventListener('change', function() {
    const depto = this.value;
    // Reiniciar lista de municipios cada vez que cambia el departamento.
    municipioSelect.innerHTML = '<option value="">Seleccione Municipio</option>';
    if (municipiosSV[depto]) {
        // Agregar cada municipio como opción en el select.
        municipiosSV[depto].forEach(mun => {
            const option = document.createElement('option');
            option.value = mun;
            option.textContent = mun;
            municipioSelect.appendChild(option);
        });
    }
});
if (window.history.replaceState) {
      // Evitar reenvío del formulario si el usuario recarga la página.
      window.history.replaceState(null, null, window.location.href);
  }
</script>


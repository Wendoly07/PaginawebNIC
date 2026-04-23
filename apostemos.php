<?php
// Conexión a la base de datos SQL Server en Azure
try {
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e){
    // Manejo de errores de conexión: muestra mensaje y detiene la ejecución
    die("Error de conexión: " . $e->getMessage());
}

// Consulta para obtener secciones específicas de la página 'apostemos' por ID
$stmt = $conn->query("SELECT * FROM paginaweb_sv_apostemos WHERE id IN (5,6,7,8)");
$seccionesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organiza los datos en un array asociativo por ID para fácil acceso
$datos = [];
foreach($seccionesData as $s){
    $datos[$s['id']] = $s;
}
?>
<style>
/* ======== ESTILO GENERAL ======== */
/* Estilos base para el cuerpo de la página */
body {
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", sans-serif;
  background: #111;
  color: white;
  text-align: center;
}

/* ======== HERO PRINCIPAL ======== */
/* Estilos para la sección hero con imagen principal */
.hero-apostemos img {
  width: 100%;
  max-width: 1400px;
  border-radius: 12px;
  display: block;
  margin: 0px auto 20px; /* Subido */
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

/* ======== TÍTULO PRINCIPAL ======== */
/* Estilos para el título y párrafo de introducción */
.intro h2 {
  color: #FFFFFF;
  margin-top: 10px;
  font-size: 39px;
}

.intro p {
  max-width: 900px;
  margin: 0 auto;
  font-size: 18px;
  opacity: 0.9;
}

/* ======== SECCIONES DE CATEGORÍAS ======== */
/* Estilos para las secciones de categorías (deporte, gaming, etc.) */
.seccion {
  padding: 50px 20px;
  margin: 40px auto;
  border-radius: 16px;
  max-width: 1400px;
  color: white;
}

.seccion h3 {
  font-size: 32px;
  letter-spacing: 6px;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.seccion p {
  font-size: 18px;
  opacity: 0.9;
  max-width: 900px;
  margin: auto;
}

.seccion img {
  width: 100%;
  max-width: 1200px;
  border-radius: 12px;
  margin-top: 25px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

/* ======== BOTONES ======== */
/* Estilos para los botones de acción */
.btn-jugar {
  display: inline-block;
  margin-top: 20px;
  background: #ffaf37;
  color: #000;
  padding: 14px 30px;
  border-radius: 40px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  transition: 0.2s;
}

.btn-jugar:hover {
  background: #ffc56e;
  transform: translateY(-3px);
}

/* ======== MÉTODOS DE RECARGA ======== */
.metodos {
  padding: 40px 20px;
  background: #222;
  margin-top: 60px;
  text-align: center;
}

.metodos h3 {
  color: #FFFFFF;
  font-size: 28px;
  margin-bottom: 30px;
}

.metodos .logos {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.metodos .logos .boton-imagen {
  width: 220px;           /* ancho del botón */
  height: 100px;          /* alto del botón */
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  border-radius: 12px;
  overflow: hidden;       /* para que la imagen no se salga del contenedor */
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
  transition: transform 0.2s, box-shadow 0.2s;
}
.metodos .logos .boton-imagen img {
  width: 100%;           /* la imagen ocupa todo el contenedor */
  height: 100%;          /* y todo el alto */
  object-fit: cover;     /* mantiene proporción y cubre todo */
}

.metodos .logos .boton-imagen:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.5);
}
.metodos .logos .fila {
  display: flex;
  justify-content: center;
  gap: 40px; /* separación entre imágenes */
}

.metodos .logos img {
  width: 200px;       /* ancho deseado */
  height: auto;       /* mantiene proporción original */
  padding: 15px;      /* más espacio para efecto de botón */
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.metodos .logos img:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.5);
}

.btn-como-jugar img {
  margin-top: 25px;
  max-width: 250px; /* igual que otros botones */
  cursor: pointer;
}

.btn-como-jugar:hover {
  transform: translateY(-3px); /* sensación de “flotar” */
  box-shadow: 0 8px 15px rgba(0,0,0,0.4); /* resalta un poco */
}

/* ===== GAMING ===== */
/* Estilos específicos para la sección gaming */
.seccion.gaming {
  background: none; /* quita el morado */
  padding: 40px 20px;
}

.banner-gaming {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto 20px auto;
  display: block;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

.titulo-gaming {
  font-size: 32px;
  letter-spacing: 2px;
  margin: 20px 0 10px 0;
  color: white;
}

.texto-gaming {
  font-size: 18px;
  opacity: 0.9;
  max-width: 900px;
  margin: 0 auto 20px auto;
  line-height: 1.4;
}

/* Botón de imagen con efecto hover */
.btn-como-jugar {
  display: inline-block;
  margin-top: 20px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.btn-como-jugar:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 15px rgba(0,0,0,0.4);
}

.imagen-principal {
  width: 100%;
  max-width: 1200px;
  margin: 20px auto 0 auto;
  display: block;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

/* Títulos y textos de Quiniela */
.titulo-quiniela {
  font-size: 32px;
  margin-top: 20px;
  color: #ff7f00;
}

.texto-quiniela {
  font-size: 18px;
  margin: 10px auto 20px auto;
  max-width: 900px;
  line-height: 1.4;
  color: white;
}

/* Botón Cómo Jugar */
.btn-como-jugar img {
  margin-top: 15px;
  max-width: 250px;
}

/* ===== FIX HERO TAPADO SOLO EN MÓVIL ===== */
/* Media query para ajustar el hero en dispositivos móviles */
@media (max-width: 767px) {
  .hero-apostemos {
    margin-top: 300px; /* ajusta si tu header es más alto */
  }
}

.banner-apostemos {
  display: block;
  margin: 25px auto 0 auto; /* centrado horizontal */
  max-width: 100%;
}

/* Ajuste SOLO en móvil */
@media (max-width: 767px) {
  .banner-apostemos {
    margin-top: 20px;
    width: 100%;
  }
}

@media (max-width: 767px) {
  /* ===== BOTÓN LOTO SALDO ===== */
 /* Ajuste del botón Loto Saldo */
  .metodos .logos a img[alt="Loto Saldo"] {
    height: 55px;             /* un poco más pequeño */
    max-width: 80%;           /* limita el ancho máximo */
    margin: 0 auto;           /* centra horizontalmente */
    display: block;           /* importante para que el margin funcione */
    padding-left: 10px;       /* espacio desde el borde izquierdo */
    padding-right: 10px;      /* espacio desde el borde derecho */
  }

  /* ===== TEXTO DE INTRO ===== */
  .intro p {
    padding-left: 15px;
    padding-right: 15px;
    box-sizing: border-box; /* para que el padding no rompa el ancho */
    text-align: center;      /* opcional, centra el texto */
  }
}

@media (max-width: 767px) {
  /* Contenedor de los botones */
  .metodos .logos .fila {
    display: flex;
    justify-content: center;  /* centra los botones */
    gap: 15px;                /* espacio entre los botones */
    flex-wrap: wrap;           /* si no caben, bajan a otra línea */
  }

  /* Todos los botones de la fila */
  .metodos .logos .fila a img {
    height: 60px;             /* mismo alto */
    max-width: 150px;         /* mismo ancho máximo para todos */
    display: block;
  }
}

</style>

<!-- ======================== CONTENIDO ======================== -->
<!-- HERO PRINCIPAL -->
<section class="hero-apostemos">
  <img src="<?= $datos[6]['hero']['imagen_header'] ?? 'ImagesSV/header_apostemos.png' ?>" alt="Apostemos Header">
</section>

<!-- INTRO -->
<section class="intro">
  <h2><?= $datos[6]['titulo'] ?? '¡BIENVENIDO A APOSTEMOS!' ?></h2>

  <p>
    <?= nl2br($datos[6]['texto'] ?? "TU CASA DE APUESTAS EXPLORA NUESTRAS EXPERIENCIAS\nÚNICAS Y ELIGE CÓMO VIVIR LA EMOCIÓN DEL JUEGO.") ?>
  </p>
</section>

<!-- DEPORTE -->
<section class="seccion deporte">
  <!-- Banner de deportes obtenido dinámicamente de la base de datos -->
  <img src="<?= $datos[5]['imagen_header'] ?? 'ImagesSV/Banner_deporte.png' ?>" alt="Banner Deporte" class="banner-deporte">

  <!-- Título de la sección de deportes -->
  <h3 class="titulo-deporte"><?= $datos[5]['titulo'] ?? 'APUESTA EN TUS DEPORTES FAVORITOS' ?></h3>

  <!-- Texto descriptivo de la sección de deportes -->
  <p class="texto-deporte">
    <?= $datos[5]['texto'] ?? 'PRONOSTICÁ RESULTADOS EN TIEMPO REAL Y SENTÍ LA ADRENALINA DE CADA JUGADA.' ?>
  </p>

  <!-- Botón que enlaza a la plataforma de apuestas deportivas -->
  <a href="<?= $datos[5]['link'] ?? 'https://juega.loto.sv/fob' ?>" class="btn-como-jugar">
    <img src="ImagesSV/jugá-aquí.png" alt="Cómo Jugar" />
  </a>

  <!-- Imagen inferior de deportes -->
  <img src="<?= $datos[5]['imagen_inferior'] ?? 'ImagesSV/deportes sv.png' ?>" alt="Apostemos" class="banner-apostemos">
</section>



<!-- GAMING -->
<section class="seccion gaming">
  <!-- Banner de gaming obtenido dinámicamente -->
  <img src="<?= $datos[7]['imagen_header'] ?? 'ImagesSV/Banner_gaming.png' ?>" alt="Banner Gaming" class="banner-gaming">

  <!-- Título de la sección gaming -->
  <h3 class="titulo-gaming"><?= $datos[7]['titulo'] ?? 'DIVERSIÓN SIN LÍMITES' ?></h3>

  <!-- Texto descriptivo de gaming -->
  <p class="texto-gaming">
    <?= $datos[7]['texto'] ?? 'DISFRUTÁ DE LOS MEJORES JUEGOS EN LÍNEA: SLOTS, JUEGOS DE MESA, JUEGOS DE CONCURSO, TODO EN UN SOLO LUGAR PARA JUGAR.' ?>
  </p>

  <!-- Botón que enlaza a la plataforma de gaming -->
  <a href="<?= $datos[7]['link'] ?? 'https://juega.loto.sv/gaming/' ?>" class="btn-como-jugar">
    <img src="ImagesSV/juga-aqui-nmorado 2.png" alt="Cómo Jugar" />
  </a>

  <!-- Imagen inferior de gaming -->
  <img src="<?= $datos[7]['imagen_inferior'] ?? 'ImagesSV/gaming 1.png' ?>" alt="Gaming" class="imagen-principal-gaming">
</section>

<!--
<section class="seccion quiniela">
  
  <img src="ImagesSV/Banner_quinela.png" alt="Banner Quiniela" class="banner-quiniela"> 
  <h3 class="titulo-quiniela">PRONOSTICA Y GANA</h3>
  <p class="texto-quiniela">
    ELIGE LOS RESULTADOS DE 10 PARTIDOS DE FÚTBOL.<br>
    ¡ENTRE MÁS ACIERTOS, MÁS OPORTUNIDAD DE GANAR EL POZO!
  </p>

  <a href="https://juega.loto.sv/lottery/" class="btn-como-jugar">
    <img src="ImagesSV/como-jugar-quinela.png" alt="Cómo Jugar" />
  </a>
  <img src="ImagesSV/quinela.png" alt="Quiniela" class="imagen-principal">
</section>
-->
<!-- MÉTODOS DE RECARGA -->
<section class="metodos">
  <!-- Título de la sección de métodos de recarga -->
  <h3>MÉTODOS PARA RECARGAR</h3>
  <div class="logos">
    <!-- Primera fila de métodos de pago -->
    <div class="fila">
      <!-- Enlace a la plataforma de websales para recargar con tarjeta -->
      <a href="https://juega.loto.sv/websales/?action=login">
    <img src="ImagesSV/tarjeta.svg" alt="Tarjeta" style="cursor:pointer;">
  </a>
  <!--
  <a href="https://juega.loto.sv/websales/?action=login">
    <img src="ImagesSV/punto tengo.svg" alt="Punto Tengo" style="cursor:pointer;">
  </a>
    </div>
    <div class="fila">
      <a href="https://juega.loto.sv/websales/?action=login">
    <img src="ImagesSV/tigo money.svg" alt="Tigo Money" style="cursor:pointer;">
  </a> -->
      <!-- Enlace para recargar con Loto Saldo -->
      <a href="https://juega.loto.sv/websales/?action=login">
  <img src="ImagesSV/Logo LotoSaldo.png"
       alt="Loto Saldo"
       style="cursor:pointer; height:60px;">
</a>

    </div>
  </div>

  <!-- Botón adicional para jugar -->
  <a href="https://juega.loto.sv/websales/" class="btn-como-jugar">
    <img src="ImagesSV/jugá-aquí.png" alt="Jugar Aquí" />
  </a>
</section>




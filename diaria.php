<?php
$config = [];
// ================= CONEXIÓN SQL SERVER =================
// Establece la conexión con la base de datos SQL Server en Azure
try {
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $conn->query("SELECT * FROM paginaweb_nic_diaria WHERE id = 1");
    $config = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    // Si la conexión falla, detiene la ejecución y muestra el error
    $config = [];
}

// ================= OBTENER DATOS =================
// Consulta la configuración de la página desde la tabla paginaweb_nic_diaria
$logoUrl = !empty($config['logo']) ? $config['logo'] : '/ImagesSV/LOGO DIARIA.svg';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>La Diaria</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    /* Importa la fuente Helvetica Rounded desde Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Helvetica+Rounded:wght@400;700;900&display=swap');

    /* Reinicio básico y tipografía global */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Helvetica Rounded', Arial, sans-serif;
    }

    /* Fondo general de la página */
    body {
      background: #fff;
    }
    /* ================= HEADER ================= */
    /* Contenedor superior de la cabecera de La Diaria */
.top {
  background: #76b82a;
  display: flex;
  justify-content: center;
  padding: 25px 10px; /* MENOS ALTO */
}

.top-content {
  display: flex;
  align-items: center; /* Centrado vertical con la imagen */
  max-width: 1300px;
  width: 100%;
  position: relative;
}

/* Imagen del logo/cabecera ubicada en la sección superior */
.top img {
  width: 330px; /* Imagen más grande */
  height: auto;
  margin-top: 70px;
  margin-left: 80px;
}

/* Caja que muestra el último número ganador y el contador */
.ganador-box {
  text-align: center;
  color: white;
  margin-top: 10px;
  margin-left: 160px; /* Mantener la posición al lado de la imagen */
}

.ganador {
  font-weight: 900;
  font-size: 26px; /* Ligeramente más grande */
  margin-bottom: 15px;
}

.nums {
  margin-bottom: 10px;
}

.num {
  width: 65px; /* Un poco más grande */
  height: 65px;
  line-height: 65px;
  display: inline-block;
  background: #13a538;
  border-radius: 50%;
  font-weight: bold;
  font-size: 24px; /* Un poco más grande */
  color: white;
  margin: 0 4px;
  border: 2px solid white;
  text-align: center;
}

.etiqueta-hola {
  background:#ffcb00;
  color: green;
  padding: 6px 14px;
  border-radius: 20px;
  font-weight: 900;   /* MÁS BOLD */
  font-size: 18px;    /* Ligeramente más grande */
}

    /* ================= MENÚ MODERNO ================= */
    /* Barra de opciones con botones de acción */
    .menu {
      display: flex;
      justify-content: center;
      gap: 18px;
      background: #76b82a;
      padding: 16px;
      flex-wrap: wrap;
    }

    .menu a {
      background: linear-gradient(135deg, #13a538, #13ac05);
      color: white;
      text-decoration: none;
      padding: 10px 22px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: bold;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(0,0,0,.25);
    }

    .menu a:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 14px rgba(0,0,0,.3);
    }

    .menu a:first-child {
  margin-right: 70px; /* mueve un poco "CÓMO JUGAR" hacia la izquierda */
}

.menu a:last-child {
  margin-left: 70px;  /* mueve un poco "RESULTADOS" hacia la derecha */
}

    /* ================= RESULTADOS ================= */
    /* Contenedor principal de resultados y calendario */
    .resultados {
      border: 1px solid #13a538;
      display: flex;
      max-width: 1100px;
      margin: 40px auto;
      background: white;
      border-radius: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
      padding: 25px;
      gap: 20px;
    }

    .resultados .col {
      flex: 1;
      text-align: center;
    }

     /* COLUMNA IZQUIERDA - MÁS IMPONENTE Y CENTRADO */
.izquierda {
  display: flex;
  flex-direction: column;
  justify-content: center; /* Centrado vertical */
  align-items: flex-start; /* Mantener al lado izquierdo */
  gap: 15px;               /* Espacio entre elementos */
  min-height: 100%;         /* Para que tome todo el alto de la fila */
}

.izquierda h2 {
  font-size: 42px;     /* Más grande */
  font-weight: 900;    /* Muy bold */
  color: #13a538;
  margin: 0;
  line-height: 1.1;
}

.label-fecha {
  font-size: 18px;     /* Más grande */
  font-weight: 700;
  background: #ffcb00; /* Mantener color que ya tenías */
  color: green;
  padding: 8px 16px;
  border-radius: 20px;
  display: inline-block;
  margin-left: 35px;  /* Mueve un poco a la derecha */
}

/* ================= CALENDARIO ULTRA MODERNO COMPACTO ================= */
/* Caja de calendario para seleccionar fechas de resultados */
.calendario-real {
  background: linear-gradient(145deg, #ffffff, #f4f4f4);
  border-radius: 16px;
  padding: 12px 14px;       /* MÁS PEQUEÑO */
  box-shadow: 0 8px 18px rgba(0,0,0,0.15);
  border: 1px solid #e5e5e5;
  max-width: 260px;        /* TAMAÑO CONTROLADO */
  margin: auto;
}

.calendario-real table {
  width: 100%;
  border-collapse: collapse;
  text-align: center;
}

.calendario-real th {
  font-size: 12px;         /* MÁS PEQUEÑO */
  font-weight: 800;
  color: #13a538;
  padding: 6px 0;
  text-transform: uppercase;
}

.calendario-real td {
  padding: 7px 0;         /* MÁS PEQUEÑO */
  font-weight: 700;
  font-size: 13px;
  color: #444;
  cursor: pointer;
  transition: 0.25s;
  border-radius: 50%;
}

.calendario-real td:hover {
  background: rgba(2,146,71,0.15);
}

.calendario-real td.activo {
  background: linear-gradient(135deg, #13a538, #13ac05);
  color: white;
  box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}

/* ================= FILTROS PREMIUM COMPACTOS ================= */
/* Contenedor de filtros para elegir mes y año */
.filtros {
  gap: 6px;
  margin-bottom: 10px;
}

.filtros select {
  padding: 6px 12px;      /* MÁS PEQUEÑO */
  font-size: 13px;
  border-radius: 10px;
  border: none;
  background: #f3f3f3;
  box-shadow: inset 0 2px 5px rgba(0,0,0,0.15);
  cursor: pointer;
  font-weight: 700;
  color: #13a538;
  transition: 0.3s;
}

.filtros select:hover {
  background: #e9e9e9;
}
    /* ================= SORTEOS MEJORADOS ================= */
.derecha {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.derecha .sorteo {
  margin-bottom: 20px;
  text-align: center;
}

.derecha h3 {
  font-size: 20px;        /* Más grande */
  font-weight: 900;      /* ULTRA BOLD */
  color: #13a538;
  margin-bottom: 12px;
  text-align: center;    /* Bien centrado */
  letter-spacing: 0.5px;
}

/* NÚMEROS DEL SORTEO */
.derecha .num {
  width: 52px;
  height: 52px;
  line-height: 52px;
  display: inline-block;
  background: #13a538;
  border-radius: 50%;
  font-weight: 900;
  font-size: 20px;
  color: white;
  margin: 0 6px;
  border: 2px solid white;
  text-align: center;
}

    /* ================= ACCORDION ================= */
    /* Contenedor principal tipo acordeón para mostrar contenido desplegable */
    .accordion {
      max-width: 1100px;
      margin: 30px auto;
      border-radius: 15px;
      overflow: hidden;
      background: white; /*  FONDO BLANCO */
      border: 2px solid #13a538; /* BORDE VISIBLE */
    }

    .accordion-header {
      padding: 18px;
      text-align: center;
      color: white;
      font-weight: bold;
      font-size: 24px;
      cursor: pointer;
      position: relative;
      background: #13a538;
    }

    .accordion-header .arrow {
      position: absolute;
      right: 20px;
      font-size: 26px;
    }

    .accordion-content {
      display: none;
      padding: 20px;
      background: white;
    }

    /* SUB-ACORDEONES */
/* ================= SUB-ACORDEONES MEJORADOS ================= */
/* Encabezado de cada sub-acordeón dentro del contenido expandible */
.sub-accordion-header {
  background: #13a538; /* Verde más intenso */
  color: white;
  padding: 14px 20px;
  margin-bottom: 10px;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-weight: 600;
  font-size: 20px; /* Letra más grande y legible */
  box-shadow: 0 3px 6px rgba(0,0,0,0.1); /* Sombra suave */
  transition: background 0.3s;
}

/* Hover opcional */
.sub-accordion-header:hover {
  background: #03b454; /* Verde más claro al pasar mouse */
}

/* CÍRCULO DE LA FLECHA */
.sub-accordion-header span {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #b4e5b0; /* Verde claro */
  color: #ffffff;      /* Flecha blanca */
  font-size: 18px;
  flex-shrink: 0;
  transition: transform 0.3s;
}

/* Girar flecha al abrir */
.sub-accordion-header.active span {
  transform: rotate(180deg);
}

/* CONTENIDO DE SUB-ACORDEONES */
.sub-accordion-content {
  display: none;
  padding: 15px 20px;
  background: white; /* Fondo blanco */
  border-radius: 0 0 12px 12px;
  margin-bottom: 12px;
  font-size: 17px; /* Texto más legible */
  font-weight: 600;
  line-height: 1.5; /* Espaciado de línea para lectura */
}

 /*  TODO EN HELVETICA ROUNDED SEMIBOLD */
body {
  font-family: 'Helvetica Rounded', Arial, sans-serif;
  font-weight: 600;
}

/* BLOQUE SUPERIOR DEL ACCORDION */
/* ================= INFO-JUEGO MEJORADA ================= */
/* Sección principal con descripción del juego y contenido destacado */
.info-juego {
  margin-bottom: 30px;
  padding: 20px;
  background: #ffffff; /* Fondo blanco */
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08); /* Sombra sutil */
}

/* SLOGAN PRINCIPAL */
.slogan {
  text-align: center; /* Centrado para resaltar */
  font-size: 22px;
  font-weight: 700;
  color: #13a538; /* Verde destacado */
  margin-bottom: 12px;
  line-height: 1.4;
}

/* DESCRIPCIÓN */
.descripcion {
  text-align: center;
  font-size: 17px;
  font-weight: 600;
  color: #333; /* Gris oscuro para mejor lectura */
  margin-bottom: 20px;
  line-height: 1.5;
}

/* SUBTÍTULO */
.subtitulo-verde {
  text-align: center;
  font-size: 20px;
  font-weight: 700;
  color: #13a538;
  margin-bottom: 15px;
}

/* TEXTO + IMAGEN AL LADO */
.linea-juego {
  display: flex;
  align-items: flex-start; /* Ajuste arriba para que texto se alinee con imagen */
  gap: 16px;
  margin-top: 15px;
  font-size: 16px;
  font-weight: 600;
  color: #333;
  line-height: 1.5;
}

/* IMAGEN */
.img-diaria {
  width: 75px;
  height: auto;
  flex-shrink: 0;
  border-radius: 6px; /* Bordes suaves */
}

/* ================= SUB-ACORDEONES ================= */
.sub-accordion-header {
  background: #13a538; /* Verde principal */
  color: white;
  padding: 14px 20px;
  margin-bottom: 10px;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-weight: 600;
  font-size: 20px;
  transition: background 0.3s;
}

/* Hover opcional */
.sub-accordion-header:hover {
  background: #03b454;
}

/* CÍRCULO DE LA FLECHA */
.sub-accordion-header span {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #c6e3b3; /* Verde más suave y elegante */
  color: #13a538;      /* Flecha verde oscuro */
  font-size: 18px;
  flex-shrink: 0;
  transition: transform 0.3s;
}

/* Girar flecha al abrir */
.sub-accordion-header.active span {
  transform: rotate(180deg);
}

/* CONTENIDO DE SUB-ACORDEONES */
.sub-accordion-content {
  display: none;
  padding: 15px 20px;
  background: white; /* Fondo blanco */
  border-radius: 0 0 12px 12px;
  margin-bottom: 12px;
  font-size: 16px;
  font-weight: 600;
  line-height: 1.5;
  color: #333;
}
    /* ================= BOTÓN ================= */
    .reglamento {
      text-align: center;
      margin: 40px 0;
    }

    .reglamento button {
      background: #ff6f00;
      color: white;
      padding: 14px 30px;
      border-radius: 30px;
      border: none;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
    }

    .calendario-real td.activo {
    background: linear-gradient(135deg, #13a538, #13ac05); /* Fondo verde */
    color: white;
    border-radius: 50%; /* Hace el fondo circular */
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25); /* Sombra sutil para el efecto de resaltar */
}

/* ================= FIX HEADER LA DIARIA – SOLO MÓVIL ================= */
@media (max-width: 768px) {

  /* Header contenedor */
  .top {
    padding: 20px 10px;
  }

  .top-content {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  /* LOGO */
  .top img {
    width: 220px;
    max-width: 90%;
    margin: 0 auto 15px auto;
  }

  /* Caja de resultados */
  .ganador-box {
    margin: 0;
    text-align: center;
  }

  .ganador {
    font-size: 20px;
    margin-bottom: 10px;
  }

  /* NÚMEROS */
  .num {
    width: 48px;
    height: 48px;
    line-height: 48px;
    font-size: 18px;
    margin: 0 3px;
  }

  /* CONTADOR */
  .etiqueta-hola {
    font-size: 15px;
    padding: 6px 12px;
    margin-top: 10px;
  }

  /* MENÚ */
  .menu {
    gap: 10px;
    padding: 12px;
  }

  .menu a {
    width: 100%;
    text-align: center;
    margin: 0;
  }

  .menu a:first-child,
  .menu a:last-child {
    margin: 0;
  }

  /* RESULTADOS */
  .resultados {
    flex-direction: column;
    padding: 20px 15px;
  }

  .izquierda {
    align-items: center;
    text-align: center;
  }

  .izquierda h2 {
    font-size: 28px;
  }

  .label-fecha {
    margin-left: 0;
  }

}

@media (max-width: 768px) {

  /* Bajamos todo el contenido del header */
  .top-content {
      margin-top: 280px; /* Ajusta este valor según cuánto quieras bajarlo */
  }

}

.linea-juego {
  display: flex;
  flex-wrap: wrap;        /* Para que sea responsive */
  align-items: center;    /* Centrado vertical */
  gap: 20px;              /* Espacio entre imagen y texto */
  margin-top: 20px;
  background: #f8f9fa;    /* Fondo suave para resaltar */
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Sombra sutil */
}

.img-container {
  flex: 0 0 120px;        /* Ancho fijo de la imagen */
  display: flex;
  justify-content: center;
  align-items: center;
}

.img-diaria {
  width: 100%;
  height: auto;
  border-radius: 10px;
  object-fit: cover;
  transition: transform 0.3s;
}

.img-diaria:hover {
  transform: scale(1.05); /* Animación ligera al pasar el mouse */
}

.texto-principal {
  flex: 1;
  font-size: 16px;
  font-weight: 600;
  color: #333;
  line-height: 1.6;
}
  </style>
</head>

<body>

  <!-- HEADER -->
  <!-- Área superior con logo y último número ganador -->
  <div class="top">
    <div class="top-content">
      <img src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo Diaria">

      <div class="ganador-box">
        <div class="ganador">ÚLTIMO NÚMERO GANADOR</div>

        <div class="nums">
  <span class="num" id="num1">0</span>
  <span class="num" id="num2">0</span>
</div>

        <div class="etiqueta-hola">
  PRÓXIMO SORTEO EN VIVO:
  <span id="horaHeader">00</span>:
  <span id="minHeader">00</span>:
  <span id="segHeader">00</span>
</div>
      </div>
    </div>
  </div>

  <!-- MENÚ -->
  <!-- Botones principales de acción: jugar y descargar tabla de señales -->
  <div class="menu">
    <a href="https://juega.loto.sv/websales/" target="_blank">JUGÁ AQUÍ</a>
    <a href="/ImagesSV/documentos/Diaria Tabla de señales.pdf" download>
  SEÑALES QUE TE HACEN GANAR
</a>

  </div>

  <!-- RESULTADOS -->
  <div class="resultados">

    <div class="col izquierda">
      <h2>RESULTADOS ANTERIORES</h2>
      <div class="label-fecha">SELECCIONÁ LA FECHA</div>
    </div>

    <div class="col calendario">
      <div class="filtros">
        <select id="filtro-mes">
          <option value="01">Enero</option>
          <option value="02">Febrero</option>
          <option value="03">Marzo</option>
          <option value="04">Abril</option>
          <option value="05">Mayo</option>
          <option value="06">Junio</option>
          <option value="07">Julio</option>
          <option value="08">Agosto</option>
          <option value="09">Septiembre</option>
          <option value="10">Octubre</option>
          <option value="11">Noviembre</option>
          <option value="12">Diciembre</option>
        </select>
        <select id="filtro-ano">
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
        </select>
      </div>

      <div class="calendario-real">
        <table>
          <thead>
            <tr>
              <th>DOM</th><th>LUN</th><th>MAR</th><th>MIE</th><th>JUE</th><th>VIE</th><th>SAB</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    
      <div class="col derecha">
      <div class="sorteo">
        <h3>SORTEO 12:00 P.M.</h3>
<span class="num-numero" id="num12_1">--</span>
<span class="num-numero" id="num12_2">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 3:00 P.M.</h3>
<span class="num-numero" id="num15_1">--</span>
<span class="num-numero" id="num15_2">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 6:00 P.M.</h3>
<span class="num-numero" id="num18_1">--</span>
<span class="num-numero" id="num18_2">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 9:00 P.M.</h3>
<span class="num-numero" id="num21_1">--</span>
<span class="num-numero" id="num21_2">--</span>
      </div>
    </div>
  </div>

  <!-- ACCORDION -->
  <!-- Sección desplegable principal con información editable de la Diaria -->
<div class="accordion">

  <div class="accordion-header" onclick="toggle(this)">
    <!-- SUBTÍTULO EDITABLE -->
    <?= htmlspecialchars($config['titulo1']) ?>
    <span class="arrow">▼</span>
  </div>

  <div class="accordion-content">

  <div class="info-juego">
    <!-- TEXTO PRINCIPAL EDITABLE -->
    <p class="descripcion">
      <?= nl2br(htmlspecialchars($config['contenido1'])) ?>
    </p>

    <!-- IMAGEN FIJA QUE NUNCA CAMBIA -->
    <div class="linea-juego">
    <div class="img-container">
        <img src="/ImagesSV/Diaria.webp" class="img-diaria" alt="Imagen Diaria">
    </div>
    <div class="texto-principal">
        <?= nl2br(htmlspecialchars($config['contenido_principal'])) ?>
    </div>
</div>
  </div>

  
  <!-- SUB-ACORDEONES DINÁMICOS -->
  <!-- Cada sub-acordeón puede abrir una sección adicional con contenido editable -->
  <div class="sub-accordion-header" onclick="toggle(this)">
    <?= htmlspecialchars($config['titulo2']) ?>
    <span>▼</span>
  </div>
  <div class="sub-accordion-content">
    <?= nl2br(htmlspecialchars($config['contenido2'])) ?>
  </div>

  <div class="sub-accordion-header" onclick="toggle(this)">
    <?= htmlspecialchars($config['titulo3']) ?>
    <span>▼</span>
  </div>
  <div class="sub-accordion-content">
    <?= nl2br(htmlspecialchars($config['contenido3'])) ?>
  </div>

</div>
</div>

  <!-- BOTÓN -->
  <!-- BOTÓN REGLAMENTO: enlace al documento PDF del reglamento oficial -->
<div class="reglamento">
  <a href="/ImagesSV/documentos/Reglamento La Diaria El Salvador.pdf" target="_blank">
    <button class="btn-reglamento">
       LEER EL REGLAMENTO
    </button>
  </a>
</div>

  <script>
    // Alterna la visibilidad del contenido justo después del encabezado clickeado
    function toggle(h) {
      let c = h.nextElementSibling;
      c.style.display = (c.style.display === "block") ? "none" : "block";
    }
  </script>
<script>
// ============================================================================
// Contador regresivo al siguiente sorteo
// ============================================================================
const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;

let hoy = new Date();
let dia = hoy.getDate();
let horaActual = hoy.getHours();
let HoraSorteo = "";
const horariosSorteo = [12, 15, 18, 21];

// Horarios de sorteo: 12:00 P.M., 3:00 P.M., 6:00 P.M. y 9:00 P.M.
HoraSorteo = horariosSorteo.find(function (horaSorteo) {
  return horaActual < horaSorteo;
});

if (!HoraSorteo) {
  HoraSorteo = horariosSorteo[0];
  dia += 1;
}

// Fecha del próximo sorteo
let countDown = new Date(
  hoy.getFullYear(),
  hoy.getMonth(),
  dia,
  HoraSorteo
).getTime();

Number.prototype.padStart = function(n, str){
  return Array(n - String(this).length + 1).join(str || '0') + this;
};

let x = setInterval(function () {
  let now = new Date().getTime();
  let distance = countDown - now;

  let h = Math.floor((distance % day) / hour).padStart(2, "0");
  let m = Math.floor((distance % hour) / minute).padStart(2, "0");
  let s = Math.floor((distance % minute) / second).padStart(2, "0");

  document.getElementById("horaHeader").innerText = h;
  document.getElementById("minHeader").innerText = m;
  document.getElementById("segHeader").innerText = s;

  if (distance <= 0) {
    clearInterval(x);
    document.querySelector(".etiqueta-hola").innerText = "¡SORTEO EN VIVO!";
  }
}, second);
</script>

<script>
  // Fetch para obtener los resultados actuales de la Diaria desde la API local
  fetch('/api/resultado-diaria.php')
    .then(r => r.json())
    .then(d => {
      if (!d.error) {

        // Actualiza los valores del header con el último número ganador
        document.getElementById("num1").innerText = d.digito1;
        document.getElementById("num2").innerText = d.digito2;

      } else {
        console.error(d.error);
      }
    })
    .catch(err => console.error(err));

  // Evento para renderizar el calendario una vez cargue la página
  document.addEventListener('DOMContentLoaded', function () {
    const mesSelect = document.getElementById('filtro-mes');
    const anoSelect = document.getElementById('filtro-ano');
    const calendario = document.querySelector('.calendario-real table tbody');

    // Función para renderizar el calendario
    function renderizarCalendario(mes, ano) {
      // Calcula el primer y último día del mes seleccionado
      const primerDia = new Date(ano, mes - 1, 1);
      const ultimoDia = new Date(ano, mes, 0); // Último día del mes

      // Día de la semana del primer día (0 = domingo, 6 = sábado)
      const diaInicio = primerDia.getDay();
      const cantidadDias = ultimoDia.getDate(); // Número de días del mes

      // Limpiar el calendario actual
      calendario.innerHTML = '';

      // Obtener la fecha actual
      const hoy = new Date();
      const diaHoy = hoy.getDate();
      const mesHoy = hoy.getMonth() + 1; // Los meses empiezan desde 0, así que se suma 1
      const anoHoy = hoy.getFullYear();

      // Generar las filas del calendario
      let fila = document.createElement('tr');

      // Añadir celdas vacías para los días antes del primer día
      for (let i = 0; i < diaInicio; i++) {
        fila.appendChild(document.createElement('td'));
      }

      // Añadir los días del mes
      for (let dia = 1; dia <= cantidadDias; dia++) {
        const celda = document.createElement('td');
        celda.textContent = dia;

        // Resaltar el día actual con un círculo verde
        if (dia === diaHoy && mesHoy === mes && anoHoy === ano) {
          celda.classList.add('activo'); // Se agrega la clase 'activo' para resaltar el día actual
        }

        fila.appendChild(celda);

        // Si hemos llegado al final de la semana (sábado), agregamos una nueva fila
        if ((dia + diaInicio) % 7 === 0) {
          calendario.appendChild(fila);
          fila = document.createElement('tr');
        }
      }

      // Añadir la fila final (si hay días que no completan la última semana)
      if (fila.children.length > 0) {
        calendario.appendChild(fila);
      }
    }

    // Evento para cambiar el mes y año seleccionado
    mesSelect.addEventListener('change', function () {
      const mesSeleccionado = mesSelect.value;
      const anoSeleccionado = anoSelect.value;
      renderizarCalendario(mesSeleccionado, anoSeleccionado);
    });

    anoSelect.addEventListener('change', function () {
      const mesSeleccionado = mesSelect.value;
      const anoSeleccionado = anoSelect.value;
      renderizarCalendario(mesSeleccionado, anoSeleccionado);
    });

    // Renderizar el calendario inicial con el mes y año actuales
    const hoy = new Date();
    const mesActual = hoy.getMonth() + 1; // +1 porque los meses en JavaScript comienzan en 0
    const anoActual = hoy.getFullYear();

    // Seleccionar el año actual en el combobox
    anoSelect.value = anoActual;

    // Asegurarse de que el mes también sea el actual
    mesSelect.value = mesActual < 10 ? '0' + mesActual : mesActual;

    renderizarCalendario(mesActual, anoActual);
  });
</script>

<script>
  function pad2(num) {
    return num.toString().padStart(2, '0');
  }

  // Función para obtener resultados desde la API remota según la fecha seleccionada
  function actualizarResultados(fecha) {
    fetch(`/api/resultados_calendario_diaria.php?fecha=${fecha}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('num12_1').innerText = data['12:00'] ? data['12:00'].charAt(0) : '0';
        document.getElementById('num12_2').innerText = data['12:00'] ? data['12:00'].charAt(1) : '0';
        document.getElementById('num15_1').innerText = data['15:00'] ? data['15:00'].charAt(0) : '0';
        document.getElementById('num15_2').innerText = data['15:00'] ? data['15:00'].charAt(1) : '0';
        document.getElementById('num18_1').innerText = data['18:00'] ? data['18:00'].charAt(0) : '0';
        document.getElementById('num18_2').innerText = data['18:00'] ? data['18:00'].charAt(1) : '0';
        document.getElementById('num21_1').innerText = data['21:00'] ? data['21:00'].charAt(0) : '0';
        document.getElementById('num21_2').innerText = data['21:00'] ? data['21:00'].charAt(1) : '0';
      })
      .catch(err => console.error('Error al obtener resultados:', err));
  }

  document.addEventListener('DOMContentLoaded', function () {
    const mesSelect = document.getElementById('filtro-mes');
    const anoSelect = document.getElementById('filtro-ano');
    const calendario = document.querySelector('.calendario-real table tbody');

    function renderizarCalendario(mes, ano) {
      const primerDia = new Date(ano, mes - 1, 1);
      const ultimoDia = new Date(ano, mes, 0);
      const diaInicio = primerDia.getDay();
      const cantidadDias = ultimoDia.getDate();

      calendario.innerHTML = '';

      const hoy = new Date();
      const diaHoy = hoy.getDate();
      const mesHoy = hoy.getMonth() + 1;
      const anoHoy = hoy.getFullYear();

      let fila = document.createElement('tr');

      for (let i = 0; i < diaInicio; i++) {
        fila.appendChild(document.createElement('td'));
      }

      for (let dia = 1; dia <= cantidadDias; dia++) {
        const celda = document.createElement('td');
        celda.textContent = dia;

        // Día actual
        if (dia === diaHoy && mesHoy === mes && anoHoy === ano) {
          celda.classList.add('activo');
          actualizarResultados(`${ano}-${pad2(mes)}-${pad2(dia)}`); // mostrar resultados del día actual
        }

        // Evento click para cada celda
        celda.addEventListener('click', function () {
          // Quitar clase 'activo' de todas
          calendario.querySelectorAll('td.activo').forEach(a => a.classList.remove('activo'));
          celda.classList.add('activo');

          const fecha = `${ano}-${pad2(mes)}-${pad2(dia)}`;
          actualizarResultados(fecha);
        });

        fila.appendChild(celda);

        if ((dia + diaInicio) % 7 === 0) {
          calendario.appendChild(fila);
          fila = document.createElement('tr');
        }
      }

      if (fila.children.length > 0) {
        calendario.appendChild(fila);
      }
    }

    // Cambios de mes y año
    function actualizarCalendario() {
      renderizarCalendario(parseInt(mesSelect.value), parseInt(anoSelect.value));
    }

    mesSelect.addEventListener('change', actualizarCalendario);
    anoSelect.addEventListener('change', actualizarCalendario);

    // Render inicial
    const hoy = new Date();
    anoSelect.value = hoy.getFullYear();
    mesSelect.value = pad2(hoy.getMonth() + 1);
    renderizarCalendario(hoy.getMonth() + 1, hoy.getFullYear());
  });
</script>
</body>
</html>


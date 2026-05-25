<?php
$config = [];

try {
    require_once __DIR__ . '/config/connection.php';
    $stmt = $conn->prepare("SELECT * FROM paginaweb_nic_juga_cuatro WHERE id = ?");
    $stmt->execute([1]);
    $config = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    $config = [];
}

$logoUrl = !empty($config['logo']) ? $config['logo'] : '/ImagesSV/Logo Juga4 - LOTO NIC- 2025.png';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Jugá Cuatro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    @font-face {
      font-family: 'HelveticaRounded';
      src: url('/fonts/HelveticaRoundedLTStd-Bd.ttf') format('truetype');
      font-weight: 700 900;
      font-style: normal;
      font-display: swap;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'HelveticaRounded', Arial, sans-serif;
    }

    body {
      background:#fff;
    }

    /* ================= HEADER ================= */
    .top {
      background: #9e1e5c;
      display: flex;
      justify-content: center;
      padding: 25px 10px;
    }

    .top-content {
      display: flex;
      align-items: center;
      max-width: 1300px;
      width: 100%;
      position: relative;
    }

    .top img {
      width: 330px;
      height: auto;
      margin-top: 70px;
      margin-left: 80px;
    }

    .ganador-box {
      text-align: center;
      color: white;
      margin-top: 10px;
      margin-left: 160px;
    }

    .ganador {
      font-weight: 900;
      font-size: 26px;
      margin-bottom: 15px;
      color: white !important;
    }

    .nums {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .num-numero {
      width: 65px;
      height: 65px;
      line-height: 65px;
      display: inline-block;
      background: #fff;
      border-radius: 50%;
      font-weight: bold;
      font-size: 24px;
      color: #333;
      margin: 0 4px;
      border: 2px solid white;
      text-align: center;
    }

.derecha .num-numero {
    width: 48px;
    height: 48px;
    line-height: 48px;
    display: inline-block;
    background: #fff;
    border-radius: 50%;
    font-weight: 900;
    font-size: 18px;
    color: #333;
    margin: 0 4px;
    border: 2px solid #ddd;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
}


    .etiqueta-hola {
      background: #ffb800;
      color: #5b123f;
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: 900;
      font-size: 18px;
    }

    /* ================= MENÚ ================= */
    .menu {
      display: flex;
      justify-content: center;
      gap: 18px;
      background:  #9e1e5c;
      padding: 16px;
      flex-wrap: wrap;
    }

    .menu a { /* juega aquí y conocé más botones */
      background: linear-gradient(135deg, #ffffff, #9e1e5c);
      color: #5b163f;
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
      margin-right: 0;
    }

    .menu a:last-child {
      margin-left: 0;
    }

    /* ================= RESULTADOS ================= */
    .resultados {
      border: 1px solid #9e1e5c;
      display: grid;
      grid-template-columns: 1fr 320px 1fr;
      align-items: center;
      max-width: 1100px;
      margin: 40px auto;
      background: white;
      border-radius: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
      padding: 25px;
      gap: 20px;
    }

    .resultados .col {
      text-align: center;
    }

    .calendario {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .izquierda {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      gap: 15px;
      min-height: 100%;
    }

    .izquierda h2 {
      font-size: 42px;
      font-weight: 900;
      color: #9e1e5c;
      margin: 0;
      line-height: 1.1;
    }

    .label-fecha {
      font-size: 18px;
      font-weight: 700;
      background: #f78f1e;
      color: #5b163f;
      padding: 8px 16px;
      border-radius: 20px;
      display: inline-block;
      margin-left: 35px;
    }

    /* ================= CALENDARIO ================= */
    .calendario-real {
      background: linear-gradient(145deg, #ffffff, #f4f4f4);
      border-radius: 16px;
      padding: 14px 16px;
      box-shadow: 0 8px 18px rgba(0,0,0,0.15);
      border: 1px solid #e5e5e5;
      width: min(100%, 300px);
  max-width: 300px;
      margin: auto;
    }

    .calendario-real table {
      width: 100%;
      table-layout: fixed;
  border-collapse: separate;
  border-spacing: 0 4px;
      text-align: center;
    }

    .calendario-real th {
      width: 14.285%;
      font-size: 10px;
      font-weight: 800;
      color: #9e1e5c;
      padding: 6px 2px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .calendario-real td {
      width: 14.285%;
      height: 28px;
      padding: 0;
      line-height: 28px;
      font-weight: 700;
      font-size: 13px;
      color: #444;
      cursor: pointer;
      transition: 0.25s;
      border-radius: 50%;
    }

    .calendario-real td:hover {
      background: rgba(192,39,43,0.15);
    }

    .calendario-real td.activo {
      background: linear-gradient(135deg, #9e1e5c, #5b163f);
      color: white;
      border-radius: 50%;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }

    /* ================= FILTROS ================= */
    .filtros {
      display: flex;
      justify-content: center;
      gap: 6px;
      margin-bottom: 10px;
    }

    .filtros select {
      padding: 6px 12px;
      font-size: 13px;
      border-radius: 10px;
      border: none;
      background: #f3f3f3;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.15);
      cursor: pointer;
      font-weight: 700;
      color: #9e1e5c;
      transition: 0.3s;
    }

    .filtros select:hover {
      background: #e9e9e9;
    }

    /* ================= SORTEOS ================= */
    .derecha {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .derecha .sorteo {
      margin-bottom: 15px;
      text-align: center;
    }

    .derecha h3 {
      font-size: 18px;
      font-weight: 900;
      color: #9e1e5c;
      margin-bottom: 8px;
      text-align: center;
    }

    .derecha .num-number {
      width: 48px;
      height: 48px;
      line-height: 48px;
      display: inline-block;
      background: #fff;
      border-radius: 50%;
      font-weight: 900;
      font-size: 18px;
      color: #333;
      margin: 0 4px;
      border: 2px solid #ddd;
      text-align: center;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }
   

    /* ================= ACCORDION ================= */
    .accordion {
      max-width: 1100px;
      margin: 8px auto;
      border-radius: 12px;
      overflow: hidden;
      background: white;
      border: 2px solid #9e1e5c;
    }

    .accordion-header {
      padding: 18px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      font-weight: 800;
      font-size: 20px;
      cursor: pointer;
      background: #9e1e5c;
      transition: background 0.3s;
    }

    .accordion-header:hover {
      background: #5b163f;
    }

    .accordion-header .arrow-circle {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: rgba(255,255,255,0.25);
      font-size: 16px;
      flex-shrink: 0;
      transition: transform 0.3s;
    }

    .accordion-header.open .arrow-circle {
      transform: rotate(180deg);
    }

    .accordion-content {
      display: none;
      padding: 20px 24px;
      background: white;
      font-size: 16px;
      font-weight: 600;
      line-height: 1.7;
      color: #333;
    }


    .contenido-visible {
      max-width: 1100px;
      margin: 32px auto;
      padding: 0 18px;
    }

    .contenido-visible h2 {
      color: #0054a6;
      font-size: 34px;
      font-weight: 900;
      margin-bottom: 28px;
    }

    .contenido-visible img {
      display: block;
      width: min(100%, 520px);
      height: auto;
      margin: 0 auto;
    }

    .contenido-visible-texto {
      color: #333;
      font-size: 16px;
      font-weight: 600;
      line-height: 1.7;
    }

    /* ================= BOTÓN REGLAMENTO ================= */
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

    /* ================= RESPONSIVE MÓVIL ================= */
    @media (max-width: 768px) {

      .top {
        padding: 20px 10px;
      }

      .top-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .top img {
        width: 220px;
        max-width: 90%;
        margin: 0 auto 15px auto;
      }

      .ganador-box {
        margin: 0;
        text-align: center;
      }

      .ganador {
        font-size: 20px;
        margin-bottom: 10px;
      }

      .num-numero,
      .num-mes {
        width: 48px;
        height: 48px;
        line-height: 48px;
        font-size: 16px;
      }

      .etiqueta-hola {
        font-size: 15px;
        padding: 6px 12px;
        margin-top: 10px;
      }

      .menu a {
        width: 100%;
        text-align: center;
        margin: 0;
      }

      .resultados {
        grid-template-columns: 1fr;
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
    @media (max-width: 480px) {
      .top {
        padding: 18px 10px;
      }

      .top-content {
        flex-direction: column;
        text-align: center;
        gap: 14px;
      }

      .top img,
      .ganador-box {
        margin-left: 0;
        margin-top: 0;
      }

      .top img {
        width: min(210px, 82vw);
      }

      .ganador {
        font-size: 20px;
      }

      .nums {
        flex-wrap: wrap;
      }

      .num,
      .num-numero,
      .num-mes {
        width: 44px;
        height: 44px;
        line-height: 44px;
        font-size: 16px;
      }

      .menu {
        gap: 10px;
        padding: 12px;
      }

      .menu a {
        width: 100%;
        width: min(100%, 300px);
  max-width: 300px;
        text-align: center;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }

      .resultados {
        width: calc(100% - 20px);
        grid-template-columns: 1fr;
        padding: 18px;
        margin: 24px auto;
      }

      .izquierda {
        align-items: center;
      }

      .izquierda h2 {
        font-size: 30px;
        text-align: center;
      }

      .label-fecha {
        margin-left: 0;
      }

      .calendario-real {
        max-width: 100%;
        overflow-x: auto;
      }

      .accordion,
      .resultados-anteriores,
      .como-jugar {
        width: calc(100% - 20px);
        margin-left: auto;
        margin-right: auto;
      }
    }
    @media (max-width: 768px) {
      .top {
        min-height: 0 !important;
        padding: 16px 10px !important;
      }

      .top-content {
        justify-content: center !important;
        align-items: center !important;
        gap: 12px !important;
        margin-top: 0 !important;
      }

      .top img {
        display: block !important;
        width: min(210px, 78vw) !important;
        max-width: 78vw !important;
        margin: 0 auto 10px !important;
      }

      .ganador-box {
        width: 100%;
        margin: 0 auto !important;
      }
    }
  </style>
</head>

<body>

  <!-- HEADER IMAGEN DEL LOGO -->
  <div class="top">
    <div class="top-content"> 
      <img src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo Juga Cuatro">

      <div class="ganador-box">
        <div class="ganador">ÚLTIMO NÚMERO GANADOR</div>

        <div class="nums">
          <span class="num-numero" id="ultimo1">--</span>
          <span class="num-numero" id="ultimo2">--</span>
          <span class="num-numero" id="ultimo3">--</span>
          <span class="num-numero" id="ultimo4">--</span>
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
  <div class="menu">
    <a href="https://juega.loto.com.ni/websales/">JUGÁ AQUÍ</a>
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
        <span class="num-numero" id="num12_3">--</span>
        <span class="num-numero" id="num12_4">--</span>

      </div>

      <div class="sorteo">
        <h3>SORTEO 3:00 P.M.</h3>
        <span class="num-numero" id="num15_1">--</span>
        <span class="num-numero" id="num15_2">--</span>
        <span class="num-numero" id="num15_3">--</span>
        <span class="num-numero" id="num15_4">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 6:00 P.M.</h3>
        <span class="num-numero" id="num18_1">--</span>
        <span class="num-numero" id="num18_2">--</span>
        <span class="num-numero" id="num18_3">--</span>
        <span class="num-numero" id="num18_4">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 9:00 P.M.</h3>
        <span class="num-numero" id="num21_1">--</span>
        <span class="num-numero" id="num21_2">--</span>
        <span class="num-numero" id="num21_3">--</span>
        <span class="num-numero" id="num21_4">--</span>
      </div>
    </div>

  </div>

  <!-- ACORDEONES -->
  <?php
    $acordeonesDefault = [
      1 => ['titulo' => 'CÓMO JUGAR', 'contenido' => ''],
      2 => ['titulo' => 'CONOZCA LOS RESULTADOS', 'contenido' => ''],
      3 => ['titulo' => 'RECLAME SU PREMIO', 'contenido' => ''],
    ];

    $acordeones = [];
    for ($i = 1; $i <= 3; $i++) {
      $titulo = trim((string)($config["titulo{$i}"] ?? ($acordeonesDefault[$i]['titulo'] ?? '')));
      $contenido = trim((string)($config["contenido{$i}"] ?? ($acordeonesDefault[$i]['contenido'] ?? '')));

      if ($titulo !== '' || $contenido !== '') {
        $acordeones[] = [
          'titulo' => $titulo,
          'contenido' => $contenido,
        ];
      }
    }

    $contenidosVisibles = [];
    for ($i = 4; $i <= 7; $i++) {
      $titulo = trim((string)($config["titulo{$i}"] ?? ''));
      $contenido = trim((string)($config["contenido{$i}"] ?? ''));

      if ($titulo !== '' || $contenido !== '') {
        $contenidosVisibles[] = [
          'titulo' => $titulo,
          'contenido' => $contenido,
          'esImagen' => (bool)preg_match('/^https?:\/\//i', $contenido),
        ];
      }
    }
  ?>

  <?php foreach ($acordeones as $index => $acordeon): ?>
    <div class="accordion">
      <div class="accordion-header <?= $index === 0 ? 'open' : '' ?>" onclick="toggleAcordeon(this)">
        <?= htmlspecialchars($acordeon['titulo']) ?>
        <span class="arrow-circle">▼</span>
      </div>
      <div class="accordion-content" <?= $index === 0 ? 'style="display:block;"' : '' ?>>
        <?= nl2br(htmlspecialchars($acordeon['contenido'])) ?>
      </div>
    </div>
  <?php endforeach; ?>

  <?php foreach ($contenidosVisibles as $contenidoVisible): ?>
    <section class="contenido-visible">
      <?php if ($contenidoVisible['titulo'] !== ''): ?>
        <h2><?= htmlspecialchars($contenidoVisible['titulo']) ?></h2>
      <?php endif; ?>

      <?php if ($contenidoVisible['contenido'] !== ''): ?>
        <?php if ($contenidoVisible['esImagen']): ?>
          <img src="<?= htmlspecialchars($contenidoVisible['contenido']) ?>" alt="<?= htmlspecialchars($contenidoVisible['titulo']) ?>">
        <?php else: ?>
          <div class="contenido-visible-texto">
            <?= nl2br(htmlspecialchars($contenidoVisible['contenido'])) ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  <?php endforeach; ?>
  <!-- BOTÓN REGLAMENTO -->
  <!--
  <div class="reglamento">
    <a href="/ImagesSV/documentos/Reglamento Juga Cuatro.pdf" target="_blank">
      <button>LEER EL REGLAMENTO</button>
    </a>
  </div>
  -->

  <script>
    function toggleAcordeon(header) {
      const content = header.nextElementSibling;
      const isOpen = content.style.display === 'block';
      content.style.display = isOpen ? 'none' : 'block';
      header.classList.toggle('open', !isOpen);
    }
  </script>

  <script>
    function pintarJugaCuatro(prefix, resultado) {
      for (let i = 1; i <= 4; i++) {
        const elem = document.getElementById(`${prefix}_${i}`);
        if (elem) elem.innerText = resultado?.[i - 1] ?? '--';
      }
    }

    function actualizarResultadosJugaCuatro(fecha) {
      fetch(`/api/resultados_calendario_juga_cuatro.php?fecha=${fecha}`)
        .then(res => {
          if (!res.ok) throw new Error(`Error HTTP ${res.status}`);
          return res.json();
        })
        .then(data => {
          if (data.error) throw new Error(data.error);
          pintarJugaCuatro('num12', data['12:00']);
          pintarJugaCuatro('num15', data['15:00']);
          pintarJugaCuatro('num18', data['18:00']);
          pintarJugaCuatro('num21', data['21:00']);
        })
        .catch(err => console.error('Error al obtener resultados Juga Cuatro:', err));
    }

    fetch('/api/resultado-juga-cuatro.php')
      .then(res => res.json())
      .then(data => {
        if (data.error) throw new Error(data.error);
        document.getElementById('ultimo1').innerText = data.par1 ?? '--';
        document.getElementById('ultimo2').innerText = data.par2 ?? '--';
        document.getElementById('ultimo3').innerText = data.par3 ?? '--';
        document.getElementById('ultimo4').innerText = data.par4 ?? '--';
      })
      .catch(err => console.error('Error al obtener ultimo resultado Juga Cuatro:', err));
  </script>

  <!-- CONTADOR -->
  <script>
    const second = 1000,
          minute = second * 60,
          hour   = minute * 60,
          day    = hour * 24;

    let hoy = new Date();
    let dia = hoy.getDate();
    let horaActual = hoy.getHours();
    let HoraSorteo = "";

    if (horaActual < 12) {
      HoraSorteo = 12;
    } else if (horaActual < 15) {
      HoraSorteo = 15;
    } else if (horaActual < 18) {
      HoraSorteo = 18;
    } else if (horaActual < 21) {
      HoraSorteo = 21;
    } else {
      HoraSorteo = 12;
      dia += 1;
    }

    let countDown = new Date(
      hoy.getFullYear(), hoy.getMonth(), dia, HoraSorteo
    ).getTime();

    Number.prototype.padStart = function(n, str){
      return Array(n - String(this).length + 1).join(str || '0') + this;
    };

    let x = setInterval(function () {
      let now = new Date().getTime();
      let distance = countDown - now;

      document.getElementById("horaHeader").innerText = Math.floor((distance % day)  / hour).padStart(2,"0");
      document.getElementById("minHeader").innerText  = Math.floor((distance % hour) / minute).padStart(2,"0");
      document.getElementById("segHeader").innerText  = Math.floor((distance % minute) / second).padStart(2,"0");

      if (distance <= 0) {
        clearInterval(x);
        document.querySelector(".etiqueta-hola").innerText = "¡SORTEO EN VIVO!";
      }
    }, second);
  </script>

  <!-- CALENDARIO -->
  <script>
    function pad2(num) {
      return num.toString().padStart(2, '0');
    }

    document.addEventListener('DOMContentLoaded', function () {
      const mesSelect  = document.getElementById('filtro-mes');
      const anoSelect  = document.getElementById('filtro-ano');
      const calendario = document.querySelector('.calendario-real table tbody');

      function renderizarCalendario(mes, ano) {
        const primerDia   = new Date(ano, mes - 1, 1);
        const ultimoDia   = new Date(ano, mes, 0);
        const diaInicio   = primerDia.getDay();
        const cantidadDias = ultimoDia.getDate();

        calendario.innerHTML = '';

        const hoy    = new Date();
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

          if (dia === diaHoy && mesHoy === mes && anoHoy === ano) {
            celda.classList.add('activo');
          }

          celda.addEventListener('click', function () {
            calendario.querySelectorAll('td.activo').forEach(a => a.classList.remove('activo'));
            celda.classList.add('activo');
            actualizarResultadosJugaCuatro(`${ano}-${pad2(mes)}-${pad2(dia)}`);
          });

          fila.appendChild(celda);

          if ((dia + diaInicio) % 7 === 0) {
            calendario.appendChild(fila);
            fila = document.createElement('tr');
          }
        }

        if (fila.children.length > 0) calendario.appendChild(fila);
      }

      mesSelect.addEventListener('change', function () {
        renderizarCalendario(parseInt(mesSelect.value), parseInt(anoSelect.value));
      });

      anoSelect.addEventListener('change', function () {
        renderizarCalendario(parseInt(mesSelect.value), parseInt(anoSelect.value));
      });

      const hoy = new Date();
      anoSelect.value = hoy.getFullYear();
      mesSelect.value = pad2(hoy.getMonth() + 1);
      renderizarCalendario(hoy.getMonth() + 1, hoy.getFullYear());
      actualizarResultadosJugaCuatro(`${hoy.getFullYear()}-${pad2(hoy.getMonth() + 1)}-${pad2(hoy.getDate())}`);
    });
  </script>

</body>
</html>


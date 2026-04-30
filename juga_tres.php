<?php
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

$stmt = $conn->query("SELECT * from paginaweb_nic_juga_tres WHERE id = 1");
$config = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Juga Tres</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Helvetica+Rounded:wght@400;700;900&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Helvetica Rounded', Arial, sans-serif;
    }

    body {
      background:#fff;
    }

    /* ================= HEADER ================= */
    .top {
      background: #00abe4;
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
      background: yellow;
      color: #0075bf;
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
      background: #00abe4;
      padding: 16px;
      flex-wrap: wrap;
    }

    .menu a { /* juega aquí y conocé más botones */
      background: linear-gradient(135deg, #ffffff, #c5eefe);
      color: #0075bf;
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
      margin-right: 70px;
    }

    .menu a:last-child {
      margin-left: 70px;
    }

    /* ================= RESULTADOS ================= */
    .resultados {
      border: 1px solid #0075bf;
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
      color: #0075bf;
      margin: 0;
      line-height: 1.1;
    }

    .label-fecha {
      font-size: 18px;
      font-weight: 700;
      background: yellow;
      color: #0075bf;
      padding: 8px 16px;
      border-radius: 20px;
      display: inline-block;
      margin-left: 35px;
    }

    /* ================= CALENDARIO ================= */
    .calendario-real {
      background: linear-gradient(145deg, #ffffff, #f4f4f4);
      border-radius: 16px;
      padding: 12px 14px;
      box-shadow: 0 8px 18px rgba(0,0,0,0.15);
      border: 1px solid #e5e5e5;
      max-width: 260px;
      margin: auto;
    }

    .calendario-real table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
    }

    .calendario-real th {
      font-size: 12px;
      font-weight: 800;
      color: #0075bf;
      padding: 6px 0;
      text-transform: uppercase;
    }

    .calendario-real td {
      padding: 7px 0;
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
      background: linear-gradient(135deg, #00abe4, #0075bf);
      color: white;
      border-radius: 50%;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }

    /* ================= FILTROS ================= */
    .filtros {
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
      color: #0075bf;
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
      color: #0075bf;
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
      border: 2px solid #0075bf;
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
      background: #00abe4;
      transition: background 0.3s;
    }

    .accordion-header:hover {
      background: #0075bf;
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
  </style>
</head>

<body>

  <!-- HEADER IMAGEN DEL LOGO -->
  <div class="top">
    <div class="top-content"> 
      <img src="/ImagesSV/logo-30-JUGA TRES.png" alt="Logo Juga Tres">

      <div class="ganador-box">
        <div class="ganador">ÚLTIMA FECHA GANADORA</div>

        <div class="nums">
<span class="num-numero" id="numNumero">--</span>
<span class="num-numero" id="numNumero">--</span>
<span class="num-numero" id="numNumero">--</span>
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
    <a href="https://juega.loto.sv/websales/">JUGÁ AQUÍ</a>
    <a href="/ImagesSV/documentos/Reglamento Juga Tres.pdf" download>CONOCÉ MÁS</a>
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

      </div>

      <div class="sorteo">
        <h3>SORTEO 3:00 P.M.</h3>
<span class="num-numero" id="num12_1">--</span>
<span class="num-numero" id="num12_2">--</span>
<span class="num-numero" id="num12_3">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 6:00 P.M.</h3>
<span class="num-numero" id="num12_1">--</span>
<span class="num-numero" id="num12_2">--</span>
<span class="num-numero" id="num12_3">--</span>
      </div>

      <div class="sorteo">
        <h3>SORTEO 9:00 P.M.</h3>
<span class="num-numero" id="num12_1">--</span>
<span class="num-numero" id="num12_2">--</span>
<span class="num-numero" id="num12_3">--</span>
      </div>
    </div>

  </div>

  <!-- ACORDEONES -->
  <div class="accordion">
    <div class="accordion-header open" onclick="toggleAcordeon(this)">
      <?= htmlspecialchars($config['titulo1'] ?? 'CÓMO JUGAR') ?>
      <span class="arrow-circle">▼</span>
    </div>
    <div class="accordion-content" style="display:block;">
      <?= nl2br(htmlspecialchars($config['contenido1'] ?? '')) ?>
    </div>
  </div>

  <div class="accordion">
    <div class="accordion-header" onclick="toggleAcordeon(this)">
      <?= htmlspecialchars($config['titulo2'] ?? 'CONOZCA LOS RESULTADOS') ?>
      <span class="arrow-circle">▼</span>
    </div>
    <div class="accordion-content">
      <?= nl2br(htmlspecialchars($config['contenido2'] ?? '')) ?>
    </div>
  </div>

  <div class="accordion">
    <div class="accordion-header" onclick="toggleAcordeon(this)">
      <?= htmlspecialchars($config['titulo3'] ?? 'RECLAME SU PREMIO') ?>
      <span class="arrow-circle">▼</span>
    </div>
    <div class="accordion-content">
      <?= nl2br(htmlspecialchars($config['contenido3'] ?? '')) ?>
    </div>
  </div>

  <!-- BOTÓN REGLAMENTO -->
  <div class="reglamento">
    <a href="/ImagesSV/documentos/Reglamento Juga Tres.pdf" target="_blank">
      <button>LEER EL REGLAMENTO</button>
    </a>
  </div>

  <script>
    function toggleAcordeon(header) {
      const content = header.nextElementSibling;
      const isOpen = content.style.display === 'block';
      content.style.display = isOpen ? 'none' : 'block';
      header.classList.toggle('open', !isOpen);
    }
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
            // actualizarResultados(`${ano}-${pad2(mes)}-${pad2(dia)}`);
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
    });
  </script>

</body>
</html>

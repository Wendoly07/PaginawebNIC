<?php
// Mostrar errores en pantalla para facilitar la depuración durante el desarrollo.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Establecer conexión PDO con SQL Server.
try {
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Cargar la configuración de contenido de la página desde la tabla correspondiente.
    $stmt = $conn->query("SELECT * FROM paginaweb_sv_superpremio WHERE id = 1");
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Super Premio</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

* { margin:0; padding:0; box-sizing:border-box; font-family:'Helvetica Rounded', Arial, sans-serif; }
body { background:#fff; font-weight:600; }
/* HEADER */
/* Estilos para la sección superior de la página con logo y último número ganador. */
.top { background:#e53935; display:flex; justify-content:center; padding:25px 10px; }
.top-content { display:flex; align-items:center; max-width:1300px; width:100%; position:relative; }
.top img { width:400px; height:auto; margin-top:20px; margin-left:80px; }
.ganador-box { text-align:center; color:white; margin-top:10px; margin-left:160px; }
.ganador { font-weight:900; font-size:26px; margin-bottom:15px; }
.nums { margin-bottom:10px; }
.num { width:65px; height:65px; line-height:65px; display:inline-block; background:#b71c1c; border-radius:50%; font-weight:bold; font-size:24px; color:white; margin:0 4px; border:2px solid white; text-align:center; }
.etiqueta-hola { background:yellow; color:#b71c1c; padding:6px 14px; border-radius:20px; font-weight:900; font-size:18px; }
/* MENÚ */
/* Estilos para el menú de navegación con enlaces. */
.menu { display:flex; justify-content:center; gap:18px; background:#e53935; padding:16px; flex-wrap:wrap; }
.menu a { background:white; color:#b71c1c; text-decoration:none; padding:10px 22px; border-radius:30px; font-size:14px; font-weight:bold; transition:0.3s; box-shadow:0 4px 10px rgba(0,0,0,.25); }
.menu a:hover { background:#f8f8f8; transform:translateY(-3px); box-shadow:0 6px 14px rgba(0,0,0,.3); }
/* RESULTADOS */
/* Estilos para la sección de resultados anteriores con calendario y sorteos. */
.resultados { border:1px solid #b71c1c; display:flex; max-width:1100px; margin:40px auto; background:white; border-radius:20px; box-shadow:0 5px 15px rgba(0,0,0,0.15); padding:25px; gap:20px; }
.resultados .col { flex:1; text-align:center; }
.izquierda { display:flex; flex-direction:column; justify-content:center; align-items:flex-start; gap:15px; min-height:100%; }
.izquierda h2 { font-size:42px; font-weight:900; color:#b71c1c; margin:0; line-height:1.1; }
.label-fecha { font-size:18px; font-weight:700; background:yellow; color:#b71c1c; padding:8px 16px; border-radius:20px; display:inline-block; margin-left:35px; }
/* FILTROS */
/* Estilos para los filtros de mes y año del calendario. */
.filtros-calendario { display:flex; justify-content:center; gap:15px; margin-bottom:15px; }
.filtros-calendario select { padding:6px 10px; font-weight:700; border-radius:8px; border:1px solid #b71c1c; }
/* CALENDARIO */
/* Estilos para el calendario interactivo. */
.calendario-real { background:linear-gradient(145deg, #ffffff, #f4f4f4); border-radius:16px; padding:12px 14px; box-shadow:0 8px 18px rgba(0,0,0,0.15); border:1px solid #e5e5e5; max-width:260px; margin:auto; }
.calendario-real table { width:100%; border-collapse:collapse; text-align:center; }
.calendario-real th { font-size:12px; font-weight:800; color:#b71c1c; padding:6px 0; text-transform:uppercase; }
.calendario-real td { padding:7px 0; font-weight:700; font-size:13px; color:#444; cursor:pointer; transition:0.25s; border-radius:50%; }
.calendario-real td:hover { background:rgba(183,28,28,0.15); }
.calendario-real td.activo { background:linear-gradient(135deg, #b71c1c, #e53935); color:white; box-shadow:0 4px 10px rgba(0,0,0,0.25); }
/* SORTEOS */
/* Estilos para mostrar los números de los sorteos. */
.derecha { display:flex; flex-direction:column; justify-content:center; align-items:center; }
.derecha .sorteo { margin-bottom:20px; text-align:center; }
.derecha h3 { font-size:20px; font-weight:900; color:#b71c1c; margin-bottom:12px; text-align:center; letter-spacing:0.5px; }
.derecha .nums { display:flex; justify-content:center; gap:4px; flex-wrap:nowrap; }
.derecha .num { width:40px; height:40px; line-height:40px; font-size:16px; margin:0 2px; }
/* ACCORDION */
/* Estilos para los elementos de acordeón expandibles. */
.accordion { max-width:1100px; margin:30px auto; border-radius:15px; overflow:hidden; background:white; border:2px solid #b71c1c; }
.accordion-header { padding:18px; text-align:center; color:white; font-weight:bold; font-size:24px; cursor:pointer; position:relative; background:#b71c1c; }
.accordion-header .arrow { position:absolute; right:20px; font-size:26px; }
.accordion-content { display:none; padding:20px; background:white; }
.sub-accordion-header { background:#b71c1c; color:white; padding:14px 20px; margin-bottom:10px; border-radius:12px; display:flex; justify-content:space-between; align-items:center; cursor:pointer; font-weight:600; font-size:20px; }
.sub-accordion-header span { display:flex; justify-content:center; align-items:center; width:32px; height:32px; border-radius:50%; background:#f28b82; color:white; font-size:18px; flex-shrink:0; transition:transform 0.3s; }
.sub-accordion-header.active span { transform:rotate(180deg); }
.sub-accordion-content { display:none; padding:15px 20px; background:white; border-radius:0 0 12px 12px; margin-bottom:12px; font-size:16px; font-weight:600; line-height:1.5; color:#333; }
.info-juego { margin-bottom:30px; padding:20px; background:#ffffff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.08); }
.slogan { text-align:center; font-size:22px; font-weight:700; color:#b71c1c; margin-bottom:12px; line-height:1.4; }
.descripcion { text-align:center; font-size:17px; font-weight:600; color:#333; margin-bottom:20px; line-height:1.5; }
.subtitulo-rojo { text-align:center; font-size:20px; font-weight:700; color:#b71c1c; margin-bottom:15px; }
.linea-juego { display:flex; align-items:flex-start; gap:16px; margin-top:15px; font-size:16px; font-weight:600; color:#333; line-height:1.5; }
.img-super { width:75px; height:auto; flex-shrink:0; border-radius:6px; }
.reglamento { text-align:center; margin:40px 0; }
.reglamento button { background:#b71c1c; color:white; padding:14px 30px; border-radius:30px; border:none; font-weight:bold; font-size:16px; cursor:pointer; transition:0.3s; }
.reglamento button:hover { background:white; color:#b71c1c; border:2px solid #b71c1c; }
/* =========================
   FIX SUPER PREMIO - MÓVIL
   ========================= */
@media (max-width: 768px) {

  /* HEADER */
  .top {
    padding: 20px 10px;
  }

  .top-content {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .top img {
    width: 220px;       /* logo más pequeño */
    margin: 0 0 15px 0; /* centrado */
  }

  .ganador-box {
    margin: 0;
  }

  .ganador {
    font-size: 20px;
  }

  .num {
    width: 48px;
    height: 48px;
    line-height: 48px;
    font-size: 18px;
  }

  .etiqueta-hola {
    font-size: 14px;
    margin-top: 10px;
  }

  /* MENÚ */
  .menu {
    gap: 10px;
    padding: 12px;
  }

  .menu a {
    font-size: 13px;
    padding: 8px 18px;
  }

  /* RESULTADOS */
  .resultados {
    flex-direction: column;
    padding: 20px 15px;
    gap: 25px;
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
    font-size: 15px;
  }

  .derecha .nums {
    flex-wrap: wrap;
  }
}

/* FIX LOGO SUPER PREMIO EN MÓVIL */
@media (max-width: 768px) {
  .logo-sp {
    display: block;
    width: 220px;
    max-width: 90%;
    height: auto;
    margin: 0 auto 15px auto; /* CENTRADO */
  }
}

/* =========================
   AJUSTE HEADER MÓVIL
   ========================= */
@media (max-width: 768px) {

  /* Empuja todo el contenido del header hacia abajo para que no se tape */
  .top-content {
      margin-top: 250px; /* Ajusta este valor según lo que necesites */
  }

}

</style>
</head>
<body>

<!-- HEADER -->
<!-- Sección superior con logo, último número ganador y countdown al próximo sorteo. -->
<div class="top">
    <div class="top-content">
        <img src="<?= $datos['logo'] ?>" class="logo-sp">

        <div class="ganador-box">
            <div class="ganador">ÚLTIMO NÚMERO GANADOR</div>
            <div class="nums" id="ultimoResultado">
                <span class="num">00</span>
                <span class="num">00</span>
                <span class="num">00</span>
                <span class="num">00</span>
                <span class="num">00</span>
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
<!-- Barra de navegación con enlaces a jugar. -->
<div class="menu">
    <a href="https://juega.loto.com.ni/websales/" target="_blank">JUGÁ AQUÍ</a>
    
</div>

<!-- RESULTADOS -->
<!-- Sección que muestra resultados anteriores con calendario interactivo y sorteos. -->
<div class="resultados">
    <div class="col izquierda">
        <h2>RESULTADOS ANTERIORES</h2>
        <div class="label-fecha">SELECCIONÁ LA FECHA</div>
    </div>
    <div class="col calendario">
        <div class="filtros-calendario">
            <select id="mesFiltro">
                <option value="0">Enero</option><option value="1">Febrero</option><option value="2">Marzo</option><option value="3">Abril</option>
                <option value="4">Mayo</option><option value="5">Junio</option><option value="6">Julio</option><option value="7">Agosto</option>
                <option value="8">Septiembre</option><option value="9">Octubre</option><option value="10">Noviembre</option><option value="11">Diciembre</option>
            </select>
            <select id="anioFiltro">
                <option>2025</option>
                <option>2026</option>
            </select>
        </div>
        <div class="calendario-real">
            <table>
                <thead><tr><th>DOM</th><th>LUN</th><th>MAR</th><th>MIE</th><th>JUE</th><th>VIE</th><th>SAB</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="col derecha">
        <div class="sorteo">
            <h3>SORTEO 9:00 P.M.</h3>
            <div class="nums" id="ultimoResultadoInferior">
                <span class="num">00</span><span class="num">00</span><span class="num">00</span><span class="num">00</span><span class="num">00</span>
            </div>
        </div>
    </div>
</div>

<!-- ACCORDION -->
<!-- Sección de acordeón con información del juego Super Premio. -->
<div class="accordion">
    <div class="sub-accordion-header">
    <?= htmlspecialchars($datos['titulo1']) ?>
    <span>▼</span>
</div>

<div class="sub-accordion-content">
    <div class="linea-juego">
        <img src="/ImagesSV/SP.svg" class="img-super">

        <p>
            <?= nl2br(htmlspecialchars($datos['contenido1'])) ?>
        </p>
    </div>
</div>

<div class="sub-accordion-header">Es
    <?= htmlspecialchars($datos['titulo2']) ?>
    <span>▼</span>
</div>
<div class="sub-accordion-content">
    <?= nl2br(htmlspecialchars($datos['contenido2'])) ?>
</div>

<div class="sub-accordion-header">
    <?= htmlspecialchars($datos['titulo3']) ?>
    <span>▼</span>
</div>
<div class="sub-accordion-content">
    <?= nl2br(htmlspecialchars($datos['contenido3'])) ?>
</div>
</div>

<!-- BOTÓN REGLAMENTO -->
<!-- Enlace para descargar el reglamento del juego. -->
<div class="reglamento">
    <a href="/ImagesSV/documentos/Reglamento-SuperPremio Loto-SV 1.pdf" download>
        <button>DESCARGAR REGLAMENTO</button>
    </a>
</div>

<script>
// Accordion principal
// Maneja la expansión del acordeón principal.
document.querySelectorAll('.accordion-header').forEach(h => h.addEventListener('click', () => {
    const c = h.nextElementSibling;
    document.querySelectorAll('.accordion-content').forEach(cc => { if(cc!==c) cc.style.display='none'; });
    c.style.display = c.style.display==='block'?'none':'block';
}));

// Sub-accordion
// Maneja la expansión de los sub-acordeones.
document.querySelectorAll('.sub-accordion-header').forEach(h => h.addEventListener('click', () => {
    h.classList.toggle('active');
    const c = h.nextElementSibling;
    c.style.display = c.style.display==='block'?'none':'block';
}));

// Countdown
// Calcula y muestra el tiempo restante hasta el próximo sorteo.
const second=1000, minute=second*60, hour=minute*60, day=hour*24;
let now=new Date(), dia=now.getDate(), hora=now.getHours(), HoraSorteo=hora<21?21:21;
if(hora>=21) dia+=1;
let countDown=new Date(now.getFullYear(), now.getMonth(), dia, HoraSorteo).getTime();
Number.prototype.padStart=function(n,str){return Array(n-String(this).length+1).join(str||'0')+this;}
setInterval(()=>{let now2=new Date().getTime(), dist=countDown-now2,h=Math.floor((dist%day)/hour).padStart(2,"0"), m=Math.floor((dist%hour)/minute).padStart(2,"0"), s=Math.floor((dist%minute)/second).padStart(2,"0"); document.getElementById("horaHeader").innerText=h; document.getElementById("minHeader").innerText=m; document.getElementById("segHeader").innerText=s; if(dist<=0){document.querySelector(".etiqueta-hola").innerText="¡SORTEO EN VIVO!";}}, second);

// Función para traer resultados
// Obtiene los resultados de una fecha específica desde la API.
function traerResultado(fecha){
    fetch(`/api/resultados_calendario.php?fecha=${fecha}`)
    .then(res=>res.json())
    .then(data=>{
        if(!data.error){
            document.getElementById('ultimoResultadoInferior').innerHTML=`
                <span class="num">${data.par1}</span>
                <span class="num">${data.par2}</span>
                <span class="num">${data.par3}</span>
                <span class="num">${data.par4}</span>
                <span class="num">${data.par5}</span>`;
        }
    }).catch(err=>console.error(err));
}

// Calendario
// Configura los filtros de mes y año para el calendario.
const mesFiltro=document.getElementById('mesFiltro'), anioFiltro=document.getElementById('anioFiltro');
const fechaHoy=new Date(), mesActual=fechaHoy.getMonth(), anioActual=fechaHoy.getFullYear();
mesFiltro.value=mesActual; for(let i=0;i<anioFiltro.options.length;i++){ if(parseInt(anioFiltro.options[i].text)===anioActual){ anioFiltro.selectedIndex=i; break; } }

// Generar calendario
// Crea dinámicamente la tabla del calendario para el mes y año seleccionados.
function generarCalendario(mes, anio){
    const tabla = document.querySelector('.calendario-real tbody');
    tabla.innerHTML = '';

    const primerDia = new Date(anio, mes, 1).getDay();
    const diasMes = new Date(anio, mes + 1, 0).getDate();

    let diaActual = 1;
    let fila = document.createElement('tr');

    // Celdas vacías antes del primer día
    for(let i = 0; i < primerDia; i++) {
        fila.appendChild(document.createElement('td'));
    }

    while(diaActual <= diasMes){
        if(fila.children.length === 7){
            tabla.appendChild(fila);
            fila = document.createElement('tr');
        }

        let celda = document.createElement('td');
        celda.textContent = diaActual;

        // Captura el día actual en una variable local para el click
        const diaParaClick = diaActual;

        // Marca el día actual
        if(diaParaClick === fechaHoy.getDate() && mes === fechaHoy.getMonth() && anio === fechaHoy.getFullYear()){
            celda.classList.add('activo');
            traerResultado(`${anio}-${String(mes+1).padStart(2,'0')}-${String(diaParaClick).padStart(2,'0')}`);
        }

        celda.addEventListener('click', () => {
            document.querySelectorAll('.calendario-real td').forEach(td => td.classList.remove('activo'));
            celda.classList.add('activo');
            const fecha = `${anio}-${String(mes+1).padStart(2,'0')}-${String(diaParaClick).padStart(2,'0')}`;
            traerResultado(fecha);
        });

        fila.appendChild(celda);
        diaActual++;
    }

    // Agrega la última fila
    if(fila.children.length > 0){
        tabla.appendChild(fila);
    }
}

// Inicializar calendario con fecha actual
generarCalendario(mesActual, anioActual);

// Actualizar calendario cuando cambien filtros
mesFiltro.addEventListener('change', () => generarCalendario(parseInt(mesFiltro.value), parseInt(anioFiltro.value)));
anioFiltro.addEventListener('change', () => generarCalendario(parseInt(mesFiltro.value), parseInt(anioFiltro.value)));

// Traer resultado inicial del día actual
traerResultado(`${anioActual}-${String(mesActual+1).padStart(2,'0')}-${String(fechaHoy.getDate()).padStart(2,'0')}`);


// Traer último resultado en vivo
// Carga el último resultado disponible desde la API.
function cargarUltimoResultado() {
    fetch('/api/ultimo_resultado.php')  // tu endpoint que funciona para el último resultado
    .then(res => res.json())
    .then(data => {
        if(!data.error){
            document.getElementById('ultimoResultado').innerHTML = `
                <span class="num">${data.par1}</span>
                <span class="num">${data.par2}</span>
                <span class="num">${data.par3}</span>
                <span class="num">${data.par4}</span>
                <span class="num">${data.par5}</span>`;
        }
    })
    .catch(err => console.error(err));
}

// Traer resultado filtrado por calendario
// Obtiene resultados para una fecha específica y actualiza la interfaz.
function traerResultado(fecha){
    fetch(`/api/resultados_calendario.php?fecha=${fecha}`)
    .then(res=>res.json())
    .then(data=>{
        if(!data.error){
            document.getElementById('ultimoResultadoInferior').innerHTML=`
                <span class="num">${data.par1}</span>
                <span class="num">${data.par2}</span>
                <span class="num">${data.par3}</span>
                <span class="num">${data.par4}</span>
                <span class="num">${data.par5}</span>`;
        } else {
            document.getElementById('ultimoResultadoInferior').innerHTML=`
                <span class="num">00</span><span class="num">00</span><span class="num">00</span><span class="num">00</span><span class="num">00</span>`;
        }
    }).catch(err=>console.error(err));
}
// Al cargar la página
cargarUltimoResultado();

</script>

</body>
</html>


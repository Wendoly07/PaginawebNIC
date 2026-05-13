<?php
// ==========================
// CONFIGURACION DE BD
// ==========================
try {
    $conn = new PDO(
        "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
        "LotoAdmin",
        "LotAdmin1.",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}

// ==========================
// OBTENER PROMOCION PRINCIPAL
// ==========================
$stmt = $conn->query("
    SELECT TOP 1 *
    FROM paginaweb_nic_promociones
    WHERE es_principal = 1
    ORDER BY id DESC
");
$principal = $stmt->fetch(PDO::FETCH_ASSOC);

// ==========================
// OBTENER PROMOCIONES SECUNDARIAS (TOP 8)
// ==========================
$stmt = $conn->query("
    SELECT TOP 8 *
    FROM paginaweb_nic_promociones
    WHERE es_principal = 0
    ORDER BY id DESC
");
$promociones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Promociones</title>

<style>
@font-face {
  font-family:'HelveticaRounded';
  src: url('fonts/HelveticaRoundedLTStd-Bd.ttf') format('truetype');
}
*{ font-family:'HelveticaRounded',sans-serif; margin:0; padding:0; box-sizing:border-box; }
body{ font-family:'HelveticaRounded', sans-serif; background:#f4f4f4; }

.container-general{ width:90%; max-width:1200px; margin:auto; }

.titulo-noticias{
  background:#a6d1f8;
  padding:80px 40px 45px;
  border-radius:0 0 14px 14px;
  text-align:center;
  margin:0 -2cm 70px;
}
.titulo-noticias h1{
  color:#fff;
  font-size:45px;
  font-weight:900;
  letter-spacing:2px;
}

.noticia-principal-container{
  display:grid;
  grid-template-columns:minmax(0, 1.45fr) minmax(300px, .9fr);
  gap:26px;
  align-items:center;
  margin-bottom:90px;
  width:100%;
  min-height:0;
}

.noticia-principal-container img{
  width:100%;
  border-radius:16px;
  object-fit:contain;
  background:#fff;
  aspect-ratio:1 / 1;
  height:auto;
  box-shadow:0 16px 35px rgba(0,0,0,0.12);
}

.noticia-principal-contenido{
  position:relative;
  overflow:hidden;
  width:100%;
  background:
    radial-gradient(circle at 88% 12%, rgba(255,255,255,0.9) 0 58px, transparent 60px),
    linear-gradient(145deg, #fff8f0 0%, #fff 52%, #eef6ff 100%);
  padding:34px 30px;
  border-radius:16px;
  box-shadow:0 16px 35px rgba(0,0,0,0.12);
  display:flex;
  flex-direction:column;
  justify-content:center;
  min-height:300px;
  border:1px solid rgba(255,102,0,0.12);
}

.noticia-principal-contenido::before{
  content:"";
  position:absolute;
  inset:18px 18px auto auto;
  width:120px;
  height:120px;
  border-radius:50%;
  background:rgba(255,102,0,0.1);
}

.noticia-principal-contenido::after{
  content:"";
  position:absolute;
  right:-42px;
  bottom:-42px;
  width:150px;
  height:150px;
  border-radius:50%;
  background:rgba(26,115,232,0.1);
}

.noticia-principal-contenido > *{
  position:relative;
  z-index:1;
}

.noticia-principal-contenido .fecha{
  font-size:15px;
  font-weight:700;
  color:#2d3a4a;
  letter-spacing:.4px;
  text-transform:uppercase;
}
.noticia-principal-contenido h2{
  color:#ff6600;
  font-size:clamp(26px, 3vw, 38px);
  margin:14px 0 22px;
  font-weight:900;
  line-height:1.08;
}

.grid-noticias-wrapper{
  background:linear-gradient(180deg, #fff 0%, #f7fbff 100%);
  padding:34px 24px 38px;
  border-radius:16px;
  box-shadow:0 6px 18px rgba(0,0,0,0.12);
  border:1px solid rgba(26,115,232,0.08);
}
.promociones-secundarias-titulo{
  color:#1a73e8;
  font-size:26px;
  font-weight:900;
  margin:0 0 22px;
  line-height:1.1;
}
.promociones-secundarias-titulo span{
  color:#ff6600;
}
.grid-noticias{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:22px;
}

.card-noticia{
  position:relative;
  background:linear-gradient(180deg, #fff 0%, #fff 58%, #f4f9ff 100%);
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 8px 22px rgba(0,0,0,0.1);
  display:flex;
  flex-direction:column;
  min-height:100%;
  border:1px solid rgba(26,115,232,0.1);
  transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}
.card-noticia::before{
  content:"";
  position:absolute;
  top:14px;
  right:14px;
  width:82px;
  height:82px;
  border-radius:50%;
  background:rgba(255,102,0,0.1);
  pointer-events:none;
}
.card-noticia::after{
  content:"";
  position:absolute;
  right:-26px;
  bottom:-26px;
  width:96px;
  height:96px;
  border-radius:50%;
  background:rgba(26,115,232,0.1);
  pointer-events:none;
}
.card-noticia > *{
  position:relative;
  z-index:1;
}
.card-noticia:hover{
  transform: translateY(-6px);
  box-shadow: 0 16px 32px rgba(0,0,0,0.16);
  border-color:rgba(255,102,0,0.24);
}
.card-noticia img{
  width:100%;
  height:210px;
  object-fit:contain;
  background:linear-gradient(145deg, #fff8f0 0%, #fff 58%, #eef6ff 100%);
  border-radius:14px 14px 0 0;
  padding:10px;
  border-bottom:1px solid rgba(26,115,232,0.08);
}
.card-noticia .fecha{
  font-size:12px;
  color:#2d3a4a;
  padding:14px 14px 0;
  font-weight:700;
  letter-spacing:.3px;
  text-transform:uppercase;
}
.card-noticia h3{
  font-size:15.5px;
  color:#ff6600;
  margin:6px 14px 0;
  font-weight:900;
  line-height:1.28;
  min-height:58px;
}

.acciones-noticia{
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  gap:8px;
  margin-top:14px;
}

.card-noticia .acciones-noticia{
  margin:auto 14px 16px;
  padding-top:16px;
}

.noticia-principal-contenido .acciones-noticia{
  flex-direction:row;
  justify-content:flex-start;
  align-items:center;
  width:100%;
  margin-top:0;
}

.btn-noticia-completa{
  display:inline-block;
  position:relative;
  overflow:hidden;
  padding:9px 18px;
  font-size:13px;
  font-weight:700;
  background:linear-gradient(135deg, #1a73e8 0%, #0057d9 100%);
  color:#fff;
  border-radius:18px;
  text-decoration:none;
  box-shadow:0 8px 18px rgba(26,115,232,0.28);
  transition:transform .2s ease, box-shadow .2s ease, background .2s ease;
}

.btn-noticia-completa::before{
  content:"";
  position:absolute;
  top:0;
  left:-80%;
  width:55%;
  height:100%;
  background:linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent);
  transform:skewX(-22deg);
  transition:left .45s ease;
}

.card-noticia .btn-noticia-completa{
  padding:7px 14px;
  font-size:12px;
  border-radius:14px;
}

.btn-noticia-completa:hover{
  background:linear-gradient(135deg, #ff6600 0%, #f04d00 100%);
  box-shadow:0 12px 24px rgba(255,102,0,0.34);
  transform:translateY(-2px);
}

.btn-noticia-completa:hover::before{
  left:125%;
}

@media(max-width:1024px){ .grid-noticias{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){
  .grid-noticias{ grid-template-columns:1fr; }
  .noticia-principal-contenido{ margin:-40px 10px 0; }
}
@media(max-width:768px){
  .noticia-principal-container{
    grid-template-columns:1fr;
    gap:0;
  }
  .noticia-principal-container img{ width:100%; }
  .noticia-principal-contenido{
    position:static;
    margin-top:-50px;
    width:auto;
    max-width:100%;
    min-height:auto;
    padding:28px 24px;
  }
}
</style>
</head>
<body>

<div class="container-general">

<section class="titulo-noticias">
  <h1>PROMOCIONES</h1>
</section>

<?php if ($principal): ?>
<section class="noticia-principal-container">
  <img src="<?= htmlspecialchars($principal['imagen_url']) ?>" alt="<?= htmlspecialchars($principal['titulo']) ?>">
  <div class="noticia-principal-contenido">
    <p class="fecha"><?= htmlspecialchars($principal['fecha']) ?></p>
    <h2><?= htmlspecialchars($principal['titulo']) ?></h2>
    <div class="acciones-noticia">
      <a href="index.php?pag=promociones_detallado&id=<?= urlencode($principal['id']) ?>" class="btn-noticia-completa">Promoción completa</a>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="grid-noticias-wrapper">
  <h2 class="promociones-secundarias-titulo">Más <span>promociones</span></h2>
  <div class="grid-noticias">
  <?php foreach($promociones as $n): ?>
    <article class="card-noticia">
      <img src="<?= htmlspecialchars($n['imagen_url']) ?>" alt="<?= htmlspecialchars($n['titulo']) ?>">
      <p class="fecha"><?= htmlspecialchars($n['fecha']) ?></p>
      <h3><?= htmlspecialchars($n['titulo']) ?></h3>
      <div class="acciones-noticia">
        <a href="index.php?pag=promociones_detallado&id=<?= urlencode($n['id']) ?>" class="btn-noticia-completa">Promoción completa</a>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</section>

</div>
<br>
<br>

</body>
</html>

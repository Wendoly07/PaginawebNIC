<?php
$rseRows = [];
$rseTitulo = 'RSE';
$rseTituloSecundario = 'Responsabilidad Social Empresarial';
$rseContenido = 'Responsabilidad Social Empresarial';
$rseImagenPrincipal = '';
$rseData = [];

try {
    require_once __DIR__ . '/config/connection.php';

    if ($conn) {
        $stmtMain = $conn->prepare("
            SELECT TOP 1 *
            FROM paginaweb_nic_rse
            WHERE activo = 1
            ORDER BY orden ASC, id ASC
        ");
        $stmtMain->execute();
        $rseData = $stmtMain->fetch(PDO::FETCH_ASSOC) ?: [];

        $stmt = $conn->prepare("
            SELECT titulo, titulo_secundario, contenido, imagen_principal_url,
                   imagen_url, imagen_titulo, imagen_descripcion, fecha_creacion
            FROM paginaweb_nic_rse
            WHERE activo = 1
            ORDER BY orden ASC, id ASC
        ");
        $stmt->execute();
        $rseRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
    $rseRows = [];
    $rseData = [];
}

if (!empty($rseData)) {
    $rseTitulo           = $rseData['titulo']               ?? $rseTitulo;
    $rseTituloSecundario = $rseData['titulo_secundario']    ?? $rseTituloSecundario;
    $rseContenido        = $rseData['contenido']            ?? $rseContenido;
    $rseImagenPrincipal  = $rseData['imagen_principal_url'] ?? '';
}

$rseStats = [];
for ($s = 1; $s <= 3; $s++) {
    $num  = trim($rseData["stat{$s}_numero"] ?? '');
    $txt  = trim($rseData["stat{$s}_texto"]  ?? '');
    $icon = trim($rseData["stat{$s}_icono"]  ?? '');
    if ($num !== '' || $txt !== '') {
        $rseStats[] = ['numero' => $num, 'texto' => $txt, 'icono' => $icon];
    }
}

$rseModeloTitulo    = trim($rseData['modelo_titulo']    ?? '');
$rseModeloSubtitulo = trim($rseData['modelo_subtitulo'] ?? '');
$rsePilares = [];
$pilarLabelsDefault = ['Proyección económica', 'Inclusión', 'Apoyo a la Mujer'];
for ($p = 1; $p <= 3; $p++) {
    $pt = trim($rseData["pilar{$p}_titulo"]    ?? '');
    $pc = trim($rseData["pilar{$p}_contenido"] ?? '');
    $pi = trim($rseData["pilar{$p}_icono"]     ?? '');
    $rsePilares[] = [
        'titulo'    => $pt !== '' ? $pt : $pilarLabelsDefault[$p-1],
        'contenido' => $pc,
        'icono'     => $pi,
    ];
}

$rseGaleria = array_values(array_filter($rseRows, function ($row) use ($rseImagenPrincipal) {
    return !empty($row['imagen_url']) && $row['imagen_url'] !== $rseImagenPrincipal;
}));

$rseMeses = [
    1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
    7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'
];

$hayPilares    = array_filter($rsePilares, fn($p) => $p['titulo'] !== '' || $p['contenido'] !== '');
$mostrarModelo = $rseModeloTitulo !== '' || $rseModeloSubtitulo !== '' || !empty($hayPilares);
?>

<style>
/* ─── Tipografía global RSE ────────────────────────────────────────────────── */
.rse-hero,.rse-page,.rse-stats-wrap,.rse-modelo,.rse-video-wrap{
  font-family:'HelveticaRounded',Arial,sans-serif;
}

/* ─── Hero ─────────────────────────────────────────────────────────────────── */
.rse-hero{width:100%;overflow:hidden;}
.rse-hero img{width:100%;height:auto;display:block;}

/* ─── Intro ────────────────────────────────────────────────────────────────── */
.rse-page{
  background:#ffffff;color:#003399;
  padding:64px clamp(22px,5vw,90px) 52px;
}
.rse-layout{
  width:min(1180px,100%);
  margin:0 auto;
  position:relative;
  display:grid;
  grid-template-columns:minmax(320px,0.43fr) minmax(0,1fr);
  gap:clamp(24px,3vw,42px);
  align-items:start;
  padding:0 28px 28px;
  box-shadow:0 18px 42px rgba(0,51,153,0.08);
}
.rse-layout::before{
  content:"";position:absolute;left:0;right:0;top:205px;bottom:0;
  background:#fff3df;border-radius:0 0 18px 18px;z-index:0;
}
.rse-layout>*{position:relative;z-index:1;}
.rse-copy{min-width:0;order:2;}
.rse-text-panel{position:relative;max-width:none;padding:0 0 28px;}
.rse-secondary-title{
  margin:50px 0 0;color:#ff7900;font-size:clamp(28px,3.1vw,44px);
  font-weight:900;line-height:1.3;text-transform:uppercase;
  max-width:760px;
}
.rse-text{
  margin:26px 0 0;color:#004aad;font-size:18px;line-height:1.58;
  font-weight:700;text-align:justify;max-width:780px;
  padding:22px 28px 0 0;
}

/* ─── Galería lateral ───────────────────────────────────────────── */
.rse-gallery{
  position:relative;overflow:hidden;
  background:linear-gradient(180deg,#ffd9b0 0%,#ff7900 100%);
  border-radius:0 90px 12px 12px;min-height:385px;order:1;
}
.rse-slide{display:none;width:100%;}
.rse-slide.active{display:block;}
.rse-slide img{width:100%;height:285px;display:block;object-fit:cover;object-position:center top;background:#ff7900;}
.rse-photo-caption{position:relative;overflow:hidden;background:transparent;min-height:80px;padding:14px 16px 42px;}
.rse-photo-caption h3{margin:0;color:#fff;font-size:15px;font-weight:850;line-height:1.22;}
.rse-photo-caption time{
  display:inline-flex;align-items:center;margin-top:12px;color:#ff7900;
  font-size:13px;font-weight:800;background:#fff8ed;
  border:1px solid rgba(255,255,255,0.65);border-radius:999px;padding:8px 12px;
}
.rse-arrow{
  position:absolute;top:142px;transform:translateY(-50%);
  width:38px;height:38px;border:0;border-radius:50%;
  background:rgba(255,126,0,0.96);color:#fff;font-size:22px;font-weight:900;
  cursor:pointer;display:flex;align-items:center;justify-content:center;
  box-shadow:0 8px 18px rgba(0,0,0,0.25);transition:transform 0.22s,background 0.22s;z-index:2;
}
.rse-arrow:hover{background:#ff5f00;transform:translateY(-50%) scale(1.08);}
.rse-arrow.prev{left:22px;}
.rse-arrow.next{right:22px;}
.rse-dots{position:absolute;right:18px;bottom:18px;display:flex;gap:8px;z-index:3;}
.rse-dot{width:9px;height:9px;border:0;border-radius:50%;background:rgba(0,74,173,0.24);cursor:pointer;padding:0;transition:width 0.2s,background 0.2s;}
.rse-dot.active{width:26px;border-radius:999px;background:#ff7e00;}

/* ─── Estadísticas (fuera del rse-page) ─────────────────────────── */
.rse-stats-wrap{
  background:#fff;
  padding:52px clamp(22px,5vw,90px) 60px;
}
.rse-stats{
  width:min(1180px,100%);margin:0 auto;
  display:grid;grid-template-columns:repeat(3,1fr);gap:18px;
}
.rse-stats-item{
  border:1px solid rgba(0,0,0,0.09);
  border-radius:14px;padding:32px 24px;
  box-shadow:0 6px 20px rgba(0,0,0,0.07);
  display:flex;flex-direction:column;align-items:center;text-align:center;gap:16px;
  padding-top:60px;
  position:relative;
  overflow:visible;
}
.rse-stats-item:nth-child(1){--stat-color:#16a34a;background:rgba(22,163,74,0.08);}
.rse-stats-item:nth-child(2){--stat-color:#db2777;background:rgba(219,39,119,0.08);}
.rse-stats-item:nth-child(3){--stat-color:#2563eb;background:rgba(37,99,235,0.08);}
.rse-stats-icon-wrap{
  width:100px;height:100px;border-radius:50%;
  background:var(--stat-color,#16a34a);border:none;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
  margin:0 auto;
  position:absolute;
  top:-50px;
}
.rse-stats-icon{width:60px;height:60px;object-fit:contain;display:block;filter:brightness(0) invert(1);}
.rse-stats-number{display:block;color:var(--stat-color,#16a34a);font-size:50px;font-weight:900;line-height:1;}
.rse-stats-text{display:block;color:var(--stat-color,#16a34a);font-size:20px;font-weight:700;line-height:1.4;text-align:center;}

/* ─── Modelo Cambia Vidas (100% ancho, fuera del rse-page) ────────────────── */
.rse-modelo{
  width:100%;
  background:transparent;border:none;padding:0;margin:0;
}
.rse-modelo-header{
  text-align:center;
  padding:40px clamp(22px,5vw,90px) 36px;
  background:#fff;width:100%;box-sizing:border-box;
}
.rse-modelo-header h2{
  margin:0;color:#004aad;font-size:clamp(26px,3vw,40px);
  font-weight:900;text-transform:uppercase;letter-spacing:0.5px;
}
.rse-modelo-header p{
  margin:12px auto 0;color:#444;font-size:15px;
  max-width:740px;line-height:1.6;
}
/* Ola transición blanco → azul */
.rse-modelo-ola{display:none;}

.rse-modelo-banda{
  width:100%;
  background:linear-gradient(to bottom,#fff 0 76px,#c8e6f5 76px 100%);
  padding:0 clamp(22px,5vw,90px) 52px;
  box-sizing:border-box;
}
.rse-modelo-inner{width:min(1180px,100%);margin:0 auto;}
.rse-pilares{
  display:grid;grid-template-columns:repeat(3,1fr);gap:20px;
  margin-top:0;
  position:relative;
  z-index:2;
}
.rse-pilar{
  background:#fff;
  border:4px solid var(--pilar-color,#22c55e);
  border-radius:14px;padding:32px 24px 30px;
  box-shadow:0 6px 20px rgba(0,0,0,0.06);
  display:flex;flex-direction:column;align-items:center;text-align:center;gap:16px;
  transition:transform 0.22s,box-shadow 0.22s;
}
.rse-pilar:hover{transform:translateY(-4px);box-shadow:0 14px 32px rgba(0,0,0,0.12);}
.rse-pilar:nth-child(1){--pilar-color:#7c58d2;}
.rse-pilar:nth-child(2){--pilar-color:#ff7e00;}
.rse-pilar:nth-child(3){--pilar-color:#80b620;}
.rse-pilar-icon{width:64px;height:64px;object-fit:contain;display:block;margin:0 auto;}
.rse-pilar h3{margin:0;color:var(--pilar-color,#80b620);font-size:20px;font-weight:900;line-height:1.2;}
.rse-pilar p{margin:0;color:#444;font-size:16px;line-height:1.65;font-weight:500;text-align:justify;}

/* ─── Video (fuera del rse-page) ───────────────────────────────────────────── */
.rse-video-wrap{
  background:#fff;
  padding:60px clamp(22px,5vw,90px) 60px;
}
.rse-video-section{
  position:relative;overflow:hidden;
  width:min(920px,100%);margin:0 auto;
  background:radial-gradient(circle at 88% 12%,rgba(255,255,255,0.9) 0 58px,transparent 60px),
             linear-gradient(145deg,#fff8f0 0%,#fff 52%,#eef6ff 100%);
  border:1px solid rgba(255,126,0,0.12);border-radius:16px;
  padding:34px clamp(18px,3vw,42px) 40px;
  box-shadow:0 16px 35px rgba(0,0,0,0.12);
}
.rse-video-section::before{
  content:"";position:absolute;inset:18px 18px auto auto;
  width:120px;height:120px;border-radius:50%;
  background:rgba(255,126,0,0.18);pointer-events:none;
}
.rse-video-section::after{
  content:"";position:absolute;right:-42px;bottom:-42px;
  width:150px;height:150px;border-radius:50%;
  background:rgba(0,74,173,0.18);pointer-events:none;
}
.rse-video-section>*{position:relative;z-index:1;}
.rse-video-header{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:28px;}
.rse-video-header h2{margin:0;color:#004aad;font-size:clamp(26px,3.2vw,40px);font-weight:850;line-height:1.06;}
.rse-video-header span{color:#ff7e00;font-size:16px;font-weight:900;text-transform:uppercase;white-space:nowrap;}
.rse-youtube-link{
  display:inline-flex;align-items:center;justify-content:center;
  margin-top:22px;color:#fff;background:#ff0000;border-radius:999px;
  padding:12px 22px;font-size:15px;font-weight:900;text-decoration:none;
  box-shadow:0 10px 22px rgba(255,0,0,0.22);transition:transform 0.2s,box-shadow 0.2s,background 0.2s;
}
.rse-youtube-link:hover{background:#d90000;color:#fff;transform:translateY(-2px);box-shadow:0 14px 28px rgba(255,0,0,0.28);}
.rse-video-frame{
  position:relative;overflow:hidden;border-radius:14px;background:#fff;
  aspect-ratio:16/9;border:1px solid rgba(0,74,173,0.1);
  box-shadow:0 16px 35px rgba(0,0,0,0.14);
}
.rse-video-frame iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}

/* ─── Responsive ───────────────────────────────────────────────────────────── */
@media(max-width:1100px){
  .rse-layout{grid-template-columns:minmax(280px,0.44fr) minmax(0,1fr);gap:26px;}
  .rse-stats{grid-template-columns:repeat(3,1fr);}
}
@media(max-width:900px){
  .rse-page{padding:42px 18px 40px;}
  .rse-layout{grid-template-columns:1fr;gap:24px;padding:0 16px 28px;border-radius:0 0 16px 16px;}
  .rse-layout::before{top:380px;border-radius:0 0 16px 16px;}
  .rse-copy,.rse-gallery{order:initial;}
  .rse-text{font-size:16px;text-align:left;max-width:none;padding:22px 0 0;}
  .rse-secondary-title{font-size:26px;}
  .rse-gallery,.rse-slide{min-height:340px;}
  .rse-slide img{height:240px;}
  .rse-arrow{top:120px;width:34px;height:34px;font-size:18px;}
  .rse-stats-wrap{padding:32px 18px 40px;}
  .rse-stats{grid-template-columns:1fr;}
  .rse-pilares{grid-template-columns:1fr;margin-top:0;}
  .rse-modelo-banda{
    background:linear-gradient(to bottom,#fff 0 46px,#c8e6f5 46px 100%);
    padding:0 18px 40px;
  }
  .rse-video-wrap{padding:38px 18px 40px;}
  .rse-video-header{display:block;margin-bottom:20px;}
  .rse-video-header span{display:block;margin-top:10px;}
  .rse-youtube-link{width:100%;}
  .rse-dots{right:auto;left:22px;bottom:22px;}
}
</style>

<?php if (!empty($rseImagenPrincipal)): ?>
<section class="rse-hero">
  <img src="<?= htmlspecialchars($rseImagenPrincipal) ?>" alt="<?= htmlspecialchars($rseTitulo) ?>">
</section>
<?php endif; ?>

<!-- ══ Intro + Galería ════════════════════════════════════════════════════════ -->
<div class="rse-page">
  <section class="rse-layout">
    <div class="rse-copy">
      <div class="rse-text-panel">
        <h2 class="rse-secondary-title"><?= nl2br(htmlspecialchars($rseTituloSecundario ?: $rseTitulo)) ?></h2>
        <div class="rse-text"><?= nl2br(htmlspecialchars($rseContenido)) ?></div>
      </div>
    </div>
    <div class="rse-gallery" aria-label="Galeria RSE">
      <button class="rse-arrow prev" type="button" aria-label="Foto anterior">&#10094;</button>
      <?php if (!empty($rseGaleria)): ?>
        <?php foreach ($rseGaleria as $index => $foto): ?>
          <div class="rse-slide <?= $index === 0 ? 'active' : '' ?>">
            <img src="<?= htmlspecialchars($foto['imagen_url']) ?>"
                 alt="<?= htmlspecialchars($foto['imagen_descripcion'] ?: ($foto['imagen_titulo'] ?: 'RSE LOTO Nicaragua')) ?>">
            <?php if (!empty($foto['imagen_titulo'])): ?>
              <div class="rse-photo-caption">
                <h3><?= htmlspecialchars($foto['imagen_titulo']) ?></h3>
                <?php if (!empty($foto['fecha_creacion'])): ?>
                  <?php
                    $rseFechaTs = strtotime($foto['fecha_creacion']);
                    $rseMesNom  = $rseMeses[(int)date('n', $rseFechaTs)] ?? '';
                    $rseAnioNum = date('Y', $rseFechaTs);
                  ?>
                  <time><?= htmlspecialchars(trim($rseMesNom . ' ' . $rseAnioNum)) ?></time>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="rse-slide active">
          <img src="/ImagesSV/banner principal.jpg" alt="RSE LOTO Nicaragua">
        </div>
      <?php endif; ?>
      <button class="rse-arrow next" type="button" aria-label="Foto siguiente">&#10095;</button>
      <div class="rse-dots" aria-label="Indicadores de galeria"></div>
    </div>
  </section>
</div>

<!-- ══ Estadísticas (ancho completo) ════════════════════════════════════════ -->
<?php if (!empty($rseStats)): ?>
<div class="rse-stats-wrap">
  <section class="rse-stats" aria-label="Estadisticas RSE">
    <?php foreach ($rseStats as $stat): ?>
    <div class="rse-stats-item">
      <?php if (!empty($stat['icono'])): ?>
        <div class="rse-stats-icon-wrap">
          <img class="rse-stats-icon" src="<?= htmlspecialchars($stat['icono']) ?>" alt="<?= htmlspecialchars($stat['texto']) ?>">
        </div>
      <?php endif; ?>
      <strong class="rse-stats-number"><?= htmlspecialchars($stat['numero']) ?></strong>
      <span class="rse-stats-text"><?= htmlspecialchars($stat['texto']) ?></span>
    </div>
    <?php endforeach; ?>
  </section>
</div>
<?php endif; ?>

<!-- ══ Modelo Cambia Vidas (ancho completo) ══════════════════════════════════ -->
<?php if ($mostrarModelo): ?>
<section class="rse-modelo" aria-label="El Modelo Cambia Vidas">
  <div class="rse-modelo-header">
    <?php if ($rseModeloTitulo !== ''): ?>
      <h2><?= htmlspecialchars($rseModeloTitulo) ?></h2>
    <?php endif; ?>
    <?php if ($rseModeloSubtitulo !== ''): ?>
      <p><?= nl2br(htmlspecialchars($rseModeloSubtitulo)) ?></p>
    <?php endif; ?>
  </div>
  <div class="rse-modelo-ola">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,0 L1440,0 L1440,20 Q1080,80 720,55 Q360,30 0,70 Z" fill="#c8e6f5"/>
    </svg>
  </div>
  <div class="rse-modelo-banda">
    <div class="rse-modelo-inner">
      <?php if (!empty($hayPilares)): ?>
      <div class="rse-pilares">
        <?php foreach ($rsePilares as $pilar): ?>
          <?php if ($pilar['titulo'] === '' && $pilar['contenido'] === '') continue; ?>
          <div class="rse-pilar">
            <?php if (!empty($pilar['icono'])): ?>
              <img class="rse-pilar-icon" src="<?= htmlspecialchars($pilar['icono']) ?>" alt="<?= htmlspecialchars($pilar['titulo']) ?>">
            <?php endif; ?>
            <h3><?= htmlspecialchars($pilar['titulo']) ?></h3>
            <?php if ($pilar['contenido'] !== ''): ?>
              <p><?= nl2br(htmlspecialchars($pilar['contenido'])) ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ Video (ancho completo) ════════════════════════════════════════════════ -->
<div class="rse-video-wrap">
  <section class="rse-video-section" aria-label="Ultimo video RSE">
    <div class="rse-video-header">
      <h2>Cambiando vidas con alegría</h2>
      <span>RSE en accion</span>
    </div>
    <div class="rse-video-frame">
      <iframe
        src="https://www.youtube.com/embed/videoseries?list=PLdWfIbhlaeKwgkFk2rnLkNQfVrvrjXYQL&rel=0"
        title="Ultimo video de RSE LOTO Nicaragua"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen>
      </iframe>
    </div>
    <a class="rse-youtube-link"
       href="https://www.youtube.com/playlist?list=PLdWfIbhlaeKwgkFk2rnLkNQfVrvrjXYQL"
       target="_blank" rel="noopener noreferrer">
      Ver más
    </a>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const gallery = document.querySelector('.rse-gallery');
  if (!gallery) return;
  const slides   = gallery.querySelectorAll('.rse-slide');
  const prev     = gallery.querySelector('.rse-arrow.prev');
  const next     = gallery.querySelector('.rse-arrow.next');
  const dotsWrap = gallery.querySelector('.rse-dots');
  if (!slides.length || !prev || !next) return;
  if (slides.length <= 1) {
    prev.style.display = 'none'; next.style.display = 'none';
    if (dotsWrap) dotsWrap.style.display = 'none';
    return;
  }
  let current = 0;
  const dots  = [];
  if (dotsWrap) {
    slides.forEach(function (_, i) {
      const dot = document.createElement('button');
      dot.type      = 'button';
      dot.className = 'rse-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('aria-label', 'Ver foto ' + (i + 1));
      dot.addEventListener('click', function () { showSlide(i); });
      dotsWrap.appendChild(dot);
      dots.push(dot);
    });
  }
  function showSlide(index) {
    slides[current].classList.remove('active');
    if (dots[current]) dots[current].classList.remove('active');
    current = (index + slides.length) % slides.length;
    slides[current].classList.add('active');
    if (dots[current]) dots[current].classList.add('active');
  }
  prev.addEventListener('click', function () { showSlide(current - 1); });
  next.addEventListener('click', function () { showSlide(current + 1); });
});
</script>

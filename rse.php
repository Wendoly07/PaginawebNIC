<?php
$rseRows = [];
$rseTitulo = 'RSE';
$rseContenido = 'Responsabilidad Social Empresarial';

try {
    require_once __DIR__ . '/config/connection.php';

    if ($conn) {
        $stmt = $conn->prepare("
            SELECT titulo, contenido, imagen_url, imagen_titulo, imagen_descripcion, fecha_creacion
            FROM paginaweb_nic_rse
            WHERE activo = ?
            ORDER BY orden ASC, id ASC
        ");
        $stmt->execute([1]);
        $rseRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log(__FILE__ . ': ' . $e->getMessage());
    $rseRows = [];
}

if (!empty($rseRows)) {
    $rseTitulo = $rseRows[0]['titulo'] ?? $rseTitulo;
    $rseContenido = $rseRows[0]['contenido'] ?? $rseContenido;
}

$rseGaleria = array_values(array_filter($rseRows, function ($row) {
    return !empty($row['imagen_url']);
}));
?>

<style>
  .rse-page {
    background:
      linear-gradient(180deg, #ffffff 0%, #f5f8ff 62%, #ffffff 100%);
    color: #003399;
    padding: 86px 24px 96px;
  }

  .rse-layout {
    width: min(1240px, 100%);
    margin: 0 auto;
    display: grid;
    grid-template-columns: minmax(360px, 0.88fr) minmax(480px, 560px);
    gap: clamp(56px, 7vw, 96px);
    align-items: start;
  }

  .rse-copy {
    min-width: 0;
  }

  .rse-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    color: #ff7e00;
    font-size: 15px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0;
  }

  .rse-eyebrow::before {
    content: "";
    width: 42px;
    height: 5px;
    border-radius: 999px;
    background: #ff7e00;
  }

  .rse-copy h1 {
    margin: 0 0 30px;
    color: #004aad;
    font-size: clamp(42px, 4.25vw, 64px);
    font-weight: 900;
    line-height: 1.04;
    letter-spacing: 0;
    max-width: 650px;
  }

  .rse-text-panel {
    position: relative;
    max-width: 620px;
    padding-left: 22px;
    border-left: 5px solid #ff7e00;
  }

  .rse-copy p,
  .rse-text {
    margin: 0 0 18px;
    color: #111;
    font-size: 17px;
    line-height: 1.45;
    font-weight: 500;
    text-align: justify;
    max-width: 610px;
  }

  .rse-impact {
    width: min(1240px, 100%);
    margin: 42px auto 0;
    display: grid;
    grid-template-columns: repeat(3, minmax(180px, 1fr));
    gap: 18px;
  }

  .rse-impact-item {
    background: #fff;
    border: 1px solid rgba(0, 74, 173, 0.12);
    border-top: 5px solid #ff7e00;
    border-radius: 8px;
    padding: 22px 24px;
    box-shadow: 0 12px 28px rgba(0, 51, 153, 0.08);
  }

  .rse-impact-item strong {
    display: block;
    color: #004aad;
    font-size: 28px;
    font-weight: 900;
    line-height: 1;
  }

  .rse-impact-item span {
    display: block;
    margin-top: 8px;
    color: #222;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.25;
  }

  .rse-video-section {
    width: min(1120px, 100%);
    margin: 64px auto 0;
    background: #003399;
    border-radius: 12px;
    padding: 42px clamp(20px, 4vw, 56px) 50px;
    box-shadow: 0 24px 48px rgba(0, 51, 153, 0.2);
  }

  .rse-video-header {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 28px;
  }

  .rse-video-header h2 {
    margin: 0;
    color: #fff;
    font-size: clamp(30px, 4vw, 48px);
    font-weight: 900;
    line-height: 1;
  }

  .rse-video-header span {
    color: #ffdf00;
    font-size: 16px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .rse-video-frame {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    background: #001f66;
    aspect-ratio: 16 / 9;
    box-shadow: 0 18px 36px rgba(0, 0, 0, 0.28);
  }

  .rse-video-frame iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border: 0;
  }

  .rse-gallery {
    position: relative;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(0, 74, 173, 0.1);
    border-radius: 12px;
    box-shadow: 0 26px 56px rgba(0, 51, 153, 0.22);
    min-height: 586px;
  }

  .rse-slide {
    display: none;
    width: 100%;
  }

  .rse-slide.active {
    display: block;
  }

  .rse-slide img {
    width: 100%;
    height: 455px;
    display: block;
    object-fit: cover;
    background: #eef3fb;
  }

  .rse-photo-caption {
    background: linear-gradient(135deg, #003399 0%, #004aad 100%);
    color: #fff;
    min-height: 116px;
    padding: 20px 26px 22px;
    border-top: 5px solid #ff7e00;
  }

  .rse-photo-caption h3 {
    margin: 0;
    font-size: 23px;
    font-weight: 900;
    line-height: 1.2;
  }

  .rse-photo-caption time {
    display: block;
    margin-top: 8px;
    color: #ffdf00;
    font-size: 16px;
    font-weight: 800;
  }

  .rse-arrow {
    position: absolute;
    top: 228px;
    transform: translateY(-50%);
    width: 52px;
    height: 52px;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 126, 0, 0.95);
    color: #fff;
    font-size: 30px;
    font-weight: 900;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 18px rgba(0,0,0,0.25);
    transition: transform 0.22s ease, background 0.22s ease;
    z-index: 2;
  }

  .rse-arrow:hover {
    background: #ff5f00;
    transform: translateY(-50%) scale(1.08);
  }

  .rse-arrow.prev {
    left: 20px;
  }

  .rse-arrow.next {
    right: 20px;
  }

  .rse-dots {
    position: absolute;
    left: 26px;
    bottom: 20px;
    display: flex;
    gap: 8px;
    z-index: 3;
  }

  .rse-dot {
    width: 9px;
    height: 9px;
    border: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.45);
    cursor: pointer;
    padding: 0;
    transition: width 0.2s ease, background 0.2s ease;
  }

  .rse-dot.active {
    width: 26px;
    border-radius: 999px;
    background: #ffdf00;
  }

  @media (max-width: 1100px) {
    .rse-layout {
      grid-template-columns: minmax(320px, 0.9fr) minmax(420px, 520px);
      gap: 42px;
    }

    .rse-copy h1 {
      font-size: 54px;
    }
  }

  @media (max-width: 900px) {
    .rse-page {
      padding: 42px 18px 58px;
    }

    .rse-layout {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .rse-copy h1 {
      margin-bottom: 28px;
      font-size: 42px;
      max-width: none;
    }

    .rse-copy p,
    .rse-text {
      font-size: 16px;
      text-align: left;
      max-width: none;
    }

    .rse-gallery,
    .rse-slide {
      min-height: 360px;
    }

    .rse-slide img {
      height: 300px;
    }

    .rse-arrow {
      top: 150px;
    }

    .rse-photo-caption {
      min-height: auto;
      padding-bottom: 42px;
    }

    .rse-impact {
      grid-template-columns: 1fr;
      margin-top: 30px;
    }

    .rse-video-section {
      margin-top: 38px;
      padding: 30px 16px 34px;
    }

    .rse-video-header {
      display: block;
      margin-bottom: 20px;
    }

    .rse-video-header span {
      display: block;
      margin-top: 10px;
      white-space: normal;
    }
  }
</style>

<main class="rse-page">
  <section class="rse-layout">
    <div class="rse-copy">
      <div class="rse-eyebrow">Compromiso social</div>
      <h1><?= htmlspecialchars($rseTitulo) ?></h1>

      <div class="rse-text-panel">
        <div class="rse-text"><?= nl2br(htmlspecialchars($rseContenido)) ?></div>
      </div>
    </div>

    <div class="rse-gallery" aria-label="Galeria RSE">
      <button class="rse-arrow prev" type="button" aria-label="Foto anterior">&#10094;</button>

      <?php if (!empty($rseGaleria)): ?>
        <?php foreach ($rseGaleria as $index => $foto): ?>
          <div class="rse-slide <?= $index === 0 ? 'active' : '' ?>">
            <img src="<?= htmlspecialchars($foto['imagen_url']) ?>" alt="<?= htmlspecialchars($foto['imagen_descripcion'] ?: ($foto['imagen_titulo'] ?: 'RSE LOTO Nicaragua')) ?>">
            <?php if (!empty($foto['imagen_titulo']) || !empty($foto['fecha_creacion'])): ?>
              <div class="rse-photo-caption">
                <?php if (!empty($foto['imagen_titulo'])): ?>
                  <h3><?= htmlspecialchars($foto['imagen_titulo']) ?></h3>
                <?php endif; ?>
                <?php if (!empty($foto['fecha_creacion'])): ?>
                  <time><?= htmlspecialchars(date('d/m/Y', strtotime($foto['fecha_creacion']))) ?></time>
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

  <section class="rse-impact" aria-label="Impacto social">
    <div class="rse-impact-item">
      <strong>+500M</strong>
      <span>Cordobas destinados a programas sociales.</span>
    </div>
    <div class="rse-impact-item">
      <strong>60 mil</strong>
      <span>Adultos mayores, ninos y ninas beneficiados.</span>
    </div>
    <div class="rse-impact-item">
      <strong>28 mil</strong>
      <span>Jovenes vinculados a ligas deportivas estudiantiles.</span>
    </div>
  </section>

  <section class="rse-video-section" aria-label="Ultimo video RSE">
    <div class="rse-video-header">
      <h2>Ultimo video</h2>
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
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const gallery = document.querySelector('.rse-gallery');
  if (!gallery) return;

  const slides = gallery.querySelectorAll('.rse-slide');
  const prev = gallery.querySelector('.rse-arrow.prev');
  const next = gallery.querySelector('.rse-arrow.next');
  const dotsWrap = gallery.querySelector('.rse-dots');
  if (!slides.length || !prev || !next) return;

  if (slides.length <= 1) {
    prev.style.display = 'none';
    next.style.display = 'none';
    if (dotsWrap) dotsWrap.style.display = 'none';
    return;
  }

  let current = 0;
  const dots = [];

  if (dotsWrap) {
    slides.forEach(function (_, index) {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'rse-dot' + (index === 0 ? ' active' : '');
      dot.setAttribute('aria-label', 'Ver foto ' + (index + 1));
      dot.addEventListener('click', function () {
        showSlide(index);
      });
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

  prev.addEventListener('click', function () {
    showSlide(current - 1);
  });

  next.addEventListener('click', function () {
    showSlide(current + 1);
  });
});
</script>

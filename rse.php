<?php
$rseRows = [];
$rseTitulo = 'RSE';
$rseTituloSecundario = 'Responsabilidad Social Empresarial';
$rseContenido = 'Responsabilidad Social Empresarial';
$rseImagenPrincipal = '';

try {
    require_once __DIR__ . '/config/connection.php';

    if ($conn) {
        $stmt = $conn->prepare("
            SELECT titulo, titulo_secundario, contenido, imagen_principal_url, imagen_url, imagen_titulo, imagen_descripcion, fecha_creacion
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
    $rseTituloSecundario = $rseRows[0]['titulo_secundario'] ?? $rseTituloSecundario;
    $rseContenido = $rseRows[0]['contenido'] ?? $rseContenido;
    foreach ($rseRows as $row) {
        if (!empty($row['imagen_principal_url'])) {
            $rseImagenPrincipal = $row['imagen_principal_url'];
            break;
        }
    }
}

$rseGaleria = array_values(array_filter($rseRows, function ($row) use ($rseImagenPrincipal) {
    return !empty($row['imagen_url']) && $row['imagen_url'] !== $rseImagenPrincipal;
}));

foreach ($rseGaleria as &$foto) {
    $foto['imagen_mostrar'] = $foto['imagen_url'];
}
unset($foto);
?>

<style>
  .rse-hero {
    width: 100%;
    overflow: hidden;
  }

  .rse-hero img {
    width: 100%;
    height: auto;
    display: block;
  }

  .rse-page {
    background: #ffffff;
    color: #003399;
    padding: 64px clamp(22px, 5vw, 90px) 78px;
  }

  .rse-layout {
    width: min(1180px, 100%);
    margin: 0 auto;
    position: relative;
    display: grid;
    grid-template-columns: minmax(320px, 0.43fr) minmax(0, 1fr);
    gap: clamp(24px, 3vw, 42px);
    align-items: end;
    background: transparent;
    border-radius: 0;
    padding: 0 28px 28px;
    box-shadow: 0 18px 42px rgba(0, 51, 153, 0.08);
  }

  .rse-layout::before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 60%;
    background: #fff8ed;
    border-radius: 0 0 18px 18px;
    z-index: 0;
  }

  .rse-layout > * {
    position: relative;
    z-index: 1;
  }

  .rse-copy {
    min-width: 0;
    order: 2;
  }

  .rse-eyebrow {
    display: none;
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

  .rse-text-panel {
    position: relative;
    max-width: none;
    padding: 0 0 28px;
    border-left: 0;
  }

  .rse-secondary-title {
    margin: 0;
    color: #ff7900;
    font-size: clamp(30px, 3.2vw, 48px);
    font-weight: 900;
    line-height: 1.02;
    letter-spacing: 0;
    max-width: 860px;
    text-transform: uppercase;
  }

  .rse-copy p,
  .rse-text {
    margin: 18px 0 0;
    color: #004aad;
    font-size: 15px;
    line-height: 1.15;
    font-weight: 850;
    text-align: justify;
    max-width: 780px;
    background: transparent;
    border-radius: 0;
    padding: 22px 28px 24px 0;
  }

  .rse-impact {
    width: min(1240px, 100%);
    margin: 52px auto 0;
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
    position: relative;
    overflow: hidden;
    width: min(920px, 100%);
    margin: 64px auto 0;
    background:
      radial-gradient(circle at 88% 12%, rgba(255,255,255,0.9) 0 58px, transparent 60px),
      linear-gradient(145deg, #fff8f0 0%, #fff 52%, #eef6ff 100%);
    border: 1px solid rgba(255, 126, 0, 0.12);
    border-radius: 16px;
    padding: 34px clamp(18px, 3vw, 42px) 40px;
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.12);
  }

  .rse-video-section::before {
    content: "";
    position: absolute;
    inset: 18px 18px auto auto;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255, 126, 0, 0.18);
    pointer-events: none;
  }

  .rse-video-section::after {
    content: "";
    position: absolute;
    right: -42px;
    bottom: -42px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(0, 74, 173, 0.18);
    pointer-events: none;
  }

  .rse-video-section > * {
    position: relative;
    z-index: 1;
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
    color: #004aad;
    font-size: clamp(28px, 3.5vw, 42px);
    font-weight: 850;
    line-height: 1.06;
  }

  .rse-video-header span {
    color: #ff7e00;
    font-size: 16px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .rse-youtube-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 22px;
    color: #fff;
    background: #ff0000;
    border-radius: 999px;
    padding: 12px 22px;
    font-size: 15px;
    font-weight: 900;
    text-decoration: none;
    box-shadow: 0 10px 22px rgba(255, 0, 0, 0.22);
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  }

  .rse-youtube-link:hover {
    background: #d90000;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(255, 0, 0, 0.28);
  }

  .rse-video-frame {
    position: relative;
    overflow: hidden;
    border-radius: 14px;
    background: #fff;
    aspect-ratio: 16 / 9;
    border: 1px solid rgba(0, 74, 173, 0.1);
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.14);
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
    background: linear-gradient(180deg, #ffd9b0 0%, #ff7900 100%);
    border: 0;
    border-radius: 0 90px 12px 12px;
    box-shadow: none;
    min-height: 385px;
    order: 1;
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
    height: 285px;
    display: block;
    object-fit: cover;
    object-position: center top;
    background: #ff7900;
  }

  .rse-photo-caption {
    position: relative;
    overflow: hidden;
    background: transparent;
    color: #004aad;
    min-height: 80px;
    padding: 14px 16px 42px;
    border-top: 0;
  }

  .rse-photo-caption h3 {
    margin: 0;
    color: #fff;
    font-size: 15px;
    font-weight: 850;
    line-height: 1.22;
    max-width: none;
  }

  .rse-photo-caption time {
    display: inline-flex;
    align-items: center;
    margin-top: 12px;
    color: #ff7900;
    font-size: 13px;
    font-weight: 800;
    line-height: 1;
    background: #fff8ed;
    border: 1px solid rgba(255, 255, 255, 0.65);
    border-radius: 999px;
    padding: 8px 12px;
  }

  .rse-arrow {
    position: absolute;
    top: 142px;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border: 0;
    border-radius: 50%;
    background: rgba(255, 126, 0, 0.96);
    color: #fff;
    font-size: 22px;
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
    left: 22px;
  }

  .rse-arrow.next {
    right: 22px;
  }

  .rse-dots {
    position: absolute;
    right: 18px;
    bottom: 18px;
    display: flex;
    gap: 8px;
    z-index: 3;
  }

  .rse-dot {
    width: 9px;
    height: 9px;
    border: 0;
    border-radius: 50%;
    background: rgba(0, 74, 173, 0.24);
    cursor: pointer;
    padding: 0;
    transition: width 0.2s ease, background 0.2s ease;
  }

  .rse-dot.active {
    width: 26px;
    border-radius: 999px;
    background: #ff7e00;
  }

  @media (max-width: 1100px) {
    .rse-layout {
      grid-template-columns: minmax(280px, 0.44fr) minmax(0, 1fr);
      gap: 26px;
    }

  }

  @media (max-width: 900px) {
    .rse-page {
      padding: 42px 18px 58px;
    }

    .rse-layout {
      grid-template-columns: 1fr;
      gap: 24px;
      padding: 0 16px 28px;
      border-radius: 0 0 16px 16px;
    }

    .rse-layout::before {
      height: 70%;
      border-radius: 0 0 16px 16px;
    }

    .rse-copy,
    .rse-gallery {
      order: initial;
    }

    .rse-copy p,
    .rse-text {
      font-size: 16px;
      text-align: left;
      max-width: none;
      line-height: 1.25;
      border-radius: 0;
      padding: 18px;
    }

    .rse-text-panel {
      padding: 0;
    }

    .rse-secondary-title {
      font-size: 32px;
      line-height: 1.08;
    }

    .rse-gallery,
    .rse-slide {
      min-height: 360px;
    }

    .rse-slide img {
      height: 260px;
    }

    .rse-arrow {
      top: 130px;
      width: 34px;
      height: 34px;
      font-size: 20px;
    }

    .rse-photo-caption {
      min-height: auto;
      padding: 20px 22px 56px;
    }

    .rse-photo-caption h3 {
      max-width: none;
      font-size: 20px;
    }

    .rse-dots {
      right: auto;
      left: 22px;
      bottom: 22px;
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

    .rse-youtube-link {
      width: 100%;
      padding-inline: 16px;
    }
  }
</style>

<?php if (!empty($rseImagenPrincipal)): ?>
  <section class="rse-hero">
    <img src="<?= htmlspecialchars($rseImagenPrincipal) ?>" alt="<?= htmlspecialchars($rseTitulo) ?>">
  </section>
<?php endif; ?>

<main class="rse-page">
  <section class="rse-layout">
    <div class="rse-copy">
      <div class="rse-eyebrow">Compromiso social</div>

      <div class="rse-text-panel">
        <h2 class="rse-secondary-title"><?= htmlspecialchars($rseTitulo) ?></h2>
        <div class="rse-text"><?= nl2br(htmlspecialchars($rseContenido)) ?></div>
      </div>
    </div>

    <div class="rse-gallery" aria-label="Galeria RSE">
      <button class="rse-arrow prev" type="button" aria-label="Foto anterior">&#10094;</button>

      <?php if (!empty($rseGaleria)): ?>
        <?php foreach ($rseGaleria as $index => $foto): ?>
          <div class="rse-slide <?= $index === 0 ? 'active' : '' ?>">
            <img src="<?= htmlspecialchars($foto['imagen_mostrar']) ?>" alt="<?= htmlspecialchars($foto['imagen_descripcion'] ?: ($foto['imagen_titulo'] ?: 'RSE LOTO Nicaragua')) ?>">
            <?php if (!empty($foto['imagen_titulo'])): ?>
              <div class="rse-photo-caption">
                <h3><?= htmlspecialchars($foto['imagen_titulo']) ?></h3>
                <?php if (!empty($foto['fecha_creacion'])): ?>
                  <?php
                    $rseMeses = [
                      1 => 'Enero',
                      2 => 'Febrero',
                      3 => 'Marzo',
                      4 => 'Abril',
                      5 => 'Mayo',
                      6 => 'Junio',
                      7 => 'Julio',
                      8 => 'Agosto',
                      9 => 'Septiembre',
                      10 => 'Octubre',
                      11 => 'Noviembre',
                      12 => 'Diciembre',
                    ];
                    $rseFecha = strtotime($foto['fecha_creacion']);
                    $rseMes = $rseMeses[(int) date('n', $rseFecha)] ?? '';
                    $rseAnio = date('Y', $rseFecha);
                  ?>
                  <time><?= htmlspecialchars(trim($rseMes . ' ' . $rseAnio)) ?></time>
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
    <a
      class="rse-youtube-link"
      href="https://www.youtube.com/playlist?list=PLdWfIbhlaeKwgkFk2rnLkNQfVrvrjXYQL"
      target="_blank"
      rel="noopener noreferrer">
      Ver más
    </a>
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

<body> 

  <style>
@font-face {
  font-family: 'HelveticaRounded';
  src: url('/fonts/HelveticaRoundedLTStd-Bd.ttf') format('truetype');
  font-weight: bold;
  font-style: normal;
  font-display: swap;
}
    html, body {
  font-family: 'HelveticaRounded', Arial, sans-serif !important;
  overflow-x: hidden !important;
  width: 100%;
}
* {
  font-family: 'HelveticaRounded', Arial, sans-serif !important;
}

    body, h1, h2, h3, h4, h5, h6, p, button, a, span, div {
      font-family: "Helvetica Rounded", "Helvetica Rounded Black", Arial, sans-serif !important;
    }

    .resultados-box {
      transition: margin-top 0.3s ease !important;
    }

    .horarios {
    font-size: 22px;
    font-weight: bold;
    color: #0070c0;
    line-height: 1.5;
  }

  .boton {
    display: inline-block;
    background: white;
    border: 2px solid #0070c0;
    color: #0070c0;
    padding: 12px 28px;
    margin-top: 15px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 12px;
    text-decoration: none;
    transition: 0.3s ease;
    box-shadow: 0px 4px 10px rgba(0, 112, 192, 0.25);
  }

  .boton:hover {
    background: #0070c0;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0px 8px 18px rgba(0, 112, 192, 0.40);
  }

  .resultados-header h2 {
    font-size: 34px;
    font-weight: 900;
    text-align: center;
    font-stretch: expanded;
    margin: 0;
  }

  .titulo-naranja {
    color: orange;
  }

  .titulo-azul {
    color: #0070c0;
  }

.resultados-box {
  padding: 40px 20px;
  background-color: #f9f9f9;
  border-radius: 16px;
  box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
  max-width: 1200px;
  margin: 0 auto 50px auto;
  transition: margin-top 0.3s ease;
}

.resultados-header h2 {
  font-size: 40px;
  font-weight: 900;
  text-align: center;
  font-stretch: expanded;
  margin-bottom: 30px;
}

.titulo-naranja {
  color: orange;
}

.titulo-azul {
  color: #0070c0;
}

/* Carrusel */
.res-carrusel-wrapper {
  position: relative;
  padding: 0 30px;
}

.res-carrusel-overflow {
  overflow: hidden;
}

.res-cards {
  display: flex;
  gap: 20px;
  transition: transform 0.4s ease;
  will-change: transform;
}

.res-card {
  flex: 0 0 calc((100% - 40px) / 3);
  background-color: white;
  border-radius: 16px;
  box-shadow: 0px 6px 15px rgba(0,0,0,0.15);
  padding: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.res-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 12px 25px rgba(0,0,0,0.25);
}

.res-card img {
  width: 100%;
  border-radius: 12px;
  margin-bottom: 10px;
}

.numeros {
  display: flex;
  gap: 8px;
  margin-bottom: 15px;
  justify-content: center;
}

.bola-verde, .bola-amarilla {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  border-radius: 50%;
  font-weight: bold;
  color: white;
  font-size: 18px;
}

.bola-verde {
  background-color: #28a745;
}

.bola-amarilla {
  background-color: #ffc107;
  color: #000;
}

.btn-container {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: auto;
}

.proximo {
  font-size: 26px;
  font-weight: 900;
  text-align: center;
  color: #003399;
  margin-top: 25px;
}

/* Flechas carrusel resultados */
.res-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: rgba(0,0,0,0.65);
  color: #fff;
  border: none;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
  transition: background 0.2s, opacity 0.2s;
}

.res-arrow:hover {
  background: rgba(0,0,0,0.85);
}

.res-arrow.prev {
  left: -10px;
}

.res-arrow.next {
  right: -10px;
}

.res-arrow:disabled {
  opacity: 0.3;
  cursor: default;
}

.youtube-video {
  flex: 1 1 500px;
  max-width: 700px;
  margin-left: -30px;
  margin-top: -80px;
  border-radius: 15px;
}
.youtube-video iframe {
  width: 100%;
  height: 315px;
  border-radius: 15px;
}

.youtube-right {
  flex: 0 0 auto;
  min-width: 300px;
  max-width: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.boton-container {
  display: flex;
  justify-content: center;
  width: 100%;
  margin-top: 20px;
}

.youtube-boton {
  padding: 12px 30px;
  border-radius: 30px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  background: orange;
  border: none;
  cursor: pointer;
  transition: transform 0.2s ease, background 0.3s ease;
}

.youtube-boton:hover {
  transform: scale(1.05);
  background: #e68928;
}

.youtube-info p {
  font-weight: 600;
}

.hero,
.hero-carousel {
  overflow: hidden;
  max-width: 100vw;
}

.hero-slide {
  display: none;
  width: 100%;
}

.hero-slide.active {
  display: block;
}

.hero-banner {
  width: 100%;
  height: auto;
  display: block;
}

@media (max-width: 1024px) {
  .youtube-content {
    flex-direction: column;
    align-items: center;
  }
  .youtube-video, .youtube-right {
    margin-left: 0;
    transform: none;
  }
  .youtube-text h2 {
    font-size: 24px;
  }
  .youtube-info p {
    font-size: 15px;
  }
}

@media (max-width: 768px) {
  .banner-container, .banner-superpremio, .banner-principal {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
  }
}

@media (max-width: 768px) {
  .rse-content {
    display: block !important;
    text-align: center;
  }
  .rse-text {
    display: block !important;
    width: 100% !important;
    text-align: center !important;
  }
  .rse-image {
    display: block !important;
    width: 100% !important;
    text-align: center !important;
    margin: 0 auto !important;
    padding: 0 !important;
  }
  .rse-image img {
    display: inline-block !important;
    margin: 0 auto !important;
    max-width: 90% !important;
    height: auto !important;
  }
  .rse .boton-container {
    display: flex !important;
    justify-content: center !important;
  }
  .rse-text p {
    margin-left: 0 !important;
    text-align: center !important;
  }
}

@media (max-width: 768px) {
  .rse-image img {
    position: relative;
    left: -10px;
    top: 10px;
  }
}

@media (max-width: 768px) {
  .hero-carousel {
    margin-top: 200px !important;
  }
  .hero {
    display: flex !important;
    flex-direction: row !important;
    justify-content: space-between;
    align-items: center;
    position: relative !important;
    width: 95%;
    max-width: 100%;
    margin: 0 auto;
    flex-wrap: wrap;
  }
  .texto-hero {
    flex: 1 1 40%;
    text-align: left !important;
    margin-left: 10px;
  }
  .texto-hero h1 {
    font-size: 1.2rem !important;
    line-height: 1.3 !important;
  }
  .texto-hero .horarios {
    font-size: 1rem !important;
    margin: 5px 0 10px 0 !important;
  }
  .texto-hero .boton {
    font-size: 0.9rem !important;
    padding: 8px 18px !important;
  }
  .hero img:not(.esfera) {
    flex: 1 1 55%;
    max-width: 100%;
    height: auto;
    display: block !important;
    margin: 0 auto;
    position: relative;
  }
  .esfera {
    width: 35px !important;
    height: 35px !important;
    line-height: 35px !important;
    font-size: 14px !important;
    position: absolute !important;
  }
}

@media (max-width: 768px) {
  .hero img:not(.esfera) {
    flex: 1 1 55%;
    max-width: 100%;
    height: auto !important;
    object-fit: contain;
    display: block !important;
    margin: 0 auto;
    position: relative;
  }
  .esfera:nth-of-type(1) { top: 40% !important; left: 42% !important; }
  .esfera:nth-of-type(2) { top: 10% !important; left: 60% !important; }
  .esfera:nth-of-type(3) { top: 65% !important; left: 55% !important; }
  .esfera:nth-of-type(4) { top: 45% !important; left: 88% !important; }
}

/* RESULTADOS MOBILE */
@media (max-width: 761px) {
  .resultados-box {
    padding: 20px 10px;
    max-width: 95%;
  }
  .resultados-header h2 {
    font-size: 24px !important;
    line-height: 1.2;
    text-align: center;
  }
  #fecha-api {
    font-size: 20px !important;
  }

  /* En mobile mostramos 1 tarjeta */
  .res-card {
    flex: 0 0 calc(100% - 0px) !important;
  }

  .res-arrow.prev { left: -5px; }
  .res-arrow.next { right: -5px; }

  .numeros {
    justify-content: center !important;
    gap: 5px !important;
  }
  .bola-verde, .bola-amarilla {
    width: 35px !important;
    height: 35px !important;
    line-height: 35px !important;
    font-size: 16px !important;
  }
  .btn-container {
    flex-direction: row !important;
    gap: 8px !important;
  }
  .proximo {
    font-size: 20px !important;
  }
  #diaSorteo {
    font-size: 14px !important;
  }
}

@media (max-width: 768px) {
  #jackpot-num-banner {
    font-size: 24px !important;
    left: 75% !important;
    transform: translate(-50%, -50%) !important;
    top: 50% !important;
    white-space: nowrap;
  }
}

@media (max-width: 768px) {
  .noticias-box {
    flex-direction: column;
    padding: 20px 10px;
  }
  .noticias-left {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
  }
  .noticias-left h3 {
    font-size: 22px;
  }
  .noticias-right {
    width: 100%;
    position: relative;
  }
  .carousel {
    display: flex;
    flex-direction: column;
    gap: 20px;
    transform: none !important;
  }
  .carousel .card {
    min-width: 100%;
    max-width: 100%;
  }
  .prev,
  .next {
    display: none !important;
  }
}

@media (max-width: 768px) {
  img[src="/ImagesSV/IMG_3933_00013.png"] {
    position: relative !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    margin: 0 !important;
    display: block;
    max-width: 100%;
    height: auto;
  }
}

@media (max-width: 768px) {
  .hero img[src="/ImagesSV/modelo.png"] {
    position: relative;
    left: -25px;
  }
}

@media (max-width: 768px) {
  .rse-content {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .rse-text {
    order: 1;
    text-align: center;
    margin-bottom: 15px;
  }
  .rse-image {
    order: 2;
    align-self: flex-start;
    margin-left: 0;
    transform: translateX(-2cm);
  }
  .rse-image img {
    width: auto;
    max-width: 80%;
    height: auto;
    display: block;
  }
}

@media (max-width: 768px) {
  .banner-container,
  .banner-superpremio,
  .banner-apostemos {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }
  .banner-container img,
  .banner-superpremio img,
  .banner-apostemos img {
    display: block;
    margin: 0 auto !important;
  }
}

@media (max-width: 768px) {
  div[style*="height: 50px"] {
    height: 15px !important;
  }
  .banner-superpremio {
    margin-top: 18px !important;
    margin-bottom: 10px !important;
  }
  a[href*="juega.loto.sv/fob"] > div {
    margin: 20px auto 10px auto !important;
  }
  .banner-superpremio img,
  a[href*="juega.loto.sv/fob"] img {
    display: block;
    margin: 0 auto !important;
  }
}

@media (max-width: 768px) {
  .youtube-content {
    flex-direction: column !important;
    align-items: center !important;
    gap: 15px !important;
  }
  .youtube-video {
    width: 95% !important;
    margin: 0 auto !important;
  }
  .youtube-right {
    width: 95% !important;
    margin: 0 auto !important;
    text-align: center !important;
  }
  .youtube-text h2 {
    font-size: 20px !important;
    line-height: 1.3 !important;
  }
  .youtube-info p {
    font-size: 14px !important;
  }
  .boton-container {
    justify-content: center !important;
    margin-top: 10px !important;
  }
}

@media (max-width: 768px) {
  .youtube-video {
    margin-bottom: 4px !important;
  }
  .youtube-right {
    margin-top: 0 !important;
  }
  .youtube-video,
  .youtube-right {
    margin-left: 1px !important;
    margin-right: 15px;
  }
  .youtube {
    margin-bottom: 20px !important;
  }
  .youtube-inner {
    padding-bottom: 0;
  }
}

@media (max-width: 768px) {
  .video-subtext {
    margin-bottom: 4px !important;
  }
  .youtube-video,
  .youtube-right {
    margin-left: 2px !important;
    margin-right: 15px;
  }
  .youtube {
    margin-bottom: 20px !important;
  }
}

.hero-carousel {
  position: relative;
  overflow: visible;
}

.hero-slide {
  display: none;
}

.hero-slide.active {
  display: block;
}

.carousel-btn {
  position: absolute;
  top: 40%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.65);
  color: #fff;
  border: none;
  font-size: 22px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.carousel-btn.prev {
  left: 20px;
}

.carousel-btn.next {
  right: 20px;
}

.carousel-btn:hover {
  background: rgba(0, 0, 0, 0.75);
  transform: translateY(-50%) scale(1.1);
}

.carousel-btn:active {
  transform: translateY(-50%) scale(0.95);
}

.hero-slide a,
.hero-slide img {
  z-index: 1;
  position: relative;
}

.carousel-btn {
  z-index: 10000;
  pointer-events: auto;
}

@media (max-width: 768px) {
  .carousel-btn {
    top: 42%;
    width: 44px;
    height: 44px;
    font-size: 20px;
  }
  .carousel-btn.prev {
    left: 8px;
  }
  .carousel-btn.next {
    right: 8px;
  }
}

@media (max-width: 768px) {
  .hero-carousel .carousel-btn {
    display: flex !important;
  }
}

.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.9);
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  z-index: 999999;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease;
}

.popup-overlay.active {
  opacity: 1;
  visibility: visible;
}

.popup-content{
  position: relative;
  max-width: 600px;
  width: 100%;
  display:flex;
  justify-content:center;
}

.popup-content img {
  width: 100%;
  max-width: 600px;
  height: auto;
  max-height: 85vh;
  object-fit: contain;
  border-radius: 12px;
  display: block;
}

.popup-close {
  position: absolute;
  top: 8px;
  right: 8px;
  background: rgba(0,0,0,0.7);
  color: white;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  font-size: 18px;
  cursor: pointer;
  font-weight: bold;
}

.popup-close:hover {
  background: red;
  transform: scale(1.1);
}

.popup-image-wrapper {
  position: relative;
  display: inline-block;
}

.res-card.naranja {
  background-color: #EF6C00;
  border-radius: 20px;
  padding: 20px;
  text-align: center;
  color: white;
}

.bola-gris {
  width: 45px;
  height: 45px;
  background: linear-gradient(145deg, #f2f2f2, #cfcfcf);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 18px;
  color: #333;
  box-shadow: inset -3px -3px 6px rgba(0,0,0,0.15), inset 3px 3px 6px rgba(255,255,255,0.6), 2px 2px 5px rgba(0,0,0,0.2);
}

.res-card.naranja .btn-jugar {
  background-color: white;
  color: #EF6C00;
  font-weight: bold;
}

.res-card.naranja .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

.res-card.morado-premiado {
  background-color: #9b51e0;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
}

.res-card.morado-premiado .btn-jugar {
  background-color: white;
  color: #9b51e0;
  font-weight: bold;
}

.res-card.morado-premiado .btn-info { 
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

.res-card.rojo-fechas {
  background-color: #e31f26;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
}

.bola-blanca {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  border-radius: 50%;
  font-weight: bold;
  font-size: 18px;
  background: linear-gradient(145deg, #f2f2f2, #cfcfcf);
  color: #333;
  box-shadow: inset -3px -3px 6px rgba(0,0,0,0.15), inset 3px 3px 6px rgba(255,255,255,0.6), 2px 2px 5px rgba(0,0,0,0.2);
}

.bola-mes-amarilla {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  border-radius: 50%;
  font-weight: bold;
  font-size: 13px;
  background-color: #f5e200;
  color: #333;
}

.res-card.rojo-fechas .btn-jugar {
  background-color: white;
  color: #e31f26;
  font-weight: bold;
}

.res-card.rojo-fechas .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

.res-card.azul-jugatres {
  background-color: #2AB5EF;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
}

.res-card.marino-terminacion2 {
  background-color: #015c91;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
}

.res-card.marino-terminacion2 .btn-jugar {
  background-color: white;
  color: #015c91;
  font-weight: bold;
}

.res-card.marino-terminacion2 .btn-info {    
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

.res-card.azul-jugatres .btn-jugar {
  background-color: white;
  color: #2AB5EF;
  font-weight: bold;
}

.res-card.azul-jugatres .btn-info {    
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

@media (max-width: 768px){
  .popup-overlay{
    padding:10px;
  }
  .popup-content{
    display:flex;
    justify-content:center;
    align-items:center;
  }
  .popup-image-wrapper{
    display:flex;
    justify-content:center;
  }
  .popup-content img{
    max-width:90vw;
    max-height:90vh;
  }
}

.noticias-right {
  overflow: hidden;
  width: 100%;
}

.carousel {
  display: flex;
  gap: 20px;
  transition: transform 0.4s ease;
  will-change: transform;
}

.card {
  min-width: 300px;
  flex: 0 0 auto;
}

.card-content {
  padding: 10px;
}

.card-content p {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  font-size: 14px;
  color: #fff;
  margin-top: 5px;
}
  </style>

  <div></div>

<?php
$stmt = $conn->prepare("
    SELECT * 
    FROM paginaweb_nic_sobre_inicio 
    WHERE seccion='banner_principal'
    ORDER BY orden ASC
");
$stmt->execute();
$banners = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="hero-carousel">

  <button class="carousel-btn prev">&#10094;</button>
  <button class="carousel-btn next">&#10095;</button>

  <div class="hero-slide active">
    <div class="hero" style="position: relative;">
      <div class="texto-hero">
        <h1>SINTONIZÁ EL PRÓXIMO SORTEO EN VIVO A LAS</h1>
        <div class="horarios">
          12:00 AM, 3:00 PM,<br>
          6:00 PM y 9:00 PM
        </div>
        <a href="https://www.youtube.com/@LotoNicaragua" class="boton">
          MÍRALO AQUÍ >
        </a>
      </div>

      <img src="/ImagesSV/modelo.png" alt="Conductora">

      <img src="/ImagesSV/Esfera_3.png" class="esfera" style="position:absolute; width:5vw; top:20%; left:65%;">
      <img src="/ImagesSV/Esfera_9.png" class="esfera" style="position:absolute; width:5vw; top:70%; left:59%;">
      <img src="/ImagesSV/Esfera _11.png" class="esfera" style="position:absolute; width:5vw; top:50%; left:94%;">
    </div>
  </div>

  <?php foreach($banners as $b): ?>
  <div class="hero-slide">
    <a href="<?= htmlspecialchars($b['link_url']) ?>" target="_blank">
      <img src="<?= htmlspecialchars($b['imagen_url']) ?>" class="hero-banner">
    </a>
  </div>
  <?php endforeach; ?>

</div>

  <?php
$CHANNEL_ID = "UCm2CdYYApcaticw4xAMTHcw";
$rss_url = "https://www.youtube.com/feeds/videos.xml?channel_id=$CHANNEL_ID";
$videoDate = "Cargando...";
$rss = simplexml_load_file($rss_url);
if ($rss && isset($rss->entry[0])) {
    $videoTitle = (string)$rss->entry[0]->title;
    if (preg_match('/\d{1,2}\s*de\s*\w+\s*\d{4},?\s*\d{1,2}:\d{2}\s*(?:A\.M\.|P\.M\.|AM|PM)/i', $videoTitle, $matches)) {
        $videoDate = $matches[0];
    } else {
        $videoDate = "Fecha no disponible";
    }
}
?>

  <div class="resultados-box">
    <div class="resultados-header">
      <h2>
        <span class="titulo-naranja">ÚLTIMOS RESULTADOS,</span>
        <span class="titulo-azul" id="fecha-api" style="font-size: 45px; color: #fff; font-family: Nunito; font-weight:795;">
          <?php echo $videoDate; ?>
        </span>
      </h2>
      <br>

      <?php
      try {
          $conn = new PDO(
              "sqlsrv:Server=srvdbcacdev.database.windows.net;Database=dblotocacdev",
              "LotoAdmin",
              "LotAdmin1.",
              [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
          );
      } catch(PDOException $e){
          die("Error de conexión: " . $e->getMessage());
      }
      $stmt = $conn->prepare("
          SELECT * 
          FROM paginaweb_nic_sobre_inicio
          WHERE seccion='juegos_home'
          ORDER BY orden ASC
      ");
      $stmt->execute();
      $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <!-- CARRUSEL CON FLECHAS -->
      <div class="res-carrusel-wrapper">

        <button class="res-arrow prev" id="res-prev" onclick="moverResCarrusel(-1)">&#10094;</button>
        <button class="res-arrow next" id="res-next" onclick="moverResCarrusel(1)">&#10095;</button>

        <div class="res-carrusel-overflow">
          <div class="res-cards" id="res-cards-inner">

            <!-- Diaria (Verde) -->
            <div class="res-card verde">
              <img src="<?= $juegos[1]['imagen_url'] ?>" 
                   alt="<?= htmlspecialchars($juegos[1]['nombre']) ?>" 
                   style="width:190px; height:auto; position:relative; top:20px;">
              <div class="numeros" style="position:relative; top:15px;">
                <span class="bola-verde" id="par1">0</span>
                <span class="bola-verde" id="par2">0</span>
              </div>
              <script>
              async function cargarResultados() {
                  try {
                      const response = await fetch('https://paginawebsvcac.azurewebsites.net/api/resultados-diaria.php');
                      if (!response.ok) throw new Error('Error en la respuesta de la API');
                      const data = await response.json();
                      document.getElementById('par1').innerText = data.par1 || '0';
                      document.getElementById('par2').innerText = data.par2 || '0';
                  } catch (error) {
                      console.error('No se pudieron cargar los resultados:', error);
                  }
              }
              cargarResultados();
              </script>
              <div class="btn-container">
                <button class="btn-jugar" onclick="window.location.href='https://loto.sv/index.php?pag=diaria'">Jugá aquí</button>
                <a href="https://loto.sv/index.php?pag=diaria">
                  <button class="btn-info">Conocé más</button>
                </a>
              </div>
            </div>

            <!-- Terminacion2 -->
            <div class="res-card marino-terminacion2">
              <img src="/ImagesSV/logo terminacion2.png"
                   alt="Terminacion 2"
                   style="width:190px; height:auto; position:relative; top:20px;">
              <div class="numeros" style="position:relative; top:15px;">
                <span class="bola-blanca" id="t2-numero">--</span>
              </div>
              <div class="btn-container">
                <button class="btn-jugar" onclick="window.location.href='index.php?pag=terminacion2'">Jugá aquí</button>
                <a href="index.php?pag=terminacion2">
                  <button class="btn-info">Conocé más</button>
                </a>
              </div>
            </div>

            <!-- Fechas Lotos -->
            <div class="res-card rojo-fechas">
              <img src="/ImagesSV/LOGO FECHAS LOTOS.png.png"
                   alt="Fechas Lotos"
                   style="width:190px; height:auto; position:relative; top:20px;">
              <div class="numeros" style="position:relative; top:15px;">
                <span class="bola-blanca" id="fl-numero">--</span>
                <span class="bola-mes-amarilla" id="fl-mes">---</span>
              </div>
              <div class="btn-container">
                <button class="btn-jugar" onclick="window.location.href='index.php?pag=fechas_lotos'">Jugá aquí</button>
                <a href="index.php?pag=fechas_lotos">
                  <button class="btn-info">Conocé más</button>
                </a>
              </div>
            </div>

            <!-- Premiado 2 -->
            <div class="res-card morado-premiado">
              <img src="/ImagesSV/Premiado2.png"
                   alt="Premiado 2"
                   style="width:190px; height:auto; position:relative; top:20px;">
              <div class="numeros" style="position:relative; top:15px;">
                <span class="bola-blanca">-</span>
                <span class="bola-blanca">-</span>
                <span class="bola-blanca">-</span>
                <span class="bola-blanca">-</span>
              </div>
              <div class="btn-container">
                <button class="btn-jugar" onclick="window.location.href='index.php?pag=premiado'">Jugá aquí</button>
                <a href="index.php?pag=premiado">
                  <button class="btn-info">Conocé más</button>
                </a>
              </div>
            </div>

            <!-- Juga Tres -->
            <div class="res-card azul-jugatres">
              <img src="/ImagesSV/logo-30-JUGA TRES.png"
                   alt="Juga Tres"
                   style="width:190px; height:auto; position:relative; top:20px;">
              <div class="numeros" style="position:relative; top:15px;">
                <span class="bola-blanca">-</span>
                <span class="bola-blanca">-</span>
                <span class="bola-blanca">-</span>
              </div>
              <div class="btn-container">
                <button class="btn-jugar" onclick="window.location.href='index.php?pag=juga_tres'">Jugá aquí</button>
                <a href="index.php?pag=juga_tres">
                  <button class="btn-info">Conocé más</button>
                </a>
              </div>
            </div>

          </div><!-- /res-cards -->
        </div><!-- /res-carrusel-overflow -->
      </div><!-- /res-carrusel-wrapper -->

      <script>
      var resIndex = 0;
      var resTotalCards = 5;

      function getResVisible() {
        return window.innerWidth <= 761 ? 1 : 3;
      }

      function moverResCarrusel(dir) {
        var visible = getResVisible();
        var maxIndex = resTotalCards - visible;

        resIndex += dir;
        if (resIndex < 0) resIndex = 0;
        if (resIndex > maxIndex) resIndex = maxIndex;

        var inner = document.getElementById('res-cards-inner');
        var cards = inner.children;
        if (cards.length === 0) return;

        var gap = 20;
        var cardWidth = cards[0].offsetWidth + gap;
        inner.style.transform = 'translateX(-' + (resIndex * cardWidth) + 'px)';

        document.getElementById('res-prev').disabled = resIndex === 0;
        document.getElementById('res-next').disabled = resIndex >= maxIndex;
      }

      // Estado inicial
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('res-prev').disabled = true;
        window.addEventListener('resize', function() {
          resIndex = 0;
          moverResCarrusel(0);
        });
      });
      </script>

    </div><!-- /resultados-header -->

    <br><br>

    <p class="proximo" style="font-size: 28px; font-weight: 900; text-align: center; font-stretch: expanded;">
      <span style="color: #003399;">PRÓXIMO SORTEO EN VIVO:</span> 
      <span style="color: white;">
        <span id="hours">0</span>H :
        <span id="minutes">0</span>M :
        <span id="seconds">0</span>S
      </span>
    </p>

    <div id="diaSorteo" style="color: white; font-size: 16px; text-align: center; margin-top: 10px;"></div>

  </div><!-- /resultados-box -->

  <br>

<?php
$stmt = $conn->prepare("
    SELECT TOP 1 * 
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion = 'popup_home'
    ORDER BY orden ASC
");
$stmt->execute();
$jackpot = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div style="width: 100%; text-align: center; position: relative; margin-bottom: 20px;">
    <?php if($jackpot): ?>
        <a href="<?= htmlspecialchars($jackpot['link_url'] ?? '#') ?>" target="_blank">
            <img 
                src="<?= htmlspecialchars($jackpot['imagen_url']) ?>" 
                alt="Jackpot" 
                style="width: 100%; max-width: 1700px; height: auto; border-radius: 16px; display: block; margin: 0 auto;"
            >
        </a>
        <div id="jackpot-num-banner" style="
            position: absolute;
            top: 47%;
            left: 65%;
            transform: translateY(-50%);
            font-size: 62px;  
            font-weight: 900;
            color: #fafaf9ff;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.5);
            z-index: 10;
        ">$ 0</div>
    <?php else: ?>
        <img 
            src="/ImagesSV/BannerDefault.png" 
            alt="Jackpot por defecto" 
            style="width: 100%; max-width: 1700px; height: auto; border-radius: 16px; display: block; margin: 0 auto;"
        >
    <?php endif; ?>
</div>

<script>
async function cargarJackpot() {
    try {
        const response = await fetch('/api/jackpot_superpremio.php');
        if (!response.ok) throw new Error('Error en la API');
        const data = await response.json();
        const monto = data.jackpot != null ? Number(data.jackpot) : 0;
        document.getElementById('jackpot-num-banner').innerText = "$" +
            monto.toLocaleString("es-ES").replace(/\./g, ",");
    } catch (error) {
        console.error("No se pudo cargar el Jackpot:", error);
    }
}
cargarJackpot();
</script>

<?php
$CHANNEL_ID = "UCm2CdYYApcaticw4xAMTHcw";
$rss_url = "https://www.youtube.com/feeds/videos.xml?channel_id=$CHANNEL_ID";
$rss = simplexml_load_file($rss_url);
$videoId = "1qsx5zpIp7w";
$videoTitle = "Sorteo LOTO 11:00 a.m 25 de Julio del 2025";
if ($rss && isset($rss->entry[0])) {
    $videoId = (string)$rss->entry[0]->children('yt', true)->videoId;
    $videoTitle = (string)$rss->entry[0]->title;
}
?>

<br><br><br><br>

<div class="youtube">
  <div class="youtube-inner">
    <div class="youtube-content">

      <div class="youtube-video">
        <iframe width="100%" height="315"
          src="https://www.youtube.com/embed/<?php echo $videoId; ?>"   
          title="YouTube video player"
          frameborder="0"
          allowfullscreen>
        </iframe>
        <p class="video-subtext"><?php echo $videoTitle; ?></p>
      </div>

      <?php
      $stmt = $conn->prepare("
          SELECT TOP 1 * 
          FROM paginaweb_nic_sobre_inicio
          WHERE seccion='youtube_home'
          ORDER BY id ASC
      ");
      $stmt->execute();
      $youtube = $stmt->fetch(PDO::FETCH_ASSOC);
      ?>

      <div class="youtube-right">
        <div class="youtube-text-wrapper">
          <div class="youtube-text">
            <h2>
              <?= nl2br($youtube['titulo'] ?? "VISUALIZÁ NUESTROS\nSORTEOS EN YOUTUBE\nLOS 365 DÍAS DEL AÑO") ?>
            </h2>
          </div>
          <div class="youtube-info">
            <p><?= $youtube['texto'] ?? "Sintonizá en vivo los sorteos..." ?></p>
          </div>
          <div class="boton-container">
            <a href="<?= $youtube['link_url'] ?? '#' ?>" target="_blank">
              <button class="youtube-boton">Ver más sorteos</button>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div style="height: 50px;"></div>

<?php
$stmt = $conn->prepare("
    SELECT TOP 1 * 
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion='banner_superpremio'
    ORDER BY id ASC
");
$stmt->execute();
$superpremio = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<a href="<?= $superpremio['link_url'] ?? 'https://juega.loto.sv/' ?>" target="_blank">
  <div class="banner-superpremio" style="width: 100%; max-width: 1700px; margin: 0 auto;">
    <img 
      src="<?= $superpremio['imagen_url'] ?? '/ImagesSV/Banner Sp.gif' ?>" 
      alt="Banner Superpremio"
      style="width: 100%; height: auto; border-radius: 16px; display: block; margin: 0 auto;"
    >
  </div>
</a>

<?php
$stmt = $conn->prepare("
    SELECT TOP 1 * 
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion='banner_apostemos'
    ORDER BY id ASC
");
$stmt->execute();
$apostemos = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<a href="<?= $apostemos['link_url'] ?? 'https://juega.loto.sv/fob/' ?>" target="_blank">
  <div style="width: 100%; max-width: 1700px; text-align: center; margin: 80px auto 20px auto; cursor: pointer;">
    <img 
      src="<?= $apostemos['imagen_url'] ?? '/ImagesSV/banner principal.jpg' ?>" 
      alt="Banner Apostemos" 
      style="width: 100%; max-width: 100%; height: auto; border-radius: 16px; display: inline-block;"
    >
  </div>
</a>

<?php
$stmt = $conn->prepare("
    SELECT * FROM paginaweb_nic_sobre_inicio 
    WHERE seccion='noticias_home' 
    ORDER BY orden ASC
");
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="height: 50px;"></div>

<div class="noticias-box">
  <div class="noticias-left">
    <h3>Noticias relevantes</h3>
    <button class="noticias-boton" onclick="window.location.href='index.php?pag=noticias';">
      Ver más noticias
    </button>
  </div>

  <div class="noticias-right">
    <div class="carousel">
      <?php foreach($noticias as $n): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($n['imagen_url']); ?>" alt="Noticia">
          <div class="card-content">
            <h4><?= htmlspecialchars($n['titulo']); ?></h4>
            <p><?= nl2br(htmlspecialchars($n['texto'] ?? '')); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const noticiasBox = document.querySelector('.noticias-box');
  const carousel = noticiasBox.querySelector('.carousel');
  const next = noticiasBox.querySelector('.next');
  const prev = noticiasBox.querySelector('.prev');
  let index = 0;

  function getVisibleCards() {
    return window.innerWidth <= 768 ? 1 : 3;
  }

  function moveCarousel() {
    const card = document.querySelector('.card');
    if (!card) return;
    const gap = 20;
    const cardWidth = card.offsetWidth + gap;
    carousel.style.transform = `translateX(${-index * cardWidth}px)`;
  }

  next.addEventListener('click', () => {
    const visibleCards = getVisibleCards();
    const maxIndex = carousel.children.length - visibleCards;
    if (index < maxIndex) { index++; moveCarousel(); }
  });

  prev.addEventListener('click', () => {
    if (index > 0) { index--; moveCarousel(); }
  });

  window.addEventListener('resize', () => {
    index = 0;
    moveCarousel();
  });
});
</script>

<div style="height: 50px;"></div>

<?php
$stmt = $conn->prepare("
    SELECT TOP 1 * 
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion='rse_home'
    ORDER BY id ASC
");
$stmt->execute();
$rse = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="rse"> 
  <div class="rse-content">
    <div class="rse-text">
      <h2 class="numero" id="contador">0</h2>
      <p style="font-size:30px; font-weight:600; margin-left:25px;">
        <?= $rse['texto'] ?? 'DESDE 2023 HASTA 2025' ?>
      </p>
    </div>
    <div class="rse-image">
      <img 
        src="<?= $rse['imagen_url'] ?? '/ImagesSV/IMG_3933_00013.png' ?>" 
        alt="Imagen RSE">
    </div>
  </div>
  <div class="boton-container">
    <a href="index.php?pag=sobre_nosotros" class="rse-boton" style="text-decoration: none;">
      Conocé más
    </a>
  </div>
</div>

<script>
function animarContador(idElemento, valorFinal, duracion) {
  const elemento = document.getElementById(idElemento);
  let valorInicial = 0;
  const incremento = Math.ceil(valorFinal / (duracion / 30));
  const intervalo = setInterval(() => {
    valorInicial += incremento;
    if (valorInicial >= valorFinal) {
      valorInicial = valorFinal;
      clearInterval(intervalo);
    }
    elemento.textContent = "$" + valorInicial.toLocaleString("es-ES").replace(/\./g, ",");
  }, 30);
}
animarContador("contador", <?= $rse['titulo'] ?? 1962862 ?>, 2000);
</script>

<script>
window.addEventListener('scroll', function() {
  const box = document.querySelector('.resultados-box');
  if (window.scrollY > 0) {
    box.style.marginTop = "-40px";
  } else {
    box.style.marginTop = "0";
  }
});
</script>

<script>
var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
var mesesEnletras = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
var hoy = new Date();
var dia = hoy.getDate();
var hora = hoy.getHours();
var HoraSorteo = "";

if(hora < 11){
    HoraSorteo = "11";
} else if(hora >= 11 && hora < 21){
    HoraSorteo = "21";
} else if(hora >= 21){
    HoraSorteo = "11";
    dia += 1;
}

Number.prototype.padStart = function (n,str){
    return Array(n-String(this).length+1).join(str||'0')+this;
}

var fechaCompleta = diasSemana[hoy.getDay()] + " " + hoy.getDate() + " de " + mesesEnletras[hoy.getMonth()];
let countDown = new Date(hoy.getFullYear(), hoy.getMonth(), dia, HoraSorteo).getTime();

let x = setInterval(function() {
    let now = new Date().getTime();
    let distance = countDown - now;
    document.getElementById('hours').innerText = Math.floor((distance % day) / hour).padStart(2, "0");
    document.getElementById('minutes').innerText = Math.floor((distance % hour) / minute).padStart(2, "0");
    document.getElementById('seconds').innerText = Math.floor((distance % minute) / second).padStart(2, "0");
    document.getElementById('diaSorteo').innerText = fechaCompleta;
    if(distance <= 0){ clearInterval(x); }
}, second);
</script>

<script>
const slides = document.querySelectorAll('.hero-slide');
const prevBtn = document.querySelector('.carousel-btn.prev');
const nextBtn = document.querySelector('.carousel-btn.next');
let currentSlide = 0;

function showSlide(index) {
  slides.forEach(slide => slide.classList.remove('active'));
  slides[index].classList.add('active');
}

nextBtn.addEventListener('click', () => {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
});

prevBtn.addEventListener('click', () => {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  showSlide(currentSlide);
});
</script>

</body>
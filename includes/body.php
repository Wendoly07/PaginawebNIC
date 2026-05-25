<?php
// Inicia el bloque de código PHP para la conexión a la base de datos

try {
    // Intenta establecer la conexión a la base de datos SQL Server

    require_once __DIR__ . '/../config/connection.php';
    // Crea una instancia de PDO para conectar a la base de datos con manejo de excepciones

} catch(PDOException $e){
    // Captura cualquier error de conexión y termina el script con el mensaje de error

    $conn = null;
}
?>

<script>
// Script para cargar los resultados de Diaria desde la API

fetch('/api/resultado-diaria.php')
  // Realiza una solicitud fetch a la API de resultados de Diaria

  .then(response => response.json())
  // Convierte la respuesta a JSON

  .then(data => {
    // Maneja los datos recibidos

      if (!data.error) {
        // Si no hay error en los datos

      document.getElementById('par1').innerText = data.digito1;
      // Actualiza el elemento con ID 'par1' con el primer dígito

      document.getElementById('par2').innerText = data.digito2;
      if (document.getElementById('par3')) document.getElementById('par3').innerText = data.multi_x || '0';
      if (document.getElementById('par4')) document.getElementById('par4').innerText = data.mas_1 || '0';
      // Actualiza el elemento con ID 'par2' con el segundo dígito

    } else {
        // Si hay un error en los datos

      console.error('Error API:', data.error);
      // Registra el error en la consola

    }
  })
  .catch(error => {
    // Maneja errores de la solicitud fetch

    console.error('Error al cargar resultados:', error);
    // Registra el error en la consola

  });
</script>

<script>
// Script para cargar los resultados de Super Premio desde la API

document.addEventListener("DOMContentLoaded", async function() {
    // Espera a que el DOM esté completamente cargado antes de ejecutar

    try {
        // Intenta realizar la solicitud a la API

        const response = await fetch('/api/ultimo_resultado.php');
        // Realiza una solicitud fetch a la API de último resultado

        if (!response.ok) throw new Error('Error en la API');
        // Lanza un error si la respuesta no es OK

        const data = await response.json();
        // Convierte la respuesta a JSON

        console.log("Super Premio API:", data);
        // Registra los datos en la consola para depuración

        // Actualizamos las esferas
        for (let i = 1; i <= 5; i++) {
            // Itera sobre los 5 números del Super Premio

            const elem = document.getElementById('num' + i);
            // Obtiene el elemento con ID 'num' seguido del número

            if (elem) elem.innerText = data['par' + i] || '00';
            // Actualiza el texto del elemento con el valor correspondiente o '00' si no existe

        }

    } catch (err) {
        // Captura cualquier error

        console.error("No se pudo cargar el Super Premio:", err);
        // Registra el error en la consola

    }
});
</script>

<!-- POPUP PRINCIPAL-->
<?php if (!empty($popup['imagen_url'])): ?>
<div id="popupOverlay" class="popup-overlay">
  <div class="popup-content">
    <div class="popup-image-wrapper">
      <a href="<?= $popup['link_url'] ?>" target="_blank">
        <img src="<?= $popup['imagen_url'] ?>" alt="Popup principal">
      </a>
      <button class="popup-close" id="cerrarPopup">&times;</button>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
// Script para manejar el popup principal

document.addEventListener("DOMContentLoaded", function() {
    // Espera a que el DOM esté cargado

  const popup = document.getElementById("popupOverlay");
  // Obtiene el elemento del popup

  const cerrar = document.getElementById("cerrarPopup");
  // Obtiene el botón de cerrar

  // Activar popup al cargar
  popup.classList.add("active");
  // Agrega la clase 'active' para mostrar el popup

  // Cerrar con botón
  cerrar.addEventListener("click", function() {
    // Agrega evento click al botón cerrar

    popup.classList.remove("active");
    // Remueve la clase 'active' para ocultar el popup

  });

  // Cerrar si hacen click fuera de la imagen
  popup.addEventListener("click", function(e) {
    // Agrega evento click al popup

    if (e.target === popup) {
      // Si el click fue en el fondo del popup

      popup.classList.remove("active");
      // Oculta el popup

    }
  });
});
</script>

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

    /* FUENTE PARA TODA LA PÁGINA */
    body, h1, h2, h3, h4, h5, h6, p, button, a, span, div {
      font-family: 'HelveticaRounded', Arial, sans-serif !important;
    }

    .hero-carousel .hero,
    .hero-carousel .hero h1,
    .hero-carousel .hero .horarios,
    .hero-carousel .hero .boton {
      font-family: "Helvetica Rounded", "Helvetica Rounded Black", Arial, sans-serif !important;
    }

    /* ANIMACIÓN SUAVE PARA EL SCROLL */
    .resultados-box {
      transition: margin-top 0.3s ease !important;
    }

    .horarios {
    font-size: 22px;
    font-weight: bold;
    color: #0070c0; /* COLOR QUE PEDISTE */
    line-height: 1.5;
  }

  .boton {
    display: inline-block;
    background: white;
    border: 2px solid #0070c0;   /* CONTORNO ELEGANTE */
    color: #0070c0;
    padding: 12px 28px;
    margin-top: 15px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 12px;         /* MODERNO */
    text-decoration: none;
    transition: 0.3s ease;
    box-shadow: 0px 4px 10px rgba(0, 112, 192, 0.25); /* SOMBRA PREMIUM */
  }

  .boton:hover {
    background: #0070c0;         /* AZUL AL PASAR */
    color: white;                /* TEXTO BLANCO */
    transform: translateY(-3px); /* EFECTO DE ELEVAR */
    box-shadow: 0px 8px 18px rgba(0, 112, 192, 0.40);
  }

  .resultados-header h2 {
    font-size: 34px;        /* Más grande */
    font-weight: 900;       /* Bold máximo */
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
/* Contenedor de resultados */
.resultados-box {
  padding: 40px 20px;
  background-color: #f9f9f9;
  border-radius: 16px;
  box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
  max-width: 1200px;
  margin: 0 auto 50px auto;
  transition: margin-top 0.3s ease;
}

/* Título */
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
.resultados-carousel {
  position: relative;
  display: flex;
  align-items: center;
  overflow: visible;
  gap: 20px;
  padding: 0 56px 10px;
  box-sizing: border-box;
}

.res-cards {
  display: flex;
  justify-content: flex-start !important;
  gap: 20px;
  width: 100%;
  min-width: 0;
  overflow-x: auto;
  scroll-behavior: smooth;
  scrollbar-width: none;
  scroll-snap-type: x mandatory;
}

.res-cards::-webkit-scrollbar {
  display: none;
}

.res-prev,
.res-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 46px;
  height: 46px;
  border: none;
  border-radius: 50%;
  background: #ff7e00;
  color: white;
  cursor: pointer;
  font-size: 26px;
  font-weight: bold;
  z-index: 20;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 6px 16px rgba(0,0,0,0.28);
  transition: background 0.3s ease, transform 0.3s ease;
}

.res-prev {
  left: 0;
}

.res-next {
  right: 0;
}

.res-prev:hover,
.res-next:hover {
  background: #ff5500;
  transform: translateY(-50%) scale(1.08);
}

/* Tarjetas */
.res-card {
  background-color: white;
  border-radius: 16px;
  box-shadow: 0px 6px 15px rgba(0,0,0,0.15);
  flex: 0 0 250px;
  padding: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
}

.res-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 12px 25px rgba(0,0,0,0.25);
}

.res-card.verde {
  background-color: #76b82a;
  color: white;
}

.res-card.verde .btn-jugar {
  background-color: white;
  color: #76b82a;
  font-weight: bold;
}

.res-card.verde .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

/* Imagen dentro de la tarjeta */
.res-card img {
  width: 100%;
  border-radius: 12px;
  margin-bottom: 10px;
}

/* Números / esferas */
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

.bola-diaria {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  border-radius: 50%;
  font-weight: 900;
  font-size: 20px;
  color: #000;
}

.bola-diaria.amarilla {
  background-color: #ffdf00;
}

.bola-diaria.naranja {
  background-color: #f59a55;
}

.diaria-bola-grupo {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
}

.diaria-bola-grupo.sin-label::before {
  content: "";
  height: 12px;
}

.diaria-bola-label {
  height: 12px;
  line-height: 12px;
  font-size: 11px;
  font-weight: 900;
  color: #000;
  text-transform: uppercase;
}

.res-card.verde .diaria-numeros {
  align-items: flex-end;
  flex-wrap: nowrap;
  gap: 4px;
  margin-bottom: 15px;
}

.res-card.verde .diaria-bola-grupo {
  flex: 0 0 auto;
}

.res-card.verde .bola-diaria {
  width: 35px;
  height: 35px;
  min-width: 35px;
  line-height: 35px;
  aspect-ratio: 1 / 1;
  border-radius: 50%;
  font-size: 17px;
}

.res-card.verde .diaria-bola-label {
  font-size: 9px;
  height: 11px;
  line-height: 11px;
  white-space: nowrap;
}

.res-card.verde .diaria-card-numeros {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 4px;
  margin: 12px 0 15px;
  flex-wrap: nowrap;
}

.res-card.verde .diaria-card-grupo {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  gap: 3px;
  padding: 0;
  margin: 0;
  width: auto;
  height: auto;
  min-width: 0;
  background: transparent !important;
  border: 0 !important;
  border-radius: 0 !important;
  box-shadow: none !important;
}

.res-card.verde .diaria-card-label {
  display: block;
  height: 11px;
  line-height: 11px;
  font-size: 8px;
  font-weight: 900;
  color: #000;
  text-transform: uppercase;
  white-space: nowrap;
}

.res-card.verde .diaria-card-label.vacio {
  visibility: hidden;
}

.res-card.verde .diaria-card-bola {
  display: inline-block;
  width: 39px;
  height: 39px;
  min-width: 39px;
  line-height: 39px;
  aspect-ratio: 1 / 1;
  text-align: center;
  border-radius: 50%;
  border: 0;
  font-weight: 900;
  font-size: 18px;
  color: #111;
  padding: 0;
  margin: 0;
  box-shadow: none;
}

.res-card.verde .diaria-card-bola.amarilla {
  background: #ffdf00;
}

.res-card.verde .diaria-card-bola.naranja {
  background: #f59a55;
}

/* Mantener botones tal como los tenías antes */
.btn-container {
  display: flex;
  justify-content: center;
  gap: 10px;
}

/* Scroll horizontal */
.resultados-carousel::-webkit-scrollbar {
  height: 8px;
}

.resultados-carousel::-webkit-scrollbar-thumb {
  background: rgba(0,0,0,0.2);
  border-radius: 4px;
}

.resultados-carousel::-webkit-scrollbar-track {
  background: transparent;
}

/* Texto PRÓXIMO SORTEO */
.proximo {
  font-size: 26px;
  font-weight: 900;
  text-align: center;
  color: #003399;
  margin-top: 25px;
}

.youtube-video {
  flex: 1 1 500px;
  max-width: 700px;
  margin-left: -30px; /* Mueve solo el video 3 cm a la izquierda */
  margin-top: -80px;  /* Subir el video 2 cm más hacia arriba */
  border-radius: 15px; /* Redondea las esquinas del video */
}
.youtube-video iframe {
  width: 100%;
  height: 315px;
  border-radius: 15px; /* Redondea las esquinas del iframe */
}

.youtube-right {
  flex: 0 0 auto;
  min-width: 300px;
  max-width: 500px;
  position: relative;

  display: flex;
  flex-direction: column;
  align-items: center; /* Centra todo el contenido dentro de este bloque */
}

.boton-container {
  display: flex;
  justify-content: center; /* centra horizontalmente el botón */
  width: 100%;             /* ocupa todo el ancho del contenedor */
  margin-top: 20px;        /* separación del texto */
}

.youtube-right .boton-container {
  align-self: center;
  justify-content: center;
  width: 100%;
  margin-top: 0;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  position: absolute;
  top: 275px;
  left: 50%;
  transform: translateX(-50%);
}

.youtube-right .boton-container a {
  display: inline-flex;
  justify-content: center;
  text-decoration: none;
}

.youtube-boton {
  background: #ff7e00;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 30px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

.youtube-boton:hover {
  transform: scale(1.05);
  background: #e68928; /* Fondo naranja más oscuro cuando el botón es hover */
}

/* Texto semi-bold */
.youtube-info p {
  font-weight: 600;      /* semi-bold */
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

/* Responsive */
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
/* ===== FIX RSE SOLO MOBILE ===== */
@media (max-width: 768px) {

  /* Apilamos todo vertical */
  .rse-content {
    display: block !important; /* cambiamos a block para móvil */
    text-align: center;        /* centra todo horizontalmente */
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
    left: -10px;  /* mueve un poco a la izquierda */
    top: 10px;    /* baja un poquito */
  }
}

/* ===== HERO RESPONSIVE MÓVIL ===== */
@media (max-width: 768px) {

  .hero {
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    padding: 24px 16px 20px !important;
    min-height: auto !important;
    gap: 16px !important;
    width: 100% !important;
    margin: 0 auto !important;
  }

  .texto-hero {
    order: 1 !important;
    width: 100% !important;
    margin-left: 0 !important;
    text-align: center !important;
  }

  .texto-hero h1 {
    font-size: 1.3rem !important;
    line-height: 1.3 !important;
  }

  .texto-hero .horarios {
    font-size: 1rem !important;
    margin: 8px 0 !important;
  }

  .texto-hero .boton {
    font-size: 0.95rem !important;
    padding: 10px 20px !important;
  }

  /* Conductora debajo del texto, no superpuesta */
  .hero img:not(.esfera) {
    order: 2 !important;
    position: relative !important;
    left: auto !important;
    right: auto !important;
    transform: none !important;
    width: min(220px, 60vw) !important;
    max-width: 60vw !important;
    height: auto !important;
    margin: 0 auto !important;
    display: block !important;
  }

  /* Esferas pequeñas */
  .hero .esfera {
    width: 26px !important;
    height: 26px !important;
  }

  .hero .esfera:nth-of-type(1) { top: 55% !important; left: 72% !important; }
  .hero .esfera:nth-of-type(2) { top: 78% !important; left: 8% !important; }
  .hero .esfera:nth-of-type(3) { top: 73% !important; left: 84% !important; }
}

@media (max-width: 768px) {

  /* Evitar que la imagen se estire */
  .hero img:not(.esfera) {
    flex: 1 1 55%;
    max-width: 100%;
    height: auto !important; /* asegura proporciones correctas */
    object-fit: contain; /* mantiene proporción */
    display: block !important;
    margin: 0 auto;
    position: relative;
  }

  .esfera:nth-of-type(1) { top: 18% !important; left: 62% !important; }
  .esfera:nth-of-type(2) { top: 74% !important; left: 16% !important; }
  .esfera:nth-of-type(3) { top: 70% !important; left: 77% !important; }
}

/* ===== RESPONSIVE MÓVIL SOLO RESULTADOS-BOX ===== */
@media (max-width: 761px) {

  /* Ajuste del contenedor principal */
  .resultados-box {
    padding: 20px 10px;
    max-width: 95%;
  }

  /* Título centrado y más pequeño */
  .resultados-header h2 {
    font-size: 24px !important;
    line-height: 1.2;
    text-align: center;
  }

  #fecha-api {
    font-size: 20px !important;
  }

  /* Carrusel apilado verticalmente */
  .resultados-carousel {
    flex-direction: column !important;
    gap: 15px !important;
  }

  .res-cards {
    flex-direction: column !important;
    gap: 15px !important;
  }

  /* Tarjetas más anchas y centradas */
  .res-card {
    width: 90% !important;
    max-width: 90% !important;
    margin: 0 auto !important;
  }

  /* Imagen dentro de tarjeta */
  .res-card img {
    width: 70% !important;
    height: auto !important;
    margin: 0 auto !important;
    display: block !important;
  }

  /* Números centrados y más pequeños */
  .numeros {
    justify-content: center !important;
    gap: 5px !important;
  }

  .bola-verde, .bola-amarilla, .res-card.verde .bola-diaria {
    width: 35px !important;
    height: 35px !important;
    line-height: 35px !important;
    font-size: 16px !important;
  }

  .res-card.verde .diaria-numeros {
    gap: 4px !important;
    flex-wrap: nowrap !important;
  }

  .res-card.verde .diaria-bola-label {
    font-size: 8px;
  }

  /* Botones apilados y centrados */
  .btn-container {
    flex-direction: column !important;
    gap: 8px !important;
  }

  .btn-jugar, .btn-info {
    font-size: 14px !important;
    padding: 8px 12px !important;
  }

  /* Próximo sorteo más pequeño */
  .proximo {
    font-size: 20px !important;
  }

  #diaSorteo {
    font-size: 14px !important;
  }
}
@media (max-width: 768px) {
  /* Hacer tarjetas un poco más altas para que quepa el botón */
  .res-card {
    min-height: 320px !important; /* ajusta este valor según necesites */
  }
}

@media (max-width: 768px) {
  /* Asegurar que las tarjetas se expandan según su contenido */
  .res-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* fuerza que el contenido y los botones queden dentro */
    min-height: auto; /* elimina la altura fija si existía */
    padding-bottom: 20px; /* espacio extra para los botones */
  }

  /* Mantener los botones centrados y del mismo tamaño */
  .res-card .btn-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-shrink: 0; /* evitar que se compriman */
  }

  .res-card .btn-container button {
    width: 120px; /* mismo ancho para ambos botones */
    padding: 10px 0; /* altura uniforme */
    font-size: 16px;
  }
}

@media (max-width: 768px) {

  /* HACER LAS TARJETAS MÁS ALTAS */
  .res-card {
    min-height: 420px !important; /*  AJUSTÁ ESTE NÚMERO SI QUERÉS MÁS ALTO */
  }

  /* FORZAR BOTONES DENTRO DE LA TARJETA */
  .btn-container {
    margin-top: auto; /* ESTO ES LA CLAVE */
  }

  /* BOTONES MISMO TAMAÑO */
  .btn-jugar,
  .btn-info {
    width: 100%;
    max-width: 180px;
  }
}

@media (max-width: 768px) {

  /* BOTONES A LA PAR */
  .res-card .btn-container {
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center;
    gap: 10px;
  }

  /* MISMO TAMAÑO */
  .res-card .btn-jugar,
  .res-card .btn-info {
    width: 140px;
    padding: 10px 0;
  }
}

@media (max-width: 768px) {
  .resultados-carousel {
    padding: 0 48px 10px !important;
  }

  .resultados-carousel .res-cards {
    flex-direction: row !important;
    gap: 15px !important;
  }

  .res-prev,
  .res-next {
    width: 40px;
    height: 40px;
    font-size: 22px;
  }
}

@media (max-width: 768px) {
  #jackpot-num-banner {
    font-size: 32px !important; /* tamaño móvil */
    left: 55% !important;       /* opcional: lo centra mejor */
  }
}

@media (max-width: 768px) {
  #jackpot-num-banner {
    font-size: 24px !important;   /* MUCHO más pequeño */
    left: 75% !important;         /* lo centra horizontalmente */
    transform: translate(-50%, -50%) !important; /* centra perfecto */
    top: 50% !important;
    white-space: nowrap;          /* evita que se parta */
  }
}

/* Ajuste final del home: resultados y noticias */
.resultados-carousel {
  overflow: hidden;
}

.resultados-carousel .res-cards {
  overflow: hidden;
}

@media (min-width: 769px) {
  .resultados-carousel .res-card {
    flex: 0 0 250px;
    max-width: 250px;
  }
}

@media (max-width: 768px) {
  .resultados-box {
    width: calc(100% - 20px) !important;
    padding: 28px 10px 0 !important;
    overflow: hidden;
  }

  .resultados-carousel {
    width: 100%;
    padding: 0 42px 10px !important;
    overflow: hidden;
  }

  .resultados-carousel .res-cards {
    width: 100% !important;
    max-width: 100% !important;
    overflow: hidden !important;
    gap: 0 !important;
  }

  .resultados-carousel .res-card {
    flex: 0 0 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    margin: 0 !important;
  }

  .res-prev {
    left: 8px;
  }

  .res-next {
    right: 8px;
  }

  .noticias-box .card-content p {
    display: none;
  }
}

/* ===== NOTICIAS RESPONSIVE MOVIL ===== */
@media (max-width: 768px) {

  /* Contenedor general */
  .noticias-box {
    flex-direction: column;
    padding: 20px 10px;
  }

  /* Columna izquierda arriba */
  .noticias-left {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
  }

  .noticias-left h3 {
    font-size: 22px;
  }

  .noticias-boton {
    margin-top: 10px;
  }

  /* Carrusel ocupa todo el ancho */
  .noticias-right {
    width: 100%;
    position: relative;
  }

  /* Carrusel horizontal con scroll */
  .carousel {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 10px;
  }

  .carousel::-webkit-scrollbar {
    display: none; /* limpio en móvil */
  }

  /* Cards más grandes para dedo */
  .card {
    min-width: 85%;
    flex: 0 0 auto;
  }

  /* Flechas visibles y usables */
  .prev,
  .next {
    position: absolute;
    top: 45%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    font-size: 28px;
    padding: 10px 14px;
    border-radius: 50%;
    z-index: 10;
    cursor: pointer;
  }

  .prev {
    left: 5px;
  }

  .next {
    right: 5px;
  }
}

@media (max-width: 768px) {

  /* Contenedor principal */
  .noticias-box {
    flex-direction: column;
  }

  /* Columna izquierda */
  .noticias-left {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
  }

  /* Parte derecha */
  .noticias-right {
    width: 100%;
    position: relative;
  }

  /* Carrusel se vuelve columna */
  .carousel {
    display: flex;
    flex-direction: column;
    gap: 20px;
    transform: none !important;
  }

  /* Cada noticia ocupa todo el ancho */
  .carousel .card {
    min-width: 100%;
    max-width: 100%;
  }

  /* OCULTAMOS FLECHAS EN MÓVIL */
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

  .hero img[src="/ImagesSV/conductora.png"] {
    position: relative;
    left: 0 !important;
    transform: none !important;
  }

}

/* SOLO MÓVIL */
@media (max-width: 768px) {
  .rse-content {
    display: flex;
    flex-direction: column; /* apila verticalmente */
    align-items: center;    /* centra el texto horizontalmente */
  }

  .rse-text {
    order: 1;
    text-align: center;
    margin-bottom: 15px;
  }

  .rse-image {
    order: 2;
    align-self: center;
    margin-left: 0;
    transform: none;
  }

  .rse-image img {
    width: auto;
    max-width: 88%;
    height: auto;
    display: block;
    margin: 0 auto;
  }
}

/* ===== AJUSTE BANNERS SOLO MÓVIL ===== */
@media (max-width: 768px) {

  /* Contenedor general de banners (si existe) */
  .banner-container,
  .banner-superpremio,
  .banner-apostemos {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }

  /* Imágenes de banners */
  .banner-container img,
  .banner-superpremio img,
  .banner-apostemos img {
    display: block;
    margin: 0 auto !important;
  }

}
/* ===== AJUSTE ESPACIOS BANNERS SOLO MÓVIL ===== */
@media (max-width: 768px) {

  /* Reduce los espacios en blanco forzados */
  div[style*="height: 50px"] {
    height: 15px !important; /* antes 50px */
  }

  /* Banner Superpremio */
  .banner-superpremio {
    margin-top: 18px !important;
    margin-bottom: 10px !important;
  }

  /* Banner Apostemos (el que tiene margin 80px) */
  a[href*="juega.loto.sv/fob"] > div {
    margin: 20px auto 10px auto !important; /* antes 80px */
  }

  /* Imágenes sin espacios raros */
  .banner-superpremio img,
  a[href*="juega.loto.sv/fob"] img {
    display: block;
    margin: 0 auto !important;
  }
}

/* Ajuste solo móvil para la sección YouTube */
@media (max-width: 768px) {
  .youtube-content {
    flex-direction: column !important; /* apilar video y texto */
    align-items: center !important;    /* centrar horizontalmente */
    gap: 15px !important;              /* espacio uniforme */
  }

  .youtube-video {
    width: 95% !important;             /* deja un pequeño margen a los lados */
    margin: 0 auto !important;         /* centrar */
  }

  .youtube-right {
    width: 95% !important;             /* mismo ancho que el video */
    margin: 0 auto !important;         /* centrar */
    text-align: center !important;     /* centrar texto y botón */
  }

  .youtube-text h2 {
    font-size: 20px !important;        /* reducir tamaño si es necesario */
    line-height: 1.3 !important;
  }

  .youtube-info p {
    font-size: 14px !important;        /* ajustar párrafos */
  }

  .boton-container {
    justify-content: center !important; /* centrar botón */
    margin-top: 10px !important;       /* separar un poco del texto */
  }

  .youtube-right .boton-container {
    position: static !important;
    transform: none !important;
    margin-top: 10px !important;
  }
}

@media (max-width: 768px) {
  div[style*="height: 50px"] {
    height: 6px !important;
  }

  .youtube {
    margin-bottom: 6px !important;
  }

  .youtube-inner {
    padding-bottom: 0 !important;
  }

  .youtube-video {
    margin-bottom: 0 !important;
  }

  .youtube-right {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  /* ajuste lateral fino */
  .youtube-video,
  .youtube-right {
    margin-left: auto !important;
    margin-right: auto !important;
  }

  /* espacio después de TODA la sección (para que no se pegue a banners) */
  .youtube {
    margin-bottom: 6px !important;
  }

  .youtube-inner {
    padding-bottom: 0 !important;
  }
}
@media (max-width: 768px) {

  .video-subtext {
    margin-bottom: 0 !important;
  }

  .youtube-video,
  .youtube-right {
    margin-left: auto !important;
    margin-right: auto !important;
  }

  .youtube {
    margin-bottom: 6px !important;
  }

}

.hero-carousel {
  position: relative;
  overflow: visible;
  margin-top: -18px !important;
  padding-top: 0 !important;
}

.hero-slide {
  display: none;
  margin-top: 0 !important;
}

.hero-slide.active {
  display: block;
}

.hero-carousel .hero {
  margin-top: 0 !important;
}

@media (min-width: 769px) {
  .hero-carousel .hero {
    min-height: 470px !important;
    padding: 58px 5% 64px !important;
    align-items: center !important;
  }

  .hero-carousel .texto-hero {
    margin-left: 80px !important;
    max-width: 650px !important;
    transform: translateY(28px);
  }

  .hero-carousel .texto-hero h1 {
    font-size: 55px !important;
    line-height: 1.3 !important;
  }

  .hero-carousel .texto-hero .horarios {
    font-size: 41px !important;
    line-height: 1.5 !important;
  }

  .hero-carousel .hero img[src="/ImagesSV/conductora.png"] {
    max-height: 400px !important;
    transform: translate(-34px, 28px);
  }
}

/* Flechas */
/* Flechas modernas */
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

/* Posición */
.carousel-btn.prev {
  left: 20px;
}

.carousel-btn.next {
  right: 20px;
}

/* Hover elegante */
.carousel-btn:hover {
  background: rgba(0, 0, 0, 0.75);
  transform: translateY(-50%) scale(1.1);
}

/* Click */
.carousel-btn:active {
  transform: translateY(-50%) scale(0.95);
}

/* Evita que los banners tapen las flechas */
.hero-slide a,
.hero-slide img {
  z-index: 1;
  position: relative;
}

/* Flechas siempre encima */
.carousel-btn {
  z-index: 10000;
  pointer-events: auto;
}

/* Mobile */
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

/* ===== POPUP NEGRO ===== */
/* ===== POPUP NEGRO MEJORADO ===== */
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

/* Tarjeta Dobletea tu Suerte */
.res-card.naranja {
  background-color: #EF6C00;
  border-radius: 20px;
  padding: 20px;
  text-align: center;
  color: white;
}

/* Contenedor de números */
.numeros {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 15px;
}

/* Bolas grises */
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
  box-shadow:
    inset -3px -3px 6px rgba(0,0,0,0.15),
    inset 3px 3px 6px rgba(255,255,255,0.6),
    2px 2px 5px rgba(0,0,0,0.2);
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
/* premiado2 Card */
.res-card.morado-premiado {
  background-color: #6E2479;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
  width: 200px;
  height: 360px;
  flex: 0 0 250px;
}
.res-card.morado-premiado .btn-jugar {
  background-color: white;
  color: #6e2479;
  font-weight: bold;
}
.res-card.morado-premiado .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}
/* Lot Dates Card */
.res-card.rojo-fechas {
  background-color: #e30613;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
  width: 200px;
  height: 360px;
  flex: 0 0 250px;
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
  color: #e30613;
  font-weight: bold;
}

.res-card.rojo-fechas .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}


/* Lot jugatres Card */
.res-card.azul-jugatres {
  background-color: #00abe4;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
  width: 200px;
  height: 360px;
  flex: 0 0 250px;
}

.res-card.magenta-jugacuatro {
  background:  #9e1e5c;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
  width: 200px;
  height: 360px;
  flex: 0 0 250px;
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

.res-card.marino-terminacion2 {
  background-color: #006a9a;
  border-radius: 15px;
  padding: 15px;
  text-align: center;
  color: white;
  width: 200px;
  height: 360px;
  flex: 0 0 250px;
}
.res-card.marino-terminacion2 .btn-jugar {
  background-color: white;
  color: #006a9a;
  font-weight: bold;
}

.res-card.marino-terminacion2 .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}
.res-card.azul-jugatres .btn-jugar {
  background-color: white;
  color: #00abe4;
  font-weight: bold;
}

.res-card.azul-jugatres .btn-info {
  background-color: rgba(255,255,255,0.2);
  color: white;
  border: 1px solid white;
}

.res-card.magenta-jugacuatro .btn-jugar {
  background-color: white;
  color: #9e1e5c;
  font-weight: bold;
}

.res-card.magenta-jugacuatro .btn-info {
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
  min-width: 0;
  flex: 0 0 calc((100% - 40px) / 3);
}

@media (min-width: 769px) {
  .noticias-box .noticias-right .carousel {
    width: 100%;
    gap: 16px;
  }

  .noticias-box .noticias-right .carousel .card {
    flex: 0 0 calc((100% - 32px) / 3) !important;
    width: calc((100% - 32px) / 3) !important;
    min-width: 0 !important;
    max-width: none !important;
  }
}

/*  DESCRIPCIÓN */
.card-content {
  padding: 10px;
}

.card-content h4 a {
  color: inherit;
  text-decoration: none;
}

.card-content p {
  display: block !important;
  font-size: 14px;
  color: #333;
  margin-top: 5px;

  /* opcional: limitar a 3 líneas */
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3; /* Propiedad estándar para compatibilidad */
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.card-content p {
  color: #fff;
}

@media (max-width: 768px) {
  .noticias-box .noticias-right .carousel .card .card-content p {
    display: none !important;
  }

  .noticias-box .noticias-right .carousel .card {
    height: auto !important;
  }
}

.res-card .btn-container a {
  display: inline-flex;
  text-decoration: none;
}

.res-card .btn-jugar,
.res-card .btn-info {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  overflow: hidden;
  isolation: isolate;
  border-radius: 16px;
  transform: translateY(0);
  transition:
    transform 0.22s ease,
    box-shadow 0.22s ease,
    filter 0.22s ease,
    background-color 0.22s ease,
    color 0.22s ease;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.16);
}

.res-card .btn-jugar::before,
.res-card .btn-info::before {
  content: "";
  position: absolute;
  inset: -30% auto -30% -70%;
  width: 52%;
  background: linear-gradient(115deg, transparent, rgba(255,255,255,0.75), transparent);
  transform: skewX(-18deg);
  transition: left 0.45s ease;
  z-index: -1;
}

.res-card .btn-jugar:hover,
.res-card .btn-info:hover {
  transform: translateY(-3px) scale(1.04);
  filter: brightness(1.05);
  box-shadow: 0 9px 18px rgba(0, 0, 0, 0.26);
}

.res-card .btn-jugar:hover::before,
.res-card .btn-info:hover::before {
  left: 120%;
}

.res-card .btn-jugar:active,
.res-card .btn-info:active {
  transform: translateY(0) scale(0.97);
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
}

.res-card .btn-jugar:focus-visible,
.res-card .btn-info:focus-visible {
  outline: 3px solid rgba(255,255,255,0.75);
  outline-offset: 3px;
}

.res-card .bola-blanca,
.res-card .bola-mes-amarilla,
.res-card .bola-verde,
.res-card .bola-amarilla,
.res-card .bola-diaria,
.res-card .diaria-card-bola {
  box-shadow:
    inset -3px -3px 6px rgba(0,0,0,0.16),
    inset 3px 3px 6px rgba(255,255,255,0.45),
    2px 3px 6px rgba(0,0,0,0.22) !important;
}
  </style>

  <div style="display:none;"></div>

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

  <!-- Flechas -->
  <button class="carousel-btn prev">&#10094;</button>
  <button class="carousel-btn next">&#10095;</button>

  <div class="hero-slide active">
    <!-- HERO ORIGINAL (NO SE TOCA) -->
    <div class="hero" style="position: relative;">
      <div class="texto-hero">
        <h1>SINTONIZÁ EL PRÓXIMO SORTEO EN VIVO</h1>
<div class="horarios">
  12:00 PM, 3:00 PM,<br>
  6:00 PM y 9:00 PM
</div>
        <a href="https://www.youtube.com/@LotoNicaragua" class="boton">
          MÍRALO AQUÍ >
        </a>
      </div>

      <img src="/ImagesSV/conductora.png" alt="Conductora">

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
$CHANNEL_ID = "UCwnJv1k2PKCpJeJWrtSaQPg";
$rss_url = "https://www.youtube.com/feeds/videos.xml?channel_id=$CHANNEL_ID";

$videoDate = "Cargando...";

$rss = simplexml_load_file($rss_url);

if ($rss && isset($rss->entry[0])) {
    $videoTitle = (string)$rss->entry[0]->title;

    // Buscar un patrón de fecha en el título (ejemplo: 29 de Diciembre 2025, 11:00 A.M.)
    if (preg_match('/\d{1,2}\s*de\s*\w+\s*\d{4},?\s*\d{1,2}:\d{2}\s*(?:A\.M\.|P\.M\.|AM|PM)/i', $videoTitle, $matches)) {
        $videoDate = $matches[0]; // Extrae solo: 29 de Diciembre 2025, 11:00 A.M.
    } else {
        $videoDate = "Fecha no disponible";
    }
}
?>
  <div class="resultados-box">
  <!-- Título -->
  <div class="resultados-header">
    <h2>
      <span class="titulo-naranja">ÚLTIMOS RESULTADOS,</span>
      <span class="titulo-azul" id="fecha-api" style="font-size: 45px; color: #fff; font-family: 'HelveticaRounded', Arial, sans-serif; font-weight:795;">
  <?php echo $videoDate; ?>
</span>
    </h2>
    <br>
    <?php
$logoFechasLotos = '/ImagesSV/LOGO FECHAS LOTOS.png.png';
$logoDiaria = '/ImagesSV/LOGO DIARIA.svg';
$logoJugaTres = '/ImagesSV/LOGOJUGATRES.png';
$logoJugaCuatro = '/ImagesSV/Logo Juga4 - LOTO NIC- 2025.png';
$logoPremiado = '/ImagesSV/Premiado2.png';
$logoTerminacion2 = '/ImagesSV/logo terminacion2.png';

try {
    $stmt = $conn->prepare("
        SELECT
            (SELECT logo FROM paginaweb_nic_fechas_loto WHERE id = 1) AS fechas_lotos,
            (SELECT logo FROM paginaweb_nic_diaria WHERE id = 1) AS diaria,
            (SELECT logo FROM paginaweb_nic_juga_tres WHERE id = 1) AS juga_tres,
            (SELECT logo FROM paginaweb_nic_premiado WHERE id = 1) AS premiado,
            (SELECT logo FROM paginaweb_nic_terminacion2 WHERE id = 1) AS terminacion2
    ");
    $stmt->execute();
    $logos = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $logoFechasLotos = !empty($logos['fechas_lotos']) ? $logos['fechas_lotos'] : $logoFechasLotos;
    $logoDiaria = !empty($logos['diaria']) ? $logos['diaria'] : $logoDiaria;
    $logoJugaTres = !empty($logos['juga_tres']) ? $logos['juga_tres'] : $logoJugaTres;
    $logoPremiado = !empty($logos['premiado']) ? $logos['premiado'] : $logoPremiado;
    $logoTerminacion2 = !empty($logos['terminacion2']) ? $logos['terminacion2'] : $logoTerminacion2;
} catch (Throwable $e) {
    // Mantener logos locales si falla la consulta de logos.
}
?>

<!-- Carrusel -->
<div class="resultados-carousel">
  <button class="res-prev" type="button" aria-label="Resultados anteriores">&#10094;</button>
  <div class="res-cards">
        <!-- Diaria (Verde) -->
    <div class="res-card verde">
      <img src="<?= htmlspecialchars($logoDiaria) ?>"
           alt="Logo Diaria"
           style="width:190px; height:auto; position: relative; top:20px;">

      <div class="diaria-card-numeros">
        <div class="diaria-card-grupo">
          <span class="diaria-card-label vacio">MULTI-X</span>
          <span class="diaria-card-bola amarilla" id="par1">0</span>
        </div>
        <div class="diaria-card-grupo">
          <span class="diaria-card-label vacio">MAS 1</span>
          <span class="diaria-card-bola amarilla" id="par2">0</span>
        </div>
        <div class="diaria-card-grupo con-label">
          <span class="diaria-card-label">MULTI-X</span>
          <span class="diaria-card-bola naranja" id="par3">0</span>
        </div>
        <div class="diaria-card-grupo con-label">
          <span class="diaria-card-label">MAS 1</span>
          <span class="diaria-card-bola naranja" id="par4">0</span>
        </div>
      </div>

      <script>
      async function cargarResultados() {
          try {
              const response = await fetch('/api/resultado-diaria.php');
              if (!response.ok) throw new Error('Error en la respuesta de la API');
              const data = await response.json();

              document.getElementById('par1').innerText = data.digito1 || '0';
              document.getElementById('par2').innerText = data.digito2 || '0';
              document.getElementById('par3').innerText = data.multi_x || '0';
              document.getElementById('par4').innerText = data.mas_1 || '0';
          } catch (error) {
              console.error('No se pudieron cargar los resultados:', error);
          }
      }
      cargarResultados();
      </script>

      <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jugá aquí
        </button>

        <a href="index.php?pag=diaria">
          <button class="btn-info">Conocé más</button>
        </a>
      </div>
    </div>
        <!-- Lotus Dates (Red) -->
    <div class="res-card rojo-fechas">
      <img src="<?= htmlspecialchars($logoFechasLotos) ?>"
           alt="Fechas Lotos"
           style="width:190px; height:auto; position:relative; top:20px;">

      <div class="numeros" style="position:relative; top:15px;">
        <span class="bola-blanca" id="fl-numero">--</span>
        <span class="bola-mes-amarilla" id="fl-mes">---</span>
      </div>

      <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jugá aquí
        </button>
        <a href="index.php?pag=fechas_lotos">
          <button class="btn-info">Conocé más</button>
        </a>
      </div>
    </div>

      <script>
      async function cargarResultadoFechasLotosCard() {
          try {
              const response = await fetch('/api/resultado-fechas-lotos.php');
              if (!response.ok) throw new Error('Error en la respuesta de la API');
              const data = await response.json();
              if (data.error) throw new Error(data.error);

              const card = document.querySelector('.res-card.rojo-fechas');
              const numero = card?.querySelector('#fl-numero');
              const mes = card?.querySelector('#fl-mes');

              if (numero) numero.innerText = data.numero || '--';
              if (mes) mes.innerText = data.mes || '---';
          } catch (error) {
              console.error('No se pudo cargar el resultado de Fechas Lotos:', error);
          }
      }
      cargarResultadoFechasLotosCard();
      </script>
  <!-- JUGA TRES (Blue) -->
    <div class="res-card azul-jugatres">
      <img src="<?= htmlspecialchars($logoJugaTres) ?>"
           alt="Juga Tres"
           style="width:190px; height:auto; position:relative; top:20px;">
      <div class="numeros" style="position:relative; top:15px;">
        <span class="bola-blanca" id="jt-numero-1">-</span>
        <span class="bola-blanca" id="jt-numero-2">-</span>
        <span class="bola-blanca" id="jt-numero-3">-</span>
      </div>
      <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jugá aquí
        </button>
        <a href="index.php?pag=juga_tres">
          <button class="btn-info">Conocé más</button>
        </a>
      </div>
    </div>
      <script>
      async function cargarResultadoJugaTresCard() {
          try {
              const response = await fetch('/api/resultado-juga-tres.php');
              if (!response.ok) throw new Error('Error en la respuesta de la API');
              const data = await response.json();
              if (data.error) throw new Error(data.error);

              const card = document.querySelector('.res-card.azul-jugatres');
              const valores = [data.par1, data.par2, data.par3];

              valores.forEach((valor, index) => {
                  const elem = card?.querySelector(`#jt-numero-${index + 1}`);
                  if (elem) elem.innerText = valor ?? '-';
              });
          } catch (error) {
              console.error('No se pudo cargar el resultado de Juga Tres:', error);
          }
      }
      cargarResultadoJugaTresCard();
      </script>
  <!-- JUGA CUATRO -->
    <div class="res-card magenta-jugacuatro">
      <img src="<?= htmlspecialchars($logoJugaCuatro) ?>"
           alt="Juga Cuatro"
           style="width:205px; height:auto; position:relative; top:12px;">
      <div class="numeros" style="position:relative; top:12px;">
        <span class="bola-blanca">-</span>
        <span class="bola-blanca">-</span>
        <span class="bola-blanca">-</span>
        <span class="bola-blanca">-</span>
      </div>
      <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jug&aacute; aqu&iacute;
        </button>
        <a href="index.php?pag=juga_cuatro">
          <button class="btn-info">Conoc&eacute; m&aacute;s</button>
        </a>
      </div>
    </div>
       <!-- Premiados 2 -->
    <div class="res-card morado-premiado">
      <img src="<?= htmlspecialchars($logoPremiado) ?>"
           alt="Logo Premiado2"
           style="width:190px; height:auto; position:relative; top:20px;">

      <div class="numeros" style="position:relative; top:15px;">
        <div class="nums">
        <span class="bola-blanca" id="premiado-numero-1">-</span>
        <span class="bola-blanca" id="premiado-numero-2">-</span>
        <span class="bola-mes-amarilla" id="premiado-numero-3">-</span>
        <span class="bola-mes-amarilla" id="premiado-numero-4">-</span>
        </div>
      </div>
            <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jugá aquí
        </button>
        <a href="index.php?pag=premiado">
          <button class="btn-info">Conocé más</button>
        </a>
      </div>
    </div>
      <script>
      async function cargarResultadoPremiadoCard() {
          try {
              const response = await fetch('/api/resultado-premiado.php');
              if (!response.ok) throw new Error('Error en la respuesta de la API');
              const data = await response.json();
              if (data.error) throw new Error(data.error);

              const card = document.querySelector('.res-card.morado-premiado');
              const valores = [data.par1, data.par2, data.par3, data.par4];

              valores.forEach((valor, index) => {
                  const elem = card?.querySelector(`#premiado-numero-${index + 1}`);
                  if (elem) elem.innerText = valor ?? '-';
              });
          } catch (error) {
              console.error('No se pudo cargar el resultado de Premia2:', error);
          }
      }
      cargarResultadoPremiadoCard();
      </script>
     <!-- terminacion2-->
    <div class="res-card marino-terminacion2">
      <img src="<?= htmlspecialchars($logoTerminacion2) ?>"
           alt="Logo Terminacion2"
           style="width:190px; height:auto; position:relative; top:20px;">
      <div class="numeros" style="position:relative; top:15px;">
        <span class="bola-mes-amarilla" id="terminacion2-numero">--</span>
      </div>
      <div class="btn-container">
        <button class="btn-jugar" onclick="window.open('https://juega.loto.com.ni/websales/', '_blank')">
          Jugá aquí
        </button>
        <a href="index.php?pag=terminacion2">
          <button class="btn-info">Conocé más</button>
        </a>
      </div>
    </div>
      <script>
      async function cargarResultadoTerminacion2Card() {
          try {
              const response = await fetch('/api/resultado-terminacion2.php');
              if (!response.ok) throw new Error('Error en la respuesta de la API');
              const data = await response.json();
              if (data.error) throw new Error(data.error);

              const numero = document.getElementById('terminacion2-numero');
              if (numero) numero.innerText = data.numero || '--';
          } catch (error) {
              console.error('No se pudo cargar el resultado de Terminacion 2:', error);
          }
      }
      cargarResultadoTerminacion2Card();
      </script>

  </div>
  <button class="res-next" type="button" aria-label="Resultados siguientes">&#10095;</button>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const resultadosBox = document.querySelector('.resultados-box');
  if (!resultadosBox) return;

  const cards = resultadosBox.querySelector('.res-cards');
  const prev = resultadosBox.querySelector('.res-prev');
  const next = resultadosBox.querySelector('.res-next');

  if (!cards || !prev || !next) return;

  let currentPage = 0;

  function getCardStep() {
    const card = cards.querySelector('.res-card');
    if (!card) return cards.clientWidth;

    const styles = window.getComputedStyle(cards);
    const gap = parseFloat(styles.columnGap || styles.gap) || 0;
    return card.offsetWidth + gap;
  }

  function getCardsPerPage() {
    return window.innerWidth <= 768 ? 1 : 3;
  }

  function updateViewportWidth() {
    const card = cards.querySelector('.res-card');
    if (!card) return;

    const cardsPerPage = getCardsPerPage();
    const visibleWidth = (cardsPerPage * getCardStep()) - (cardsPerPage > 1 ? getCardStep() - card.offsetWidth : 0);

    cards.style.width = `${visibleWidth}px`;
    cards.style.maxWidth = '100%';
  }

  function getMaxPage() {
    return Math.max(0, Math.ceil(cards.querySelectorAll('.res-card').length / getCardsPerPage()) - 1);
  }

  function moveResults() {
    updateViewportWidth();

    const cardsPerPage = getCardsPerPage();
    const maxScroll = Math.max(0, cards.scrollWidth - cards.clientWidth);
    const requestedLeft = currentPage * cardsPerPage * getCardStep();
    const left = currentPage >= getMaxPage() ? maxScroll : requestedLeft;

    cards.scrollTo({ left, behavior: 'smooth' });
    prev.style.display = 'flex';
    next.style.display = 'flex';
    prev.style.opacity = currentPage === 0 ? '0.55' : '1';
    next.style.opacity = currentPage >= getMaxPage() ? '0.55' : '1';
    prev.style.pointerEvents = currentPage === 0 ? 'none' : 'auto';
    next.style.pointerEvents = currentPage >= getMaxPage() ? 'none' : 'auto';
  }

  prev.addEventListener('click', function () {
    currentPage = Math.max(0, currentPage - 1);
    moveResults();
  });

  next.addEventListener('click', function () {
    currentPage = Math.min(getMaxPage(), currentPage + 1);
    moveResults();
  });

  window.addEventListener('resize', function () {
    currentPage = 0;
    moveResults();
  });

  moveResults();
});
</script>
<br>
<br>
 <p id="countdown-container" class="proximo" style="font-size: 28px; font-weight: 900; text-align: center; font-stretch: expanded;">
  <span style="color: #003399;">PRÓXIMO SORTEO EN VIVO:</span>
  <span style="color: white;">
    <span id="hours">0</span>H :
    <span id="minutes">0</span>M :
    <span id="seconds">0</span>S
  </span>
</p>

<!-- Fecha mostrada por el contador regresivo -->
<div id="diaSorteo" style="color: white; font-size: 16px; text-align: center; margin-top: 10px;"></div>

</div>
  </div>
  <br>

<?php
// ====================== CONSULTA JACKPOT ======================
$stmt = $conn->prepare("
    SELECT TOP 1 *
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion = 'popup_home'
    ORDER BY orden ASC
");
$stmt->execute();
$jackpot = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- BANNER JACKPOT -->
<div style="width: 100%; text-align: center; position: relative; margin-bottom: 20px;">

    <?php if($jackpot): ?>
        <a href="<?= htmlspecialchars($jackpot['link_url'] ?? '#') ?>" target="_blank">
            <img
                src="<?= htmlspecialchars($jackpot['imagen_url']) ?>"
                alt="Jackpot"
                style="width: 100%; max-width: 1700px; height: auto; border-radius: 16px; display: block; margin: 0 auto;"
            >
        </a>

    <?php else: ?>
        <!-- Fallback si no hay jackpot -->
        <img
            src="/ImagesSV/BannerDefault.png"
            alt="Jackpot por defecto"
            style="width: 100%; max-width: 1700px; height: auto; border-radius: 16px; display: block; margin: 0 auto;"
        >
    <?php endif; ?>

</div>

<script>
// Script para cargar el jackpot de Super Premio

async function cargarJackpot() {
    // Función asíncrona para cargar el jackpot

    try {
        // Intenta realizar la solicitud

        const response = await fetch('/api/jackpot_superpremio.php');
        // Realiza una solicitud fetch a la API del jackpot

        if (!response.ok) throw new Error('Error en la API');
        // Lanza un error si la respuesta no es OK

        const data = await response.json();
        // Convierte la respuesta a JSON

        console.log("Jackpot API:", data);
        // Registra los datos en la consola para depuración

        const monto = data.jackpot != null ? Number(data.jackpot) : 0;
        // Convierte el jackpot a número, o 0 si es null

        // Formateamos con coma para miles
        document.getElementById('jackpot-num-banner').innerText = "$" +
            monto.toLocaleString("es-ES").replace(/\./g, ",");
        // Actualiza el texto del elemento con el monto formateado

    } catch (error) {
        // Captura cualquier error

        console.error("No se pudo cargar el Jackpot:", error);
        // Registra el error en la consola

    }
}

// Llamamos a la función
cargarJackpot();
</script>

<br>
<br>
<br>
<br>

<!-- SECCIÓN YOUTUBE -->
<?php
$CHANNEL_ID = "UCwnJv1k2PKCpJeJWrtSaQPg"; // Canal de LOTO Nicaragua
$youtubeStreamsUrl = "https://www.youtube.com/@LotoNicaragua/streams";
$rss_url = "https://www.youtube.com/feeds/videos.xml?channel_id=$CHANNEL_ID";

// Cargar el RSS
$rss = simplexml_load_file($rss_url);

// Datos por defecto
$videoId = "1qsx5zpIp7w";
$videoTitle = "Sorteo LOTO 11:00 a.m 25 de Julio del 2025";
$videoDate = date('j \d\e F \d\e Y');

if ($rss && isset($rss->entry[0])) {
    $videoId = (string)$rss->entry[0]->children('yt', true)->videoId;
    $videoTitle = (string)$rss->entry[0]->title;
    $videoDate = date('j \d\e F \d\e Y', strtotime($rss->entry[0]->published));
}
?>

<!-- SECCIÓN YOUTUBE -->
<div class="youtube">
  <div class="youtube-inner">
    <div class="youtube-content">

      <!-- Video que sale a la par del mesaje visualiza nuestros sorteos -->
      <div class="youtube-video">
        <iframe width="100%" height="315"
          src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId, ENT_QUOTES, 'UTF-8'); ?>"
          title="YouTube video player"
          frameborder="0"
          allowfullscreen>
        </iframe>

        <!-- SOLO EL TÍTULO -->
        <p class="video-subtext"><?php echo htmlspecialchars($videoTitle, ENT_QUOTES, 'UTF-8'); ?></p>
      </div>

      <?php
      // =================== Traer contenido dinámico ===================
      $stmt = $conn->prepare("
          SELECT TOP 1 *
          FROM paginaweb_nic_sobre_inicio
          WHERE seccion='youtube_home'
          ORDER BY id ASC
      ");
      $stmt->execute();
      $youtube = $stmt->fetch(PDO::FETCH_ASSOC);
      ?>

      <!-- Texto a la derecha -->
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
            <a href="<?= htmlspecialchars($youtube['link_url'] ?? $youtubeStreamsUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">
              <button class="youtube-boton">Ver más sorteos</button>
            </a>
          </div>

        </div>
      </div>

    </div> <!-- youtube-content -->
  </div> <!-- youtube-inner -->
</div> <!--  ESTE ES EL QUE TE FALTABA -->

  <!-- Espacio en blanco -->
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


 <!-- Banner Superpremio -->
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
    SELECT TOP 8 *
    FROM paginaweb_nic_noticias
    ORDER BY es_principal DESC, id DESC
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
          <a href="index.php?pag=noticia_detalle&id=<?= urlencode($n['id']) ?>">
            <img src="<?= htmlspecialchars($n['imagen_url']); ?>" alt="<?= htmlspecialchars($n['titulo']); ?>">
          </a>

          <div class="card-content">
            <h4>
              <a href="index.php?pag=noticia_detalle&id=<?= urlencode($n['id']) ?>">
                <?= htmlspecialchars($n['titulo']); ?>
              </a>
            </h4>

            <p><?= nl2br(htmlspecialchars($n['descripcion'] ?? '')); ?></p>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
  </div>

</div>

<script>
// Script para el carrusel de noticias

document.addEventListener("DOMContentLoaded", function() {
    // Espera a que el DOM esté cargado

  const noticiasBox = document.querySelector('.noticias-box');
  // Selecciona el contenedor de noticias

  const carousel = noticiasBox.querySelector('.carousel');
  // Selecciona el carrusel dentro del contenedor de noticias

  const next = noticiasBox.querySelector('.next');
  // Selecciona el botón siguiente

  const prev = noticiasBox.querySelector('.prev');
  // Selecciona el botón anterior

  let index = 0;
  // Índice actual del carrusel

  function getVisibleCards() {
    // Función para determinar cuántas tarjetas son visibles según el ancho de pantalla

    return window.innerWidth <= 768 ? 1 : 3;
    // Si la pantalla es móvil, muestra 1 tarjeta; de lo contrario, 3

  }

  function moveCarousel() {
    // Función para mover el carrusel

    const card = document.querySelector('.card');
    // Selecciona la primera tarjeta para calcular el ancho

    if (!card) return;
    // Si no hay tarjetas, sale de la función

    const gap = parseFloat(window.getComputedStyle(carousel).gap) || 0;
    // Espacio entre tarjetas

    const cardWidth = card.offsetWidth + gap;
    // Calcula el ancho total de una tarjeta incluyendo el gap

    carousel.style.transform = `translateX(${-index * cardWidth}px)`;
    // Mueve el carrusel horizontalmente

  }

  next.addEventListener('click', () => {
    // Agrega evento click al botón siguiente

    const visibleCards = getVisibleCards();
    // Obtiene el número de tarjetas visibles

    const maxIndex = carousel.children.length - visibleCards;
    // Calcula el índice máximo posible

    if (index < maxIndex) {
      // Si no está en el último índice

      index++;
      // Incrementa el índice

      moveCarousel();
      // Mueve el carrusel

    }
  });

  prev.addEventListener('click', () => {
    // Agrega evento click al botón anterior

    if (index > 0) {
      // Si no está en el primer índice

      index--;
      // Decrementa el índice

      moveCarousel();
      // Mueve el carrusel

    }
  });

  window.addEventListener('resize', () => {
    // Agrega evento resize a la ventana

    index = 0;
    // Resetea el índice

    moveCarousel();
    // Mueve el carrusel a la posición inicial

  });

});
</script>

  <!-- Espacio en blanco -->
  <div style="height: 50px;"></div>

  <?php
// =================== RSE HOME ===================
$stmt = $conn->prepare("
    SELECT TOP 1 *
    FROM paginaweb_nic_sobre_inicio
    WHERE seccion='rse_home'
    ORDER BY id ASC
");
$stmt->execute();
$rse = $stmt->fetch(PDO::FETCH_ASSOC);
$rseMontoPremios = $rse['titulo'] ?? 7983;
$rseMontoPremios = is_numeric($rseMontoPremios) ? (int) $rseMontoPremios : 8893;
$rseTextoPremios = $rse['texto'] ?? 'Millones de cordobas';
?>

  <div class="rse">
  <div class="rse-content">

    <!-- Texto y número -->
    <div class="rse-text">
      <p style="font-size:30px; font-weight:600; margin-left:25px;">
        LOTO ha entregado en premios, m&aacute;s de
      </p>

      <h2 class="numero" id="contador">C$<?= number_format($rseMontoPremios, 0, '.', ',') ?></h2>

      <p style="font-size:30px; font-weight:600; margin-left:25px;">
        <?= htmlspecialchars($rseTextoPremios, ENT_QUOTES, 'UTF-8') ?>
      </p>
    </div>

    <!-- Imagen -->
    <div class="rse-image">
      <img
        src="<?= $rse['imagen_url'] ?? '/ImagesSV/IMG_3933_00013.png' ?>"
        alt="Imagen RSE">
    </div>

  </div>

  <!-- Botón -->
  <div class="boton-container">
    <a href="index.php?pag=sobre_nosotros" class="rse-boton" style="text-decoration: none;">
      Conocé más
    </a>
  </div>
</div>

  <script>
    // Función animar número con + y coma como separador de miles
    function animarContador(idElemento, valorFinal, duracion) {
      // Función para animar un contador numérico

      const elemento = document.getElementById(idElemento);
      // Obtiene el elemento por su ID

      let valorInicial = 0;
      // Valor inicial del contador

      const incremento = Math.ceil(valorFinal / (duracion / 30));
      // Calcula el incremento por frame (ajusta la velocidad)

      const intervalo = setInterval(() => {
        // Ejecuta cada 30ms

        valorInicial += incremento;
        // Incrementa el valor

        if (valorInicial >= valorFinal) {
          // Si alcanza el valor final

          valorInicial = valorFinal;
          // Establece el valor final

          clearInterval(intervalo);
          // Detiene el intervalo

        }
        // Formatear con separador de miles (coma) y agregar + al inicio
        elemento.textContent = "C$" + valorInicial
  .toLocaleString("en-US");
        // Actualiza el texto del elemento con el valor formateado

      }, 30);
      // Intervalo de 30ms

    }

    // Llamada a la función
    animarContador("contador", <?= json_encode($rseMontoPremios) ?>, 2000);
    // Anima el contador con el valor de la base de datos o un valor por defecto

  </script>

  <!-- SCRIPT SCROLL SUAVE (REEMPLAZA TRANSFORM POR MARGIN-TOP) -->
  <script>
    // Script para el efecto de scroll suave en la caja de resultados

    window.addEventListener('scroll', function() {
      // Agrega evento scroll a la ventana

      const box = document.querySelector('.resultados-box');
      // Selecciona la caja de resultados

      if (window.scrollY > 0) {
        // Si se ha hecho scroll hacia abajo

        box.style.marginTop = "-40px";
        // Reduce el margen superior para crear un efecto de movimiento

      } else {
        // Si está en la parte superior

        box.style.marginTop = "0";
        // Restablece el margen superior

      }
    });
  </script>

<script>
// Script para el contador regresivo al próximo sorteo

var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
// Array con los nombres de los días de la semana

var mesesEnletras = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
// Array con los nombres de los meses

const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;
// Constantes para convertir tiempo

var hoy = new Date();
// Fecha actual

var horariosSorteo = [12, 15, 18, 21];
// Horarios de sorteo: 12 PM, 3 PM, 6 PM y 9 PM

var proximoSorteo = horariosSorteo
    .map(function(horaSorteo) {
        return new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), horaSorteo, 0, 0);
    })
    .find(function(fechaSorteo) {
        return fechaSorteo > hoy;
    });
// Busca el siguiente sorteo del día

if(!proximoSorteo){
    proximoSorteo = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate() + 1, horariosSorteo[0], 0, 0);
    // Si ya pasó el sorteo de las 9 PM, pasa al sorteo de mañana a las 12 PM
}

Number.prototype.padStart = function (n,str){
    // Extiende el prototipo de Number para agregar padStart

    return Array(n-String(this).length+1).join(str||'0')+this;
    // Agrega ceros al inicio hasta alcanzar la longitud n

}

var fechaCompleta = diasSemana[proximoSorteo.getDay()] + " " + proximoSorteo.getDate() + " de " + mesesEnletras[proximoSorteo.getMonth()];
// Construye la fecha completa en texto

let countDown = proximoSorteo.getTime();
// Calcula el timestamp del próximo sorteo

let x = setInterval(function() {
    // Función que se ejecuta cada segundo

    let now = new Date().getTime();
    // Timestamp actual

    let distance = countDown - now;
    // Diferencia en milisegundos

    document.getElementById('hours').innerText = Math.floor((distance % day) / hour).padStart(2, "0");
    // Actualiza las horas restantes

    document.getElementById('minutes').innerText = Math.floor((distance % hour) / minute).padStart(2, "0");
    // Actualiza los minutos restantes

    document.getElementById('seconds').innerText = Math.floor((distance % minute) / second).padStart(2, "0");
    // Actualiza los segundos restantes

    document.getElementById('diaSorteo').innerText = fechaCompleta;
    // Actualiza la fecha del sorteo

    if(distance <= 0){
        // Si el tiempo se agotó

        clearInterval(x);
        // Detiene el intervalo

        document.getElementById('countdown-container').innerText = "¡Sorteo en vivo!";
        // Muestra mensaje de sorteo en vivo

    }
}, second);
</script>

<script>
// Script para el carrusel del hero (sección principal)

  const slides = document.querySelectorAll('.hero-slide');
  // Selecciona todas las diapositivas del hero

  const prevBtn = document.querySelector('.carousel-btn.prev');
  // Selecciona el botón anterior

  const nextBtn = document.querySelector('.carousel-btn.next');
  // Selecciona el botón siguiente

  let currentSlide = 0;
  // Índice de la diapositiva actual

  function showSlide(index) {
    // Función para mostrar la diapositiva en el índice dado

    slides.forEach(slide => slide.classList.remove('active'));
    // Remueve la clase 'active' de todas las diapositivas

    slides[index].classList.add('active');
    // Agrega la clase 'active' a la diapositiva actual

  }

  nextBtn.addEventListener('click', () => {
    // Agrega evento click al botón siguiente

    currentSlide = (currentSlide + 1) % slides.length;
    // Incrementa el índice y lo mantiene dentro del rango

    showSlide(currentSlide);
    // Muestra la nueva diapositiva

  });

  prevBtn.addEventListener('click', () => {
    // Agrega evento click al botón anterior

    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    // Decrementa el índice y lo mantiene dentro del rango

    showSlide(currentSlide);
    // Muestra la nueva diapositiva

  });
</script>


</body>

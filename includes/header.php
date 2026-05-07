<!DOCTYPE html>
<!-- Declaración del tipo de documento HTML5 -->
<html lang="es">
<!-- Elemento raíz del documento HTML, idioma español -->
<head>
  <!-- Sección de metadatos del documento -->
  <meta charset="UTF-8">
  <!-- Codificación de caracteres UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Configuración de viewport para dispositivos móviles -->
  <title>LOTO - HOME</title>
  <!-- Título de la página que aparece en la pestaña del navegador -->
  <link rel="icon" type="image/png" href="/imagesSV/icono.png">
  <!-- Icono del sitio web (favicon) -->
  <link rel="stylesheet" href="/css/style.css" />
  <!-- Enlace al archivo de estilos CSS principal -->
  <style>
    /* Estilos CSS embebidos para elementos específicos del header */

    body {
      /* Estilos base para el cuerpo de la página */
      font-family: 'Helvetica Rounded Black', Arial, sans-serif;
      /* Fuente principal del sitio */
      margin: 0;
      padding: 0;
      /* Elimina márgenes y padding por defecto */
    }

    /* Dropdown juegos corregido */
    .dropdown {
      /* Contenedor del menú desplegable de juegos */
      position: relative;
      display: inline-block;
    }

    .dropdown > a {
      /* Estilo del enlace principal del dropdown */
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 5px 10px;
      transition: color 0.3s;
      /* Transición suave para el cambio de color */
    }

    .dropdown:hover > a {
      /* Color del enlace al pasar el mouse */
      color: #0070c0; /* azul hover */
    }

   .dropdown-content {
     /* Contenido del menú desplegable */
  display: none;
  /* Oculto por defecto */
  position: absolute;
  top: 100%;
  /* Posicionado debajo del enlace */
  left: 0;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.2);
  /* Sombra para efecto visual */
  min-width: 180px;
  z-index: 1000;
  /* Asegura que aparezca sobre otros elementos */
}

.dropdown-content a {
  /* Estilos de los enlaces dentro del dropdown */
  display: block;
  padding: 10px 15px;
  color: black !important;
  text-decoration: none;
  font-weight: normal;
}

.dropdown-content a:hover {
  /* Efecto hover en los enlaces del dropdown */
  background-color: #0070c0;
  color: white !important;
}

    .dropdown:hover .dropdown-content {
      /* Muestra el dropdown al pasar el mouse sobre el contenedor */
      display: block; /* aparece inmediatamente */
    }

    /* Hover azul para links del nav principal */
    .nav-menu a {
      /* Estilos para los enlaces del menú de navegación principal */
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 5px 10px;
      transition: color 0.3s;
    }

    .nav-menu a:hover {
      /* Color hover para enlaces del menú principal */
      color: #0070c0; /* azul hover */
    }

    /* ================= RESPONSIVE SOLO MÓVIL ================= */
    /* Estilos específicos para dispositivos móviles (ancho máximo 768px) */
@media (max-width: 768px) {

  /* Top menu más compacto */
  .top-menu {
    /* Menú superior adaptado para móviles */
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 5px;         /* menos espacio entre links */
    padding: 5px 0;   /* menos padding */
    text-align: center;
  }

  .top-menu a {
    /* Enlaces del menú superior en móviles */
    font-size: 11px;  /* letras más pequeñas */
    padding: 3px 5px; /* menos padding interno */
  }

  /* Header principal más compacto */
  .main-header {
    /* Contenedor principal del header en móviles */
    flex-direction: column;
    align-items: center;
    gap: 8px;         /* menos espacio entre logo, nav y botón */
    padding: 5px 0;
  }

  /* Logo más pequeño */
  .logo img {
    /* Imagen del logo reducida para móviles */
    max-width: 140px; /* antes 180px */
    height: auto;
  }

  /* Nav más compacto */
  .nav-menu {
    /* Menú de navegación compacto en móviles */
    flex-wrap: wrap;
    justify-content: center;
    gap: 5px;
    text-align: center;
  }

  .nav-menu a {
    /* Enlaces del menú en móviles */
    font-size: 12px;  /* antes 14px */
    padding: 4px 6px; /* antes 6px 8px */
  }

  /* Dropdown */
  .dropdown-content {
    /* Menú desplegable centrado en móviles */
    left: 50%;
    transform: translateX(-50%);
    min-width: 140px; /* menos ancho en móvil */
  }

  /* Botón jugar más pequeño */
  .play-button img {
    /* Botón de jugar reducido para móviles */
    max-width: 160px; /* antes 200px */
    height: auto;
  }

  /* Botón jugar en línea */
  .play-button a {
    /* Enlace del botón de jugar */
    display: inline-block;
    background: none;
    padding: 0;
  }

  .play-button img {
    /* Imagen del botón de jugar */
    display: block;
    max-width: 160px; /* mantiene coherencia con arriba */
    height: auto;
  }

}
@media (max-width: 768px) {
  /* Estilos adicionales para el menú superior en móviles */

  .top-menu {
    /* Diseño de grid para mejor organización */
    display: grid;
    grid-template-columns: repeat(2, auto); /* 2 y 2, compactos */
    justify-content: center;                /* centra el bloque */
    column-gap: 14px;                       /* separación horizontal CONTROLADA */
    row-gap: 6px;                           /* separación vertical */
    padding: 6px 10px;
  }

  .top-menu a {
    /* Enlaces del menú superior con ajustes finales */
    font-size: 11px;
    padding: 4px 8px;
    white-space: nowrap;                    /* no se parten */
  }

}
  </style>

  <!-- Google tag (gtag.js) -->
  <!-- Script de Google Analytics para seguimiento de usuarios -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-T1ZVRGYX8X"></script>
<script>
  // Configuración de Google Analytics
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-T1ZVRGYX8X');
  // Inicializa el seguimiento con el ID especificado
</script>


</head>
<body>
  <!-- Inicio del cuerpo del documento HTML -->
  <header>
    <!-- Elemento header que contiene la navegación principal -->

    <!-- Menú superior azul -->
    <div class="top-menu">
      <!-- Enlaces de navegación secundaria en la parte superior -->
      <a href="index.php?pag=sobre_nosotros">Sobre nosotros</a>
      <a href="index.php?pag=quiero_ser_agente">Quiero ser vendedor</a>
      <a href=" https://www.google.com/maps/d/u/1/edit?mid=1gerRqZPZbxOs3JlQuXiYnUMIGiLWpvA&usp=sharing" target="_blank">Puntos de venta</a>
      <a href="index.php?pag=aplica_con_nosotros">Aplicá con nosotros</a>
    </div>

    <!-- Cuadro naranja con logo, navegación y botón -->
    <div class="main-header">
      <!-- Contenedor principal del header con logo, menú y botón -->

      <div class="logo">
        <!-- Sección del logo -->
        <a href="login.php">
          <!-- Enlace al login al hacer click en el logo -->
          <img src="/ImagesSV/logo-02-LOTO.png" alt="Logo" style="cursor:pointer;">
          <!-- Imagen del logo con cursor de puntero -->
        </a>
      </div>

      <nav class="nav-menu">
        <!-- Menú de navegación principal -->

        <div class="dropdown">
          <!-- Menú desplegable de juegos -->
          <a href="#">JUEGOS ▾</a>
          <!-- Enlace principal del dropdown con flecha -->
          <div class="dropdown-content">
            <a href="index.php?pag=diaria">Diaria</a>
            <a href="index.php?pag=fechas_lotos">Fechas Loto</a>
            <a href="index.php?pag=premiado">Premia2</a>
            <a href="index.php?pag=juga_tres">Juga Tres</a>
            <a href="index.php?pag=terminacion2">Terminación 2</a>
          </div>
        </div>
        <a href="index.php?pag=noticias">NOTICIAS</a>
        <!-- Enlace a la página de noticias -->
        <a href="index.php?pag=contactanos">CONTÁCTANOS</a>
        <!-- Enlace a la página de contacto -->
      </nav>

      <div class="play-button">
        <!-- Botón para jugar en línea -->
        <a href="https://juega.loto.com.ni/websales/" target="_blank">
          <!-- Enlace externo a la plataforma de juegos -->
          <img src="/ImagesSV/boton-jugar-en-linea.png" alt="Jugar en línea">
          <!-- Imagen del botón -->
        </a>
      </div>
    </div>
  </header>


  <script>
    // Script para funcionalidad del menú desplegable en dispositivos móviles
document.addEventListener("DOMContentLoaded", function () {
  // Espera a que el DOM esté completamente cargado

  const btn = document.querySelector(".dropdown > a");
  // Selecciona el enlace principal del dropdown

  const content = document.querySelector(".dropdown-content");
  // Selecciona el contenido del dropdown

  btn.addEventListener("click", function(e) {
    // Agrega evento click al botón del dropdown
    e.preventDefault();
    // Previene el comportamiento por defecto del enlace
    content.style.display = content.style.display === "block" ? "none" : "block";
    // Alterna la visibilidad del contenido del dropdown
  });

  document.addEventListener("click", function(e) {
    // Agrega evento click al documento completo
    if (!document.querySelector(".dropdown").contains(e.target)) {
      // Si el click no fue dentro del dropdown
      content.style.display = "none";
      // Oculta el dropdown
    }
  });
});
</script>

<!-- Meta Pixel Code -->
<!-- Código de seguimiento de Facebook Pixel para analytics -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1517228626366116');
// Inicializa Facebook Pixel con el ID de seguimiento
fbq('track', 'PageView');
// Registra la visualización de página
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1517228626366116&ev=PageView&noscript=1"
/></noscript>
<!-- Fin del código de Facebook Pixel -->

<!-- 
Start of global snippet: Please do not remove
Place this snippet between the <head> and </head> tags on every page of your site.
-->
<!-- Código global de Google Ads para seguimiento de conversiones -->
<!-- Google tag (gtag.js) -->
<script async src=""https://www.googletagmanager.com/gtag/js?id=DC-14581472""></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'DC-14581472');
  // Configura Google Ads con el ID especificado
</script>
<!-- End of global snippet: Please do not remove -->

<!--Event snippet for Loto_Traffic on : Please do not remove.
Place this snippet on pages with events you’re tracking. 
Creation date: 05/21/2025-->
<!-- Fragmento de evento para seguimiento de conversiones de LOTO -->
<script>
  gtag('event', 'conversion', {
    'allow_custom_scripts': true,
    'send_to': 'DC-14581472/invmedia/loto_0+standard'
    // Envía evento de conversión a Google Ads
  });
</script>
<noscript>
<img src=""https://ad.doubleclick.net/ddm/activity/src=14581472;type=invmedia;cat=loto_0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;gdpr=${GDPR};gdpr_consent=${GDPR_CONSENT_755};ord=1?"" width=""1"" height=""1"" alt=""""/>
</noscript>
<!-- End of event snippet: Please do not remove -->
</body>
</html>

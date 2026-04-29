<style>
/* =========================
   ESTILOS RESPONSIVOS PARA DISPOSITIVOS MÓVILES
   Ajustes específicos para pantallas de ancho máximo 768px (tablets y móviles)
   ========================= */
@media (max-width: 768px) {

  .footer {
    /* Cambia el footer a disposición vertical en móviles */
    display: flex;
    flex-direction: column;
    align-items: center;
    /* Centra todos los elementos verticalmente */
  }

  /* LOGO PRINCIPAL */
  .footer-left {
    /* Sección del logo ocupa todo el ancho en móviles */
    width: 100%;
    display: flex;
    justify-content: center;
    /* Centra el logo horizontalmente */
    margin-bottom: 20px;
    /* Espacio inferior antes de las columnas */
  }

  .footer-left img {
    /* Escala el logo para que sea visible en móviles */
    transform: scale(2) !important;
    /* Mantiene tamaño grande pero controlado */
    margin-top: 25px !important;
    /* Margen superior para posicionamiento */
  }

  /* COLUMNAS */
  .footer-right {
    /* Sección derecha ocupa todo el ancho en móviles */
    width: 100%;
  }

  .footer-columns {
    /* Organiza las columnas en vertical */
    display: flex;
    flex-direction: column;
    align-items: center;
    /* Centra las columnas */
    text-align: center;
    /* Centra el texto de títulos y enlaces */
    gap: 20px;
    /* Espacio entre columnas */
  }

  .footer-column {
    /* Cada columna ocupa todo el ancho disponible */
    width: 100%;
  }

  .footer-column h3 {
    /* Centra los títulos de las columnas */
    text-align: center;
  }

  .footer-column p {
    /* Centra los párrafos y enlaces */
    text-align: center;
  }

  /* LOGO +18 */
  .footer-logos {
    /* Contenedor de logos adicionales */
    width: 100%;
    display: flex;
    justify-content: center;
    /* Centra los logos */
    margin-top: 20px;
    /* Espacio superior */
  }

  /* REDES SOCIALES */
  .social-icons {
    /* Contenedor de iconos de redes sociales */
    display: flex;
    justify-content: center;
    /* Centra los iconos */
    width: 100%;
    margin-top: 20px;
    /* Espacio superior */
  }
}

/* =========================
   ESTILOS ADICIONALES PARA LOGOS EN MÓVILES
   ========================= */
@media (max-width: 768px) {

  .footer-extra-logo {
    /* Limita el tamaño máximo de logos adicionales */
    max-width: 70px;
    width: 100%;
    height: auto;
    /* Mantiene proporción */
  }

  .footer-logos {
    /* Asegura centrado de logos */
    display: flex;
    justify-content: center;
    align-items: center;
  }
}
</style>

<!-- PIE DE PÁGINA PRINCIPAL -->
<div class="footer">
  <!-- Sección izquierda del footer - Logo principal -->
  <div class="footer-left">
   <!-- Logo de LOTO en blanco -->
   <img src="/ImagesSV/LOGO LOTO JDL WHITE.svg" alt="Logo" class="footer-logo"
     style="transform: scale(2.5) translateX(40px); margin-top: 25px;">
     <!-- Logo escalado y posicionado para desktop -->
  </div>

  <!-- Sección derecha del footer - Contenido -->
  <div class="footer-right">
    <!-- Contenedor de columnas -->
    <div class="footer-columns">
      <!-- Columna de Juegos -->
      <div class="footer-column">
        <h3>Juegos</h3>
        <!-- Enlaces a las diferentes páginas de juegos -->
        <p>
          <a href="index.php?pag=diaria" style="color: inherit; text-decoration: none;">
            Diaria
          </a>
        </p>
        <p>
          <a href="index.php?pag=fechas_lotos" style="color: inherit; text-decoration: none;">
            Fechas Lotos
          </a>
        </p>


      </div>

      <!-- Columna de Nosotros -->
      <div class="footer-column">
        <h3>Nosotros</h3>
        <!-- Enlaces a páginas de información corporativa -->
        <p>
        <a href="index.php?pag=aplica_con_nosotros" style="color: inherit; text-decoration: none;">
        Aplicá con nosotros
      </a>
      </p>
        <p>
        <a href="index.php?pag=quiero_ser_agente" style="color: inherit; text-decoration: none;">
        Quiero ser vendedor
      </a>
        </p>
       <p>
  <a href="https://www.google.com/maps/d/u/1/edit?mid=1gerRqZPZbxOs3JlQuXiYnUMIGiLWpvA&usp=sharing" target="_blank" style="color: inherit; text-decoration: none;">

    Puntos de venta
  </a>
</p>

      </div>

      <!-- Columna de Secciones -->
      <div class="footer-column">
    <h3>Secciones</h3>
    <!-- Enlaces a secciones informativas del sitio -->
    <p>
        <a href="index.php?pag=noticias" style="color: inherit; text-decoration: none;">
            Noticias
        </a>
    </p>
    <p>
        <a href="index.php?pag=contactanos" style="color: inherit; text-decoration: none;">
            Contáctanos
        </a>
    </p>
    <!-- Enlace a documento descargable de reglamento -->
    <p>
        <a href="/ImagesSV/documentos/120226 LOTO - Bases de la Promoción Dobleteá tu Suerte vFinal.pdf"
           style="color: inherit; text-decoration: none;"
           download>
          Reglamento promoción
        </a>
    </p>
</div>


    </div>
  </div>

  <!-- Logos adicionales en la parte inferior -->
  <div class="footer-logos">
     <!-- Logo ESR comentado (no se muestra) -->
     <!-- <img src="/ImagesSV/Logo ESR.png" alt="Logo ESR" class="footer-extra-logo"> -->
    <!-- Logo de restricción de edad +18 -->
    <img src="/ImagesSV/18 años png.png" alt="Logo Loto 21" class="footer-extra-logo">
  </div>

  <!-- Iconos de redes sociales -->
  <div class="social-icons">
  <!-- Enlaces a perfiles sociales que se abren en nueva pestaña -->
  <a href="https://www.tiktok.com/@lotoelsalvador" target="_blank">
    <img src="/ImagesSV/tik-tok.svg" alt="TikTok">
  </a>
  <a href="https://www.instagram.com/Lotoelsalvador/" target="_blank">
    <img src="/ImagesSV/instagram.svg" alt="Instagram">
  </a>
  <a href="https://www.facebook.com/LotoElSalvador/" target="_blank">
    <img src="/ImagesSV/facebook.svg" alt="Facebook">
  </a>
 <!-- Enlace a Twitter comentado (no se muestra) -->
 <!-- <a href="https://x.com/LotoElSalvador" target="_blank">
    <img src="/ImagesSV/Twitter.svg" alt="Twitter">
  </a>   -->
  <a href="https://www.youtube.com/results?search_query=loto+el+salvador" target="_blank">
    <img src="/ImagesSV/Youtube.svg" alt="Youtube">
  </a>
  <a href="https://sv.linkedin.com/company/lotoeselsalvador" target="_blank">
    <img src="/ImagesSV/linkedin.svg" alt="LinkedIn">
  </a>
</div>

</div>

<?php
$titulo_pagina = 'Curso HTML';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-curso">
<h2 id="titulo-curso">Curso HTML</h2>
<h3>Guía</h3>
<h4>Unidad 1: Introducción</h4>
<p>Conceptos iniciales para comenzar a trabajar con HTML.</p>
<h4>Unidad 2: Etiquetas</h4>
<p>Uso de etiquetas HTML y estructura semántica. Se trabajan encabezados, párrafos, listas, enlaces, imágenes, tablas y formularios.</p>
<h4>Unidad 3: Formularios</h4>
<p>Creación de formularios accesibles mediante <code>label</code>, campos de texto, correo, números, botones y mensajes de validación.</p>
<h4>Unidad 4: CSS</h4>
<p>Introducción a selectores, propiedades, modelo de caja, tipografías, colores, espaciado, tarjetas, navegación y diseño responsive.</p>
<h4>Unidad 5: JavaScript</h4>
<p>Variables, tipos de datos, funciones, eventos y manipulación del DOM. Estos conceptos permiten agregar interactividad sin cambiar la estructura HTML.</p>
<h4>Unidad 6: Accesibilidad</h4>
<p>Buenas prácticas para navegación con teclado, foco visible, texto alternativo, contraste, jerarquía de títulos y formularios comprensibles.</p>
<figure>
<img src="assets/html.svg" alt="Imagen ilustrativa sobre etiquetas HTML y estructura web">
<figcaption>Aprendizaje de etiquetas y estructura HTML.</figcaption>
</figure>

<article aria-labelledby="video-html">
<h3 id="video-html">Video relacionado: desarrollo web</h3>
<p>Este video complementa el contenido del curso y presenta de forma breve HTML, CSS, JavaScript y accesibilidad.</p>
<figure class="video-wrapper"><video controls preload="metadata" poster="assets/html.svg"><source src="assets/desarrollo-web.mp4" type="video/mp4">Tu navegador no puede reproducir este video.</video></figure>
<figure class="video-wrapper" style="display:none">
<iframe
  src="https://www.youtube.com/embed/pQN-pnXPaVg"
  title="Introducción a HTML para principiantes"
  loading="lazy"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
  allowfullscreen></iframe>
</figure>
</article>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

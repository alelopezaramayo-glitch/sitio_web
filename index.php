<?php
$titulo_pagina = 'Inicio';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-inicio">
<h2 id="titulo-inicio">Inicio</h2>
<p>Bienvenido a mi sitio web, un espacio práctico para aprender los fundamentos del desarrollo web. Acá vas a encontrar contenidos sobre <strong>HTML, CSS, JavaScript y accesibilidad</strong>, organizados de forma clara para que puedas avanzar paso a paso.</p>
<div class="info-grid"><article><h3>HTML</h3><p>Aprendé a estructurar páginas con etiquetas semánticas, formularios, enlaces, imágenes y contenido accesible.</p></article><article><h3>CSS</h3><p>Descubrí cómo aplicar colores, tipografías, espaciado, diseño responsive y estilos visuales.</p></article><article><h3>JavaScript</h3><p>Agregá interactividad con eventos, validaciones, fechas, galerías, formularios y cambios de tema.</p></article><article><h3>Accesibilidad</h3><p>Conocé buenas prácticas para que el contenido pueda ser utilizado por más personas y dispositivos.</p></article></div>
<figure>
<img src="assets/html.svg" alt="Imagen ilustrativa relacionada con el aprendizaje de HTML">
<figcaption>Recursos visuales para acompañar el contenido de aprendizaje web.</figcaption>
</figure>
</section>
<section class="content-card" aria-labelledby="video-presentacion">
<h2 id="video-presentacion">Video: desarrollo web</h2>
<p>Una breve presentación visual de las tecnologías que forman parte de este sitio: HTML para la estructura, CSS para el diseño y JavaScript para la interacción. También se destaca la importancia de la accesibilidad.</p>
<figure class="video-wrapper"><video controls preload="metadata" poster="assets/javascript.svg"><source src="assets/desarrollo-web.mp4" type="video/mp4">Tu navegador no puede reproducir este video.</video><figcaption>Presentación sobre HTML, CSS, JavaScript y accesibilidad.</figcaption></figure>
</section>
<section class="content-card">
<h2>¿Qué podés aprender?</h2>
<div class="info-grid">
<article><h3>HTML semántico</h3><p>Aprendé a organizar el contenido con encabezados, párrafos, listas, enlaces, imágenes, formularios y elementos semánticos. Una estructura clara mejora la comprensión del contenido y facilita su mantenimiento.</p></article>
<article><h3>CSS responsive</h3><p>Trabajá con tipografías, colores, espacios, tarjetas, navegación y diseños adaptables. El objetivo es que el sitio conserve una buena experiencia tanto en pantallas grandes como en celulares.</p></article>
<article><h3>JavaScript</h3><p>Usá variables, funciones, eventos, condiciones y manipulación del DOM para crear validaciones, galerías, menús, relojes, formularios interactivos y cambios de tema.</p></article>
<article><h3>Accesibilidad</h3><p>Aplicá texto alternativo, foco visible, navegación mediante teclado, etiquetas de formulario y suficiente contraste para que más personas puedan utilizar el sitio.</p></article>
</div>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

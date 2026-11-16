<?php
$titulo_pagina = 'Currículum Vitae';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-cv">
<h2 id="titulo-cv">Currículum Vitae</h2>
<article>
<h3>Datos</h3><p>Nombre: Juan Pérez</p>
<h3>Experiencia</h3><p>Desarrollador Web en Empresa X</p>
<h3>Educación</h3><p>Secundario completo</p>
<h3>Habilidades</h3><p>HTML, CSS y desarrollo web accesible.</p>
<figure>
<img src="assets/javascript.svg" alt="Imagen ilustrativa de un currículum y habilidades de desarrollo web">
<figcaption>Perfil profesional orientado al desarrollo web.</figcaption>
</figure>
</article>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

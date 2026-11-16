<?php
$titulo_pagina = 'Blog';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-blog">
<h2 id="titulo-blog">Blog</h2>
<article>
<h3>Aprendiendo HTML</h3>
<p>Consejos básicos para comenzar a crear páginas web accesibles y semánticas.</p>
</article>
<article aria-labelledby="comentarios">
<h3 id="comentarios">Comentarios</h3>
<p>Excelente contenido para comenzar.</p>
<figure>
<img src="assets/web-animation.gif" alt="Animación decorativa relacionada con el aprendizaje">
<figcaption>Animación de apoyo al contenido del blog.</figcaption>
</figure>
</article>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

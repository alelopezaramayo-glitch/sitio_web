<?php
/**
 * buscar.php — Buscador enviado por GET (Clase 5).
 * Los parámetros viajan en la URL (?q=...&categoria=...), por lo que la búsqueda
 * se puede copiar, compartir y volver a abrir. Se sanitiza con filter_input + trim
 * y se escapa con e() al imprimir (anti-XSS).
 */
require_once __DIR__ . '/includes/funciones.php';

// Catálogo de contenidos del sitio sobre el que se busca
$catalogo = [
    ['titulo' => 'Inicio',                 'url' => 'index.php',       'categoria' => 'Sitio',          'descripcion' => 'Presentación del sitio y resumen de los temas: HTML, CSS, JavaScript y accesibilidad.'],
    ['titulo' => 'Quiénes somos',          'url' => 'nosotros.php',    'categoria' => 'Sitio',          'descripcion' => 'Conocé al equipo y la misión del proyecto de aprendizaje web.'],
    ['titulo' => 'Servicios',              'url' => 'servicios.php',   'categoria' => 'Sitio',          'descripcion' => 'Diseño web, desarrollo front-end y consultoría de accesibilidad.'],
    ['titulo' => 'Curso de HTML',          'url' => 'curso.php',       'categoria' => 'HTML',           'descripcion' => 'Etiquetas semánticas, formularios, enlaces e imágenes paso a paso.'],
    ['titulo' => 'Blog',                   'url' => 'blog.php',        'categoria' => 'Sitio',          'descripcion' => 'Artículos sobre desarrollo web, buenas prácticas y novedades.'],
    ['titulo' => 'Preguntas frecuentes',   'url' => 'faq.php',         'categoria' => 'Sitio',          'descripcion' => 'Respuestas rápidas sobre cursos, contenidos y soporte.'],
    ['titulo' => 'Currículum Vitae',       'url' => 'cv.php',          'categoria' => 'Sitio',          'descripcion' => 'Formación, experiencia y habilidades del autor del sitio.'],
    ['titulo' => 'Galería',                'url' => 'galeria.php',     'categoria' => 'CSS',            'descripcion' => 'Imágenes con texto alternativo y diseño responsive adaptable a celulares.'],
    ['titulo' => 'JavaScript interactivo', 'url' => 'javascript.php',  'categoria' => 'JavaScript',     'descripcion' => 'Eventos, validación de formularios, fecha y hora, menú y modo oscuro.'],
    ['titulo' => 'Testimonios',            'url' => 'testimonios.php', 'categoria' => 'Sitio',          'descripcion' => 'Opiniones de personas que realizaron los cursos.'],
    ['titulo' => 'Política de privacidad', 'url' => 'politica.php',    'categoria' => 'Accesibilidad',  'descripcion' => 'Cómo se tratan los datos personales y qué derechos tenés.'],
    ['titulo' => 'Contacto',               'url' => 'contacto.php',    'categoria' => 'Sitio',          'descripcion' => 'Formulario de contacto para consultas sobre servicios y cursos.'],
];
$categorias = array_values(array_unique(array_column($catalogo, 'categoria')));
sort($categorias);

// 1) Entrada sanitizada (GET)
$consultado = array_key_exists('q', $_GET) || array_key_exists('categoria', $_GET);
$q          = entrada_get('q');
$categoria  = entrada_get('categoria');
$errores    = [];
$resultados = [];

// 2) Validación en servidor
if ($consultado) {
    if ($q === '' && $categoria === '') {
        $errores[] = 'Escribí un término de búsqueda o elegí una categoría.';
    }
    if ($q !== '' && largo($q) < 2) {
        $errores[] = 'El término de búsqueda debe tener al menos 2 caracteres.';
    }
    if (largo($q) > 50) {
        $errores[] = 'El término de búsqueda no puede superar los 50 caracteres.';
    }
    if ($categoria !== '' && !in_array($categoria, $categorias, true)) {
        $errores[] = 'La categoría elegida no es válida.';
    }

    // 3) Búsqueda
    if (!$errores) {
        foreach ($catalogo as $item) {
            $coincideTexto = $q === '' || mb_stripos($item['titulo'] . ' ' . $item['descripcion'], $q, 0, 'UTF-8') !== false;
            $coincideCat   = $categoria === '' || $item['categoria'] === $categoria;
            if ($coincideTexto && $coincideCat) {
                $resultados[] = $item;
            }
        }
    }
}

$titulo_pagina        = 'Buscar';
$encabezado_subtitulo = 'Encontrá rápido el contenido que necesitás.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-buscar">
<h2 id="titulo-buscar">Buscar en el sitio</h2>
<p>Escribí una palabra y, si querés, filtrá por categoría. La búsqueda se envía por <strong>GET</strong>, así que el resultado queda en la dirección (URL) y se puede compartir.</p>

<form action="buscar.php" method="get" class="search-form" role="search" novalidate>
<p class="form-group">
<label for="q">Palabra a buscar</label>
<input id="q" name="q" type="search" maxlength="60" placeholder="Ej.: formularios" value="<?= e($q) ?>">
</p>
<p class="form-group">
<label for="categoria">Categoría</label>
<select id="categoria" name="categoria">
<option value="">Todas</option>
<?php foreach ($categorias as $cat): ?>
<option value="<?= e($cat) ?>"<?= $categoria === $cat ? ' selected' : '' ?>><?= e($cat) ?></option>
<?php endforeach; ?>
</select>
</p>
<p class="form-group form-actions">
<button type="submit">Buscar</button>
<a class="button-link" href="buscar.php">Limpiar</a>
</p>
</form>

<?php if ($errores): ?>
<div class="alert alert-error" role="alert">
<p><strong>No se pudo realizar la búsqueda.</strong></p>
<ul>
<?php foreach ($errores as $mensaje): ?>
<li><?= e($mensaje) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php elseif ($consultado): ?>
<div class="alert alert-ok" role="status">
<p>
<?php if ($q !== ''): ?>Resultados para «<strong><?= e($q) ?></strong>»<?php else: ?>Resultados<?php endif; ?>
<?php if ($categoria !== ''): ?> en la categoría <strong><?= e($categoria) ?></strong><?php endif; ?>:
<strong><?= count($resultados) ?></strong> encontrado<?= count($resultados) === 1 ? '' : 's' ?>.
</p>
</div>

<?php if ($resultados): ?>
<ul class="result-list">
<?php foreach ($resultados as $item): ?>
<li class="result-card">
<h3><a href="<?= e($item['url']) ?>"><?= e($item['titulo']) ?></a></h3>
<p><?= e($item['descripcion']) ?></p>
<p class="result-meta">Categoría: <?= e($item['categoria']) ?></p>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>No encontramos contenidos con esos criterios. Probá con otra palabra o quitá el filtro de categoría.</p>
<?php endif; ?>
<?php endif; ?>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

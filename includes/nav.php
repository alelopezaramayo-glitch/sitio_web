<?php
/**
 * nav.php — menú principal. El ítem activo se detecta con el nombre del
 * archivo que se está ejecutando (index.php, servicios.php, etc.).
 *
 * Variable opcional:
 *   $hint_teclado (string, HTML) Texto de ayuda de navegación por teclado.
 */
$pagina_actual = basename($_SERVER['SCRIPT_NAME']);

$menu = [
    'index.php'     => 'Inicio',
    'nosotros.php'  => 'Nosotros',
    'servicios.php' => 'Servicios',
    'curso.php'     => 'Curso',
    'blog.php'      => 'Blog',
    'faq.php'       => 'FAQ',
    'cv.php'        => 'CV',
    'galeria.php'   => 'Galería',
    'javascript.php'=> 'JavaScript',
    'contacto.php'  => 'Contacto',
];

$hint_teclado = $hint_teclado ?? '⌨️ Navegación accesible: usá <strong>Tab</strong> para avanzar, <strong>Shift + Tab</strong> para volver y <strong>Enter</strong> para activar enlaces y botones.';
?>
<nav class="site-nav" aria-label="Navegación principal">
<ul>
<?php foreach ($menu as $archivo => $etiqueta): ?>
<?php if ($archivo === $pagina_actual): ?>
<li><a href="<?= $archivo ?>" class="active" aria-current="page"><?= $etiqueta ?></a></li>
<?php else: ?>
<li><a href="<?= $archivo ?>"><?= $etiqueta ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</nav>
<p class="keyboard-hint"><?= $hint_teclado ?></p>

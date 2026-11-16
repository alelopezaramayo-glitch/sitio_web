<?php
/**
 * contacto.php — Formulario enviado por POST (Clase 5).
 * Flujo: leer con filter_input + trim -> validar en servidor -> mostrar mensajes
 * -> conservar lo escrito si hay errores -> escapar con e() al imprimir (anti-XSS).
 */
require_once __DIR__ . '/includes/funciones.php';

$paises = [
    'argentina' => 'Argentina',
    'bolivia'   => 'Bolivia',
    'chile'     => 'Chile',
    'paraguay'  => 'Paraguay',
    'uruguay'   => 'Uruguay',
];

// La sesión (y su token CSRF) se inicia ANTES de enviar cualquier HTML
$csrf = token_csrf();

$campos  = ['nombre', 'email', 'edad', 'pais', 'motivo'];
$valores = array_fill_keys($campos, '');
$valores['terminos'] = false;
$errores = [];
$exito   = false;
$resumen = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Entrada sanitizada
    foreach ($campos as $campo) {
        $valores[$campo] = entrada_post($campo);
    }
    $valores['terminos'] = isset($_POST['terminos']); // checkbox: solo importa si llegó o no

    // 2) Validación en servidor
    if (!token_csrf_valido()) {
        $errores['general'] = 'La sesión del formulario expiró. Volvé a enviarlo.';
    }

    if ($valores['nombre'] === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (largo($valores['nombre']) < 3 || largo($valores['nombre']) > 40) {
        $errores['nombre'] = 'El nombre debe tener entre 3 y 40 caracteres.';
    } elseif (!preg_match("/^[\p{L}][\p{L} .'-]*$/u", $valores['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede contener letras, espacios, puntos, apóstrofes y guiones.';
    }

    if ($valores['email'] === '') {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (largo($valores['email']) > 254 || !filter_var($valores['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo electrónico válido (ej.: nombre@dominio.com).';
    }

    if ($valores['edad'] === '') {
        $errores['edad'] = 'La edad es obligatoria.';
    } else {
        $edad = filter_var($valores['edad'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 15, 'max_range' => 100]]);
        if ($edad === false) {
            $errores['edad'] = 'La edad debe ser un número entero entre 15 y 100.';
        }
    }

    if ($valores['pais'] === '') {
        $errores['pais'] = 'Seleccioná un país.';
    } elseif (!array_key_exists($valores['pais'], $paises)) {
        $errores['pais'] = 'El país seleccionado no es válido.';
    }

    if ($valores['motivo'] === '') {
        $errores['motivo'] = 'El motivo de la consulta es obligatorio.';
    } elseif (largo($valores['motivo']) < 10 || largo($valores['motivo']) > 1000) {
        $errores['motivo'] = 'El motivo debe tener entre 10 y 1000 caracteres.';
    }

    if (!$valores['terminos']) {
        $errores['terminos'] = 'Tenés que aceptar los términos y condiciones.';
    }

    // 3) Resultado
    if (!$errores) {
        $exito   = true;
        $resumen = $valores;
        // Formulario limpio tras un envío correcto
        $valores = array_fill_keys($campos, '');
        $valores['terminos'] = false;
        unset($_SESSION['csrf']);   // el token se usa una sola vez
        $csrf = token_csrf();       // token nuevo para el formulario limpio
    }
}

$titulo_pagina        = 'Contacto';
$encabezado_subtitulo = 'Escribinos y te respondemos en menos de 24 horas.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-contacto">
<h2 id="titulo-contacto">Contáctanos</h2>
<p>Completa el formulario para recibir información sobre nuestros servicios y cursos. Respondemos en menos de 24 horas.</p>

<?php if ($exito): ?>
<div class="alert alert-ok" role="status">
<p><strong>¡Mensaje enviado con éxito!</strong> Gracias, <?= e($resumen['nombre']) ?>. Te responderemos a <?= e($resumen['email']) ?>.</p>
<dl class="summary-list">
<dt>Nombre</dt><dd><?= e($resumen['nombre']) ?></dd>
<dt>Correo</dt><dd><?= e($resumen['email']) ?></dd>
<dt>Edad</dt><dd><?= e($resumen['edad']) ?></dd>
<dt>País</dt><dd><?= e($paises[$resumen['pais']]) ?></dd>
<dt>Motivo</dt><dd><?= nl2br(e($resumen['motivo'])) ?></dd>
</dl>
</div>
<?php elseif ($errores): ?>
<div class="alert alert-error" role="alert" id="resumen-errores" tabindex="-1">
<p><strong>No se pudo enviar el formulario.</strong> Corregí los siguientes errores:</p>
<ul>
<?php foreach ($errores as $mensaje): ?>
<li><?= e($mensaje) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<form action="contacto.php" method="post" novalidate>
<input type="hidden" name="csrf" value="<?= e($csrf) ?>">

<p class="form-group">
<label for="nombre">Nombre</label>
<input id="nombre" name="nombre" type="text" maxlength="40" autocomplete="name" placeholder="Tu nombre" value="<?= e($valores['nombre']) ?>"<?= isset($errores['nombre']) ? ' aria-invalid="true" aria-describedby="error-nombre"' : '' ?>>
<?php if (isset($errores['nombre'])): ?><span class="form-error" id="error-nombre"><?= e($errores['nombre']) ?></span><?php endif; ?>
</p>

<p class="form-group">
<label for="email">Correo electrónico</label>
<input id="email" name="email" type="email" autocomplete="email" placeholder="correo@ejemplo.com" value="<?= e($valores['email']) ?>"<?= isset($errores['email']) ? ' aria-invalid="true" aria-describedby="error-email"' : '' ?>>
<?php if (isset($errores['email'])): ?><span class="form-error" id="error-email"><?= e($errores['email']) ?></span><?php endif; ?>
</p>

<p class="form-group">
<label for="edad">Edad</label>
<input id="edad" name="edad" type="number" min="15" max="100" value="<?= e($valores['edad']) ?>"<?= isset($errores['edad']) ? ' aria-invalid="true" aria-describedby="error-edad"' : '' ?>>
<?php if (isset($errores['edad'])): ?><span class="form-error" id="error-edad"><?= e($errores['edad']) ?></span><?php endif; ?>
</p>

<p class="form-group">
<label for="pais">País</label>
<select id="pais" name="pais"<?= isset($errores['pais']) ? ' aria-invalid="true" aria-describedby="error-pais"' : '' ?>>
<option value="">Seleccione</option>
<?php foreach ($paises as $clave => $nombre_pais): ?>
<option value="<?= e($clave) ?>"<?= $valores['pais'] === $clave ? ' selected' : '' ?>><?= e($nombre_pais) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errores['pais'])): ?><span class="form-error" id="error-pais"><?= e($errores['pais']) ?></span><?php endif; ?>
</p>

<p class="form-group">
<label for="motivo">Motivo de la consulta</label>
<textarea id="motivo" name="motivo" maxlength="1000" placeholder="Escribe tu consulta"<?= isset($errores['motivo']) ? ' aria-invalid="true" aria-describedby="error-motivo"' : '' ?>><?= e($valores['motivo']) ?></textarea>
<?php if (isset($errores['motivo'])): ?><span class="form-error" id="error-motivo"><?= e($errores['motivo']) ?></span><?php endif; ?>
</p>

<p class="form-group">
<label class="checkbox-label" for="terminos">
<input id="terminos" name="terminos" type="checkbox" value="1"<?= $valores['terminos'] ? ' checked' : '' ?><?= isset($errores['terminos']) ? ' aria-invalid="true" aria-describedby="error-terminos"' : '' ?>>
<span>Acepto los términos y condiciones.</span>
</label>
<?php if (isset($errores['terminos'])): ?><span class="form-error" id="error-terminos"><?= e($errores['terminos']) ?></span><?php endif; ?>
</p>

<button type="submit">Enviar</button>
<a class="button-link" href="contacto.php">Limpiar formulario</a>
</form>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

<?php
/**
 * header.php — <head>, metadatos, hoja de estilos y cabecera del sitio.
 *
 * Variables que define cada página ANTES de incluir esta plantilla:
 *   $titulo_pagina        (string)  Título de la pestaña. Se le agrega " | NOMBRE_APP".
 *   $encabezado_titulo    (string, opcional)  <h1> de la cabecera. Por defecto APP_NAME.
 *   $encabezado_subtitulo (string, opcional)  Subtítulo de la cabecera.
 */
require_once __DIR__ . '/../config/env.php';

$titulo_pagina        = $titulo_pagina        ?? 'Inicio';
$encabezado_titulo    = $encabezado_titulo    ?? APP_NAME;
$encabezado_subtitulo = $encabezado_subtitulo ?? 'Aprendé HTML, diseño web y accesibilidad de forma práctica.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo_pagina) ?> | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<a class="skip-link" href="#contenido-principal">Saltar al contenido principal</a>
<header class="site-header"><h1><?= htmlspecialchars($encabezado_titulo) ?></h1><p class="site-subtitle"><?= htmlspecialchars($encabezado_subtitulo) ?></p></header>

<?php
/**
 * Carga las variables de entorno desde el archivo .env (raíz del proyecto)
 * y las expone como constantes globales.
 *
 * Si .env no existe (por ejemplo, recién clonado el repo) se usan valores
 * por defecto. Para configurar: copiar .env.example a .env.
 */

$env_defaults = [
    'APP_NAME'      => 'Mi Sitio Web',
    'APP_OWNER'     => 'WayerFC',
    'SUPPORT_EMAIL' => 'soporte@example.com',
    'APP_ENV'       => 'local',
];

$env_valores = $env_defaults;
$env_archivo = dirname(__DIR__) . '/.env';

if (is_readable($env_archivo)) {
    foreach (file($env_archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);

        // Ignorar comentarios y líneas sin "="
        if ($linea === '' || $linea[0] === '#' || strpos($linea, '=') === false) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        // Quitar comillas simples o dobles alrededor del valor
        if (strlen($valor) >= 2 && ($valor[0] === '"' || $valor[0] === "'") && substr($valor, -1) === $valor[0]) {
            $valor = substr($valor, 1, -1);
        }

        $env_valores[$clave] = $valor;
    }
}

foreach ($env_valores as $clave => $valor) {
    if (!defined($clave)) {
        define($clave, $valor);
    }
}

// Según el entorno, mostrar u ocultar errores de PHP
if (APP_ENV === 'local') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}

unset($env_defaults, $env_valores, $env_archivo, $linea, $clave, $valor);

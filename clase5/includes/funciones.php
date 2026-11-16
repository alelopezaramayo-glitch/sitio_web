<?php
/**
 * funciones.php — utilidades de sanitización y validación (Clase 5).
 *
 * Regla de oro (prevención de XSS, OWASP Top 10):
 *   1) ENTRADA: todo dato de $_POST / $_GET se lee con filter_input(), se recorta
 *      con trim() y se le quitan caracteres de control. Nunca se usa $_POST/$_GET directo.
 *   2) SALIDA: todo dato que se imprime en pantalla pasa por e() (htmlspecialchars),
 *      de modo que <script> se muestra como texto y nunca se ejecuta.
 */

/**
 * Escapa un valor para imprimirlo de forma segura en HTML (texto y atributos).
 */
function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Limpia un texto recibido: trim() + elimina caracteres de control invisibles.
 */
function limpiar_texto(mixed $valor): string
{
    if (!is_string($valor)) {
        return '';
    }
    $valor = trim($valor);
    // Quita caracteres de control (excepto salto de línea y tabulación)
    $valor = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $valor) ?? '';
    return $valor;
}

/**
 * Lee un campo enviado por POST de forma segura.
 */
function entrada_post(string $campo): string
{
    return limpiar_texto(filter_input(INPUT_POST, $campo, FILTER_UNSAFE_RAW));
}

/**
 * Lee un parámetro enviado por GET (query string) de forma segura.
 */
function entrada_get(string $campo): string
{
    return limpiar_texto(filter_input(INPUT_GET, $campo, FILTER_UNSAFE_RAW));
}

/**
 * Longitud de un texto en caracteres (UTF-8).
 */
function largo(string $texto): int
{
    return mb_strlen($texto, 'UTF-8');
}

/**
 * Genera (o reutiliza) el token CSRF de la sesión para los formularios POST.
 */
function token_csrf(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/**
 * Comprueba el token CSRF recibido por POST.
 */
function token_csrf_valido(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $recibido = entrada_post('csrf');
    return isset($_SESSION['csrf']) && $recibido !== '' && hash_equals($_SESSION['csrf'], $recibido);
}

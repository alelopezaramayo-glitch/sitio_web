<?php
$titulo_pagina = 'JavaScript';
$encabezado_titulo = 'JavaScript';
$encabezado_subtitulo = 'Interactividad para páginas web: formularios, eventos, fechas, galerías y más.';
$hint_teclado = '⌨️ Usá Tab para navegar y Enter para activar controles.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card"><h2>Aprender JavaScript</h2><p>JavaScript permite convertir una página estática en una experiencia interactiva. En esta sección se aplican conceptos básicos del lenguaje mediante ejemplos prácticos.</p><figure><img src="assets/javascript.svg" alt="Ilustración sobre JavaScript"><figcaption>JavaScript agrega comportamiento e interacción a una página web.</figcaption></figure></section>
<section class="content-card">
<h2>Conceptos fundamentales</h2>
<p><strong>String:</strong> representa texto. <strong>Number:</strong> representa números. <strong>Boolean:</strong> trabaja con verdadero o falso. También existen <strong>undefined</strong>, <strong>null</strong>, <strong>Symbol</strong> y <strong>BigInt</strong>.</p>
<p>JavaScript es un lenguaje multiparadigma: permite trabajar con programación imperativa, funcional y orientada a objetos. En el navegador se ejecuta mediante un motor JavaScript y puede modificar el contenido, estilos y comportamiento de una página.</p>
</section>
<section class="content-card">
<h2>JavaScript en este sitio</h2>
<p>Las prácticas de esta página muestran situaciones habituales del desarrollo web: mostrar mensajes, validar información antes de enviarla, consultar la fecha y hora, controlar elementos visibles, recorrer una galería, cambiar el tema visual y presentar un resumen de datos.</p>
</section>
<section class="content-card">
<h2>Video: JavaScript y desarrollo web</h2>
<p>Presentación breve de las tecnologías utilizadas en el sitio.</p>
<figure class="video-wrapper"><video controls preload="metadata" poster="assets/javascript.svg"><source src="assets/desarrollo-web.mp4" type="video/mp4">Tu navegador no puede reproducir este video.</video></figure>
</section>
<section class="content-card"><h2>Mensajes</h2><p>Al cargar la página se muestra un saludo y también podés ejecutarlo nuevamente.</p><button id="saludo">Mostrar saludo</button></section>
<section class="content-card"><h2>Validación de formulario</h2><form id="form-validacion"><label for="js-nombre">Nombre</label><input id="js-nombre" required><span id="js-error-nombre" class="form-error" aria-live="polite"></span><label for="js-correo">Correo electrónico</label><input id="js-correo" type="email" required><span id="js-error-correo" class="form-error" aria-live="polite"></span><button>Validar</button><p id="js-ok" class="success-message" aria-live="polite"></p></form></section>
<section class="content-card"><h2>Fecha y hora</h2><p>Fecha: <strong id="fecha"></strong></p><p>Hora: <strong id="hora"></strong></p></section>
<section class="content-card"><h2>Menú interactivo</h2><button id="toggle-menu" aria-expanded="false" aria-controls="menu-js">Mostrar / ocultar</button><div id="menu-js" class="interactive-panel">Este contenido se puede mostrar u ocultar usando JavaScript y clases CSS.</div></section>
<section class="content-card"><h2>Galería interactiva</h2><div class="js-gallery"><img id="foto-js" src="assets/html.svg" alt="Imagen de HTML"><div><button id="anterior">Anterior</button><button id="siguiente">Siguiente</button></div><div class="gallery-thumbs"><button data-i="0"><img src="assets/html.svg" alt="HTML"></button><button data-i="1"><img src="assets/css.svg" alt="CSS"></button><button data-i="2"><img src="assets/javascript.svg" alt="JavaScript"></button><button data-i="3"><img src="assets/accesibilidad.svg" alt="Accesibilidad"></button></div><button id="ampliar">Ampliar imagen</button><img id="foto-grande" class="expanded-image" alt=""></div></section>
<section class="content-card"><h2>Modo oscuro</h2><button id="tema">Activar / desactivar modo oscuro</button></section>
<section class="content-card"><h2>Formulario con resumen</h2><form id="resumen-form"><label for="r-nombre">Nombre</label><input id="r-nombre" required><label for="r-edad">Edad</label><input id="r-edad" type="number" min="1" required><label for="r-email">Correo</label><input id="r-email" type="email" required><button>Mostrar resumen</button></form><div id="resumen-js" class="summary-box" aria-live="polite"></div></section>
</main>
<?php
$scripts_extra = ['javascript.js'];
require_once __DIR__ . '/includes/footer.php';

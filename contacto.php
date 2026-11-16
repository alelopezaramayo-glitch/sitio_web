<?php
$titulo_pagina = 'Contacto';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main id="contenido-principal">
<section class="content-card" aria-labelledby="titulo-contacto">
<h2 id="titulo-contacto">Contáctanos</h2>
<p>Completa el formulario para recibir información sobre nuestros servicios y cursos. Respondemos en menos de 24 horas.</p>
<form action="/registrar.php" method="post">
<p class="form-group">
<label for="nombre">Nombre</label>
<input id="nombre" name="nombre" type="text" required minlength="3" maxlength="40" autocomplete="name" placeholder="Tu nombre">
</p>
<p class="form-group">
<label for="email">Correo electrónico</label>
<input id="email" name="email" type="email" required autocomplete="email" placeholder="correo@ejemplo.com">
</p>
<p class="form-group">
<label for="edad">Edad</label>
<input id="edad" name="edad" type="number" min="15" max="100" required>
</p>
<p class="form-group">
<label for="pais">País</label>
<select id="pais" name="pais" required>
<option value="">Seleccione</option>
<option value="argentina">Argentina</option>
<option value="chile">Chile</option>
</select>
</p>
<p class="form-group">
<label for="motivo">Motivo de la consulta</label>
<textarea id="motivo" name="motivo" required minlength="10" placeholder="Escribe tu consulta"></textarea>
</p>
<p class="form-group">
<label class="checkbox-label" for="terminos">
<input id="terminos" name="terminos" type="checkbox" required>
<span>Acepto los términos y condiciones.</span>
</label>
</p>
<button type="submit">Enviar</button>
<button type="reset">Borrar</button>
</form>
</section>
</main>
<?php
require_once __DIR__ . '/includes/footer.php';

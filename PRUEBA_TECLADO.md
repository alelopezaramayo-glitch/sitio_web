# Prueba de navegación con teclado

Realizada sobre la estructura HTML/CSS de las 11 páginas.

## Secuencia esperada
1. `Tab` entra primero al enlace "Saltar al contenido principal".
2. `Tab` continúa por los enlaces de navegación en orden visual.
3. El foco es visible mediante `:focus-visible`.
4. En `contacto.html`, `Tab` recorre: nombre → correo → edad → país → motivo → términos → enviar → borrar.
5. `Shift + Tab` permite retroceder.
6. `Enter` activa enlaces y botones.
7. `Espacio` activa el checkbox y los botones cuando tienen el foco.

## Resultado de revisión estática
- Todos los enlaces de navegación son elementos `<a>` nativos.
- Los controles del formulario son elementos HTML nativos.
- No se añadieron manejadores que dependan exclusivamente del mouse.
- Se agregó un enlace de salto al contenido en todas las páginas.
- Se agregaron indicadores de foco visibles y con contraste adecuado.

**Nota:** la prueba manual final debe hacerse en un navegador real con `Tab`, `Shift+Tab`, `Enter` y `Espacio`.

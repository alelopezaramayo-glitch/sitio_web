# Sitio web - versión accesible

Cambios realizados:

1. **Navegación por teclado**
   - Se agregó un enlace "Saltar al contenido principal".
   - Se definieron estados `:focus-visible` claramente visibles.
   - Se mantuvo un orden lógico de tabulación.
   - Los controles del formulario son accesibles con Tab, Shift+Tab, Enter y Espacio según el control.

2. **Contraste**
   - Se revisaron los colores principales con WebAIM Contrast Checker.
   - Blanco `#FFFFFF` sobre `#333333`: **12.63:1**, supera WCAG AA y AAA para texto normal.
   - Blanco `#FFFFFF` sobre `#555555`: **7.46:1**, supera WCAG AA y AAA para texto normal.
   - Amarillo `#FFFF00` sobre `#555555`: **6.94:1**, supera WCAG AA y AAA para texto normal.
   - Se incorporó `webaim_contrast_analysis.png` como captura/registro del análisis.
   - Herramienta oficial: https://webaim.org/resources/contrastchecker/

3. **Idioma**
   - Todas las páginas tienen `<html lang="es">`.

4. **Texto alternativo**
   - Todas las imágenes tienen `alt` descriptivo.
   - Se añadieron `figure` y `figcaption` cuando corresponde.

5. **Formularios**
   - Todos los controles tienen un `<label>` asociado mediante `for` + `id`.
   - El checkbox de términos también tiene asociación explícita.
   - Se añadieron atributos `autocomplete` en nombre y correo.

6. **Video**
   - Se agregó un video relacionado con HTML en `curso.html`, con `title` accesible para el iframe.

7. **HTML semántico**
   - Se utilizan `header`, `nav`, `main`, `section`, `article`, `figure`, `footer` y otros elementos semánticos.
   - El sitio original ya no tenía etiquetas `<div>` en las páginas principales; en esta versión se mantiene **0 etiquetas `<div>`**.

## Verificación rápida

- Archivos HTML: 11
- `<html lang="es">`: 11/11
- Imágenes con `alt`: todas
- Etiquetas `<div>`: 0
- Formularios con labels: `contacto.html`

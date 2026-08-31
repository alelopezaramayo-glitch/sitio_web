# Sitio web accesible

Sitio web estático preparado para publicarse en GitHub Pages.

## Incluye

- `index.html` como página principal.
- `styles.css` como hoja de estilos externa compartida por todas las páginas.
- Navegación mediante teclado con foco visible y enlace "Saltar al contenido principal".
- Estructura semántica HTML y `lang="es"`.
- Textos alternativos (`alt`) para las imágenes.
- Formularios con etiquetas `label` asociadas.
- Video relacionado con la temática del sitio.
- Diseño responsive para escritorio y dispositivos móviles.
- Soporte para `prefers-reduced-motion`.

## Publicar en GitHub Pages

1. Crear un repositorio nuevo en GitHub.
2. Subir **todos los archivos y carpetas de esta carpeta**, manteniendo sus nombres.
3. Ir a **Settings → Pages**.
4. En **Build and deployment**, seleccionar **Deploy from a branch**.
5. Elegir la rama `main` y la carpeta `/ (root)`.
6. Guardar y esperar a que GitHub Pages publique el sitio.

La página inicial es `index.html`, por lo que GitHub Pages la utilizará como portada.


## Contenido ampliado
Se incorporó una sección práctica de JavaScript con mensajes, validación de formularios, fecha y hora, menú interactivo, galería, modo oscuro y resumen de formulario. Las imágenes utilizadas se guardan localmente en `assets/` para evitar depender de servicios externos.

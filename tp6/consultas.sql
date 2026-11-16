-- =====================================================================
-- consultas.sql — Pruebas CRUD sobre la base "mi_sitio_web" (TP 6)
-- Ejecutar DESPUÉS de schema.sql.
--
-- Los INSERT usan ids fijos y ON DUPLICATE KEY UPDATE, de modo que el
-- script se puede ejecutar varias veces sin errores.
-- =====================================================================

USE mi_sitio_web;

-- =====================================================================
-- 1) CREATE — Inserción de datos iniciales
-- =====================================================================

-- 1.a) Tablas maestras / secundarias (3 roles, 3 categorías, 3 estados, 5 etiquetas, 3 países)
INSERT INTO roles (id_rol, nombre, descripcion) VALUES
    (1, 'Administrador', 'Gestiona todo el sitio'),
    (2, 'Editor',        'Redacta y edita publicaciones'),
    (3, 'Visitante',     'Usuario registrado sin permisos de edición')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion);

INSERT INTO categorias (id_categoria, nombre, descripcion) VALUES
    (1, 'HTML',       'Contenidos sobre estructura web'),
    (2, 'CSS',        'Contenidos sobre estilos y diseño'),
    (3, 'JavaScript', 'Contenidos sobre interactividad')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion);

INSERT INTO estados_publicacion (id_estado, nombre) VALUES
    (1, 'Borrador'),
    (2, 'Publicado'),
    (3, 'Archivado')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO etiquetas (id_etiqueta, nombre) VALUES
    (1, 'html'),
    (2, 'accesibilidad'),
    (3, 'css'),
    (4, 'layout'),
    (5, 'javascript')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO paises (id_pais, nombre) VALUES
    (1, 'Argentina'),
    (2, 'Chile'),
    (3, 'Uruguay')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- 1.b) Usuarios (el password_hash es un valor de ejemplo con forma de hash bcrypt de PHP)
INSERT INTO usuarios (id_usuario, id_rol, nombre, apellido, email, password_hash, telefono) VALUES
    (1, 1, 'Santiago', 'Lopez', 'santiago@example.com', '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012345', '387-5111111'),
    (2, 2, 'Ana',      'Perez', 'ana@example.com',      '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ678901', '387-5222222')
ON DUPLICATE KEY UPDATE id_rol = VALUES(id_rol), nombre = VALUES(nombre), apellido = VALUES(apellido),
                        telefono = VALUES(telefono);

-- 1.c) Tabla principal: 3 publicaciones vinculadas con sus claves foráneas
--      (id_usuario = autor, id_categoria, id_estado)
INSERT INTO publicaciones (id_publicacion, id_usuario, id_categoria, id_estado, titulo, contenido, fecha_publicacion) VALUES
    (1, 1, 1, 2, 'Guía de HTML semántico',
        'Cómo usar header, nav, main y footer para estructurar páginas accesibles.', '2026-11-01'),
    (2, 1, 2, 1, 'Flexbox en 10 minutos',
        'Introducción práctica a Flexbox para armar diseños responsive.', NULL),
    (3, 2, 3, 1, 'Publicación de prueba (se eliminará)',
        'Registro temporal para probar la sentencia DELETE.', NULL)
ON DUPLICATE KEY UPDATE id_usuario = VALUES(id_usuario), id_categoria = VALUES(id_categoria),
                        id_estado = VALUES(id_estado), titulo = VALUES(titulo),
                        contenido = VALUES(contenido), fecha_publicacion = VALUES(fecha_publicacion);

-- 1.d) Tabla de relación N:M: etiquetas de cada publicación
INSERT INTO publicacion_etiqueta (id_publicacion, id_etiqueta) VALUES
    (1, 1), (1, 2),     -- "Guía de HTML semántico": html, accesibilidad
    (2, 3), (2, 4),     -- "Flexbox en 10 minutos": css, layout
    (3, 5)              -- "Publicación de prueba": javascript
ON DUPLICATE KEY UPDATE id_etiqueta = VALUES(id_etiqueta);

-- 1.e) Consultas del formulario de contacto
INSERT INTO consultas (id_consulta, id_usuario, id_pais, nombre, email, edad, motivo, acepto_terminos) VALUES
    (1, NULL, 1, 'Lucía Gómez',  'lucia@example.com',  22, 'Quiero información sobre el curso de HTML.', 1),
    (2, 2,    2, 'Ana Perez',    'ana@example.com',    30, 'Consulta sobre accesibilidad en formularios.', 1)
ON DUPLICATE KEY UPDATE id_pais = VALUES(id_pais), nombre = VALUES(nombre), email = VALUES(email),
                        edad = VALUES(edad), motivo = VALUES(motivo), atendida = 0;

-- =====================================================================
-- 2) READ — Consultas y uniones
-- =====================================================================

-- 2.a) SELECT con WHERE y ORDER BY:
--      publicaciones en estado "Publicado" (id_estado = 2) ordenadas de la más reciente a la más antigua
SELECT id_publicacion, titulo, fecha_publicacion
FROM publicaciones
WHERE id_estado = 2
ORDER BY fecha_publicacion DESC;

-- 2.b) INNER JOIN de cuatro tablas:
--      título de la publicación + nombre del autor + categoría + estado
SELECT p.id_publicacion,
       p.titulo,
       CONCAT(u.nombre, ' ', u.apellido) AS autor,
       c.nombre                          AS categoria,
       e.nombre                          AS estado
FROM publicaciones p
INNER JOIN usuarios            u ON u.id_usuario   = p.id_usuario
INNER JOIN categorias          c ON c.id_categoria = p.id_categoria
INNER JOIN estados_publicacion e ON e.id_estado    = p.id_estado
ORDER BY p.id_publicacion;

-- 2.c) INNER JOIN a través de la tabla N:M: publicaciones con sus etiquetas
SELECT p.titulo,
       t.nombre AS etiqueta
FROM publicaciones p
INNER JOIN publicacion_etiqueta pe ON pe.id_publicacion = p.id_publicacion
INNER JOIN etiquetas            t  ON t.id_etiqueta     = pe.id_etiqueta
WHERE p.id_categoria IN (1, 2)
ORDER BY p.titulo, t.nombre;

-- 2.d) INNER JOIN: consultas del formulario con el país de origen, solo las pendientes
SELECT q.id_consulta, q.nombre, q.email, pa.nombre AS pais, q.motivo
FROM consultas q
INNER JOIN paises pa ON pa.id_pais = q.id_pais
WHERE q.atendida = 0
ORDER BY q.created_at DESC, q.id_consulta DESC;

-- =====================================================================
-- 3) UPDATE — Modificación de un registro específico (siempre con WHERE)
-- =====================================================================

-- 3.a) Publicar la entrada 2: cambia su estado a "Publicado" (id_estado = 2) y fija la fecha
UPDATE publicaciones
SET id_estado = 2,
    fecha_publicacion = '2026-11-12'
WHERE id_publicacion = 2;

-- 3.b) Marcar como atendida la consulta 1
UPDATE consultas
SET atendida = 1
WHERE id_consulta = 1;

-- Verificación del UPDATE
SELECT id_publicacion, titulo, id_estado, fecha_publicacion
FROM publicaciones
WHERE id_publicacion = 2;

-- =====================================================================
-- 4) DELETE — Baja de un registro de prueba (siempre con WHERE)
-- =====================================================================

-- Se elimina la publicación temporal. Sus filas en publicacion_etiqueta se borran
-- solas por la restricción ON DELETE CASCADE.
DELETE FROM publicaciones
WHERE id_publicacion = 3;

-- Verificación del DELETE: no debe devolver filas
SELECT * FROM publicaciones WHERE id_publicacion = 3;

-- Verificación de la cascada: la publicación 3 ya no tiene etiquetas (0 filas)
SELECT * FROM publicacion_etiqueta WHERE id_publicacion = 3;

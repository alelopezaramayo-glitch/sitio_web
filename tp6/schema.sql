-- =====================================================================
-- schema.sql — Esquema de la base de datos de "Mi Sitio Web" (TP 6)
-- Motor: MySQL / MariaDB (XAMPP, Laragon, phpMyAdmin)
-- Modelo en 3FN: ver NORMALIZACION.md
--
-- Cómo ejecutarlo:
--   phpMyAdmin -> pestaña "Importar" -> elegir schema.sql -> Continuar
--   o en consola: mysql -u root -p < schema.sql
--
-- El script es re-ejecutable: borra y vuelve a crear las tablas del
-- proyecto (en orden inverso a sus dependencias).
-- =====================================================================

CREATE DATABASE IF NOT EXISTS mi_sitio_web
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE mi_sitio_web;

-- ---------------------------------------------------------------------
-- Limpieza previa (hijas primero, para respetar las claves foráneas)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS publicacion_etiqueta;
DROP TABLE IF EXISTS consultas;
DROP TABLE IF EXISTS publicaciones;
DROP TABLE IF EXISTS etiquetas;
DROP TABLE IF EXISTS estados_publicacion;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS paises;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;

-- ---------------------------------------------------------------------
-- Tablas maestras / secundarias
-- ---------------------------------------------------------------------

-- Roles de usuario (Administrador, Editor, Visitante)
CREATE TABLE roles (
    id_rol      INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(30)  NOT NULL,
    descripcion VARCHAR(150) NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_roles_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

-- Categorías de las publicaciones del blog
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(40)  NOT NULL,
    descripcion  VARCHAR(150) NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_categorias_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

-- Estados posibles de una publicación (Borrador, Publicado, Archivado)
CREATE TABLE estados_publicacion (
    id_estado  INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_estados_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

-- Etiquetas (palabras clave) para las publicaciones
CREATE TABLE etiquetas (
    id_etiqueta INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(40) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_etiquetas_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

-- Países (lista usada por el formulario de contacto de la Clase 5)
CREATE TABLE paises (
    id_pais    INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(60) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_paises_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Usuarios (autenticación, rol y datos personales)
-- ---------------------------------------------------------------------
CREATE TABLE usuarios (
    id_usuario    INT AUTO_INCREMENT PRIMARY KEY,
    id_rol        INT          NOT NULL,
    nombre        VARCHAR(40)  NOT NULL,
    apellido      VARCHAR(40)  NOT NULL,
    email         VARCHAR(120) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,   -- se guarda el hash (password_hash() de PHP), nunca la contraseña
    telefono      VARCHAR(20)  NULL,
    activo        TINYINT(1)   NOT NULL DEFAULT 1,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_usuarios_email UNIQUE (email),
    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (id_rol) REFERENCES roles (id_rol)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla principal de negocio: publicaciones del blog
-- ---------------------------------------------------------------------
CREATE TABLE publicaciones (
    id_publicacion    INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario        INT          NOT NULL,   -- autor
    id_categoria      INT          NOT NULL,
    id_estado         INT          NOT NULL,
    titulo            VARCHAR(120) NOT NULL,
    contenido         TEXT         NOT NULL,
    fecha_publicacion DATE         NULL,       -- NULL mientras es borrador
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_publicaciones_usuarios
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_publicaciones_categorias
        FOREIGN KEY (id_categoria) REFERENCES categorias (id_categoria)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_publicaciones_estados
        FOREIGN KEY (id_estado) REFERENCES estados_publicacion (id_estado)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla de relación N:M entre publicaciones y etiquetas
-- (la clave primaria es compuesta: no necesita AUTO_INCREMENT)
-- ---------------------------------------------------------------------
CREATE TABLE publicacion_etiqueta (
    id_publicacion INT NOT NULL,
    id_etiqueta    INT NOT NULL,
    PRIMARY KEY (id_publicacion, id_etiqueta),
    CONSTRAINT fk_pe_publicaciones
        FOREIGN KEY (id_publicacion) REFERENCES publicaciones (id_publicacion)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_pe_etiquetas
        FOREIGN KEY (id_etiqueta) REFERENCES etiquetas (id_etiqueta)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Consultas recibidas por el formulario de contacto (Clase 5, método POST)
-- ---------------------------------------------------------------------
CREATE TABLE consultas (
    id_consulta     INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario      INT          NULL,        -- opcional: si quien consulta está registrado
    id_pais         INT          NOT NULL,
    nombre          VARCHAR(40)  NOT NULL,
    email           VARCHAR(120) NOT NULL,
    edad            TINYINT UNSIGNED NOT NULL,
    motivo          TEXT         NOT NULL,
    acepto_terminos TINYINT(1)   NOT NULL DEFAULT 0,
    atendida        TINYINT(1)   NOT NULL DEFAULT 0,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_consultas_edad CHECK (edad BETWEEN 15 AND 100),
    CONSTRAINT fk_consultas_usuarios
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT fk_consultas_paises
        FOREIGN KEY (id_pais) REFERENCES paises (id_pais)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Índices explícitos (campos de filtrado frecuente)
-- ---------------------------------------------------------------------

-- Filtrar el blog por categoría y estado (ej.: publicaciones "Publicado" de "HTML")
CREATE INDEX idx_publicaciones_categoria_estado ON publicaciones (id_categoria, id_estado);

-- Ordenar / filtrar publicaciones por fecha
CREATE INDEX idx_publicaciones_fecha ON publicaciones (fecha_publicacion);

-- Buscar consultas por correo electrónico del remitente
CREATE INDEX idx_consultas_email ON consultas (email);

-- Nota: usuarios.email ya tiene un índice único (uq_usuarios_email), por lo que
-- la búsqueda de un usuario por email (login) también está optimizada.

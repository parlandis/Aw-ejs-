SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: eventia_db
--


-- Borrado de usuarios y base de datos previos
DROP DATABASE IF EXISTS ejercicio3_db;
DROP USER IF EXISTS 'usuario_cliente'@'localhost';
DROP USER IF EXISTS 'usuario_admin'@'localhost';
DROP USER IF EXISTS 'usuario_promotor'@'localhost';


-- Creacion de la base de datos
CREATE DATABASE IF NOT EXISTS ejercicio3_db DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE ejercicio3_db;




-- Estructura de la tabla Eventos

CREATE TABLE eventos (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  precio VARCHAR(255) NOT NULL,
  descripcion TEXT DEFAULT NULL,
  fecha_inicio DATE NOT NULL,
  ubicacion VARCHAR(255) DEFAULT NULL,
  organizador VARCHAR(100) DEFAULT NULL,
  imagen VARCHAR(255) NOT NULL DEFAULT 'img/default.jpg',
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insercion de datos en la tabla Eventos

INSERT INTO eventos (id, nombre, precio, descripcion, fecha_inicio, ubicacion, organizador, imagen) VALUES
(1, 'Concierto de Metallica', 20, NULL, '2025-03-15', NULL, NULL, 'img/metallica.jpg'),
(2, 'Concierto Anuel AA', 3, NULL, '2025-03-31', NULL, NULL, 'img/anuel.jpg'),
(3, 'Halloween en Fabrik', 100, 'Halloween en Fabrik!! No te lo pierdas', '2026-10-31', 'Fabrik', 'Eventia', 'img/halloween.jpg');


-- Estructura de la tabla Foro

CREATE TABLE foro (
  id int(11) NOT NULL AUTO_INCREMENT,
  titulo varchar(255) NOT NULL,
  autor varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  mensaje text NOT NULL,
  evento int(11) DEFAULT NULL,
  fecha_publicacion timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insercion de datos en la tabla Foro

INSERT INTO `foro` (`id`, `titulo`, `autor`, `email`, `mensaje`, `evento`, `fecha_publicacion`) VALUES
(4, 'Prueba ', 'admin', 'admin@eventia.es', 'Probando \r\n', NULL, '2025-03-07 19:37:51');




-- Estructura de la tabla Usuarios

CREATE TABLE usuarios (
  username varchar(10) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(255) NOT NULL,
  rol ENUM('cliente', 'promotor', 'administrador') NOT NULL DEFAULT 'cliente',
  puntos VARCHAR(255) NOT NULL DEFAULT 0,
  PRIMARY KEY(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insercion de datos en la tabla Usuarios

INSERT INTO usuarios (username, email, password, rol, puntos) VALUES
('admin', 'admin@eventia.es', '$2y$10$nx7sPLOeZyLFfQ5wHYDSnea7eJOtf5XGhEKDK7YJpe8Bmp8wk5dkG', 'administrador', 0),
('user', ' user@gmail.com', '$2y$10$0jHBrtOHcO/BQi8mZ1ZZvulNjN4UUQhjRlkx/m55RaH8GbKdd.db.', 'cliente', 0);



-- Estructura de la tabla Valoraciones
CREATE TABLE valoraciones (
  id_evento INT(11) NOT NULL,
  username varchar(10) DEFAULT NULL,
  nota INT(1) NOT NULL CHECK (nota BETWEEN 1 AND 5),
  comentario TEXT DEFAULT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha en que se realizó la valoración
  FOREIGN KEY (id_evento) REFERENCES eventos(id) ON DELETE CASCADE,
  FOREIGN KEY (username) REFERENCES usuarios(username) ON DELETE SET NULL,
  PRIMARY KEY(id_evento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insercion de datos en la tabla Valoraciones

INSERT INTO valoraciones (id_evento, username, nota, comentario, fecha) VALUES
(1, 'admin', 5, 'Tercio gratis para aquellos que lleguéis antes de las 19:00!!! No te lo pierdas ;)', '2025-03-13'),
(2, 'user', 5, 'guapísimo', '2025-03-17'),
(3, 'user', 4, 'aunque me decepcionó un poco que no se rompiera la camiseta al terminar el conci :(', '2025-03-17');



--
-- CREACION DE LOS USUARIOS DE ACCESO A LA BD
--


-- Clientes - MODIFICADO para incluir UPDATE en la tabla foro
CREATE USER 'usuario_cliente'@'localhost' IDENTIFIED BY 'clientepass';
-- Concedemos acceso a select, insert y UPDATE en foro para que puedan editar sus propios mensajes
GRANT SELECT, INSERT ON ejercicio3_db.usuarios TO 'usuario_cliente'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ejercicio3_db.foro TO 'usuario_cliente'@'localhost';
GRANT SELECT, INSERT ON ejercicio3_db.eventos TO 'usuario_cliente'@'localhost';
GRANT SELECT, INSERT ON ejercicio3_db.valoraciones TO 'usuario_cliente'@'localhost';

-- Promotores
CREATE USER 'usuario_promotor'@'localhost' IDENTIFIED BY 'promotorpass';
-- Concedemos acceso a select e insert en todas las tablas, ademas de update y delete en eventos
GRANT SELECT, INSERT ON ejercicio3_db.usuarios TO 'usuario_promotor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ejercicio3_db.foro TO 'usuario_promotor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ejercicio3_db.eventos TO 'usuario_promotor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON ejercicio3_db.valoraciones TO 'usuario_promotor'@'localhost';

-- Administrador
CREATE USER 'usuario_admin'@'localhost' IDENTIFIED BY 'adminpass';
-- Concedemos todos los permisos
GRANT ALL PRIVILEGES ON ejercicio3_db.* TO 'usuario_admin'@'localhost';

-- Aplicar cambios
FLUSH PRIVILEGES;

COMMIT;
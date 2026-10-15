-- =====================================================================
-- SIS-256 - Laboratorio 3 - Tema 3: PHP con base de datos
-- Base de datos: bd_consultorio26
-- Importar desde phpMyAdmin:  Importar -> seleccionar este archivo -> Continuar
-- =====================================================================

CREATE DATABASE IF NOT EXISTS bd_consultorio26
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bd_consultorio26;

DROP TABLE IF EXISTS citas;
DROP TABLE IF EXISTS pacientes;
DROP TABLE IF EXISTS medicos;
DROP TABLE IF EXISTS especialidades;
DROP TABLE IF EXISTS usuarios;

-- ---------------------------------------------------------------------
-- usuarios: tabla de autenticacion. La clave se guarda cifrada con sha1
-- La clave de los dos usuarios de prueba es:  123
-- sha1("123") = 40bd001563085fc35165329ea1ff5c5ecbdbbeef
-- ---------------------------------------------------------------------
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  correo VARCHAR(100) NOT NULL UNIQUE,
  clave VARCHAR(100) NOT NULL,
  nombre VARCHAR(80) NOT NULL,
  rol ENUM('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (correo, clave, nombre, rol) VALUES
('admin@sis256.edu',     '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Dra. Administradora', 'admin'),
('recepcion@sis256.edu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Recepcion',           'user');

-- ---------------------------------------------------------------------
CREATE TABLE especialidades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO especialidades (nombre) VALUES
('Medicina General'),
('Pediatria'),
('Cardiologia'),
('Odontologia'),
('Dermatologia');

-- ---------------------------------------------------------------------
CREATE TABLE medicos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombres VARCHAR(60) NOT NULL,
  apellidos VARCHAR(60) NOT NULL,
  especialidad_id INT NOT NULL,
  FOREIGN KEY (especialidad_id) REFERENCES especialidades(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO medicos (nombres, apellidos, especialidad_id) VALUES
('Ramiro',  'Zalles Vaca',      1),
('Patricia','Nogales Siles',    2),
('Hugo',    'Camargo Arancibia',3),
('Lucia',   'Ortiz Mendoza',    4),
('Javier',  'Rocha Bustamante', 5);

-- ---------------------------------------------------------------------
CREATE TABLE pacientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fotografia VARCHAR(100) NOT NULL DEFAULT '',
  nombres VARCHAR(60) NOT NULL,
  apellidos VARCHAR(60) NOT NULL,
  ci VARCHAR(20) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  fecha_nacimiento DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO pacientes (fotografia, nombres, apellidos, ci, telefono, fecha_nacimiento) VALUES
('p1.png', 'Ana Maria',  'Rojas Vargas',     '5412398', '70412345', '1992-04-18'),
('p2.png', 'Carlos',     'Mendoza Quispe',   '4820117', '71523344', '1985-11-02'),
('p3.png', 'Lucia',      'Fernandez Soria',  '6933142', '72634455', '2001-07-25'),
('',       'Jorge Luis',  'Arancibia Flores', '3711205', '68745566', '1978-01-09'),
('',       'Daniela',     'Paredes Cossio',   '7245896', '73856677', '1996-09-14'),
('',       'Marcelo',     'Choque Mamani',    '5129634', '69967788', '1989-03-30'),
('',       'Veronica',    'Salinas Duran',    '6540278', '74078899', '1994-12-05'),
('',       'Ruben',       'Guzman Teran',     '4398712', '71189900', '1982-06-21');

-- ---------------------------------------------------------------------
CREATE TABLE citas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  paciente_id INT NOT NULL,
  medico_id INT NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  motivo VARCHAR(150) NOT NULL,
  estado ENUM('pendiente','atendida','cancelada') NOT NULL DEFAULT 'pendiente',
  FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
  FOREIGN KEY (medico_id)   REFERENCES medicos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO citas (paciente_id, medico_id, fecha, hora, motivo, estado) VALUES
(1, 1, '2026-10-19', '08:30:00', 'Control anual',                 'pendiente'),
(2, 3, '2026-10-19', '09:15:00', 'Dolor en el pecho',             'pendiente'),
(3, 2, '2026-10-20', '10:00:00', 'Control de crecimiento',        'atendida'),
(4, 4, '2026-10-20', '11:30:00', 'Limpieza dental',               'pendiente'),
(5, 5, '2026-10-21', '08:00:00', 'Manchas en la piel',            'cancelada'),
(6, 1, '2026-10-21', '09:45:00', 'Certificado medico',            'atendida'),
(7, 3, '2026-10-22', '15:20:00', 'Control de presion arterial',   'pendiente'),
(8, 2, '2026-10-22', '16:00:00', 'Vacunacion',                    'pendiente'),
(1, 4, '2026-10-23', '08:40:00', 'Dolor de muela',                'pendiente'),
(3, 1, '2026-10-23', '10:30:00', 'Resfrio persistente',           'atendida');

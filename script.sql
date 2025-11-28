------------------------------------------------------------
--   CREAR BASE DE DATOS
------------------------------------------------------------
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'Mathleague')
BEGIN
    CREATE DATABASE Mathleague;
END;
GO

USE Mathleague;
GO

------------------------------------------------------------
--   ELIMINAR TABLAS EXISTENTES EN ORDEN CORRECTO
------------------------------------------------------------
IF OBJECT_ID('opciones', 'U') IS NOT NULL DROP TABLE opciones;
IF OBJECT_ID('preguntas', 'U') IS NOT NULL DROP TABLE preguntas;
IF OBJECT_ID('sesionesJuego', 'U') IS NOT NULL DROP TABLE sesionesJuego;
IF OBJECT_ID('sesionesCompleta', 'U') IS NOT NULL DROP TABLE sesionesCompleta;
IF OBJECT_ID('juegos', 'U') IS NOT NULL DROP TABLE juegos;
IF OBJECT_ID('usuario', 'U') IS NOT NULL DROP TABLE usuario;
GO

------------------------------------------------------------
--   TABLA usuario
------------------------------------------------------------
CREATE TABLE usuario (
    id_usuario INT IDENTITY(1,1) PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro DATETIME NOT NULL DEFAULT GETDATE()
);
GO

------------------------------------------------------------
--   TABLA juegos
------------------------------------------------------------
CREATE TABLE juegos (
    id_juego INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    orden INT NOT NULL
);
GO

------------------------------------------------------------
--   TABLA sesionesCompleta
------------------------------------------------------------
CREATE TABLE sesionesCompleta (
    id_sesion INT IDENTITY(1,1) PRIMARY KEY,
    tiempo DATETIME NOT NULL,
    duracion_sesion INT NOT NULL,
    intentos INT NOT NULL,
    errores INT NOT NULL,
    puntos INT NOT NULL,
    ayuda INT NOT NULL,
    nivelCompletado BIT NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);
GO

------------------------------------------------------------
--   TABLA sesionesJuego
------------------------------------------------------------
CREATE TABLE sesionesJuego (
    id_juegos_sesion INT IDENTITY(1,1) PRIMARY KEY,
    numero_nivel INT NOT NULL,
    duracion_nivel INT NOT NULL,
    completado BIT NOT NULL,
    errores_nivel INT NOT NULL,
    intentos_nivel INT NOT NULL,
    puntuacion INT NOT NULL,
    id_sesionCompleta INT NOT NULL,
    id_juego INT NOT NULL,
    FOREIGN KEY (id_sesionCompleta) REFERENCES sesionesCompleta(id_sesion),
    FOREIGN KEY (id_juego) REFERENCES juegos(id_juego)
);
GO

------------------------------------------------------------
--   TABLA preguntas
------------------------------------------------------------
CREATE TABLE preguntas (
    id_pregunta INT IDENTITY(1,1) PRIMARY KEY,
    enunciado VARCHAR(255) NOT NULL,
    id_juego INT NOT NULL,
    FOREIGN KEY (id_juego) REFERENCES juegos(id_juego)
);
GO

------------------------------------------------------------
--   TABLA opciones
------------------------------------------------------------
CREATE TABLE opciones (
    id_opcion INT IDENTITY(1,1) PRIMARY KEY,
    opcion1 INT NOT NULL,
    opcion2 INT NOT NULL,
    opcion3 INT NOT NULL,
    opcion4 INT NOT NULL,
    esCorrecta INT NOT NULL,
    id_pregunta INT NOT NULL,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta)
);
GO

------------------------------------------------------------
--   INSERT DE USUARIOS
------------------------------------------------------------
INSERT INTO usuario (username, email, contrasena)
VALUES
('Admin', 'admin@gmail.com', 'admin123'),
('UsuarioPrueba', 'prueba@gmail.com', 'pass456');
GO

------------------------------------------------------------
--   INSERT DE JUEGOS
------------------------------------------------------------
INSERT INTO juegos (nombre, orden)
VALUES
('Mathbus', 1),
('Cortacesped', 2),
('Mathmatch', 3),
('Entrevista', 4);
GO

------------------------------------------------------------
--   INSERT DE SESIONES COMPLETAS
------------------------------------------------------------
INSERT INTO sesionesCompleta (tiempo, duracion_sesion, intentos, errores, puntos, ayuda, nivelCompletado, id_usuario)
VALUES
(GETDATE(), 3600, 150, 10, 500, 5, 1, 1),
(GETDATE(), 1800, 75, 20, 150, 10, 0, 2);
GO

------------------------------------------------------------
--   INSERT DE SESIONES DE JUEGO
------------------------------------------------------------
INSERT INTO sesionesJuego (numero_nivel, duracion_nivel, completado, errores_nivel, intentos_nivel, puntuacion, id_sesionCompleta, id_juego)
VALUES
(1, 1200, 1, 3, 50, 250, 1, 1),
(2, 1200, 1, 7, 50, 150, 1, 1),
(1, 900, 0, 10, 25, 50, 2, 3),
(2, 900, 0, 10, 25, 100, 2, 3);
GO

------------------------------------------------------------
--   INSERT DE PREGUNTAS
------------------------------------------------------------
SET IDENTITY_INSERT preguntas ON;

INSERT INTO preguntas (id_pregunta, enunciado, id_juego)
VALUES
(1, '¿Cuánto es 5 + 3?', 1), (2, '¿Cuánto es 12 - 7?', 1), (3, '¿Cuánto es 4 * 6?', 1), (4, '¿Cuánto es 20 ÷ 4?', 1), (5, '¿Cuánto es 9 + 8?', 1),
(6, '¿Cuánto es 15 - 9?', 1), (7, '¿Cuánto es 7 * 3?', 1), (8, '¿Cuánto es 18 ÷ 3?', 1), (9, '¿Cuánto es 6 + 14?', 1), (10, '¿Cuánto es 25 - 10?', 1),
(11, '¿Cuánto es 8 * 5?', 1), (12, '¿Cuánto es 28 ÷ 7?', 1), (13, '¿Cuánto es 11 + 12?', 1), (14, '¿Cuánto es 30 - 14?', 1), (15, '¿Cuánto es 9 * 4?', 1),
(16, '¿Cuánto es 24 ÷ 6?', 1), (17, '¿Cuánto es 13 + 7?', 1), (18, '¿Cuánto es 19 - 8?', 1), (19, '¿Cuánto es 6 * 7?', 1), (20, '¿Cuánto es 32 ÷ 8?', 1),
(21, '¿Cuánto es 14 + 9?', 1), (22, '¿Cuánto es 27 - 9?', 1), (23, '¿Cuánto es 3 * 9?', 1), (24, '¿Cuánto es 45 ÷ 5?', 1), (25, '¿Cuánto es 10 + 11?', 1),
(26, '¿Cuánto es 22 - 13?', 1), (27, '¿Cuánto es 8 * 7?', 1), (28, '¿Cuánto es 36 ÷ 6?', 1), (29, '¿Cuánto es 9 + 15?', 1), (30, '¿Cuánto es 40 - 18?', 1),
(31, '¿Cuánto es 5 * 9?', 1), (32, '¿Cuánto es 56 ÷ 8?', 1), (33, '¿Cuánto es 17 + 6?', 1), (34, '¿Cuánto es 29 - 12?', 1), (35, '¿Cuánto es 4 * 8?', 1),
(36, '¿Cuánto es 48 ÷ 6?', 1), (37, '¿Cuánto es 21 + 5?', 1), (38, '¿Cuánto es 33 - 15?', 1), (39, '¿Cuánto es 6 * 8?', 1), (40, '¿Cuánto es 72 ÷ 9?', 1),
(41, '¿Cuánto es 18 + 7?', 1), (42, '¿Cuánto es 26 - 8?', 1), (43, '¿Cuánto es 9 * 6?', 1), (44, '¿Cuánto es 81 ÷ 9?', 1), (45, '¿Cuánto es 12 + 16?', 1),
(46, '¿Cuánto es 50 - 25?', 1), (47, '¿Cuánto es 7 * 8?', 1), (48, '¿Cuánto es 64 ÷ 8?', 1), (49, '¿Cuánto es 20 + 15?', 1), (50, '¿Cuánto es 90 - 30?', 1),

(101, 'Descompón factorialmente el número 12', 3), (102, 'Descompón factorialmente el número 18', 3), (103, 'Descompón factorialmente el número 20', 3), (104, 'Descompón factorialmente el número 24', 3), (105, 'Descompón factorialmente el número 30', 3),
(106, 'Descompón factorialmente el número 16', 3), (107, 'Descompón factorialmente el número 36', 3), (108, 'Descompón factorialmente el número 28', 3), (109, 'Descompón factorialmente el número 40', 3), (110, 'Descompón factorialmente el número 45', 3),
(111, 'Descompón factorialmente el número 32', 3), (112, 'Descompón factorialmente el número 48', 3), (113, 'Descompón factorialmente el número 50', 3), (114, 'Descompón factorialmente el número 54', 3), (115, 'Descompón factorialmente el número 60', 3),
(116, 'Descompón factorialmente el número 64', 3), (117, 'Descompón factorialmente el número 70', 3), (118, 'Descompón factorialmente el número 72', 3), (119, 'Descompón factorialmente el número 75', 3), (120, 'Descompón factorialmente el número 80', 3),
(121, 'Descompón factorialmente el número 81', 3), (122, 'Descompón factorialmente el número 84', 3), (123, 'Descompón factorialmente el número 90', 3), (124, 'Descompón factorialmente el número 96', 3), (125, 'Descompón factorialmente el número 98', 3),
(126, 'Descompón factorialmente el número 100', 3), (127, 'Descompón factorialmente el número 108', 3), (128, 'Descompón factorialmente el número 120', 3), (129, 'Descompón factorialmente el número 125', 3), (130, 'Descompón factorialmente el número 144', 3),
(131, 'Descompón factorialmente el número 150', 3), (132, 'Descompón factorialmente el número 162', 3), (133, 'Descompón factorialmente el número 168', 3), (134, 'Descompón factorialmente el número 180', 3), (135, 'Descompón factorialmente el número 189', 3),
(136, 'Descompón factorialmente el número 196', 3), (137, 'Descompón factorialmente el número 200', 3), (138, 'Descompón factorialmente el número 225', 3), (139, 'Descompón factorialmente el número 240', 3), (140, 'Descompón factorialmente el número 243', 3),
(141, 'Descompón factorialmente el número 250', 3), (142, 'Descompón factorialmente el número 256', 3), (143, 'Descompón factorialmente el número 270', 3), (144, 'Descompón factorialmente el número 288', 3), (145, 'Descompón factorialmente el número 300', 3),
(146, 'Descompón factorialmente el número 320', 3), (147, 'Descompón factorialmente el número 324', 3), (148, 'Descompón factorialmente el número 360', 3), (149, 'Descompón factorialmente el número 400', 3), (150,'Descompón factorialmente el número 500', 3);

SET IDENTITY_INSERT preguntas OFF;
GO

------------------------------------------------------------
--   INSERT DE OPCIONES
------------------------------------------------------------
SET IDENTITY_INSERT opciones ON;

INSERT INTO opciones (id_opcion, opcion1, opcion2, opcion3, opcion4, esCorrecta, id_pregunta)
VALUES
-- Aritmética
(1,6,7,8,8,1), (2,5,6,7,5,2), (3,24,20,26,24,3), (4,5,4,6,5,4), (5,17,18,16,17,5), 
(6,6,5,7,6,6), (7,21,24,20,21,7), (8,6,5,7,6,8), (9,20,19,18,20,9), (10,15,14,16,15,10),
(11,40,35,45,40,11), (12,4,5,6,4,12), (13,23,24,22,23,13), (14,16,14,15,16,14), (15,36,32,28,36,15),
(16,4,6,5,4,16), (17,20,19,18,20,17), (18,11,12,10,11,18), (19,42,36,48,42,19), (20,4,5,6,4,20),
(21,23,24,22,23,21), (22,18,16,20,18,22), (23,27,26,28,27,23), (24,9,8,7,9,24), (25,21,20,22,21,25),
(26,9,10,11,9,26), (27,56,54,49,56,27), (28,6,5,7,6,28), (29,24,25,23,24,29), (30,22,20,18,22,30),
(31,45,44,40,45,31), (32,7,8,9,7,32), (33,23,24,22,23,33), (34,17,16,18,17,34), (35,32,30,28,32,35),
(36,8,6,7,8,36), (37,26,27,25,26,37), (38,18,16,19,18,38), (39,48,44,42,48,39), (40,8,7,9,8,40),
(41,25,26,24,25,41), (42,18,19,20,18,42), (43,54,52,48,54,43), (44,9,8,10,9,44), (45,28,27,26,28,45),
(46,25,26,24,25,46), (47,56,54,52,56,47), (48,8,7,9,8,48), (49,35,34,33,35,49), (50,60,58,62,60,50)
-- Opciones de factorial se pueden agregar igual, siguiendo el mismo patrón
;

SET IDENTITY_INSERT opciones OFF;
GO

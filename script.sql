-- *******************************************
-- SCRIPTS DDL y DML para Base de Datos Mathleague (SQL Server / T-SQL)
-- ** VERSIÓN FINAL Y CORREGIDA **
-- *******************************************

-- Bloque de Limpieza (Eliminar tablas en orden de dependencia inversa)
DROP TABLE IF EXISTS opciones;
DROP TABLE IF EXISTS preguntas;
DROP TABLE IF EXISTS sesionesJuego;
DROP TABLE IF EXISTS sesionesCompleta;
DROP TABLE IF EXISTS juegos;
DROP TABLE IF EXISTS usuario;

---

-- Creación y Selección de la Base de Datos
IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = N'Mathleague')
    CREATE DATABASE Mathleague;

-- ❗ COMANDO CLAVE: Selecciona la base de datos para todas las siguientes operaciones
USE Mathleague; 

---

-- 🛠️ Creación de Tablas y PRIMARY KEYs

CREATE TABLE "usuario"(
    "id_usuario" INT NOT NULL,
    "username" VARCHAR(255) NOT NULL,
    "email" VARCHAR(255) NOT NULL,
    "contrasena" VARCHAR(255) NOT NULL,
    "fecha_registro" DATETIME NOT NULL
);
ALTER TABLE "usuario" ADD CONSTRAINT "usuario_id_usuario_primary" PRIMARY KEY("id_usuario");

CREATE TABLE "juegos"(
    "id_juego" INT NOT NULL,
    "nombre" VARCHAR(255) NOT NULL,
    "orden" INT NOT NULL
);
ALTER TABLE "juegos" ADD CONSTRAINT "juegos_id_juego_primary" PRIMARY KEY("id_juego");

CREATE TABLE "sesionesCompleta"(
    "id_sesion" INT NOT NULL,
    "tiempo" DATETIME NOT NULL,
    "duracion_sesion" INT NOT NULL,
    "intentos" INT NOT NULL,
    "errores" INT NOT NULL,
    "puntos" INT NOT NULL,
    "ayuda" INT NOT NULL,
    "nivelCompletado" BIT NOT NULL,
    "id_usuario" INT NOT NULL -- FOREIGN KEY
);
ALTER TABLE "sesionesCompleta" ADD CONSTRAINT "sesionescompleta_id_sesion_primary" PRIMARY KEY("id_sesion");

CREATE TABLE "sesionesJuego"(
    "id_juegos_sesion" INT NOT NULL,
    "numero_nivel" INT NOT NULL,
    "duracion_nivel" INT NOT NULL,
    "completado" BIT NOT NULL,
    "errores_nivel" INT NOT NULL,
    "intentos_nivel" INT NOT NULL,
    "puntuacion" INT NOT NULL,
    "id_sesionCompleta" INT NOT NULL, -- FOREIGN KEY
    "id_juego" INT NOT NULL -- FOREIGN KEY
);
ALTER TABLE "sesionesJuego" ADD CONSTRAINT "sesionesjuego_id_juegos_sesion_primary" PRIMARY KEY("id_juegos_sesion");

CREATE TABLE "preguntas"(
    "id_pregunta" INT NOT NULL,
    "enunciado" VARCHAR(255) NOT NULL,
    "id_juego" INT NOT NULL -- FOREIGN KEY
);
ALTER TABLE "preguntas" ADD CONSTRAINT "preguntas_id_pregunta_primary" PRIMARY KEY("id_pregunta");

CREATE TABLE "opciones"(
    "opcion1" INT NOT NULL,
    "opcion2" INT NOT NULL,
    "opcion3" INT NOT NULL,
    "opcion4" INT NOT NULL,
    "esCorrecta" INT NOT NULL,
    "id_pregunta" INT NOT NULL -- FOREIGN KEY
);
ALTER TABLE "opciones" ADD CONSTRAINT "opciones_opcion1_primary" PRIMARY KEY("opcion1");

---

-- 🔑 Creación de FOREIGN KEYs

ALTER TABLE "sesionesJuego" ADD CONSTRAINT "sesionesjuego_id_sesioncompleta_foreign" FOREIGN KEY("id_sesionCompleta") REFERENCES "sesionesCompleta"("id_sesion");
ALTER TABLE "sesionesJuego" ADD CONSTRAINT "sesionesjuego_id_juego_foreign" FOREIGN KEY("id_juego") REFERENCES "juegos"("id_juego");
ALTER TABLE "opciones" ADD CONSTRAINT "opciones_id_pregunta_foreign" FOREIGN KEY("id_pregunta") REFERENCES "preguntas"("id_pregunta");
ALTER TABLE "sesionesCompleta" ADD CONSTRAINT "sesionescompleta_id_usuario_foreign" FOREIGN KEY("id_usuario") REFERENCES "usuario"("id_usuario");
ALTER TABLE "preguntas" ADD CONSTRAINT "preguntas_id_juego_foreign" FOREIGN KEY("id_juego") REFERENCES "juegos"("id_juego");

---

-- ➕ Inserción de Datos

-- 1. Inserción de Usuarios (CORREGIDO: Se añade el ID 2)
INSERT INTO usuario (id_usuario, username, email, contrasena, fecha_registro) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', GETDATE()),
(2, 'UsuarioPrueba', 'prueba@gmail.com', 'pass456', GETDATE());


-- 2. Inserción de Juegos
INSERT INTO juegos (id_juego, nombre, orden) VALUES
(1, 'Mathbus', 1),
(2, 'Cortacesped', 2),
(3, 'Mathmatch', 3),
(4, 'Entrevista', 4);

-- 3. Inserción de Sesiones Completas (CORREGIDO: Ahora el id_usuario=2 es válido)
INSERT INTO sesionesCompleta (id_sesion, tiempo, duracion_sesion, intentos, errores, puntos, ayuda, nivelCompletado, id_usuario) VALUES
(1001, GETDATE(), 3600, 150, 10, 500, 5, 1, 1),
(1002, GETDATE(), 1800, 75, 20, 150, 10, 0, 2);

-- 4. Inserción de Sesiones de Juego (Ahora la FK a id_sesionCompleta=1002 es válida)
INSERT INTO sesionesJuego (id_juegos_sesion, numero_nivel, duracion_nivel, completado, errores_nivel, intentos_nivel, puntuacion, id_sesionCompleta, id_juego) VALUES
(2001, 1, 1200, 1, 3, 50, 250, 1001, 1), -- Sesión 1001 (Usuario 1)
(2002, 2, 1200, 1, 7, 50, 150, 1001, 1), -- Sesión 1001 (Usuario 1)
(2003, 1, 900, 0, 10, 25, 50, 1002, 3), -- Sesión 1002 (Usuario 2)
(2004, 2, 900, 0, 10, 25, 100, 1002, 3); -- Sesión 1002 (Usuario 2)

-- 5. Inserción de Preguntas (ID 1-50: Aritmética)
INSERT INTO preguntas (id_pregunta, enunciado, id_juego) VALUES
(1, '¿Cuánto es 5 + 3?', 1), (2, '¿Cuánto es 12 - 7?', 1), (3, '¿Cuánto es 4 * 6?', 1), (4, '¿Cuánto es 20 ÷ 4?', 1), (5, '¿Cuánto es 9 + 8?', 1),
(6, '¿Cuánto es 15 - 9?', 1), (7, '¿Cuánto es 7 * 3?', 1), (8, '¿Cuánto es 18 ÷ 3?', 1), (9, '¿Cuánto es 6 + 14?', 1), (10, '¿Cuánto es 25 - 10?', 1),
(11, '¿Cuánto es 8 * 5?', 1), (12, '¿Cuánto es 28 ÷ 7?', 1), (13, '¿Cuánto es 11 + 12?', 1), (14, '¿Cuánto es 30 - 14?', 1), (15, '¿Cuánto es 9 * 4?', 1),
(16, '¿Cuánto es 24 ÷ 6?', 1), (17, '¿Cuánto es 13 + 7?', 1), (18, '¿Cuánto es 19 - 8?', 1), (19, '¿Cuánto es 6 * 7?', 1), (20, '¿Cuánto es 32 ÷ 8?', 1),
(21, '¿Cuánto es 14 + 9?', 1), (22, '¿Cuánto es 27 - 9?', 1), (23, '¿Cuánto es 3 * 9?', 1), (24, '¿Cuánto es 45 ÷ 5?', 1), (25, '¿Cuánto es 10 + 11?', 1),
(26, '¿Cuánto es 22 - 13?', 1), (27, '¿Cuánto es 8 * 7?', 1), (28, '¿Cuánto es 36 ÷ 6?', 1), (29, '¿Cuánto es 9 + 15?', 1), (30, '¿Cuánto es 40 - 18?', 1),
(31, '¿Cuánto es 5 * 9?', 1), (32, '¿Cuánto es 56 ÷ 8?', 1), (33, '¿Cuánto es 17 + 6?', 1), (34, '¿Cuánto es 29 - 12?', 1), (35, '¿Cuánto es 4 * 8?', 1),
(36, '¿Cuánto es 48 ÷ 6?', 1), (37, '¿Cuánto es 21 + 5?', 1), (38, '¿Cuánto es 33 - 15?', 1), (39, '¿Cuánto es 6 * 8?', 1), (40, '¿Cuánto es 72 ÷ 9?', 1),
(41, '¿Cuánto es 18 + 7?', 1), (42, '¿Cuánto es 26 - 8?', 1), (43, '¿Cuánto es 9 * 6?', 1), (44, '¿Cuánto es 81 ÷ 9?', 1), (45, '¿Cuánto es 12 + 16?', 1),
(46, '¿Cuánto es 50 - 25?', 1), (47, '¿Cuánto es 7 * 8?', 1), (48, '¿Cuánto es 64 ÷ 8?', 1), (49, '¿Cuánto es 20 + 15?', 1), (50, '¿Cuánto es 90 - 30?', 1);

-- 6. Inserción de Preguntas (ID 101-150: Descomposición Factorial)
INSERT INTO preguntas (id_pregunta, enunciado, id_juego) VALUES
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

-- 7. Inserción de Opciones (ID 1-50 para Aritmética)
INSERT INTO opciones VALUES 
(1,6,7,8,8,1), (2,5,6,7,5,2), (3,24,20,26,24,3), (4,5,4,6,5,4), (5,17,18,16,17,5), 
(6,6,5,7,6,6), (7,21,24,20,21,7), (8,6,5,7,6,8), (9,20,19,18,20,9), (10,15,14,16,15,10), 
(11,40,35,45,40,11), (12,4,5,6,4,12), (13,23,24,22,23,13), (14,16,14,15,16,14), (15,36,32,28,36,15), 
(16,4,6,5,4,16), (17,20,19,18,20,17), (18,11,12,10,11,18), (19,42,36,48,42,19), (20,4,5,6,4,20), 
(21,23,24,22,23,21), (22,18,16,20,18,22), (23,27,26,28,27,23), (24,9,8,7,9,24), (25,21,20,22,21,25), 
(26,9,10,11,9,26), (27,56,54,49,56,27), (28,6,5,7,6,28), (29,24,25,23,24,29), (30,22,20,18,22,30), 
(31,45,44,40,45,31), (32,7,8,9,7,32), (33,23,24,22,23,33), (34,17,16,18,17,34), (35,32,30,28,32,35),
(36,8,6,7,8,36), (37,26,27,25,26,37), (38,18,16,19,18,38), (39,48,44,42,48,39), (40,8,7,9,8,40), 
(41,25,26,24,25,41), (42,18,19,20,18,42), (43,54,52,48,54,43), (44,9,8,10,9,44), (45,28,27,26,28,45), 
(46,25,26,24,25,46), (47,56,54,52,56,47), (48,8,7,9,8,48), (49,35,34,33,35,49), (50,60,58,62,60,50);

-- 8. Inserción de Opciones (ID 101-150 para Descomposición Factorial)
INSERT INTO opciones VALUES
(223, 232, 222, 233, 223, 101), (222, 232, 233, 232, 233, 102), (252, 225, 255, 522, 225, 103), (2322, 2322, 2223, 2223, 2223, 104), (325, 235, 253, 532, 235, 105),
(2224, 2222, 2242, 2422, 2222, 106), (2323, 2233, 2332, 3223, 2233, 107), (272, 722, 227, 727, 227, 108), (2522, 2225, 2252, 5222, 2225, 109), (353, 335, 533, 355, 335, 110),
(22220, 22222, 22222, 2222, 2222, 111), (23222, 22223, 22322, 22232, 22223, 112), (525, 255, 552, 2550, 255, 113), (3323, 2333, 3233, 3332, 2333, 114), (2352, 2235, 22350, 2532, 2235, 115),
(222262, 222222, 222226, 222622, 222222, 116), (2735, 2537, 2357, 23570, 2357, 117), (23223, 22323, 22233, 22332, 22233, 118), (533, 355, 535, 353, 355, 119), (22522, 22252, 22225, 222250, 22225, 120),
(33331, 3333, 33330, 33332, 3333, 121), (2273, 2237, 2327, 22370, 2237, 122), (2353, 2335, 3253, 23350, 2335, 123), (222232, 222223, 222322, 2222230, 222223, 124), (722, 277, 272, 227, 277, 125),
(5225, 2255, 2525, 22550, 2255, 126), (33233, 22333, 223330, 23333, 23333, 127), (22352, 22235, 22325, 222350, 22235, 128), (555, 5550, 5551, 5552, 555, 129), (223323, 222333, 223233, 2223330, 222333, 130),
(2535, 3255, 2355, 23550, 2355, 131), (32333, 23333, 33233, 233330, 23333, 132), (22372, 22237, 22327, 222370, 22237, 133), (23335, 22335, 22353, 223350, 22335, 134), (3733, 3337, 3373, 33370, 3337, 135),
(2727, 2277, 2772, 22770, 2277, 136), (22552, 22255, 22525, 222550, 22255, 137), (3535, 3355, 5335, 33550, 3355, 138), (222253, 222235, 222523, 2222350, 222235, 139), (333330, 33333, 333331, 333332, 33333, 140),
(2555, 25550, 25551, 25552, 2555, 141), (22222220, 2222222, 22222221, 22222222, 2222222, 142), (23533, 23335, 23353, 233350, 23335, 143), (2223323, 2222333, 2223233, 22223330, 2222333, 144), (22553, 22355, 22335, 223550, 22355, 145),
(222522, 222225, 222252, 2222250, 222225, 146), (323333, 223333, 233333, 2233330, 223333, 147), (223253, 222335, 223235, 2223350, 222335, 148), (222525, 225225, 222255, 2222550, 222255, 149), (52255, 22555, 225550, 25255, 22555, 150);
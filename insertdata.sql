
--Inserción de datos
--(Faltan agregar más)

--Area--
INSERT INTO Area (nombre, fumadores, ) VALUES ('Terraza', TRUE);
INSERT INTO Area (nombre, fumadores, ) VALUES ('Salón principal', FALSE);
INSERT INTO Area (nombre, fumadores, ) VALUES ('Salón 2', FALSE);
INSERT INTO Area (nombre, fumadores, ) VALUES ('Salón 3', FALSE);
INSERT INTO Area (nombre, fumadores, ) VALUES ('Pérgola', FALSE);

--Mesa--
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (4, TRUE, 1);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (2, FALSE, 2);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (6, TRUE, 3);

--Cliente--
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('123456-K', 'Juan Pérez', 'Calle La Laguna 526');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('654321-3', 'Ana López', 'Avenida Sampedrana 437');

--Personal--
INSERT INTO Personal (nombre, rol) VALUES ('Carlos Martínez', 'Gerente');
INSERT INTO Personal (nombre, rol) VALUES ('Sofía Gómez', 'Chef');
INSERT INTO Personal (nombre, rol) VALUES ('Daniel Barrios', 'Mesero');
INSERT INTO Personal (nombre, rol) VALUES ('Ximena Garcia', 'Host');



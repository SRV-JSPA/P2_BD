
--Inserción de datos
--(Faltan agregar más)

--Restaurante--
INSERT INTO Restaurante (nombre, ubicacion) VALUES ('La Buena Mesa', 'Calle Principal 123');
INSERT INTO Restaurante (nombre, ubicacion) VALUES ('Aurora Mediterránea', 'Avenida del Parque 456');

--Area--
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Terraza', TRUE, 1);
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Salón principal', FALSE, 1);
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Salón 1', FALSE, 2);
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Salón 2', FALSE, 2);
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Pérgola', FALSE, 2);
INSERT INTO Area (nombre, fumadores, id_restaurante) VALUES ('Terraza', TRUE, 2);

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



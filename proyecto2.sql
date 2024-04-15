--Proyecto2.sql--

CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- CREACIÓN DE TABLAS --
CREATE TABLE IF NOT EXISTS Area ( --Categoriza las distintas áreas del restaurante--
    id_area SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    fumadores BOOLEAN NOT NULL
);
SELECT setval('area_id_area_seq', 1, false);

CREATE TABLE IF NOT EXISTS Mesa ( --Mesas del restaurante--
    id_mesa SERIAL PRIMARY KEY,
    capacidad INTEGER NOT NULL,
    movil BOOLEAN NOT NULL,
    id_area INTEGER NOT NULL,
    FOREIGN KEY (id_area) REFERENCES Area(id_area)
);
SELECT setval('mesa_id_mesa_seq', 1, false);

CREATE TABLE IF NOT EXISTS Cliente ( --Guarda la información de los clientes--
    id_cliente SERIAL PRIMARY KEY,
    nit TEXT,
    nombre TEXT NOT NULL,
    direccion TEXT
);
SELECT setval('cliente_id_cliente_seq', 1, false);

CREATE TABLE IF NOT EXISTS Personal ( --Mantiene el registro de los empleados--
    id_personal SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    rol TEXT NOT NULL
);
SELECT setval('personal_id_personal_seq', 1, false);

CREATE TABLE IF NOT EXISTS Usuarios ( --Cuentas de usuario para la autenticación del sistema--
    id_usuario SERIAL PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    id_personal INTEGER,
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal)
);
SELECT setval('usuarios_id_usuario_seq', 1, false);

CREATE TABLE IF NOT EXISTS Mesero ( --Identifica únicamente a los meseros--
    id_mesero SERIAL PRIMARY KEY,
    id_personal INTEGER NOT NULL,
    nombre TEXT NOT NULL,
    id_area_asignada INTEGER,
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal),
    FOREIGN KEY (id_area_asignada) REFERENCES Area(id_area)
);
SELECT setval('mesero_id_mesero_seq', 1, false);

CREATE TABLE IF NOT EXISTS Pedido (--Realiza un seguimiento de los pedidos realizados por los clientes--
    id_pedido SERIAL PRIMARY KEY,
    fecha DATE NOT NULL,
	hora TIME DEFAULT CURRENT_TIME NOT NULL,
	horafin TIME DEFAULT CURRENT_TIME,
    id_mesa INTEGER NOT NULL,
    id_mesero INTEGER,
    id_cliente INTEGER NOT NULL,
    subtotal NUMERIC(10, 2),
    total NUMERIC(10, 2),
    propina NUMERIC(10, 2),
    FOREIGN KEY (id_mesa) REFERENCES Mesa(id_mesa),
    FOREIGN KEY (id_mesero) REFERENCES Mesero(id_mesero),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);
SELECT setval('pedido_id_pedido_seq', 1, false);

CREATE TABLE IF NOT EXISTS Item ( --Define los items disponibles para pedir--
    id_item SERIAL PRIMARY KEY,
    tipo_item TEXT NOT NULL, --Platillo, Bebida, o Postre
    nombre TEXT NOT NULL,
    descripcion TEXT,
    precio NUMERIC(10, 2) NOT NULL
);
SELECT setval('item_id_item_seq', 1, false);

CREATE TABLE IF NOT EXISTS Detalle_Pedido ( --Relaciona los pedidos con los items específicos--
    id_detalle_pedido SERIAL PRIMARY KEY, 
    id_pedido INTEGER NOT NULL,
    id_item INTEGER,
    cantidad INTEGER NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);
SELECT setval('detalle_pedido_id_detalle_pedido_seq', 1, false);

CREATE TABLE IF NOT EXISTS Pago ( --Registra información sobre los pagos de los pedidos.--
    id_pago SERIAL PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    monto_total NUMERIC(10, 2) NOT NULL, --Total pagado en el pedido.
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);
SELECT setval('pago_id_pago_seq', 1, false);

CREATE TABLE IF NOT EXISTS ContribucionPago ( --Permite rastrear las contribuciones individuales a los pagos cuando un pedido es compartido por varios clientes.--
    id_contribucion SERIAL PRIMARY KEY,
    id_pago INTEGER,
    id_cliente INTEGER,
    monto_contribucion NUMERIC(10, 2) NOT NULL, --Cuánto paga cada cliente
    FOREIGN KEY (id_pago) REFERENCES Pago(id_pago),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);
SELECT setval('contribucionpago_id_contribucion_seq', 1, false);

CREATE TABLE IF NOT EXISTS MetodoPago ( --Detalla los métodos de pago utilizados para cada pago--
    id_metodo_pago SERIAL PRIMARY KEY,
    id_contribucion INTEGER,
    metodo_pago TEXT NOT NULL, -- Efectivo, Tarjeta de Crédito
    monto NUMERIC(10, 2) NOT NULL,
    FOREIGN KEY (id_contribucion) REFERENCES ContribucionPago(id_contribucion)
);
SELECT setval('metodopago_id_metodo_pago_seq', 1, false);

CREATE TABLE IF NOT EXISTS Encuesta ( --Recopila retroalimentación de los clientes sobre los meseros y el servicio proporcionado--
    id_encuesta SERIAL PRIMARY KEY,
    id_mesero INTEGER,
    id_pedido INTEGER NOT NULL,
    amabilidad INTEGER CHECK (amabilidad BETWEEN 1 AND 5),
    exactitud INTEGER CHECK (exactitud BETWEEN 1 AND 5),
    FOREIGN KEY (id_mesero) REFERENCES Mesero(id_mesero),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);
SELECT setval('encuesta_id_encuesta_seq', 1, false);

CREATE TABLE IF NOT EXISTS Queja ( -- Permite a los clientes presentar quejas, que se registran con detalles como el motivo, la clasificación de gravedad y si están relacionadas con personal o ítems específicos. --
    id_queja SERIAL PRIMARY KEY,
    id_cliente INTEGER NOT NULL,
    fecha DATE NOT NULL,
	hora TIME NOT NULL,
    motivo TEXT,
    clasificacion INTEGER CHECK (clasificacion BETWEEN 1 AND 5),
    id_personal INTEGER,
    id_item INTEGER,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);
SELECT setval('queja_id_queja_seq', 1, false);

--INSERTS Y TRIGGERS--
--Area--
INSERT INTO Area (nombre, fumadores ) VALUES ('Terraza', TRUE);
INSERT INTO Area (nombre, fumadores ) VALUES ('Salón principal', FALSE);
INSERT INTO Area (nombre, fumadores) VALUES ('Salón 2', FALSE);
INSERT INTO Area (nombre, fumadores ) VALUES ('Pérgola', FALSE);


--Mesa--
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (4, TRUE, 1);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (2, FALSE, 2);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (6, TRUE, 3);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (8, TRUE, 1); 
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (4, FALSE, 2); 
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (10, TRUE, 3); 
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (2, TRUE, 4);  
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (4, FALSE, 2);
INSERT INTO Mesa (capacidad, movil, id_area) VALUES (6, TRUE, 4);


--Cliente--
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('123456-K', 'Juan Pérez', 'Calle La Laguna 526');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('654321-3', 'Ana López', 'Avenida Sampedrana 437');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('789012-5', 'Carlos Ruiz', 'Paseo de la Reforma 1234');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('210987-3', 'Lucía Méndez', 'Bulevar Morazán 56');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('345678-8', 'Omar Morales', 'Residencial Los Pinos 789');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('432109-7', 'Marta Hernández', 'Colonia Palmira 101');
INSERT INTO Cliente (nit, nombre, direccion) VALUES ('487654-2', 'Wagner Barrios', 'Residencial El Valle 454');


--Personal--
INSERT INTO Personal (nombre, rol) VALUES ('Carlos Martínez', 'Gerente');
INSERT INTO Personal (nombre, rol) VALUES ('Sofía Gómez', 'Chef');
INSERT INTO Personal (nombre, rol) VALUES ('Adrián Ramos', 'Chef');
INSERT INTO Personal (nombre, rol) VALUES ('Daniel Barrios', 'Mesero');
INSERT INTO Personal (nombre, rol) VALUES ('Sebastián Mendez', 'Mesero');
INSERT INTO Personal (nombre, rol) VALUES ('Ximena Garcia', 'Host');


--TRIGGER para hashear las contraseñas de los usuarios registrados en la base de datos--
--Función del trigger--
CREATE OR REPLACE FUNCTION hash_password()
RETURNS TRIGGER AS $$
BEGIN
    -- Aplica un hash a la contraseña usando crypt 
    NEW.contrasena = crypt(NEW.contrasena, gen_salt('bf', 8));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS hash_password_users ON Usuarios;
--Trigger--
CREATE TRIGGER hash_password_users
BEFORE INSERT OR UPDATE ON Usuarios
FOR EACH ROW
EXECUTE FUNCTION hash_password();

--Usuarios--
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('mar37452', '1234', 1);
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('gom21968', '8293', 2);
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('ram65472', '2763', 3);
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('bar30495', '6384', 4);
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('men44563', '9867', 5);
INSERT INTO Usuarios (usuario, contrasena, id_personal) VALUES ('gar92365', '0234', 6);


--Mesero--
INSERT INTO Mesero (id_personal, nombre, id_area_asignada) VALUES (4, 'Daniel Barrios', 1);
INSERT INTO Mesero (id_personal, nombre, id_area_asignada) VALUES (5, 'Sebastián Mendez', 2);


--TRIGGER para calcular la propina y el total--
--Función del trigger
CREATE OR REPLACE FUNCTION calcular_propina_total()
RETURNS TRIGGER AS $$
BEGIN
    NEW.propina := NEW.subtotal * 0.15;  -- Calcula la propina como el 15% del subtotal
    NEW.total := NEW.subtotal + NEW.propina;  -- Suma la propina al subtotal para obtener el total
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_calculo_propina_total ON Pedido;
--Trigger--
CREATE TRIGGER trigger_calculo_propina_total
BEFORE INSERT OR UPDATE ON Pedido
FOR EACH ROW
EXECUTE FUNCTION calcular_propina_total();

--Pedido--
INSERT INTO Pedido (fecha, hora, horafin, id_mesa, id_mesero, id_cliente, subtotal) VALUES ('2024-01-01', '12:00','13:30', 1, 1, 2, 55.50);
INSERT INTO Pedido (fecha, hora, horafin, id_mesa, id_mesero, id_cliente, subtotal) VALUES ('2024-02-01', '12:30','14:05', 2, 1, 1, 69.24);
INSERT INTO Pedido (fecha, hora, horafin, id_mesa, id_mesero, id_cliente, subtotal) VALUES ('2024-03-01', '13:00','14:45', 3, 2, 3, 41.15);
INSERT INTO Pedido (fecha, hora, horafin, id_mesa, id_mesero, id_cliente, subtotal)VALUES ('2024-02-01', '12:30', '14:15', 5, 2, 4, 22.50);
INSERT INTO Pedido (fecha, hora, horafin, id_mesa, id_mesero, id_cliente, subtotal)VALUES ('2023-05-05', '15:30', '16:40', 6, 1, 3, 88.50);


--Item--
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Pizza de Pepperoni', 'Pizza de pepperoni de 8 piezas', 26.50);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Pollo a la Parrilla', 'Pechuga de pollo asada con verduras', 18.75);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Bebida', 'Coca Cola', 'Bebida carbonatada sabor cola', 2.50);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Postre', 'Pastel de Chocolate', 'Delicioso pastel de chocolate con frosting', 12.99);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Hamburguesa con Queso', 'Hamburguesa con carne, queso y vegetales', 14.95);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Bebida', 'Limonada Fresca', 'Limónada natural con hielo', 3.75);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Postre', 'Tarta de Manzana', 'Tarta casera de manzana con canela', 10.50);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Bebida', 'Agua Mineral', 'Agua mineral natural embotellada', 1.99);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Postre', 'Cheesecake de Fresa', 'Cheesecake cremoso con salsa de fresa', 11.25);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Pasta Alfredo', 'Fettuccine en salsa alfredo con pollo', 16.99);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Enchiladas Verdes', 'Enchiladas de pollo bañadas en salsa verde', 13.50);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Bebida', 'Café Americano', 'Taza de café americano caliente', 2.25);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Postre', 'Gelatina de Limón', 'Refrescante gelatina de limón', 4.99);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Platillo', 'Tacos de Carnitas', 'Tacos de cerdo estilo carnitas', 10.75);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Bebida', 'Té Helado', 'Té helado con limón y menta', 3.25);
INSERT INTO Item (tipo_item, nombre, descripcion, precio) VALUES ('Postre', 'Mousse de Chocolate Blanco', 'Mousse cremoso de chocolate blanco', 8.99);


--Detalle de pedido--
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (1, 1, 2);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (1, 3, 1);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (2, 2, 3);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (2, 4, 1);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (3, 5, 2);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (3, 6, 3);
INSERT INTO Detalle_Pedido (id_pedido, id_item, cantidad) VALUES (4, 9, 2);
INSERT INTO Detalle_Pedido (id_pedido, id_item,cantidad) VALUES (5, 7, 8);
INSERT INTO Detalle_Pedido (id_pedido, id_item,cantidad) VALUES (5, 12, 2);


-- Pago --
INSERT INTO Pago (id_pedido, monto_total) VALUES (1, 63.83);
INSERT INTO Pago (id_pedido, monto_total) VALUES (2, 79.63);
INSERT INTO Pago (id_pedido, monto_total) VALUES (3, 47.32);
INSERT INTO Pago (id_pedido, monto_total) VALUES (4, 25.88);
INSERT INTO Pago (id_pedido, monto_total) VALUES (5, 101.78);


-- Contribución --
INSERT INTO ContribucionPago (id_pago, id_cliente, monto_contribucion) VALUES (2, 1, 26.55);
INSERT INTO ContribucionPago (id_pago, id_cliente, monto_contribucion) VALUES (2, 5, 26.55);
INSERT INTO ContribucionPago (id_pago, id_cliente, monto_contribucion) VALUES (2, 6, 26.53);


-- Método de Pago --
INSERT INTO MetodoPago (metodo_pago, monto) VALUES ('Efectivo', 63.83);
INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES (1, 'Efectivo', 26.55); 
INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES (2, 'Efectivo', 13.00);
INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES (2, 'Tarjeta', 13.55); 
INSERT INTO MetodoPago (id_contribucion, metodo_pago, monto) VALUES (3, 'Tarjeta', 26.53);    
INSERT INTO MetodoPago (metodo_pago, monto) VALUES ('Tarjeta', 47.32); 
INSERT INTO MetodoPago (metodo_pago, monto) VALUES ('Tarjeta', 25.88);
INSERT INTO MetodoPago (metodo_pago, monto) VALUES ('Tarjeta', 101.78);


-- Encuesta --
INSERT INTO Encuesta (id_mesero, id_pedido, amabilidad, exactitud) VALUES (1, 1, 4, 4);
INSERT INTO Encuesta (id_mesero, id_pedido, amabilidad, exactitud) VALUES (2, 2, 5, 5);
INSERT INTO Encuesta (id_mesero, id_pedido, amabilidad, exactitud) VALUES (1, 3, 3, 2);
INSERT INTO Encuesta (id_mesero, id_pedido, amabilidad, exactitud) VALUES (2, 4, 3, 3);
INSERT INTO Encuesta (id_mesero, id_pedido, amabilidad, exactitud) VALUES (1, 5, 4, 3);


-- Queja --
INSERT INTO Queja (id_cliente, fecha, hora, motivo, clasificacion, id_personal, id_item) 
VALUES (2, '2024-01-01', '14:00', 'Mala comida', 4, 2, 2);
INSERT INTO Queja (id_cliente, fecha, hora, motivo, clasificacion, id_personal, id_item) 
VALUES (1, '2024-02-01', '15:30', 'Servicio lento', 3, 5, NULL);
INSERT INTO Queja (id_cliente, fecha, hora, motivo, clasificacion, id_personal, id_item) 
VALUES (3, '2024-03-01', '16:45', 'Pedido incorrecto', 2, 4, 5);
INSERT INTO Queja (id_cliente, fecha, hora, motivo, clasificacion, id_personal, id_item) 
VALUES (4, '2024-04-01', '13:00', 'Actitud del mesero', 4, 4, NULL);
INSERT INTO Queja (id_cliente, fecha, hora, motivo, clasificacion, id_personal, id_item) 
VALUES (3, '2023-05-05', '16:15', 'Porciones muy pequeñas', 3, 4, 7);


--Funciones para generar los reportes--
--1. Platos más pedidos por los clientes--
CREATE OR REPLACE FUNCTION platos_mas_pedidos(fecha_i DATE, fecha_f DATE)
RETURNS TABLE (id_item INT, nombre_item TEXT, cantidad_pedida BIGINT) AS $$
DECLARE
    v_fecha_inicio DATE := fecha_i;
    v_fecha_fin DATE := fecha_f;
BEGIN
    RETURN QUERY
    SELECT dpd.id_item, i.nombre AS nombre_item, SUM(dpd.cantidad) AS cantidad_pedida
    FROM detalle_pedido dpd
    JOIN pedido pd ON pd.id_pedido = dpd.id_pedido
    JOIN Item i ON i.id_item = dpd.id_item
    WHERE pd.fecha BETWEEN v_fecha_inicio AND v_fecha_fin
    GROUP BY dpd.id_item, i.nombre
    ORDER BY cantidad_pedida DESC
	LIMIT 5;
END;
$$ LANGUAGE plpgsql;

--2. Horario en el que se se ingresan más pedidos--
CREATE OR REPLACE FUNCTION reporte_horario_max_pedidos(fecha_inicio DATE, fecha_fin DATE)
RETURNS TABLE(fecha DATE, hora TIME, cantidad_pedidos INT) AS $$     
BEGIN
    RETURN QUERY
    SELECT
        p.fecha,
        p.hora,
        CAST(COUNT(*) AS INTEGER) AS cantidad_pedidos
    FROM
        Pedido p
    WHERE
        p.fecha BETWEEN fecha_inicio AND fecha_fin
    GROUP BY
        p.fecha, p.hora
    ORDER BY
        cantidad_pedidos DESC, p.fecha, p.hora
    LIMIT 1; 
	END;
$$ LANGUAGE plpgsql;

--3. Promedio de tiempo en que se tardan los clientes en comer --
CREATE OR REPLACE FUNCTION reporte_tiempo_comida(fecha_inicio DATE, fecha_fin DATE)
RETURNS TABLE(cantidad_personas INTEGER, promedio_minutos NUMERIC) AS $$
BEGIN
    RETURN QUERY
    SELECT
        m.capacidad AS cantidad_personas,
        AVG(EXTRACT(EPOCH FROM (p.horafin - p.hora)) / 60) AS promedio_minutos
    FROM
        Pedido p
    JOIN
        Mesa m ON p.id_mesa = m.id_mesa
    WHERE
        p.fecha BETWEEN fecha_inicio AND fecha_fin
    GROUP BY
        m.capacidad
    ORDER BY
        m.capacidad;
END;
$$ LANGUAGE plpgsql;

--4. Reporte de las quejas agrupadas por persona --
CREATE OR REPLACE FUNCTION reporte_quejas_por_persona(fecha_inicio DATE, fecha_fin DATE)
RETURNS TABLE (
    id_cliente INTEGER,
    nombre_cliente TEXT,
    numero_quejas INTEGER,
    motivos TEXT[]
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        q.id_cliente,
        c.nombre AS nombre_cliente,
        CAST(COUNT(*) AS INTEGER) AS numero_quejas,
        array_agg(q.motivo) AS motivos
    FROM 
        Queja q
    JOIN 
        Cliente c ON q.id_cliente = c.id_cliente
    WHERE 
        q.fecha BETWEEN fecha_inicio AND fecha_fin
    GROUP BY 
        q.id_cliente, c.nombre
    ORDER BY 
        numero_quejas DESC;
END;
$$ LANGUAGE plpgsql;

--5. Reporte de las quejas agrupadas por plato
CREATE OR REPLACE FUNCTION reporte_quejas_por_plato(fecha_inicio DATE, fecha_fin DATE)
RETURNS TABLE (
    nombre_plato TEXT,
    numero_quejas INTEGER,
    motivos TEXT[]
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        i.nombre AS nombre_plato,
        CAST(COUNT(*) AS INTEGER) AS numero_quejas,
        array_agg(q.motivo) AS motivos
    FROM 
        Queja q
    JOIN 
        Item i ON q.id_item = i.id_item
    WHERE 
        q.fecha BETWEEN fecha_inicio AND fecha_fin
        AND q.id_item IS NOT NULL
    GROUP BY 
        i.nombre
    ORDER BY 
        numero_quejas DESC;
END;
$$ LANGUAGE plpgsql;

--6. Reporte de la eficiencia de los meseros en los últimos 6 meses
CREATE OR REPLACE FUNCTION reporte_eficiencia_meseros()
RETURNS TABLE (
    nombre_mesero TEXT,
    mes_encuesta TEXT,
    promedio_amabilidad NUMERIC,
    promedio_exactitud NUMERIC
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        me.nombre AS nombre_mesero,
        to_char(p.fecha, 'YYYY-MM') AS mes_encuesta,
        AVG(e.amabilidad) AS promedio_amabilidad,
        AVG(e.exactitud) AS promedio_exactitud
    FROM 
        Encuesta e
    JOIN 
        Pedido p ON e.id_pedido = p.id_pedido
    JOIN
        Mesero me ON p.id_mesero = me.id_mesero
    WHERE 
        p.fecha >= current_date - INTERVAL '6 months'
    GROUP BY 
        me.nombre, to_char(p.fecha, 'YYYY-MM')
    ORDER BY 
        me.nombre, to_char(p.fecha, 'YYYY-MM');
END;
$$ LANGUAGE plpgsql;


--SELECTS--
--Triggers--
--SELECT tgname FROM pg_trigger WHERE tgname = 'trigger_calculo_propina_total';
--SELECT tgname FROM pg_trigger WHERE tgname = 'hash_password_users';
--Funciones--
--SELECT * FROM platos_mas_pedidos('2023-05-01'::DATE, '2024-04-01'::DATE);
--SELECT * FROM reporte_horario_max_pedidos('2023-05-01', '2024-04-01');
--SELECT * FROM reporte_tiempo_comida('2023-05-01', '2024-04-01');
--SELECT * FROM reporte_quejas_por_persona('2023-05-01', '2024-04-01');
--SELECT * FROM reporte_quejas_por_plato('2023-05-10', '2024-04-01');
--SELECT * FROM reporte_eficiencia_meseros();
--Tablas--
--SELECT * FROM AREA;
--SELECT * FROM MESA;
--SELECT * FROM CLIENTE;
--SELECT * FROM PERSONAL;
--SELECT * FROM USUARIOS;
--SELECT * FROM MESERO;
--SELECT * FROM PEDIDO;
--SELECT * FROM ITEM;
--SELECT * FROM DETALLE_PEDIDO;
--SELECT * FROM PAGO;
--SELECT * FROM CONTRIBUCIONPAGO;
--SELECT * FROM METODOPAGO;
--SELECT * FROM ENCUESTA;
--SELECT * FROM QUEJA;

--Drop Tables--
--DROP TABLE Area CASCADE;
--DROP TABLE Mesa CASCADE;
--DROP TABLE Cliente CASCADE;
--DROP TABLE Personal CASCADE;
--DROP TABLE Usuarios;
--DROP TABLE Mesero CASCADE;
--DROP TABLE Pedido CASCADE;
--DROP TABLE Item CASCADE;
--DROP TABLE Detalle_Pedido;
--DROP TABLE Pago CASCADE;
--DROP TABLE ContribucionPago CASCADE;
--DROP TABLE MetodoPago;
--DROP TABLE Encuesta;
--DROP TABLE Queja;

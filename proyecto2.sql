-- Creación de tablas
CREATE TABLE Area ( --Categoriza las distintas áreas del restaurante--
    id_area SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    fumadores BOOLEAN NOT NULL,
);

CREATE TABLE Mesa ( --Mesas del restaurante--
    id_mesa SERIAL PRIMARY KEY,
    capacidad INTEGER NOT NULL,
    movil BOOLEAN NOT NULL,
    id_area INTEGER NOT NULL,
    FOREIGN KEY (id_area) REFERENCES Area(id_area)
);
    
CREATE TABLE Cliente ( --Guarda la información de los clientes--
    id_cliente SERIAL PRIMARY KEY,
    nit TEXT,
    nombre TEXT NOT NULL,
    direccion TEXT
);

CREATE TABLE Personal ( --Mantiene el registro de los empleados--
    id_personal SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    rol TEXT NOT NULL
);

CREATE TABLE Usuarios ( --Cuentas de usuario para la autenticación del sistema--
    id_usuario SERIAL PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    id_personal INTEGER,
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal)
);

CREATE TABLE Mesero ( --Identifica únicamente a los meseros--
    id_mesero SERIAL PRIMARY KEY,
    id_personal INTEGER NOT NULL,
    nombre TEXT NOT NULL,
    id_area_asignada INTEGER,
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal),
    FOREIGN KEY (id_area_asignada) REFERENCES Area(id_area)
);

CREATE TABLE Pedido (--Realiza un seguimiento de los pedidos realizados por los clientes--
    id_pedido SERIAL PRIMARY KEY,
    fecha_hora TIMESTAMP DEFAULT NOW(),
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

CREATE TABLE Item ( --Define los items disponibles para pedir--
    id_item SERIAL PRIMARY KEY,
    tipo_item TEXT NOT NULL, --Platillo, Bebida, o Postre
    nombre TEXT NOT NULL,
    descripcion TEXT,
    precio NUMERIC(10, 2) NOT NULL
);

CREATE TABLE Detalle_Pedido ( --Relaciona los pedidos con los items específicos--
    id_detalle_pedido SERIAL PRIMARY KEY, -- Clave primaria autoincrementable
    id_pedido INTEGER NOT NULL,
    id_item INTEGER NOT NULL,
    cantidad INTEGER NOT NULL,
    UNIQUE(id_pedido, id_item), -- Asegura que la combinación de pedido e ítem sea única
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);

CREATE TABLE Pago ( --Registra información sobre los pagos de los pedidos.--
    id_pago SERIAL PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    monto_total NUMERIC(10, 2) NOT NULL, --Total pagado en el pedido.
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

CREATE TABLE MetodoPago ( --Detalla los métodos de pago utilizados para cada pago--
    id_metodo_pago SERIAL PRIMARY KEY,
    id_contribucion INTEGER NOT NULL,
    metodo_pago TEXT NOT NULL, -- Efectivo, Tarjeta de Crédito
    monto NUMERIC(10, 2) NOT NULL,
    FOREIGN KEY (id_contribucion) REFERENCES ContribucionPago(id_contribucion)
);

CREATE TABLE ContribucionPago ( --Permite rastrear las contribuciones individuales a los pagos cuando un pedido es compartido por varios clientes.--
    id_contribucion SERIAL PRIMARY KEY,
    id_pago INTEGER NOT NULL,
    id_cliente INTEGER NOT NULL,
    monto_contribucion NUMERIC(10, 2) NOT NULL, --Cuánto paga cada cliente
    FOREIGN KEY (id_pago) REFERENCES Pago(id_pago),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);

CREATE TABLE Encuesta ( --Recopila retroalimentación de los clientes sobre los meseros y el servicio proporcionado--
    id_encuesta SERIAL PRIMARY KEY,
    id_mesero INTEGER NOT NULL,
    id_pedido INTEGER NOT NULL,
    amabilidad INTEGER CHECK (amabilidad BETWEEN 1 AND 5),
    exactitud INTEGER CHECK (exactitud BETWEEN 1 AND 5),
    FOREIGN KEY (id_mesero) REFERENCES Mesero(id_mesero),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

CREATE TABLE Queja ( -- Permite a los clientes presentar quejas, que se registran con detalles como el motivo, la clasificación de gravedad y si están relacionadas con personal o ítems específicos. --
    id_queja SERIAL PRIMARY KEY,
    id_cliente INTEGER NOT NULL,
    fecha_hora TIMESTAMP DEFAULT NOW(),
    motivo TEXT,
    clasificacion INTEGER CHECK (clasificacion BETWEEN 1 AND 5),
    id_personal INTEGER,
    id_item INTEGER,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    FOREIGN KEY (id_personal) REFERENCES Personal(id_personal),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);

--Inserción de datos
--(Faltan agregar más)

--Area--
INSERT INTO Area (nombre, fumadores ) VALUES ('Terraza', TRUE);
INSERT INTO Area (nombre, fumadores ) VALUES ('Salón principal', FALSE);
INSERT INTO Area (nombre, fumadores) VALUES ('Salón 2', FALSE);
INSERT INTO Area (nombre, fumadores ) VALUES ('Salón 3', FALSE);
INSERT INTO Area (nombre, fumadores ) VALUES ('Pérgola', FALSE);

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
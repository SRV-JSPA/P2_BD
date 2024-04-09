
--Creación de tablas

CREATE TABLE Restaurante (
    id_Restaurante SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    ubicacion TEXT NOT NULL
);

CREATE TABLE Area (
    id_area SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    fumadores BOOLEAN NOT NULL,
    id_restaurante INTEGER NOT NULL,
    FOREIGN KEY (id_restaurante) REFERENCES Restaurante(id_restaurante)
);

CREATE TABLE Mesa (
    id_mesa SERIAL PRIMARY KEY,
    capacidad INTEGER NOT NULL,
    movil BOOLEAN NOT NULL,
    id_area INTEGER NOT NULL,
    FOREIGN KEY (id_area) REFERENCES Area(id_area)
);

CREATE TABLE Cliente (
    id_cliente SERIAL PRIMARY KEY,
    nit TEXT,
    nombre TEXT NOT NULL,
    direccion TEXT
);

CREATE TABLE Pedido (
    id_pedido SERIAL PRIMARY KEY,
    fecha_hora TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

CREATE TABLE Item (
    id_item SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    descripcion TEXT,
    precio NUMERIC(10, 2) NOT NULL
);

CREATE TABLE Detalle_Pedido (
    id_pedido INTEGER NOT NULL,
    id_item INTEGER NOT NULL,
    cantidad INTEGER NOT NULL,
    PRIMARY KEY (id_pedido, id_item),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);

CREATE TABLE Pago (
    id_pago SERIAL PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    monto NUMERIC(10, 2) NOT NULL,
    tipo TEXT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

CREATE TABLE Mesero (
    id_mesero SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    id_area_asignada INTEGER,
    FOREIGN KEY (id_area_asignada) REFERENCES Area(id_area)
);

CREATE TABLE Encuesta (
    id_encuesta SERIAL PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    amabilidad INTEGER CHECK (amabilidad BETWEEN 1 AND 5),
    exactitud INTEGER CHECK (exactitud BETWEEN 1 AND 5),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

CREATE TABLE Queja (
    id_queja SERIAL PRIMARY KEY,
    id_cliente INTEGER NOT NULL,
    fecha_hora TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT,
    clasificacion INTEGER CHECK (clasificacion BETWEEN 1 AND 5),
    id_personal INTEGER,
    id_item INTEGER,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    FOREIGN KEY (id_personal) REFERENCES Mesero(id_mesero),
    FOREIGN KEY (id_item) REFERENCES Item(id_item)
);

CREATE TABLE Personal (
    ip_personal SERIAL PRIMARY KEY,
    nombre TEXT NOT NULL,
    rol TEXT NOT NULL
);
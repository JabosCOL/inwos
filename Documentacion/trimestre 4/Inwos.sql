create database Inwos ;
drop database inwos;
CREATE TABLE Proveedor (
  cedula INT NOT NULL,
  dir_domicilio VARCHAR (30) NOT NULL,
  fecha_nacimiento VARCHAR (25) NOT NULL,
  contacto VARCHAR(25) NOT NULL,
  referencia VARCHAR (500) NOT NULL,
  nombres VARCHAR(45) NOT NULL,
  apellidos VARCHAR(45) NOT NULL,
  profesion VARCHAR (50) NOT NULL,
  tipo_documento VARCHAR (15) NOT NULL,
  ciudad VARCHAR(15) NOT NULL,
  experiencia VARCHAR(250) NOT NULL,
  area_de_profesion VARCHAR (50) NOT NULL,
  PRIMARY KEY (cedula));
 
CREATE TABLE servicio (
  id_servicio INT NOT NULL,
  descripcion VARCHAR (2000) NOT NULL,
  costo INT NOT NULL,
  direccion VARCHAR (30),
  horario_Ini TIME NOT NULL,
  horario_Fin TIME NOT NULL,
  condiciones_servicio VARCHAR (2000) NOT NULL,
  PRIMARY KEY (id_servicio));
  
   DROP TABLE servicio; 
  
CREATE TABLE cliente (
cedula INT NOT NULL,
usuario VARCHAR (30) NOT NULL,
Contraseña VARCHAR (40) NOT NULL,
PRIMARY KEY (cedula, usuario));

DROP TABLE cliente;

Create table encuesta_satisfaccion (
id_encuesta int primary key NOT NULL,
comentario VARCHAR (2000),
nota_de_servicio int,
nota_presentacion int,
volveria_a_hacer_negocio boolean
);
ALTER TABLE encuesta_satisfaccion ADD nombre_cliente VARCHAR (50) NOT NULL;
ALTER TABLE encuesta_satisfaccion ADD id_servicio int not null;
ALTER TABLE encuesta_satisfaccion DROP id_servicio;

DROP TABLE encuesta_satisfaccion;

INSERT INTO proveedor (cedula, dir_domicilio, fecha_nacimiento, contacto, nombres, apellidos, profesion, tipo_documento, ciudad, experiencia, area_de_profesion, referencia)
VALUES (1001097020,"Cll 135#58b-08",10/05/1995,3112869894, "Jose Roberto", "Ruiz Canciller", "estilista", "CC", "Bogota", 24, "belleza", "instituto American Style"),
(1008094156,"Cll 185#52b-12",15/08/1998,315856798, "Mario Alberto", "Mancilla", "Tecnico electricista", "CC", "Barranquilla", 36, "electricista", "SENA"),
(1005079864,"Cll 174#85b-15",08/05/1991,312856791, "Jose Maria", "Escamilla Perez", "Tecnico sistemas", "CC", "Bogota", 12, "servicio tecnico y mantenimiento", "instituto Computo sas");

SELECT*FROM proveedor;

INSERT INTO cliente (cedula, usuario, contraseña)
VALUES (1005087025,"Rosa98",123456),(1004085045,"Jabos094",35128679),(1009082058,"RosarioP",8675201),(39684152,"AngelaS",8264591),(1008080005,"PedroSar",13796243),
(1009279546,"Oscarx",9173825),(1003087128,"Roberto",82564793),(39855742,"Fredx","Fred123"),(1001887029,"Ron8",1237965),(1005987124,"Cornxw",8264573);

SELECT*FROM cliente;

INSERT INTO servicio (id_servicio, descripcion, costo, direccion, horario_Ini, horario_Fin, condiciones_servicio)
VALUES (19952,"Peluqueria con 2 años de experiencia en cortes para damas y caballeros, manicure, pedicure y otros.",35000,"Cll 135#158b-08","8:00:00","20:30:00","cita previa"),
(19958,"Reparaciones para el hogar, oficinas. Se ofrecen reparaciones de todo tipo a un precio asequible.",100000,"Cll 157#125b-05","9:30:00","20:30:00","Debe abonar el 50% del costo"),
(19845,"Servicio tecnico para equipos de computo en general y mantenimientos.",40000,"Cll 147#152b-15","8:00:00","20:30:00","Después de 30 días no se responde por equipos");

SELECT*FROM servicio;

INSERT INTO encuesta_satisfaccion (id_encuesta, nombre_cliente, comentario, nota_de_servicio, nota_presentacion, volveria_a_hacer_negocio)
VALUES (1006896, "Rafael Londoño", "excelente servicio", 9, 7, TRUE),(10069196, "Samuel Duque", "buen servicio", 8, 7, TRUE),(1056896, "Stiven Univar", "Buena atención", 8, 9, TRUE),(1082896, "José londoño", "pesimo servicio", 4, 5, FALSE),
(1086836, "David Perez", "Ladrón", 1, 1, FALSE),(1007596, "Karen Mora", "Recomendado", 9, 9, TRUE),(1084896, "Susan Paz", "excelente servicio", 9, 7, TRUE);

SELECT*FROM encuesta_satisfaccion;

ALTER TABLE servicio ADD id_proveedor int not null;
ALTER TABLE servicio ADD id_cliente varchar (30);


SELECT nota_de_servicio, count(*) FROM encuesta_satisfaccion GROUP BY nota_de_servicio;
SELECT nombre_cliente,comentario,volveria_a_hacer_negocio FROM encuesta_satisfaccion ORDER BY nombre_cliente desc;
SELECT id_servicio,costo FROM servicio ORDER BY costo desc;


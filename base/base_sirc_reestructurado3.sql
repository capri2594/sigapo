CREATE TABLE cambio_nombre (
  cod_antiguo VARCHAR(50) NOT NULL,
  dependencia_cod VARCHAR(50) NOT NULL,
  nombre_antiguo VARCHAR(255) NULL,
  fecha_cambio DATE NULL,
  PRIMARY KEY(cod_antiguo, dependencia_cod),
  INDEX cambio_nombre_FKIndex1(dependencia_cod)
);

CREATE TABLE campos_aux (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  organizacion_nombre VARCHAR(100) NOT NULL,
  campo  VARCHAR(50) NULL,
  valor VARCHAR(255) NULL,
  PRIMARY KEY(id),
  INDEX campos_aux_FKIndex1(organizacion_nombre)
);

CREATE TABLE cite (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  dependencia_cod VARCHAR(50) NOT NULL,
  siglas VARCHAR(80) NULL,
  numero INTEGER UNSIGNED NULL,
  gestion INT(4) NULL,
  descripcion TEXT NULL,
  PRIMARY KEY(id, dependencia_cod),
  INDEX cite_FKIndex1(dependencia_cod)
);

CREATE TABLE contacto (
  nombre VARCHAR(45) NOT NULL,
  organizacion_nombre VARCHAR(100) NOT NULL,
  ci VARCHAR(20) NOT NULL,
  idcontacto INTEGER UNSIGNED NULL,
  mail VARCHAR(30) NULL,
  fono VARCHAR(10) NULL,
  cargo VARCHAR(50) NULL,
  PRIMARY KEY(nombre),
  INDEX contacto_FKIndex1(organizacion_nombre)
);

CREATE TABLE dependencia (
  cod VARCHAR(50) NOT NULL,
  nombre VARCHAR(255) NULL,
  PRIMARY KEY(cod)
);

CREATE TABLE dep_como_dep (
  dependencia_cod VARCHAR(50) NOT NULL,
  PRIMARY KEY(dependencia_cod),
  INDEX dependencia_has_dependencia_FKIndex1(dependencia_cod),
  INDEX dependencia_has_dependencia_FKIndex2(dependencia_cod)
);

CREATE TABLE derivacion (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  einterna_id INTEGER UNSIGNED NOT NULL,
  einterna_entradas_tema_titulo VARCHAR(100) NOT NULL,
  einterna_entradas_id INTEGER UNSIGNED NOT NULL,
  usuario_cuenta VARCHAR(20) NOT NULL,
  einterna_entradas_usuario_cuenta VARCHAR(20) NOT NULL,
  hojaruta_salinternas_salidas_usuario_cuenta VARCHAR(20) NOT NULL,
  hojaruta_salinternas_salidas_tipo_clase VARCHAR(50) NOT NULL,
  hojaruta_salinternas_salidas_tema_titulo VARCHAR(100) NOT NULL,
  hojaruta_salinternas_salidas_cite VARCHAR(50) NOT NULL,
  hojaruta_salinternas_id INTEGER UNSIGNED NOT NULL,
  hojaruta_cod VARCHAR(50) NOT NULL,
  hojaruta_einterna_id INTEGER UNSIGNED NOT NULL,
  hojaruta_einterna_entradas_id INTEGER UNSIGNED NOT NULL,
  hojaruta_einterna_entradas_tema_titulo VARCHAR(100) NOT NULL,
  hojaruta_einterna_entradas_usuario_cuenta VARCHAR(20) NOT NULL,
  nro_destino INTEGER UNSIGNED NULL,
  destino VARCHAR(50) NULL,
  destinatario VARCHAR(100) NULL,
  fecha_derivacion DATETIME NULL,
  resp VARCHAR(255) NULL,
  nota TEXT NULL,
  fecha_proveido DATETIME NULL,
  proveido VARCHAR(100) NULL,
  PRIMARY KEY(id, einterna_id, einterna_entradas_tema_titulo, einterna_entradas_id, usuario_cuenta, einterna_entradas_usuario_cuenta, hojaruta_salinternas_salidas_usuario_cuenta, hojaruta_salinternas_salidas_tipo_clase, hojaruta_salinternas_salidas_tema_titulo, hojaruta_salinternas_salidas_cite, hojaruta_salinternas_id, hojaruta_cod, hojaruta_einterna_id, hojaruta_einterna_entradas_id, hojaruta_einterna_entradas_tema_titulo, hojaruta_einterna_entradas_usuario_cuenta),
  INDEX derivacion_FKIndex1(einterna_id, einterna_entradas_id, einterna_entradas_tema_titulo, einterna_entradas_usuario_cuenta),
  INDEX derivacion_FKIndex2(usuario_cuenta),
  INDEX derivacion_FKIndex3(hojaruta_cod, hojaruta_salinternas_id, hojaruta_salinternas_salidas_cite, hojaruta_salinternas_salidas_tema_titulo, hojaruta_salinternas_salidas_tipo_clase, hojaruta_salinternas_salidas_usuario_cuenta, hojaruta_einterna_entradas_usuario_cuenta, hojaruta_einterna_entradas_tema_titulo, hojaruta_einterna_entradas_id, hojaruta_einterna_id)
);

CREATE TABLE eexterna (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  entradas_id INTEGER UNSIGNED NOT NULL,
  entradas_tema_titulo VARCHAR(100) NOT NULL,
  entradas_usuario_cuenta VARCHAR(20) NOT NULL,
  cite VARCHAR(50) NULL,
  ref VARCHAR(80) NULL,
  remitente VARCHAR(100) NULL,
  org_remitente VARCHAR(50) NULL,
  PRIMARY KEY(id, entradas_id, entradas_tema_titulo, entradas_usuario_cuenta),
  INDEX nota_e_externa_FKIndex1(entradas_id, entradas_tema_titulo, entradas_usuario_cuenta)
);

CREATE TABLE einterna (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  entradas_id INTEGER UNSIGNED NOT NULL,
  entradas_tema_titulo VARCHAR(100) NOT NULL,
  entradas_usuario_cuenta VARCHAR(20) NOT NULL,
  cite VARCHAR(50) NOT NULL,
  ref VARCHAR(50) NULL,
  dependencia VARCHAR(50) NULL,
  funcionario VARCHAR(50) NULL,
  hojaruta_codigo VARCHAR(50) NULL,
  PRIMARY KEY(id, entradas_id, entradas_tema_titulo, entradas_usuario_cuenta),
  INDEX nota_e_interna_FKIndex1(entradas_id, entradas_tema_titulo, entradas_usuario_cuenta)
);

CREATE TABLE entradas (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tema_titulo VARCHAR(100) NOT NULL,
  usuario_cuenta VARCHAR(20) NOT NULL,
  fecha_recibido DATETIME NULL,
  PRIMARY KEY(id, tema_titulo, usuario_cuenta),
  INDEX nen_FKIndex1(usuario_cuenta),
  INDEX entradas_FKIndex2(tema_titulo)
);

CREATE TABLE funcionario (
  nombre VARCHAR(50) NOT NULL,
  usuario_cuenta VARCHAR(20) NOT NULL,
  dependencia_cod VARCHAR(50) NOT NULL,
  ci VARCHAR(50) NOT NULL,
  cargo VARCHAR(50) NULL,
  celular VARCHAR(8) NULL,
  telefono VARCHAR(10) NULL,
  email VARCHAR(30) NULL,
  PRIMARY KEY(nombre, usuario_cuenta, dependencia_cod),
  INDEX funcionario_FKIndex1(dependencia_cod),
  INDEX funcionario_FKIndex2(usuario_cuenta)
);

CREATE TABLE hojaruta (
  cod VARCHAR(50) NOT NULL,
  salinternas_id INTEGER UNSIGNED NOT NULL,
  salinternas_salidas_cite VARCHAR(50) NOT NULL,
  salinternas_salidas_tema_titulo VARCHAR(100) NOT NULL,
  salinternas_salidas_tipo_clase VARCHAR(50) NOT NULL,
  salinternas_salidas_usuario_cuenta VARCHAR(20) NOT NULL,
  einterna_entradas_usuario_cuenta VARCHAR(20) NOT NULL,
  einterna_entradas_tema_titulo VARCHAR(100) NOT NULL,
  einterna_entradas_id INTEGER UNSIGNED NOT NULL,
  einterna_id INTEGER UNSIGNED NOT NULL,
  fecha DATETIME NULL,
  dependencia VARCHAR(50) NULL,
  funcionario VARCHAR(50) NULL,
  fecha_proveido DATETIME NULL,
  proveido VARCHAR(100) NULL,
  fecha_resp DATETIME NULL,
  respuesta VARCHAR(255) NULL,
  nota TEXT NULL,
  PRIMARY KEY(cod, salinternas_id, salinternas_salidas_cite, salinternas_salidas_tema_titulo, salinternas_salidas_tipo_clase, salinternas_salidas_usuario_cuenta, einterna_entradas_usuario_cuenta, einterna_entradas_tema_titulo, einterna_entradas_id, einterna_id),
  INDEX hoja_de_ruta_FKIndex1(salinternas_id, salinternas_salidas_cite, salinternas_salidas_tema_titulo, salinternas_salidas_tipo_clase, salinternas_salidas_usuario_cuenta),
  INDEX hojaruta_FKIndex2(einterna_id, einterna_entradas_id, einterna_entradas_tema_titulo, einterna_entradas_usuario_cuenta)
);

CREATE TABLE organizacion (
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(20) NULL,
  direccion VARCHAR(255) NULL,
  ciudad VARCHAR(255) NULL,
  categoria VARCHAR(45) NULL,
  PRIMARY KEY(nombre)
);

CREATE TABLE salexternas (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  salidas_cite VARCHAR(50) NOT NULL,
  salidas_tema_titulo VARCHAR(100) NOT NULL,
  salidas_tipo_clase VARCHAR(50) NOT NULL,
  salidas_usuario_cuenta VARCHAR(20) NOT NULL,
  contacto VARCHAR(100) NULL,
  organismo VARCHAR(50) NULL,
  PRIMARY KEY(id, salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta),
  INDEX nsext_FKIndex1(salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta)
);

CREATE TABLE salidas (
  cite VARCHAR(50) NOT NULL,
  tema_titulo VARCHAR(100) NOT NULL,
  tipo_clase VARCHAR(50) NOT NULL,
  usuario_cuenta VARCHAR(20) NOT NULL,
  dep_remitente VARCHAR(50) NULL,
  remitente VARCHAR(100) NULL,
  fecha_envio DATETIME NULL,
  ref VARCHAR(80) NULL,
  fecha_proveido DATETIME NULL,
  proveido VARCHAR(100) NULL,
  PRIMARY KEY(cite, tema_titulo, tipo_clase, usuario_cuenta),
  INDEX nota_saliente_FKIndex1(usuario_cuenta),
  INDEX salidas_FKIndex2(tema_titulo),
  INDEX salidas_FKIndex3(tipo_clase)
);

CREATE TABLE salinternas (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  salidas_cite VARCHAR(50) NOT NULL,
  salidas_tema_titulo VARCHAR(100) NOT NULL,
  salidas_tipo_clase VARCHAR(50) NOT NULL,
  salidas_usuario_cuenta VARCHAR(20) NOT NULL,
  nhojas INTEGER UNSIGNED NULL,
  ladjuntos TEXT NULL,
  danexos TEXT NULL,
  funcionario VARCHAR(50) NULL,
  dependencia VARCHAR(50) NULL,
  PRIMARY KEY(id, salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta),
  INDEX nota_s_interna_FKIndex1(salidas_cite, salidas_tema_titulo, salidas_tipo_clase, salidas_usuario_cuenta)
);

CREATE TABLE tema (
  titulo VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) NULL,
  PRIMARY KEY(titulo)
);

CREATE TABLE tipo (
  clase VARCHAR(50) NOT NULL,
  descripcion VARCHAR(255) NULL,
  PRIMARY KEY(clase)
);

CREATE TABLE usuario (
  cuenta VARCHAR(20) NOT NULL,
  clave VARCHAR(10) NULL,
  PRIMARY KEY(cuenta)
);



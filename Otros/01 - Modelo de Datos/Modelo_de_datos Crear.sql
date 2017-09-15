CREATE TABLE tsg_comentario_proyecto (cop_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', cop_descrip varchar(1000) comment 'Descripci�n', tsg_proyectopro_id int(10) NOT NULL, tsg_usuariousu_id int(10) NOT NULL, tsg_archivoarc_id int(10) NOT NULL, cop_fecha_creacion datetime NULL comment 'Fecha de creaci�n', PRIMARY KEY (cop_id)) comment='Tabla de observaciones del proyecto';
CREATE TABLE tsg_proyecto_historico (prh_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', prh_usuario varchar(255) comment 'Usuario creador', prh_fecha datetime NULL comment 'Fecha de creaci�n', tsg_proyectopro_id int(10) NOT NULL, sqi_tipo_proyectotip_id int(10) NOT NULL, tsg_estado_proyectoest_id int(10) NOT NULL, PRIMARY KEY (prh_id)) comment='Tabla de hist�rico del proyecto';
CREATE TABLE tsg_modulo_tsg_rol (tsg_modulomod_id int(10) NOT NULL, tsg_rolrol_id int(10) NOT NULL, PRIMARY KEY (tsg_modulomod_id, tsg_rolrol_id));
CREATE TABLE tsg_usuario_tsg_rol (tsg_usuariousu_id int(10) NOT NULL, tsg_rolrol_id int(10) NOT NULL, PRIMARY KEY (tsg_usuariousu_id, tsg_rolrol_id));
CREATE TABLE tsg_usuario_tsg_proyecto (tsg_usuariousu_id int(10) NOT NULL, tsg_proyectopro_id int(10) NOT NULL, PRIMARY KEY (tsg_usuariousu_id, tsg_proyectopro_id));
CREATE TABLE tsg_archivo (arc_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico', arc_nombre varchar(255) NOT NULL comment 'nombre del archivo adjunto', arc_peso float NOT NULL comment 'peso del archivo adjunto', arc_url varchar(255) NOT NULL comment 'url del archivo adjunto', PRIMARY KEY (arc_id)) comment='Tabla de archivos adjuntos';
CREATE TABLE tsg_estadistica_diaria (dis_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', dis_fecha int(10) NOT NULL comment 'Fecha', dis_total int(10) NOT NULL comment 'Total de tickets', dis_procesadas int(10) NOT NULL comment 'Total procesados', dis_pendientes int(10) NOT NULL comment 'Total pendientes', dis_cerradas int(10) NOT NULL comment 'Total cerradas', tsg_proyectopro_id int(10) NOT NULL, PRIMARY KEY (dis_id)) comment='Tabla de registro estad�stico diario';
CREATE TABLE tsg_modulo (mod_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', mod_nombre varchar(100) NOT NULL comment 'Nombre', mod_descrip varchar(1000) comment 'Descripci�n del rol', mod_activo tinyint(1) NOT NULL comment 'Indicador de registro activo', mod_usu_creador varchar(255) NOT NULL comment 'Usuario creador', mod_fecha_creacion datetime NOT NULL comment 'Fecha de creaci�n', mod_fecha_modificacion datetime NULL comment 'Fecha de modificaci�n', mod_id_mod_padre int(11), mod_ruta_imagen varchar(100), PRIMARY KEY (mod_id)) comment='Tabla de m�dulos';
CREATE TABLE tsg_historico_ticket (his_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico', his_nombre varchar(100) NOT NULL comment 'nombre del hist�rico', his_descrip varchar(1000) comment 'descripci�n hist�rico', tsg_estado_ticketest_id int(10) NOT NULL, tsg_tickettic_id int(10) NOT NULL, tsg_usuariousu_id int(10) NOT NULL, tsg_proyectopro_id int(10) NOT NULL, tsg_prioridadpri_id int(10) NOT NULL, tsg_categoriacat_id int(10) NOT NULL, PRIMARY KEY (his_id)) comment='Tabla de registro hist�rico del ticket';
CREATE TABLE tsg_rol (rol_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', rol_nombre varchar(100) comment 'Nombre del rol', rol_descrip varchar(1000) NOT NULL comment 'Descripci�n del rol', rol_activo tinyint(1) NOT NULL comment 'Indicador de registro activo', rol_usu_creador varchar(255) NOT NULL comment 'Usuario creador', rol_fecha_creacion datetime NOT NULL comment 'Fecha de creaci�n', rol_fecha_modificacion datetime NULL comment 'Fecha modificaci�n', PRIMARY KEY (rol_id)) comment='Tabla de roles';
CREATE TABLE tsg_categoria (cat_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico', cat_nombre varchar(100) NOT NULL comment 'nombre de la categor�a.', cat_descrip varchar(1000) comment 'descripci�n de la categor�a', cat_activo tinyint(1) NOT NULL comment 'eliminaci�n l�gica del sistema.', cat_usu_creador varchar(255) NOT NULL comment 'Usuario creador', cat_fecha_creacion datetime NOT NULL comment 'Fecha creaci�n', cat_fecha_modificacion datetime NULL comment 'Fecha modificaci�n', PRIMARY KEY (cat_id)) comment='tabla de las categor�as del proyecto';
CREATE TABLE sqi_tipo_proyecto (tip_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico', tip_nombre varchar(100) NOT NULL comment 'Nombre del tipo de proyecto', tip_descrip varchar(1000) comment 'Descripci�n del tipo de proyecto', tip_activo tinyint(1) NOT NULL comment 'Registro activo', tip_usu_creador varchar(255) NOT NULL comment 'Usuario creador', tip_fecha_creacion datetime NOT NULL comment 'Fecha de creaci�n', tip_fecha_modificacion datetime NULL comment 'Fecha de modificaci�n', tsg_proyecto_historicoprh_id int(10) NOT NULL, PRIMARY KEY (tip_id)) comment='Tipo de proyecto';
CREATE TABLE tsg_prioridad (pri_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico de la prioridad del ticket', pri_nombre varchar(100) NOT NULL comment 'nombre de la prioridad', pri_descrip varchar(1000) comment 'descripci�n de la prioridad', pri_activo tinyint(1) NOT NULL comment 'eliminaci�n l�gica del sistema.', PRIMARY KEY (pri_id)) comment='prioridad del ticket';
CREATE TABLE tsg_comentario_ticket (com_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico del comentario', com_descrip varchar(1000) comment 'descripci�n del comentario asociado al ticket', tsg_tickettic_id int(10) NOT NULL, tsg_usuariousu_id int(10) NOT NULL, tsg_archivoarc_id int(10) NOT NULL, com_fecha_creacion datetime NULL comment 'Fecha de creaci�n', PRIMARY KEY (com_id)) comment='comentario asociado al ticket';
CREATE TABLE tsg_estado_ticket (est_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico', est_nombre varchar(100) NOT NULL comment 'nombre del estado del ticket', est_descrip varchar(1000) comment 'descripci�n del estado del ticket', est_activo tinyint(1) NOT NULL comment 'eliminaci�n l�gica del sistema', PRIMARY KEY (est_id)) comment='tabla del estado del ticket';
CREATE TABLE tsg_estado_proyecto (est_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico del estado del proyecto', est_nombre varchar(255) NOT NULL comment 'nombre del estado del proyecto', est_descrip int(10) comment 'descripci�n del estado del proyecto', est_activo int(10) NOT NULL comment 'eliminaci�n logica del sistema', PRIMARY KEY (est_id)) comment='tabla que corresponde al estado que se encuentra el proyecto';
CREATE TABLE tsg_cliente (cli_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la cliente.' 		, cli_nombre varchar(255) NOT NULL comment 'corresponde al nombre del cliente' 																														, cli_apellido varchar(255) NOT NULL comment 'apellido del cliente', cli_correo varchar(255) comment 'correo electr�nico del cliente', cli_empresa varchar(255) comment 'nombre de la empresa en la cual se encuentra posicionado el cliente', cli_rut varchar(255) NOT NULL comment 'rut del cliente', cli_direccion varchar(255) comment 'direcci�n del cliente', cli_fecha_ini timestamp NOT NULL comment 'fecha de inicio del cliente', cli_fecha_mod timestamp NULL comment 'fecha de modificaci�n del cliente', cli_activo tinyint(1) NOT NULL comment '
se deja la tabla de cliente con la opci�n para saber si el usuario esta activo o inactivo, en la BD se mostrara oculto si se elimino por sistema. (1 o 0 ) Eliminaci�n logica.', cli_usu_creador varchar(255) NOT NULL comment 'Usuario creador', PRIMARY KEY (cli_id)) comment='tabla sistema de gesti�n, est� tabla contiene los datos del cliente que interactuara con el sistema.';
CREATE TABLE tsg_ticket (tic_id int(10) NOT NULL AUTO_INCREMENT comment 'identificador �nico del ticket', tic_nombre varchar(255) NOT NULL comment 'nombre del ticket', tic_fecha_crea timestamp NOT NULL comment 'fecha de creaci�n del ticket', tsg_estado_ticketest_id int(10) NOT NULL, tsg_usuariousu_id int(10) NOT NULL, tsg_proyectopro_id int(10) NOT NULL, tsg_prioridadpri_id int(10) NOT NULL, tsg_categoriacat_id int(10) NOT NULL, tic_destcado tinyint(1) comment 'Desatacado (Estrellita)', tsg_tic_correo_en_copia varchar(1000) comment 'Correos en copia del cambio de estado', PRIMARY KEY (tic_id)) comment='tabla ticket corresponde a los tickets que tiene asociado el proyecto';
CREATE TABLE tsg_proyecto (pro_id int(10) NOT NULL AUTO_INCREMENT comment 'Clave primaria del proyecto, identificador �nico', pro_nombre varchar(255) NOT NULL comment 'nombre del proyecto', pro_descrip varchar(255) comment 'descripci�n del proyecto', pro_usu_id_jefepro int(10) NOT NULL comment 'Identificador del jefe de proyecto', pro_duracion varchar(255) NOT NULL comment 'duraci�n del proyecto', pro_fecha_ini timestamp NOT NULL comment 'Fecha inicio del proyecto', pro_fecha_term timestamp NOT NULL comment 'fecha termino del proyecto', pro_fecha_garan timestamp NULL comment 'fecha de garant�a del proyecto', pro_activo tinyint(1) NOT NULL comment 'eliminaci�n l�gica del sistema.', tsg_clientecli_id int(10) NOT NULL, tsg_estado_proyectoest_id int(10) NOT NULL, sqi_tipo_proyectotip_id int(10), pro_usu_creador varchar(255) NOT NULL comment 'Usuario creador', pro_fecha_creacion datetime NOT NULL comment 'Fecha creaci�n', pro_fecha_modificacion datetime NULL comment 'Fecha de modificaci�n', pro_destacado tinyint(1) comment 'Destacado (Estrellita)', PRIMARY KEY (pro_id));
CREATE TABLE tsg_usuario (usu_id int(10) NOT NULL AUTO_INCREMENT comment 'Identificador �nico de la tabla', usu_nombre varchar(255) NOT NULL comment 'Nombre', usu_apellido varchar(255) NOT NULL comment 'Apellido del usuario', usu_telefono tinyint(10) NOT NULL comment 'tel�fono del usuario', usu_direccion varchar(255) NOT NULL comment 'Direcci�n del Usuario', usu_fecha_crea timestamp NOT NULL comment 'Fecha de creaci�n, se usara la secuencia de timestamp para guardar la hora y la fecha.', usu_fecha_mod timestamp NOT NULL comment 'fecha de modificaci�n, se guardar� con la secuencia timestamp para guardar la hora y la fecha de la modificaci�n.', usu_rut varchar(50) NOT NULL comment 'se define el rut del usuario, se considera como varchar ya que contienen n�mero y caracteres.', usu_activo varchar(20), usu_correo varchar(255) NOT NULL comment 'correo electr�nico del usuario', usu_activo int(2) NOT NULL comment 'se deja la tabla de usuario con la opci�n para saber si el usuario esta activo o inactivo, en la BD de mostrara oculto si se elimino por sistema. (1 o 0)', PRIMARY KEY (usu_id)) comment='Tabla de Usuarios';
ALTER TABLE tsg_usuario_tsg_proyecto ADD INDEX FKtsg_usuari848679 (tsg_usuariousu_id), ADD CONSTRAINT FKtsg_usuari848679 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
ALTER TABLE tsg_usuario_tsg_proyecto ADD INDEX FKtsg_usuari832738 (tsg_proyectopro_id), ADD CONSTRAINT FKtsg_usuari832738 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id);
ALTER TABLE tsg_usuario_tsg_rol ADD INDEX FKtsg_usuari286059 (tsg_usuariousu_id), ADD CONSTRAINT FKtsg_usuari286059 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
ALTER TABLE tsg_usuario_tsg_rol ADD INDEX FKtsg_usuari189443 (tsg_rolrol_id), ADD CONSTRAINT FKtsg_usuari189443 FOREIGN KEY (tsg_rolrol_id) REFERENCES tsg_rol (rol_id);
ALTER TABLE tsg_modulo_tsg_rol ADD INDEX FKtsg_modulo656602 (tsg_modulomod_id), ADD CONSTRAINT FKtsg_modulo656602 FOREIGN KEY (tsg_modulomod_id) REFERENCES tsg_modulo (mod_id);
ALTER TABLE tsg_modulo_tsg_rol ADD INDEX FKtsg_modulo632852 (tsg_rolrol_id), ADD CONSTRAINT FKtsg_modulo632852 FOREIGN KEY (tsg_rolrol_id) REFERENCES tsg_rol (rol_id);
ALTER TABLE tsg_proyecto ADD INDEX FKtsg_proyec672127 (tsg_clientecli_id), ADD CONSTRAINT FKtsg_proyec672127 FOREIGN KEY (tsg_clientecli_id) REFERENCES tsg_cliente (cli_id);
ALTER TABLE tsg_proyecto ADD INDEX FKtsg_proyec412853 (tsg_estado_proyectoest_id), ADD CONSTRAINT FKtsg_proyec412853 FOREIGN KEY (tsg_estado_proyectoest_id) REFERENCES tsg_estado_proyecto (est_id);
ALTER TABLE tsg_proyecto ADD INDEX FKtsg_proyec283651 (sqi_tipo_proyectotip_id), ADD CONSTRAINT FKtsg_proyec283651 FOREIGN KEY (sqi_tipo_proyectotip_id) REFERENCES sqi_tipo_proyecto (tip_id);
ALTER TABLE tsg_proyecto_historico ADD INDEX FKtsg_proyec767319 (tsg_proyectopro_id), ADD CONSTRAINT FKtsg_proyec767319 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id);
ALTER TABLE sqi_tipo_proyecto ADD INDEX FKsqi_tipo_p791418 (tsg_proyecto_historicoprh_id), ADD CONSTRAINT FKsqi_tipo_p791418 FOREIGN KEY (tsg_proyecto_historicoprh_id) REFERENCES tsg_proyecto_historico (prh_id);
ALTER TABLE tsg_proyecto_historico ADD INDEX FKtsg_proyec676013 (sqi_tipo_proyectotip_id), ADD CONSTRAINT FKtsg_proyec676013 FOREIGN KEY (sqi_tipo_proyectotip_id) REFERENCES sqi_tipo_proyecto (tip_id);
ALTER TABLE tsg_proyecto_historico ADD INDEX FKtsg_proyec979508 (tsg_estado_proyectoest_id), ADD CONSTRAINT FKtsg_proyec979508 FOREIGN KEY (tsg_estado_proyectoest_id) REFERENCES tsg_estado_proyecto (est_id);
ALTER TABLE tsg_ticket ADD INDEX FKtsg_ticket88476 (tsg_estado_ticketest_id), ADD CONSTRAINT FKtsg_ticket88476 FOREIGN KEY (tsg_estado_ticketest_id) REFERENCES tsg_estado_ticket (est_id);
ALTER TABLE tsg_ticket ADD INDEX FKtsg_ticket546662 (tsg_usuariousu_id), ADD CONSTRAINT FKtsg_ticket546662 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
ALTER TABLE tsg_comentario_ticket ADD INDEX FKtsg_coment449974 (tsg_tickettic_id), ADD CONSTRAINT FKtsg_coment449974 FOREIGN KEY (tsg_tickettic_id) REFERENCES tsg_ticket (tic_id);
ALTER TABLE tsg_ticket ADD INDEX FKtsg_ticket228081 (tsg_proyectopro_id), ADD CONSTRAINT FKtsg_ticket228081 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id);
ALTER TABLE tsg_ticket ADD INDEX FKtsg_ticket635084 (tsg_prioridadpri_id), ADD CONSTRAINT FKtsg_ticket635084 FOREIGN KEY (tsg_prioridadpri_id) REFERENCES tsg_prioridad (pri_id);
ALTER TABLE tsg_comentario_ticket ADD INDEX FKtsg_coment189196 (tsg_usuariousu_id), ADD CONSTRAINT FKtsg_coment189196 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
ALTER TABLE tsg_comentario_ticket ADD INDEX FKtsg_coment842735 (tsg_archivoarc_id), ADD CONSTRAINT FKtsg_coment842735 FOREIGN KEY (tsg_archivoarc_id) REFERENCES tsg_archivo (arc_id);
ALTER TABLE tsg_ticket ADD INDEX FKtsg_ticket331605 (tsg_categoriacat_id), ADD CONSTRAINT FKtsg_ticket331605 FOREIGN KEY (tsg_categoriacat_id) REFERENCES tsg_categoria (cat_id);
ALTER TABLE tsg_comentario_proyecto ADD INDEX FKtsg_coment854003 (tsg_proyectopro_id), ADD CONSTRAINT FKtsg_coment854003 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id);
ALTER TABLE tsg_comentario_proyecto ADD INDEX FKtsg_coment436168 (tsg_usuariousu_id), ADD CONSTRAINT FKtsg_coment436168 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
ALTER TABLE tsg_comentario_proyecto ADD INDEX FKtsg_coment782628 (tsg_archivoarc_id), ADD CONSTRAINT FKtsg_coment782628 FOREIGN KEY (tsg_archivoarc_id) REFERENCES tsg_archivo (arc_id);


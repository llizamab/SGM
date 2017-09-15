/* Limpiado de datos */
DELETE FROM tsg_usuario_tsg_rol;
DELETE FROM tsg_usuario_tsg_proyecto;
DELETE FROM tsg_modulo_tsg_rol;
DELETE FROM tsg_usuario;
DELETE FROM tsg_rol;
DELETE FROM tsg_modulo;
DELETE FROM tsg_archivo;
DELETE FROM tsg_comentario_proyecto;
DELETE FROM tsg_proyecto_historico;
DELETE FROM tsg_proyecto;
DELETE FROM tsg_cliente;
DELETE FROM sqi_tipo_proyecto;
DELETE FROM tsg_estado_proyecto;
DELETE FROM tsg_categoria;
DELETE FROM tsg_prioridad;
DELETE FROM tsg_comentario_ticket;
DELETE FROM tsg_historico_ticket;
DELETE FROM tsg_ticket;
DELETE FROM tsg_estado_ticket;
DELETE FROM tsg_estadistica_diaria;

SET NAMES 'utf8';
SET CHARACTER SET 'utf8';

/*
 #############################
 Datos fijos
 #############################
*/

/* Insercion de usuarios */
INSERT INTO `tsg_usuario`(`usu_id`, `usu_nombre`, `usu_apellido`, `usu_telefono`, `usu_direccion`, `usu_fecha_crea`, `usu_fecha_mod`, `usu_rut`, `usu_pass`, `usu_correo`, `usu_activo`) 
VALUES 
(1,'Tracy Solange','Padilla',123456,'Av. Alemania 123',now(),null,'11.111.111-1','d964173dc44da83eeafa3aebbee9a1a0','padilla.tracy.s@gmail.com',1),
(2,'Luis Alberto','Lizama',123456,'Av. Alemania 123',now(),null,'22.222.222-2','d964173dc44da83eeafa3aebbee9a1a0','luxohcf@gmail.com',1),
(3,'Juan Carlos','Vallejos',123456,'Av. Alemania 123',now(),null,'33.333.333-3','d964173dc44da83eeafa3aebbee9a1a0','juan.carlos.vallejos.obreque@gmail.com',1);

/* Insercion de roles */
INSERT INTO `tsg_rol`(`rol_id`, `rol_nombre`, `rol_descrip`, `rol_activo`, `rol_usu_creador`, `rol_fecha_creacion`, `rol_fecha_modificacion`) 
VALUES 
(1,'super-user','Rol del super usuario',1,'tracy',now(),null),
(2,'Administrador','Rol del Administrador',1,'tracy',now(),null),
(3,'Encargado','Rol del Encargado',1,'tracy',now(),null),
(4,'Desarrollador','Rol del Desarrollador',1,'tracy',now(),null);

/* Asociacion de roles a usuarios */
INSERT INTO `tsg_usuario_tsg_rol`(`tsg_usuariousu_id`, `tsg_rolrol_id`) 
VALUES 
(1,1),(1,3), -- Tracy super-user y Encargado
(2,3),       -- Luis Encargado
(3,4);       -- Juan Desarrollador

/* Insercion de modulos */
INSERT INTO 
`tsg_modulo`(`mod_id`,`mod_nombre`, `mod_descrip`, `mod_activo`, `mod_usu_creador`, `mod_fecha_creacion`, `mod_fecha_modificacion`, `mod_id_mod_padre`, `mod_ruta_imagen`) 
VALUES 
(1,'Proyectos','',1,'tracy',now(),null,null,null),
(2,'Clientes','',1,'tracy',now(),null,null,null),
(3,'Usuarios','',1,'tracy',now(),null,null,null),
(4,'Solicitudes','',1,'tracy',now(),null,null,null),
(5,'Estad&iacute;sticas','',1,'tracy',now(),null,null,null),
(6,'Registrar','crear_proyecto.php',1,'tracy',now(),null,1,'css/images/registrar.gif'),
(7,'Buscar','busqueda_proyecto.php',1,'tracy',now(),null,1,'css/images/Search.png'),
(8,'Registrar','crear_cliente.php',1,'tracy',now(),null,2,'css/images/registrar.gif'),
(9,'Buscar','busqueda_cliente.php',1,'tracy',now(),null,2,'css/images/Search.png'),
(10,'Registrar','crear_usuario.php',1,'tracy',now(),null,3,'css/images/registrar.gif'),
(11,'Buscar','busqueda_usuario.php',1,'tracy',now(),null,3,'css/images/Search.png'),
(12,'Registrar','crear_solicitudes.php',1,'tracy',now(),null,4,'css/images/registrar.gif'),
(13,'Buscar','busqueda_solicitudes.php',1,'tracy',now(),null,4,'css/images/Search.png'),
(14,'Buscar','ver_estadisticas.php',1,'tracy',now(),null,5,'css/images/Search.png'),
(15,'Actual','situacion_actual.php',1,'tracy',now(),null,5,'css/images/Search.png');

/* Asociacion de modulos a roles */
INSERT INTO `tsg_modulo_tsg_rol`(`tsg_rolrol_id`,`tsg_modulomod_id`) 
VALUES 
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12),
(1,13),
(1,14),
(1,15),
(2,6),
(2,7),
(2,8),
(2,9),
(2,10),
(2,11),
(2,13),
(2,14),
(2,15),
(3,6),
(3,7),
(3,9),
(3,12),
(3,13),
(3,14),
(4,13);

/* Estados de las solicitudes */
INSERT INTO tsg_estado_ticket (est_id,est_nombre,est_descrip,est_activo)
VALUES
(1,'Creada','Estado creado',1),
(2,'Asignada','Estado Asignada',1),
(3,'Resuelta','Estado Resuelta',1),
(4,'Rechazada','Estado Rechazada',1),
(5,'Cerrada','Estado Cerrada',1),
(6,'Desestimada','Estado Desestimada',1);

/* Prioridades de las solicitudes */
INSERT INTO tsg_prioridad (pri_id,pri_nombre,pri_descrip,pri_activo) 
VALUES
(1,'Baja','Prioridad baja',1),
(2,'Media','Prioridad media',1),
(3,'Alta','Prioridad alta',1);

/* Categorias de las solicitudes */
INSERT INTO tsg_categoria (cat_id,cat_nombre,cat_descrip,cat_activo,cat_usu_creador,cat_fecha_creacion,cat_fecha_modificacion) 
VALUES
(1,'Error','Categoría Error',1,'luxo',now(),null),
(2,'Soporte','Categoría Soporte',1,'luxo',now(),null),
(3,'Desarrollo','Categoría Desarrollo',1,'luxo',now(),null);

/* Tipo de proyecto */
INSERT INTO `sqi_tipo_proyecto`(`tip_id`, `tip_nombre`, `tip_descrip`, `tip_activo`, `tip_usu_creador`, `tip_fecha_creacion`, `tip_fecha_modificacion`) 
VALUES 
(1,'Desarrollo','Desarrollo',1,'luxo',now(),null),
(2,'Mantenimiento','Mantenimiento',1,'luxo',now(),null);

/* Estado proyecto */
INSERT INTO `tsg_estado_proyecto`(`est_id`, `est_nombre`, `est_descrip`, `est_activo`) 
VALUES 
(1,'Creado','Creado',1),
(2,'En ejecuci&oacute;n','En ejecuci&oacute;n',1),
(3,'En mantenimiento','En mantenimiento',1),
(4,'Finalizado','Finalizado',1);


/*
 #############################
 Datos de prueba
 #############################
*/

/* Clientes de prueba */
INSERT INTO `tsg_cliente`(`cli_id`, `cli_nombre`, `cli_apellido`, `cli_correo`, `cli_empresa`, `cli_rut`, `cli_direccion`, `cli_fecha_ini`, `cli_fecha_mod`, `cli_activo`, `cli_usu_creador`) 
VALUES 
(1,'Hardy','Millar','correo@c.cl','cliente Lazos ltds.','77123546-8','Av. alemania 123',now(),null,1,'luxo'),
(2,'Cliente 2','Ap','correo@c.cl','cliente 2 ltds.','22123546-8','Av. alemania 123',now(),null,1,'luxo'),
(3,'Cliente 3','Ap','correo@c.cl','cliente 3 ltds.','33123546-8','Av. alemania 123',now(),null,1,'luxo');

/* Proyectos de prueba */

INSERT INTO `tsg_proyecto`(`pro_id`, `pro_nombre`, `pro_descrip`, `pro_usu_id_jefepro`, `pro_duracion`, `pro_fecha_ini`, `pro_fecha_term`, `pro_fecha_garan`, `pro_activo`, `tsg_clientecli_id`, `tsg_estado_proyectoest_id`, `sqi_tipo_proyectotip_id`, `pro_usu_creador`, `pro_fecha_creacion`, `pro_fecha_modificacion`, `pro_destacado`) 
VALUES 
(1,'Proyecto 1','Proyecto 1',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 1 ,1,1,'luxo',now(),null,1),
(2,'Proyecto 2','Proyecto 2',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 1 ,3,2,'luxo',now(),null,1),
(3,'Proyecto 3','Proyecto 3',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 2 ,2,1,'luxo',now(),null,0),
(4,'Proyecto 4','Proyecto 4',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 2 ,4,2,'luxo',now(),null,0);
/*(5,'Proyecto 5','Proyecto 5',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 3 ,1,1,'luxo',now(),null,1),
(6,'Proyecto 6','Proyecto 6',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 3 ,3,2,'luxo',now(),null,0),
(7,'Proyecto 7','Proyecto 7',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 1 ,2,1,'luxo',now(),null,1),
(8,'Proyecto 8','Proyecto 8',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 2 ,4,2,'luxo',now(),null,0),
(9,'Proyecto 9','Proyecto 9',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 3 ,1,1,'luxo',now(),null,1),
(10,'Proyecto 10','Proyecto 10',null,'0 año(s), 1 mes(es) 0 día(s)',STR_TO_DATE('01-01-2013','%d-%m-%Y'),STR_TO_DATE('01-02-2013','%d-%m-%Y'),STR_TO_DATE('01-03-2013','%d-%m-%Y'),1, 1 ,3,2,'luxo',now(),null,0);*/


/* Encargados de proyecto */
INSERT INTO tsg_usuario_tsg_proyecto (tsg_usuariousu_id, tsg_proyectopro_id, rol_id) 
VALUES 
(1, 1, 3),
(2, 1, 3),
(1, 2, 3),
(2, 2, 3),
(1, 3, 3),
(2, 4, 3);

/* Archivos de prueba 
INSERT INTO `tsg_archivo`(`arc_id`, `arc_nombre`, `arc_peso`, `arc_url`) 
VALUES
(1,'Documento1.doc',1024,'/ruta/subruta/2013-20-1_Documento1.doc'),
(2,'Documento1.doc',1024,'/ruta/subruta/2013-20-1_Documento1.doc'),
(3,'Documento1.doc',1024,'/ruta/subruta/2013-20-1_Documento1.doc');*/

/* Comentarios de prueba */

INSERT INTO `tsg_comentario_proyecto`(`cop_id`, `cop_descrip`, `tsg_proyectopro_id`, `tsg_usuariousu_id`, `tsg_archivoarc_id`, `cop_fecha_creacion`) 
VALUES 
(1,'Observaci&oacute;n de prueba 1',1,1,null,now()),
(2,'Observaci&oacute;n de prueba 2',1,1,null,now()),
(3,'Observaci&oacute;n de prueba 3',2,2,null,now()),
(4,'Observaci&oacute;n de prueba 4',2,2,null,now()),
(5,'Observaci&oacute;n de prueba 5',2,1,null,now()),
(6,'Observaci&oacute;n de prueba 6',3,1,null,now()),
(7,'Observaci&oacute;n de prueba 7',3,2,null,now()),
(8,'Observaci&oacute;n de prueba 8',4,2,null,now()),
(9,'Observaci&oacute;n de prueba 9',4,1,null,now());

/* Estadistica de pruebas */

INSERT INTO tsg_estadistica_diaria (dis_fecha,dis_total,dis_creadas,dis_asignadas,dis_resueltas,dis_rechazadas,dis_cerradas,dis_desestimadas,tsg_proyectopro_id) 
VALUES 
-- Proyecto 1
(DATE_ADD(CURDATE(),INTERVAL -5 DAY),0,0,0,0,0,0,0,1),
(DATE_ADD(CURDATE(),INTERVAL -4 DAY),2,2,0,0,0,0,0,1),
(DATE_ADD(CURDATE(),INTERVAL -3 DAY),4,1,1,1,0,0,0,1),
(DATE_ADD(CURDATE(),INTERVAL -2 DAY),6,2,0,0,3,1,0,1),
(DATE_ADD(CURDATE(),INTERVAL -1 DAY),8,2,0,0,0,0,2,1),
(DATE_ADD(CURDATE(),INTERVAL  0 DAY),9,1,1,0,1,0,0,1),
-- Proyecto 2
(DATE_ADD(CURDATE(),INTERVAL -5 DAY),0,0,0,0,0,0,0,2),
(DATE_ADD(CURDATE(),INTERVAL -4 DAY),1,0,0,0,0,0,0,2),
(DATE_ADD(CURDATE(),INTERVAL -3 DAY),3,1,0,1,0,0,0,2),
(DATE_ADD(CURDATE(),INTERVAL -2 DAY),3,2,0,0,0,1,0,2),
(DATE_ADD(CURDATE(),INTERVAL -1 DAY),4,2,0,0,1,0,2,2),
(DATE_ADD(CURDATE(),INTERVAL  0 DAY),5,1,1,0,1,0,0,2);
/*
('12-02-2013',0,0,0,0,0,0,0,1),
('12-01-2013',0,0,0,0,0,0,0,2),
('12-02-2013',0,0,0,0,0,0,0,2),
('12-01-2013',0,0,0,0,0,0,0,3),
('12-02-2013',0,0,0,0,0,0,0,3),
('12-01-2013',0,0,0,0,0,0,0,4),
('12-02-2013',0,0,0,0,0,0,0,4),
('12-01-2013',0,0,0,0,0,0,0,5),
('12-02-2013',0,0,0,0,0,0,0,5),
('12-01-2013',0,0,0,0,0,0,0,6),
('12-02-2013',0,0,0,0,0,0,0,6),
(DATE_ADD(CURDATE(),INTERVAL 1 DAY),0,0,0,0,0,0,0,1),
(DATE_ADD(CURDATE(),INTERVAL 2 DAY),1,0,0,1,0,0,0,1),
(DATE_ADD(CURDATE(),INTERVAL 3 DAY),2,1,0,0,0,1,0,1),
(DATE_ADD(CURDATE(),INTERVAL 4 DAY),5,2,0,0,0,3,0,1),
(DATE_ADD(CURDATE(),INTERVAL 5 DAY),2,0,0,1,0,1,1,1),
(DATE_ADD(CURDATE(),INTERVAL 6 DAY),4,1,0,1,0,0,2,1),
(DATE_ADD(CURDATE(),INTERVAL 1 DAY),0,0,0,0,0,0,0,2),
(DATE_ADD(CURDATE(),INTERVAL 2 DAY),1,0,0,1,0,0,0,2),
(DATE_ADD(CURDATE(),INTERVAL 3 DAY),2,1,0,0,0,1,0,2),
(DATE_ADD(CURDATE(),INTERVAL 4 DAY),5,2,0,0,0,3,0,2),
(DATE_ADD(CURDATE(),INTERVAL 5 DAY),2,0,0,1,0,1,1,2),
(DATE_ADD(CURDATE(),INTERVAL 6 DAY),4,1,0,1,0,0,2,2);*/


/* Solicitudes de prueba */

INSERT INTO tsg_ticket (`tic_id`, `tic_nombre`, `tic_descripcion`, `tic_fecha_crea`, `tsg_estado_ticketest_id`, `tsg_usuariousu_id`, `tsg_proyectopro_id`, `tsg_prioridadpri_id`, `tsg_categoriacat_id`, `tic_destcado`, `tsg_tic_correo_en_copia`)
VALUES
(1,'Solicitud prueba 1','Solicitud prueba 1',NOW(),1,1,1,1,1,0,'padilla.tracy.s@gmail.com'),
(2,'Solicitud prueba 2','Solicitud prueba 2',NOW(),1,1,2,1,1,0,'padilla.tracy.s@gmail.com'),
(3,'Solicitud prueba 3','Solicitud prueba 3',NOW(),1,2,3,2,1,0,'padilla.tracy.s@gmail.com'),
(4,'Solicitud prueba 4','Solicitud prueba 4',NOW(),1,2,4,2,1,0,'padilla.tracy.s@gmail.com'),
(5,'Solicitud prueba 5','Solicitud prueba 5',NOW(),1,1,1,1,1,0,'padilla.tracy.s@gmail.com'),
(6,'Solicitud prueba 6','Solicitud prueba 6',NOW(),1,1,2,1,1,0,'padilla.tracy.s@gmail.com'),
(7,'Solicitud prueba 7','Solicitud prueba 7',NOW(),1,2,3,2,1,0,'padilla.tracy.s@gmail.com'),
(8,'Solicitud prueba 8','Solicitud prueba 8',NOW(),1,2,4,2,1,0,'padilla.tracy.s@gmail.com');

/* tsg_comentario_ticket */


/* tsg_historico_ticket */

















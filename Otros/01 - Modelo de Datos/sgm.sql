-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generaciÃ³n: 05-11-2013 a las 03:59:38
-- VersiÃ³n del servidor: 5.5.27
-- VersiÃ³n de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: sgm
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla sqi_tipo_proyecto
--

CREATE TABLE sqi_tipo_proyecto (
  tip_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único',
  tip_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de proyecto',
  tip_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descripción del tipo de proyecto',
  tip_activo tinyint(1) NOT NULL COMMENT 'Registro activo',
  tip_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  tip_fecha_creacion datetime NOT NULL COMMENT 'Fecha de creación',
  tip_fecha_modificacion datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  PRIMARY KEY (tip_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipo de proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_archivo
--

CREATE TABLE tsg_archivo (
  arc_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único',
  arc_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del archivo adjunto',
  arc_peso float NOT NULL COMMENT 'peso del archivo adjunto',
  arc_url varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'url del archivo adjunto',
  content MEDIUMBLOB NOT NULL,
  type VARCHAR(30) NOT NULL,
  PRIMARY KEY (arc_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de archivos adjuntos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_categoria
--

CREATE TABLE tsg_categoria (
  cat_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único',
  cat_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre de la categoría.',
  cat_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción de la categoría',
  cat_activo tinyint(1) NOT NULL COMMENT 'eliminación lógica del sistema.',
  cat_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  cat_fecha_creacion datetime NOT NULL COMMENT 'Fecha creación',
  cat_fecha_modificacion datetime DEFAULT NULL COMMENT 'Fecha modificación',
  PRIMARY KEY (cat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla de las categorías del proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_cliente
--

CREATE TABLE tsg_cliente (
  cli_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la cliente.',
  cli_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'corresponde al nombre del cliente',
  cli_apellido varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'apellido del cliente',
  cli_correo varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'correo electrónico del cliente',
  cli_empresa varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'nombre de la empresa en la cual se encuentra posicionado el cliente',
  cli_rut varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'rut del cliente',
  cli_direccion varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'dirección del cliente',
  cli_fecha_ini datetime NOT NULL COMMENT 'fecha de inicio del cliente',
  cli_fecha_mod datetime NULL DEFAULT NULL COMMENT 'fecha de modificación del cliente',
  cli_activo tinyint(1) NOT NULL COMMENT '\r\nse deja la tabla de cliente con la opción para saber si el usuario esta activo o inactivo, en la BD se mostrara oculto si se elimino por sistema. (1 o 0 ) Eliminación logica.',
  cli_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  PRIMARY KEY (cli_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla sistema de gestión, está tabla contiene los datos del cliente que interactuara con el sistema.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_comentario_proyecto
--

CREATE TABLE tsg_comentario_proyecto (
  cop_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  cop_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descripción',
  tsg_proyectopro_id int(10) NOT NULL,
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_archivoarc_id int(10) NULL,
  cop_fecha_creacion datetime DEFAULT NULL COMMENT 'Fecha de creación',
  PRIMARY KEY (cop_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de observaciones del proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_comentario_ticket
--

CREATE TABLE tsg_comentario_ticket (
  com_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del comentario',
  com_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción del comentario asociado al ticket',
  tsg_tickettic_id int(10) NOT NULL,
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_archivoarc_id int(10) NULL,
  com_fecha_creacion datetime DEFAULT NULL COMMENT 'Fecha de creación',
  PRIMARY KEY (com_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='comentario asociado al ticket' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_estadistica_diaria
--

CREATE TABLE tsg_estadistica_diaria (
  dis_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  dis_fecha datetime NOT NULL COMMENT 'Fecha',
  dis_total int(10) NOT NULL COMMENT 'Total de tickets',
  dis_creadas int(10) NOT NULL,
  dis_asignadas int(10) NOT NULL,
  dis_resueltas int(10) NOT NULL,
  dis_rechazadas int(10) NOT NULL,
  dis_cerradas int(10) NOT NULL,
  dis_desestimadas int(10) NOT NULL,
  tsg_proyectopro_id int(10) NOT NULL,
  PRIMARY KEY (dis_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de registro estadístico diario' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_estado_proyecto
--

CREATE TABLE tsg_estado_proyecto (
  est_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del estado del proyecto',
  est_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del estado del proyecto',
  est_descrip int(10) DEFAULT NULL COMMENT 'descripción del estado del proyecto',
  est_activo int(10) NOT NULL COMMENT 'eliminación logica del sistema',
  PRIMARY KEY (est_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla que corresponde al estado que se encuentra el proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_estado_ticket
--

CREATE TABLE tsg_estado_ticket (
  est_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único',
  est_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del estado del ticket',
  est_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción del estado del ticket',
  est_activo tinyint(1) NOT NULL COMMENT 'eliminación lógica del sistema',
  PRIMARY KEY (est_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla del estado del ticket' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_historico_ticket
--

CREATE TABLE tsg_historico_ticket (
  his_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único',
  his_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del histórico',
  his_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción histórico',
  tsg_estado_ticketest_id int(10) NOT NULL,
  tsg_tickettic_id int(10) NOT NULL,
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_proyectopro_id int(10) NOT NULL,
  tsg_prioridadpri_id int(10) NOT NULL,
  tsg_categoriacat_id int(10) NOT NULL,
  his_fecha datetime NOT NULL COMMENT 'Fecha',
  PRIMARY KEY (his_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de registro histórico del ticket' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_modulo
--

CREATE TABLE tsg_modulo (
  mod_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  mod_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre',
  mod_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descripción del rol',
  mod_activo tinyint(1) NOT NULL COMMENT 'Indicador de registro activo',
  mod_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  mod_fecha_creacion datetime NOT NULL COMMENT 'Fecha de creación',
  mod_fecha_modificacion datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  mod_id_mod_padre int(11) DEFAULT NULL,
  mod_ruta_imagen varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (mod_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de módulos' AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_modulo_tsg_rol
--

CREATE TABLE tsg_modulo_tsg_rol (
  tsg_modulomod_id int(10) NOT NULL,
  tsg_rolrol_id int(10) NOT NULL,
  PRIMARY KEY (tsg_modulomod_id,tsg_rolrol_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_prioridad
--

CREATE TABLE tsg_prioridad (
  pri_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de la prioridad del ticket',
  pri_nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre de la prioridad',
  pri_descrip varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción de la prioridad',
  pri_activo tinyint(1) NOT NULL COMMENT 'eliminación lógica del sistema.',
  PRIMARY KEY (pri_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='prioridad del ticket' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_proyecto
--

CREATE TABLE tsg_proyecto (
  pro_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria del proyecto, identificador único',
  pro_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del proyecto',
  pro_descrip varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'descripción del proyecto',
  pro_usu_id_jefepro int(10) NULL COMMENT 'Identificador del jefe de proyecto',
  pro_duracion varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'duración del proyecto',
  pro_fecha_ini datetime NOT NULL COMMENT 'Fecha inicio del proyecto',
  pro_fecha_term datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'fecha termino del proyecto',
  pro_fecha_garan datetime NULL DEFAULT NULL COMMENT 'fecha de garantía del proyecto',
  pro_activo tinyint(1) NOT NULL COMMENT 'eliminación lógica del sistema.',
  tsg_clientecli_id int(10) NOT NULL,
  tsg_estado_proyectoest_id int(10) NOT NULL,
  sqi_tipo_proyectotip_id int(10) DEFAULT NULL,
  pro_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  pro_fecha_creacion datetime NOT NULL COMMENT 'Fecha creación',
  pro_fecha_modificacion datetime DEFAULT NULL COMMENT 'Fecha de modificación',
  pro_destacado tinyint(1) DEFAULT NULL COMMENT 'Destacado (Estrellita)',
  PRIMARY KEY (pro_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_proyecto_historico
--

CREATE TABLE tsg_proyecto_historico (
  prh_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  prh_usuario varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Usuario creador',
  prh_fecha datetime DEFAULT NULL COMMENT 'Fecha de creación',
  tsg_proyectopro_id int(10) NOT NULL,
  sqi_tipo_proyectotip_id int(10) NOT NULL,
  tsg_estado_proyectoest_id int(10) NOT NULL,
  PRIMARY KEY (prh_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de histórico del proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_rol
--

CREATE TABLE tsg_rol (
  rol_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  rol_nombre varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre del rol',
  rol_descrip varchar(1000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Descripción del rol',
  rol_activo tinyint(1) NOT NULL COMMENT 'Indicador de registro activo',
  rol_usu_creador varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador',
  rol_fecha_creacion datetime NOT NULL COMMENT 'Fecha de creación',
  rol_fecha_modificacion datetime DEFAULT NULL COMMENT 'Fecha modificación',
  PRIMARY KEY (rol_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de roles' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_ticket
--

CREATE TABLE tsg_ticket (
  tic_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del ticket',
  tic_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del ticket',
  tic_descripcion varchar(1000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Descripción del ticket',
  tic_fecha_crea datetime NOT NULL COMMENT 'fecha de creación del ticket',
  tsg_estado_ticketest_id int(10) NOT NULL,
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_proyectopro_id int(10) NOT NULL,
  tsg_prioridadpri_id int(10) NOT NULL,
  tsg_categoriacat_id int(10) NOT NULL,
  tic_destcado tinyint(1) DEFAULT NULL COMMENT 'Desatacado (Estrellita)',
  tsg_tic_correo_en_copia varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Correos en copia del cambio de estado',
  PRIMARY KEY (tic_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla ticket corresponde a los tickets que tiene asociado el proyecto' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_usuario
--

CREATE TABLE tsg_usuario (
  usu_id int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla',
  usu_nombre varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre',
  usu_apellido varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Apellido del usuario',
  usu_telefono int(10) NOT NULL COMMENT 'teléfono del usuario',
  usu_direccion varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Dirección del Usuario',
  usu_fecha_crea datetime NOT NULL COMMENT 'Fecha de creación, se usara la secuencia de timestamp para guardar la hora y la fecha.',
  usu_fecha_mod datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'fecha de modificación, se guardará con la secuencia timestamp para guardar la hora y la fecha de la modificación.',
  usu_rut varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'se define el rut del usuario, se considera como varchar ya que contienen número y caracteres.',
  usu_pass varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  usu_correo varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'correo electrónico del usuario',
  usu_activo int(2) NOT NULL COMMENT 'se deja la tabla de usuario con la opción para saber si el usuario esta activo o inactivo, en la BD de mostrara oculto si se elimino por sistema. (1 o 0)',
  PRIMARY KEY (usu_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de Usuarios' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_usuario_tsg_proyecto
--

CREATE TABLE tsg_usuario_tsg_proyecto (
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_proyectopro_id int(10) NOT NULL,
  rol_id int(10) NOT NULL,
  PRIMARY KEY (tsg_usuariousu_id,tsg_proyectopro_id,rol_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tsg_usuario_tsg_rol
--

CREATE TABLE tsg_usuario_tsg_rol (
  tsg_usuariousu_id int(10) NOT NULL,
  tsg_rolrol_id int(10) NOT NULL,
  PRIMARY KEY (tsg_usuariousu_id,tsg_rolrol_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla tsg_comentario_proyecto
--
ALTER TABLE tsg_comentario_proyecto
  ADD CONSTRAINT FKtsg_coment436168 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id),
  ADD CONSTRAINT FKtsg_coment854003 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id);

--
-- Filtros para la tabla tsg_comentario_ticket
--
ALTER TABLE tsg_comentario_ticket
  ADD CONSTRAINT FKtsg_coment189196 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id),
  ADD CONSTRAINT FKtsg_coment449974 FOREIGN KEY (tsg_tickettic_id) REFERENCES tsg_ticket (tic_id),

--
-- Filtros para la tabla tsg_modulo_tsg_rol
--
ALTER TABLE tsg_modulo_tsg_rol
  ADD CONSTRAINT FKtsg_modulo632852 FOREIGN KEY (tsg_rolrol_id) REFERENCES tsg_rol (rol_id),
  ADD CONSTRAINT FKtsg_modulo656602 FOREIGN KEY (tsg_modulomod_id) REFERENCES tsg_modulo (mod_id);

--
-- Filtros para la tabla tsg_proyecto
--
ALTER TABLE tsg_proyecto
  ADD CONSTRAINT FKtsg_proyec283651 FOREIGN KEY (sqi_tipo_proyectotip_id) REFERENCES sqi_tipo_proyecto (tip_id),
  ADD CONSTRAINT FKtsg_proyec412853 FOREIGN KEY (tsg_estado_proyectoest_id) REFERENCES tsg_estado_proyecto (est_id),
  ADD CONSTRAINT FKtsg_proyec672127 FOREIGN KEY (tsg_clientecli_id) REFERENCES tsg_cliente (cli_id);

--
-- Filtros para la tabla tsg_proyecto_historico
--
ALTER TABLE tsg_proyecto_historico
  ADD CONSTRAINT FKtsg_proyec676013 FOREIGN KEY (sqi_tipo_proyectotip_id) REFERENCES sqi_tipo_proyecto (tip_id),
  ADD CONSTRAINT FKtsg_proyec767319 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id),
  ADD CONSTRAINT FKtsg_proyec979508 FOREIGN KEY (tsg_estado_proyectoest_id) REFERENCES tsg_estado_proyecto (est_id);

--
-- Filtros para la tabla tsg_ticket
--
ALTER TABLE tsg_ticket
  ADD CONSTRAINT FKtsg_ticket228081 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id),
  ADD CONSTRAINT FKtsg_ticket331605 FOREIGN KEY (tsg_categoriacat_id) REFERENCES tsg_categoria (cat_id),
  ADD CONSTRAINT FKtsg_ticket546662 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id),
  ADD CONSTRAINT FKtsg_ticket635084 FOREIGN KEY (tsg_prioridadpri_id) REFERENCES tsg_prioridad (pri_id),
  ADD CONSTRAINT FKtsg_ticket88476 FOREIGN KEY (tsg_estado_ticketest_id) REFERENCES tsg_estado_ticket (est_id);

--
-- Filtros para la tabla tsg_usuario_tsg_proyecto
--
ALTER TABLE tsg_usuario_tsg_proyecto
  ADD CONSTRAINT FKtsg_usuari832738 FOREIGN KEY (tsg_proyectopro_id) REFERENCES tsg_proyecto (pro_id),
  ADD CONSTRAINT FKtsg_usuari848679 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);

--
-- Filtros para la tabla tsg_usuario_tsg_rol
--
ALTER TABLE tsg_usuario_tsg_rol
  ADD CONSTRAINT FKtsg_usuari189443 FOREIGN KEY (tsg_rolrol_id) REFERENCES tsg_rol (rol_id),
  ADD CONSTRAINT FKtsg_usuari286059 FOREIGN KEY (tsg_usuariousu_id) REFERENCES tsg_usuario (usu_id);
*/
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

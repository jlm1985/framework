--*******************************************************************************************
--*******************************************************************************************
--************************************** PERFIL FUNCIONAL ***********************************
--*******************************************************************************************
--*******************************************************************************************

CREATE TABLE apex_usuario_grupo_acc
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: permisos
--: dump_order_by: usuario_grupo_acc
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(	
	proyecto						varchar(15)		NOT NULL,
	usuario_grupo_acc				varchar(30)		NOT NULL,
	nombre							varchar(80)		NOT NULL,
	nivel_acceso					smallint		NULL,
	descripcion						varchar			NULL,
	vencimiento						date			NULL,
	dias							smallint		NULL,
	hora_entrada					time(0) without time	zone NULL,
	hora_salida						time(0) without time	zone NULL,
	listar							smallint			NULL,
	CONSTRAINT	"apex_usu_g_acc_pk" PRIMARY KEY ("proyecto","usuario_grupo_acc")
	--CONSTRAINT	"apex_usu_g_acc_fk_niv"	FOREIGN KEY	("nivel_acceso") REFERENCES "apex_nivel_acceso"	("nivel_acceso") ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
);
--#################################################################################################

CREATE TABLE apex_usuario_grupo_acc_item
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: permisos
--: dump_order_by: usuario_grupo_acc, item
--: zona: usuario, item
--: desc:
--: columna_grupo_desarrollo: item
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)		NOT NULL,
	usuario_grupo_acc				varchar(30)		NOT NULL,
	item_id							int4				NULL,	
	item							varchar(60)		NOT NULL,
	CONSTRAINT	"apex_usu_item_pk" PRIMARY	KEY ("proyecto","usuario_grupo_acc","item"),
	CONSTRAINT	"apex_usu_item_fk_us_gru_acc"	FOREIGN KEY	("proyecto","usuario_grupo_acc")	REFERENCES "apex_usuario_grupo_acc"	("proyecto","usuario_grupo_acc")	ON	DELETE CASCADE ON UPDATE CASCADE DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_usu_item_fk_item"	 FOREIGN KEY	("proyecto","item") 
			REFERENCES "apex_item" ("proyecto","item")	
					ON	DELETE CASCADE ON UPDATE	CASCADE  DEFERRABLE INITIALLY IMMEDIATE
);

--*******************************************************************************************
--*******************************************************************************************
--*******************************  Esquema de PERMISOS **************************************
--*******************************************************************************************
--*******************************************************************************************

CREATE TABLE apex_permiso_grupo_acc
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: permisos
--: dump_order_by: permiso, usuario_grupo_acc
--: zona: usuario
--: desc:
--: columna_grupo_desarrollo: permiso
--: version: 1.0
---------------------------------------------------------------------------------------------------
(	
	proyecto							varchar(15)		NOT NULL,
	usuario_grupo_acc					varchar(30)		NOT NULL,
	permiso								int4			NOT NULL,
	CONSTRAINT	"apex_per_grupo_acc_pk" 		PRIMARY	KEY ("usuario_grupo_acc","permiso","proyecto"),
	CONSTRAINT	"apex_per_grupo_acc_grupo_fk"	FOREIGN KEY	("proyecto","usuario_grupo_acc")	REFERENCES "apex_usuario_grupo_acc"	("proyecto","usuario_grupo_acc")	ON	DELETE CASCADE ON UPDATE CASCADE DEFERRABLE INITIALLY IMMEDIATE
);

--*******************************************************************************************
--*******************************************************************************************
--*******************************  RESTRICCIONES FUNCIONALES ********************************
--*******************************************************************************************
--*******************************************************************************************

CREATE SEQUENCE apex_restriccion_funcional_seq	INCREMENT 1	MINVALUE 0 MAXVALUE 9223372036854775807 CACHE 1;
CREATE TABLE apex_restriccion_funcional
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(	
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional			int4				DEFAULT nextval('"apex_restriccion_funcional_seq"'::text) NOT NULL,
	descripcion						varchar(255)		NULL,
	CONSTRAINT	"restriccion_funcional_pk" PRIMARY	KEY ("proyecto", "restriccion_funcional"),
	CONSTRAINT	"restriccion_funcional_fk_proy"	FOREIGN KEY	("proyecto") REFERENCES	"apex_proyecto" ("proyecto") ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE
);
--#################################################################################################

CREATE TABLE apex_grupo_acc_restriccion_funcional
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: permisos
--: dump_order_by: usuario_grupo_acc, restriccion_funcional
--: zona: usuario
--: desc:
--: columna_grupo_desarrollo: permiso
--: version: 1.0
---------------------------------------------------------------------------------------------------
(	
	proyecto							varchar(15)		NOT NULL,
	usuario_grupo_acc					varchar(30)		NOT NULL,
	restriccion_funcional				int4			NOT NULL,
	CONSTRAINT	"apex_grupo_acc_restriccion_funcional_pk" 		PRIMARY	KEY ("usuario_grupo_acc","restriccion_funcional","proyecto"),
	CONSTRAINT	"apex_grupo_acc_restriccion_funcional_rf_fk"	FOREIGN KEY	("proyecto","restriccion_funcional")	REFERENCES "apex_restriccion_funcional"	("proyecto","restriccion_funcional")	ON	DELETE CASCADE ON UPDATE CASCADE DEFERRABLE INITIALLY IMMEDIATE
);
--#################################################################################################

CREATE TABLE apex_restriccion_funcional_ef
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional, objeto_ei_formulario_fila
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional				int4				NOT NULL,
	item							int4				NOT NULL,
	objeto_ei_formulario_fila		int4				NOT NULL,
	objeto_ei_formulario			int4				NOT NULL,
	no_visible						smallint			NULL,
	no_editable						smallint			NULL,
	CONSTRAINT	"apex_restriccion_funcional_ef_pk" PRIMARY	KEY ("proyecto","restriccion_funcional","objeto_ei_formulario_fila"),
	CONSTRAINT	"apex_restriccion_funcional_ef_fk_pf"	FOREIGN KEY	("proyecto","restriccion_funcional") 
			REFERENCES	"apex_restriccion_funcional" ("proyecto","restriccion_funcional") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_restriccion_funcional_ef_fk_ef"	FOREIGN KEY	("proyecto","objeto_ei_formulario","objeto_ei_formulario_fila") 
			REFERENCES	"apex_objeto_ei_formulario_ef" ("objeto_ei_formulario_proyecto","objeto_ei_formulario","objeto_ei_formulario_fila") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"restriccion_funcional_ef_fk_item"	 FOREIGN KEY	("proyecto","item")
			REFERENCES "apex_item" ("proyecto","item")	ON	DELETE CASCADE ON UPDATE
			CASCADE  DEFERRABLE INITIALLY IMMEDIATE
	
);
--#################################################################################################

CREATE TABLE apex_restriccion_funcional_pantalla
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional, pantalla
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional				int4				NOT NULL,
	item							int4				NOT NULL,
	pantalla						int4				NOT NULL,
	objeto_ci						int4				NOT NULL,
	no_visible						smallint			NULL,
	CONSTRAINT	"apex_restriccion_funcional_pantalla_pk" PRIMARY	KEY ("proyecto","restriccion_funcional","pantalla"),
	CONSTRAINT	"apex_restriccion_funcional_pantalla_fk_pf"	FOREIGN KEY	("proyecto","restriccion_funcional") 
			REFERENCES	"apex_restriccion_funcional" ("proyecto","restriccion_funcional") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_restriccion_funcional_pantalla_fk_pantalla"	FOREIGN KEY	("proyecto","objeto_ci","pantalla") 
			REFERENCES	"apex_objeto_ci_pantalla" ("objeto_ci_proyecto","objeto_ci","pantalla") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"restriccion_funcional_pantalla_fk_item"	 FOREIGN KEY	("proyecto","item")
			REFERENCES "apex_item" ("proyecto","item")	ON	DELETE CASCADE ON UPDATE
			CASCADE  DEFERRABLE INITIALLY IMMEDIATE
	
);
--#################################################################################################

CREATE TABLE apex_restriccion_funcional_evt
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional, evento_id
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional				int4				NOT NULL,
	item							int4				NOT NULL,
	evento_id						int4				NOT NULL,
	no_visible						smallint			NULL,
	CONSTRAINT	"apex_restriccion_funcional_evt_pk" PRIMARY	KEY ("proyecto","restriccion_funcional","evento_id"),
	CONSTRAINT	"apex_restriccion_funcional_evt_fk_pf"	FOREIGN KEY	("proyecto","restriccion_funcional") 
			REFERENCES	"apex_restriccion_funcional" ("proyecto","restriccion_funcional") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_restriccion_funcional_evt_fk_evt"	FOREIGN KEY	("proyecto","evento_id") 
			REFERENCES	"apex_objeto_eventos" ("proyecto","evento_id") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"restriccion_funcional_evt_fk_item"	 FOREIGN KEY	("proyecto","item")
			REFERENCES "apex_item" ("proyecto","item")	ON	DELETE CASCADE ON UPDATE
			CASCADE  DEFERRABLE INITIALLY IMMEDIATE
);
--#################################################################################################

CREATE TABLE apex_restriccion_funcional_ei
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional, objeto
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional				int4				NOT NULL,
	item							int4				NOT NULL,
	objeto							int4				NOT NULL,
	no_visible						smallint			NULL,
	CONSTRAINT	"apex_restriccion_funcional_ei_pk" PRIMARY	KEY ("proyecto","restriccion_funcional","objeto"),
	CONSTRAINT	"apex_restriccion_funcional_ei_fk_pf"	FOREIGN KEY	("proyecto","restriccion_funcional") 
			REFERENCES	"apex_restriccion_funcional" ("proyecto","restriccion_funcional") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_restriccion_funcional_ei_fk_evt"	FOREIGN KEY	("proyecto","objeto") 
			REFERENCES	"apex_objeto" ("proyecto","objeto") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"restriccion_funcional_ei_fk_item"	 FOREIGN KEY	("proyecto","item")
			REFERENCES "apex_item" ("proyecto","item")	ON	DELETE CASCADE ON UPDATE
			CASCADE  DEFERRABLE INITIALLY IMMEDIATE
);
--#################################################################################################

CREATE TABLE apex_restriccion_funcional_cols
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: multiproyecto
--: dump_order_by: restriccion_funcional, objeto_cuadro_col
--: zona: usuario
--: desc:
--: version: 1.0
---------------------------------------------------------------------------------------------------
(
	proyecto						varchar(15)			NOT NULL,
	restriccion_funcional				int4				NOT NULL,
	item							int4				NOT NULL,
	objeto_cuadro					int4				NOT NULL,
	objeto_cuadro_col				int4				NOT NULL,
	no_visible						smallint			NULL,
	CONSTRAINT	"apex_restriccion_funcional_cols_pk" PRIMARY	KEY ("proyecto","restriccion_funcional","objeto_cuadro_col"),
	CONSTRAINT	"apex_restriccion_funcional_cols_fk_pf"	FOREIGN KEY	("proyecto","restriccion_funcional") 
			REFERENCES	"apex_restriccion_funcional" ("proyecto","restriccion_funcional") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"apex_restriccion_funcional_cols_fk_evt"	FOREIGN KEY	("proyecto","objeto_cuadro","objeto_cuadro_col") 
			REFERENCES	"apex_objeto_ei_cuadro_columna" ("objeto_cuadro_proyecto","objeto_cuadro","objeto_cuadro_col") 
			ON DELETE	NO	ACTION ON UPDATE NO ACTION	DEFERRABLE	INITIALLY IMMEDIATE,
	CONSTRAINT	"restriccion_funcional_cols_fk_item"	 FOREIGN KEY	("proyecto","item")
			REFERENCES "apex_item" ("proyecto","item")	ON	DELETE CASCADE ON UPDATE
			CASCADE  DEFERRABLE INITIALLY IMMEDIATE
);
--#################################################################################################
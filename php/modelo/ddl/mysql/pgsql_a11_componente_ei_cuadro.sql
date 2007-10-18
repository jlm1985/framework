
CREATE TABLE apex_objeto_cuadro
(
	objeto_cuadro_proyecto  	varchar(15)		NOT NULL,
	objeto_cuadro           integer		NOT NULL,
	titulo                  	varchar(255) 	NULL,
	subtitulo               	varchar(255) 	NULL,
nosql                    	text     	NULL,       
	columnas_clave				text			NULL,   
	clave_dbr					smallint		NULL,
	archivos_callbacks      	varchar(255)	NULL,			
	ancho                   	varchar(10) 	NULL,
	ordenar                 	smallint    	NULL,
	paginar                 	smallint    	NULL,
	tamano_pagina           	smallint    	NULL,
	tipo_paginado				varchar(1)  	NULL,
	eof_invisible           	smallint    	NULL,   
	eof_customizado       		text			NULL,
	exportar		           	smallint       	NULL,		
	exportar_rtf            	smallint       	NULL,		
	pdf_propiedades         	text			NULL,
	pdf_respetar_paginacion 	smallint       	NULL,  		
	asociacion_columnas			varchar(255)	NULL,
	ev_seleccion				smallint		NULL,		
	ev_eliminar					smallint		NULL,		
	dao_nucleo_proyecto			varchar(15)		NULL,
	dao_nucleo					varchar(60)		NULL,
	dao_metodo					varchar(80)		NULL,
	dao_parametros				varchar(255)	NULL,
	desplegable					smallint		NULL,
	desplegable_activo			smallint		NULL,
	scroll						smallint		NULL,
	scroll_alto					varchar(10)		NULL,
	cc_modo						varchar(1)		NULL,		
	cc_modo_anidado_colap		smallint		NULL,		
	cc_modo_anidado_totcol		smallint		NULL,		
	cc_modo_anidado_totcua		smallint		NULL,		
	CONSTRAINT   apex_objeto_cuadro_pk  PRIMARY KEY ( objeto_cuadro_proyecto , objeto_cuadro ),
	CONSTRAINT   apex_objeto_cuadro_fk_objeto   FOREIGN KEY ( objeto_cuadro_proyecto , objeto_cuadro ) REFERENCES    apex_objeto  ( proyecto , objeto ) ON DELETE CASCADE ON UPDATE NO ACTION   
) ENGINE=InnoDB;

CREATE TABLE apex_objeto_cuadro_cc
(
	objeto_cuadro_proyecto        	varchar(15)		NOT NULL,
	objeto_cuadro                 integer      		NOT NULL,
	objeto_cuadro_cc			integer		 auto_increment  NOT NULL, 
	identificador					varchar(200)		NULL,			
	descripcion						varchar(200)		NULL,
	orden				            float      		NOT NULL,
	columnas_id	    				varchar(200)	NOT NULL,		
	columnas_descripcion			varchar(200)	NOT NULL,		
	pie_contar_filas				varchar(10)		NULL,
	pie_mostrar_titular				smallint		NULL,			
	pie_mostrar_titulos				smallint		NULL,			
	imp_paginar						smallint		NULL,		
	modo_inicio_colapsado			smallint		NULL DEFAULT 0,			
	CONSTRAINT   apex_obj_cuadro_cc_pk  PRIMARY KEY ( objeto_cuadro_proyecto , objeto_cuadro , objeto_cuadro_cc ),
	CONSTRAINT   apex_obj_cuadro_cc_uq  UNIQUE ( objeto_cuadro_proyecto , objeto_cuadro , identificador ),
	CONSTRAINT   apex_obj_cuadro_cc_fk_objeto_cuadro  FOREIGN KEY ( objeto_cuadro_proyecto , objeto_cuadro ) REFERENCES  apex_objeto_cuadro  ( objeto_cuadro_proyecto , objeto_cuadro ) ON DELETE CASCADE ON UPDATE NO ACTION   
) ENGINE=InnoDB;

CREATE TABLE apex_objeto_ei_cuadro_columna
(
	objeto_cuadro_proyecto        	varchar(15)		NOT NULL,
	objeto_cuadro                 integer      		NOT NULL,
	objeto_cuadro_col			integer		 auto_increment  NOT NULL, 
	clave          					varchar(80)    	NOT NULL,		
	orden				            float      		NOT NULL,
	titulo                        	varchar(255)	NULL,
	estilo_titulo                   varchar(100)	DEFAULT 'ei-cuadro-col-tit' NULL,
	estilo    					integer	    NOT NULL,	
	ancho							varchar(10)		NULL,		
	formateo   					integer	    NULL,		
	vinculo_indice	      			varchar(20) 	NULL,       
	no_ordenar						smallint		NULL,		
	mostrar_xls						smallint		NULL,
	mostrar_pdf						smallint		NULL,
	pdf_propiedades          		text			NULL,
	desabilitado					smallint		NULL,
	total							smallint		NULL,		
	total_cc						varchar(100)	NULL,			
	usar_vinculo					smallint			NULL,
	vinculo_carpeta					varchar(60)			NULL,
	vinculo_ item integer 			NULL,
	vinculo_popup					smallint			NULL,
	vinculo_popup_param				varchar(100)		NULL,
	vinculo_target					varchar(40)			NULL,
	vinculo_celda					varchar(40)			NULL,
	CONSTRAINT   apex_obj_ei_cuadro_pk  PRIMARY KEY ( objeto_cuadro_proyecto , objeto_cuadro , objeto_cuadro_col ),
	CONSTRAINT   apex_obj_ei_cuadro_fk_objeto_cuadro  FOREIGN KEY ( objeto_cuadro_proyecto , objeto_cuadro ) REFERENCES  apex_objeto_cuadro  ( objeto_cuadro_proyecto , objeto_cuadro ) ON DELETE CASCADE ON UPDATE NO ACTION   ,
	CONSTRAINT   apex_obj_ei_cuadro_fk_formato  FOREIGN KEY ( formateo ) REFERENCES  apex_columna_formato  ( columna_formato ) ON DELETE NO ACTION ON UPDATE NO ACTION   ,
	CONSTRAINT   apex_obj_ei_cuadro_fk_estilo  FOREIGN KEY ( estilo ) REFERENCES  apex_columna_estilo  ( columna_estilo ) ON DELETE NO ACTION ON UPDATE NO ACTION   
) ENGINE=InnoDB;

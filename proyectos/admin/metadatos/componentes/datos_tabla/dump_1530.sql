------------------------------------------------------------
--[1530]--  OBJETO - EI formulario EF 
------------------------------------------------------------
INSERT INTO apex_objeto (proyecto, objeto, anterior, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES ('admin', '1530', NULL, NULL, 'toba', 'objeto_datos_tabla', 'odt_formulario_efs', 'db/odt_formulario_efs.php', NULL, NULL, 'OBJETO - EI formulario EF', NULL, NULL, NULL, 'admin', 'instancia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2005-08-28 03:20:29');
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, ap, ap_clase, ap_archivo, tabla, alias, modificar_claves) VALUES ('admin', '1530', NULL, NULL, '1', NULL, NULL, 'apex_objeto_ei_formulario_ef', NULL, '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '207', 'objeto_ei_formulario_proyecto', 'C', '1', NULL, '15', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '208', 'objeto_ei_formulario', 'E', '1', NULL, NULL, NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '209', 'objeto_ei_formulario_fila', 'E', '1', 'apex_obj_ei_form_fila_seq', NULL, NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '210', 'identificador', 'C', '0', NULL, '30', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '211', 'elemento_formulario', 'C', '0', NULL, '30', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '212', 'columnas', 'C', '0', NULL, '255', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '213', 'obligatorio', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '214', 'inicializacion', 'C', '0', NULL, '-1', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '215', 'orden', 'E', '0', NULL, NULL, NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '216', 'etiqueta', 'C', '0', NULL, '80', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '217', 'descripcion', 'C', '0', NULL, '-1', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '218', 'colapsado', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '219', 'desactivado', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '220', 'estilo', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '221', 'total', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '362', 'etiqueta_estilo', 'C', '0', NULL, '80', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000008', 'estado_defecto', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000009', 'solo_lectura', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000010', 'carga_metodo', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000011', 'carga_clase', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000012', 'carga_include', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000013', 'carga_col_clave', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000014', 'carga_col_desc', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000015', 'carga_sql', 'C', '0', NULL, '-1', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000016', 'carga_fuente', 'C', '0', NULL, '30', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000017', 'carga_lista', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000018', 'carga_maestros', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000019', 'carga_cascada_relaj', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000020', 'carga_no_seteado', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000021', 'edit_tamano', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000022', 'edit_maximo', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000023', 'edit_mascara', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000024', 'edit_unidad', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000025', 'edit_rango', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000026', 'edit_filas', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000027', 'edit_columnas', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000028', 'edit_wrap', 'C', '0', NULL, '20', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000029', 'edit_resaltar', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000030', 'edit_ajustable', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000031', 'popup_item', 'C', '0', NULL, '60', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000032', 'popup_proyecto', 'C', '0', NULL, '15', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000033', 'popup_editable', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000034', 'popup_ventana', 'C', '0', NULL, '50', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000035', 'fieldset_fin', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000036', 'check_valor_si', 'C', '0', NULL, '40', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000037', 'check_valor_no', 'C', '0', NULL, '40', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000038', 'check_desc_si', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000039', 'check_desc_no', 'C', '0', NULL, '100', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000040', 'fijo_sin_estado', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000041', 'editor_ancho', 'C', '0', NULL, '10', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000042', 'editor_alto', 'C', '0', NULL, '10', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000043', 'editor_botonera', 'C', '0', NULL, '50', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000044', 'selec_cant_minima', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000045', 'selec_cant_maxima', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000046', 'selec_utilidades', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000047', 'selec_tamano', 'E', '0', NULL, NULL, NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1530', '1000048', 'selec_serializar', 'E', '0', NULL, NULL, NULL, '0', '0');

------------------------------------------------------------
--[1000145]--  Editor Par�metros Efs: carga 
------------------------------------------------------------
INSERT INTO apex_objeto (proyecto, objeto, anterior, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES ('admin', '1000145', NULL, NULL, 'toba', 'objeto_ei_formulario', 'form_carga', 'objetos_toba/efs/form_carga.php', NULL, NULL, 'Editor Par�metros Efs: carga', NULL, '0', NULL, 'admin', 'instancia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-06-28 09:37:22');
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda) VALUES ('admin', '1000156', '1000145', 'modificacion', '&Modificacion', '1', NULL, NULL, NULL, NULL, NULL, '0', NULL, '1', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ut_formulario (objeto_ut_formulario_proyecto, objeto_ut_formulario, tabla, titulo, ev_agregar, ev_agregar_etiq, ev_mod_modificar, ev_mod_modificar_etiq, ev_mod_eliminar, ev_mod_eliminar_etiq, ev_mod_limpiar, ev_mod_limpiar_etiq, ev_mod_clave, clase_proyecto, clase, auto_reset, ancho, ancho_etiqueta, campo_bl, scroll, filas, filas_agregar, filas_agregar_online, filas_undo, filas_ordenar, columna_orden, filas_numerar, ev_seleccion, alto, analisis_cambios) VALUES ('admin', '1000145', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '150px', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000145', 'mecanismo', 'ef_combo', 'mecanismo', '0', '1', 'Tipo de Carga', NULL, 'Seleccione el mecanismo por el cual se cargan los valores disponibles del elemento.', '0', '0', NULL, '0', NULL, NULL, NULL, 'get_mecanismos_carga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '--- Sin carga ---', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000146', 'carga_include', 'ef_popup', 'carga_include', '0', '4', 'Archivo', NULL, 'Archivo donde se encuentra definida la clase', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '50', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/admin/objetos_toba/selector_archivo', 'admin', '1', 'width: 400,height: 400,scroll: yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000147', 'carga_clase', 'ef_editable', 'carga_clase', '0', '5', 'Clase', NULL, 'Nombre de la clase que contiene el m�todo a consultar. Este m�todo necesita ser <strong>est�tico</strong>.', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000148', 'carga_metodo', 'ef_editable', 'carga_metodo', '0', '2', 'Nombre del m�todo', NULL, NULL, '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000149', 'estatico', 'ef_checkbox', 'estatico', '0', '3', '�Es est�tico?', NULL, 'Normalmente el m�todo se encuentra en el [wiki:Referencia/Objetos/Ci CI] contenedor, si en cambio se encuentra en alguna otra clase/archivo se denomina carga est�tica (porque se invoca clase::metodo).', '0', '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000150', 'carga_col_clave', 'ef_editable', 'carga_col_clave', '0', '8', 'Columna Clave', NULL, 'Columna/s del recordset que representa la clave del registro. En caso de ser m�s de una separar por comas. Por defecto se asume que es posicional y la clave es la componente `0`.', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000151', 'carga_col_desc', 'ef_editable', 'carga_col_desc', '0', '9', 'Columna Descripci�n', NULL, 'Columna del recordset que representa la descripci�n del registro. Por defecto se asume que es posicional y la clave es la componente `1`.', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000152', 'carga_sql', 'ef_editable_textarea', 'carga_sql', '0', '6', 'Consulta SQL', NULL, NULL, '0', '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000153', 'carga_fuente', 'ef_combo', 'carga_fuente', '0', '7', 'Fuente', NULL, NULL, '0', '0', NULL, '0', NULL, NULL, '0', 'get_fuentes_datos', 'dao_editores', 'modelo/consultas/dao_editores.php', 'fuente_datos', 'descripcion_corta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000154', 'carga_lista', 'ef_editable', 'carga_lista', '0', '11', 'Lista de Opciones', NULL, 'Las opciones provienen de una lista fija. Los valores se separan por coma (,). Si la clave y descripci�n varian se separan con barra (/). Por ejemplo a,b,c o  a/A,b/B,c/C', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '40', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000155', 'carga_maestros', 'ef_multi_seleccion_doble', 'carga_maestros', '0', '12', 'Cascada - Maestros', NULL, 'Seleccione los efs de los que dependen los posibles valores que puede tomar el actual.', '0', '0', NULL, '0', NULL, NULL, '0', 'get_posibles_maestros', NULL, NULL, NULL, NULL, NULL, 'instancia', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '6');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000156', 'carga_cascada_relaj', 'ef_checkbox', 'carga_cascada_relaj', '0', '13', 'Cascada Relajada', NULL, 'Si esta seleccionado, la obligatoriedad del campo se elimina en caso de que algunos de sus ef\'s maestros no tengan estado.', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', 'S�', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total, inicializacion, estado_defecto, solo_lectura, carga_metodo, carga_clase, carga_include, carga_col_clave, carga_col_desc, carga_sql, carga_fuente, carga_lista, carga_maestros, carga_cascada_relaj, carga_no_seteado, edit_tamano, edit_maximo, edit_mascara, edit_unidad, edit_rango, edit_filas, edit_columnas, edit_wrap, edit_resaltar, edit_ajustable, popup_item, popup_proyecto, popup_editable, popup_ventana, fieldset_fin, check_valor_si, check_valor_no, check_desc_si, check_desc_no, fijo_sin_estado, editor_ancho, editor_alto, editor_botonera, selec_cant_minima, selec_cant_maxima, selec_utilidades, selec_tamano) VALUES ('admin', '1000145', '1000189', 'carga_no_seteado', 'ef_editable', 'carga_no_seteado', '0', '10', 'Desc. No-Selecci�n', NULL, 'Descripcion que representa la NO-SELECCION de opciones.', '0', '0', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30', '255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

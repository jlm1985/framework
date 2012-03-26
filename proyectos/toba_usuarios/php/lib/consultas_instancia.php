<?php

class consultas_instancia
{
	static function get_lista_proyectos()
	{
		$sql = "SELECT proyecto FROM apex_proyecto WHERE proyecto <> 'toba' ORDER BY proyecto;";
		return toba::db()->consultar($sql);
	}

	static function get_datos_proyecto($proyecto)
	{
		$proyecto = quote($proyecto);
		$sql = "SELECT * FROM apex_proyecto WHERE proyecto = $proyecto";
		$rs = toba::db()->consultar($sql);
		return $rs[0];
	}

	static function get_cantidad_ips_rechazadas()
	{
		$sql = 'SELECT count(*) as cantidad FROM toba_logs.apex_log_ip_rechazada;';
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}
	
	static function get_cantidad_usuarios_bloqueados()
	{
		$sql = 'SELECT count(*) as cantidad FROM apex_usuario WHERE bloqueado = 1;';
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}
	
	static function get_cantidad_usuarios_desbloqueados()
	{
		$sql = 'SELECT count(*) as cantidad FROM apex_usuario WHERE bloqueado = 0;';
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}
	
	//---------------------------------------------------------------------
	//------ SESIONES -----------------------------------------------------
	//---------------------------------------------------------------------

	static function get_cantidad_sesiones_proyecto($proyecto)
	{
		$proyecto = quote($proyecto);
		$sql = "SELECT count(*) as cantidad FROM toba_logs.apex_sesion_browser WHERE proyecto = $proyecto;";
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}

	static function get_sesiones($proyecto, $filtro)
	{
		$proyecto = quote($proyecto);
		$where = '';
		$filtro_sano = quote($filtro);
		if (isset($filtro['sesion'])) {
			$where .= " AND se.sesion_browser = {$filtro_sano['sesion']} ";
		} else {
			if (isset($filtro['desde'])) {
				$where .= " AND date(se.ingreso) >= {$filtro_sano['desde']} ";
			}
			if (isset($filtro['hasta'])) {
				$where .= " AND date(se.ingreso) <= {$filtro_sano['hasta']} ";
			}
			if (isset($filtro['usuario'])) {
				$where .= " AND usuario = {$filtro_sano['usuario']} ";
			}
		}
		$sql = "
				SELECT	se.sesion_browser as id,
						usuario,
						ingreso,
						egreso,
						se.ip as ip,
						count(so.solicitud_browser) as solicitudes
					FROM toba_logs.apex_sesion_browser se
						LEFT OUTER JOIN toba_logs.apex_solicitud_browser so
						ON se.sesion_browser = so.sesion_browser
						AND se.proyecto = so.proyecto
					WHERE se.proyecto = $proyecto
					$where
					GROUP BY 1,2,3,4,5
					ORDER BY ingreso DESC;";
		return toba::db()->consultar($sql);		
	}
	
	static function get_id_sesion($id_solicitud)
	{
		$id_solicitud = quote($id_solicitud);
		$sql = "
				SELECT	sesion_browser as id
				FROM toba_logs.apex_solicitud_browser
				WHERE solicitud_browser = $id_solicitud
		";
		$fila = toba::db()->consultar_fila($sql);
		if (isset($fila['id'])) {
			return $fila['id'];
		} else {
			throw new toba_error("No se encontro la sesi�n de la solicitud $id_solicitud");
		}
	}

	static function get_solicitudes_browser($sesion, $id_solicitud=null)
	{
		$extra = '';
		if (isset($id_solicitud)) {
			$id_solicitud = quote($id_solicitud);
			$extra = "AND sb.solicitud_browser = $id_solicitud";
		}
		$sesion = quote($sesion);
		$sql = "
				SELECT	s.solicitud as id,
						s.item_proyecto as item_proyecto,
						s.item as item,
						i.nombre as item_nombre,
						s.momento as momento,
						s.tiempo_respuesta as tiempo,
						count(so.solicitud_observacion) as observaciones
				FROM 	toba_logs.apex_solicitud_browser sb,
						apex_item i,
						toba_logs.apex_solicitud s
						LEFT OUTER JOIN toba_logs.apex_solicitud_observacion so
							ON s.solicitud = so.solicitud
							AND s.proyecto = so.proyecto
				WHERE	s.solicitud = sb.solicitud_browser
				AND	s.proyecto = sb.solicitud_proyecto
				AND	s.item = i.item
				AND s.item_proyecto = i.proyecto
				AND	sb.sesion_browser = $sesion
				$extra
				GROUP BY 1,2,3,4,5,6
				ORDER BY s.momento DESC;";
		return toba::db()->consultar($sql);		
	}
	
	static function get_solicitud_observaciones($solicitud)
	{
		$solicitud = quote($solicitud);
		$sql = "
				SELECT 	solicitud_observacion,
						observacion,
						ot.descripcion
				FROM toba_logs.apex_solicitud_observacion o
					LEFT OUTER JOIN toba_logs.apex_solicitud_obs_tipo ot
						ON ot.solicitud_obs_tipo = o.solicitud_obs_tipo
						AND ot.proyecto = o.solicitud_obs_tipo_proyecto
				WHERE o.solicitud = $solicitud
				ORDER BY 1;";
		return toba::db()->consultar($sql);
	}
	
	static function get_solicitudes_consola($proyecto, $filtro)
	{
		$proyecto = quote($proyecto);
		$sql = "		
				SELECT	s.solicitud as id,
						s.momento as momento,
						s.item_proyecto as item_proyecto,
						s.item as item,
						s.tiempo_respuesta as tiempo,
						sc.usuario as usuario,
						sc.llamada as llamada
				FROM	toba_logs.apex_solicitud s,
						toba_logs.apex_solicitud_consola sc
				WHERE	s.proyecto = sc.proyecto
				AND	s.solicitud = sc.solicitud_consola
				AND	s.proyecto = $proyecto;";
		return toba::db()->consultar($sql);		
	}

	//---------------------------------------------------------------------
	//------ Usuarios -----------------------------------------------------
	//---------------------------------------------------------------------

	function get_lista_usuarios($filtro=null)
	{
		$where = '';
		$condiciones = array();
		if (isset($filtro)) {
			if (isset($filtro['nombre'])) {
				$quote = quote("%{$filtro['nombre']}%");
				$condiciones[] = "(nombre ILIKE $quote)";
			}
			if (isset($filtro['usuario'])) {
				$quote = quote("%{$filtro['usuario']}%");
				$condiciones[] = "(usuario ILIKE $quote)";
			}
		}
		if ($condiciones) {
			$where = ' WHERE ' . implode(' AND ', $condiciones);	
		}
		$sql = "SELECT 	usuario,
						nombre
				FROM apex_usuario
				$where
				ORDER BY usuario;";
		return toba::db()->consultar($sql);		
	}
	
	static function get_usuarios_no_vinculados($filtro=null)
	{
		$where = 'WHERE	up.proyecto IS NULL';
		$condiciones = array();
		if (isset($filtro)) {
			if (isset($filtro['nombre'])) {
				$quote = quote("%{$filtro['nombre']}%");
				$condiciones[] = "(nombre ILIKE $quote)";
			}
			if (isset($filtro['usuario'])) {
				$quote = quote("%{$filtro['usuario']}%");
				$condiciones[] = "(usuario ILIKE $quote)";
			}
		}
		if ($condiciones) {
			$where .= 'AND' . implode(' AND ', $condiciones);
		}
		$sql = "SELECT 	u.usuario as usuario, 
						u.nombre as nombre,
						up.proyecto as proyecto
				FROM 	apex_usuario u 
							LEFT OUTER JOIN apex_usuario_proyecto up 
							ON u.usuario = up.usuario 
						$where
				;";
		
		return toba::db()->consultar($sql);
	}

	static function get_cantidad_usuarios()
	{
		$sql = 'SELECT count(*) as cantidad FROM apex_usuario;';
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}

	static function get_cantidad_usuarios_proyecto($proyecto)
	{
		$proyecto = quote($proyecto);
		$sql = "SELECT count(*) as cantidad FROM apex_usuario_proyecto WHERE proyecto = $proyecto";
		$rs = toba::db()->consultar($sql);
		return $rs[0]['cantidad'];
	}

	static function get_usuarios_vinculados_proyecto($proyecto, $filtro=null)
	{
		$proyecto = quote($proyecto);
		$where = "WHERE 	g.usuario_grupo_acc = up.usuario_grupo_acc
					AND		g.proyecto = up.proyecto
					AND		u.usuario = up.usuario
					AND		up.proyecto = $proyecto";

		$condiciones = array();
		if (isset($filtro)) {
			if (isset($filtro['nombre'])) {
				$quote = quote("%{$filtro['nombre']}%");
				$condiciones[] = "(u.nombre ILIKE $quote)";
			}
			if (isset($filtro['usuario'])) {
				$quote = quote("%{$filtro['usuario']}%");
				$condiciones[] = "(u.usuario ILIKE $quote)";
			}
		}
		if ($condiciones) {
			$where .= 'AND' . implode(' AND ', $condiciones);
		}
		$sql = "SELECT 	up.proyecto as proyecto,
						up.usuario as usuario, 
						u.nombre as nombre,
						g.nombre as grupo_acceso
				FROM 	apex_usuario u,
						apex_usuario_proyecto up,
						apex_usuario_grupo_acc g
						$where
				ORDER BY usuario
				";
		$datos = toba::db()->consultar($sql);
		$temp = array();
		foreach ($datos as $dato) {
			$temp[$dato['usuario']]['proyecto'] = $dato['proyecto'];
			$temp[$dato['usuario']]['usuario'] = $dato['usuario'];
			$temp[$dato['usuario']]['nombre'] = $dato['nombre'];
			if (isset($temp[$dato['usuario']]['grupo_acceso'])) {
				$temp[$dato['usuario']]['grupo_acceso'] .= ', ' . $dato['grupo_acceso'];
			} else {
				$temp[$dato['usuario']]['grupo_acceso'] = $dato['grupo_acceso'];
			}
		}
		return (array_values($temp));
	}

	static function get_usuarios_no_vinculados_proyecto($proyecto, $filtro=null)
	{
		$join = '';
		if (isset($proyecto)) {
			$proyecto = quote($proyecto);
			$join = " AND up.proyecto = $proyecto";
		}
		$condiciones = array();
		if (isset($filtro)) {
			if (isset($filtro['nombre'])) {
				$quote = quote("%{$filtro['nombre']}%");
				$condiciones[] = "(u.nombre ILIKE $quote)";
			}
			if (isset($filtro['usuario'])) {
				$quote = quote("%{$filtro['usuario']}%");
				$condiciones[] = "(u.usuario ILIKE $quote)";
			}
		}
		$where = '';
		if ($condiciones) {
			$where .= 'AND' . implode(' AND ', $condiciones);
		}
		$sql = "SELECT 	u.usuario as usuario, 
						u.nombre as nombre,
						up.proyecto as proyecto
				FROM 	apex_usuario u 
							LEFT OUTER JOIN apex_usuario_proyecto up 
							ON u.usuario = up.usuario 
							$join
				WHERE	up.proyecto IS NULL
					$where
				ORDER BY usuario;";
		return toba::db()->consultar($sql);
	}
	
	//---------------------------------------------------------------------
	//------ Perfil Funcional ---------------------------------------------
	//---------------------------------------------------------------------
	
	static function get_lista_grupos_acceso_usuario_proyecto($usuario, $proyecto)
	{
		$proyecto = quote($proyecto);
		$usuario = quote($usuario);
		$sql = "SELECT	usuario_grupo_acc
				FROM	apex_usuario_proyecto
				WHERE 		proyecto = $proyecto
						AND	usuario = $usuario
				;";
		return toba::db()->consultar($sql);
	}

	static function get_lista_grupos_acceso_proyecto($proyecto)
	{
		$proyecto = quote($proyecto);
		$sql = "SELECT 	proyecto,
						usuario_grupo_acc,
						nombre,
						descripcion
				FROM 	apex_usuario_grupo_acc
				WHERE 	proyecto = $proyecto";
		return toba::db()->consultar($sql);
	}
	
	function get_descripcion_grupo_acceso($proyecto, $grupo)
	{
		$proyecto = quote($proyecto);
		$grupo = quote($grupo);
		$sql = "SELECT 	nombre as 			grupo_acceso,
						descripcion as 		grupo_acceso_desc
				FROM 	apex_usuario_grupo_acc
				WHERE 	proyecto = $proyecto
				AND 	usuario_grupo_acc = $grupo";
		return toba::db()->consultar($sql);
	}
	
	function get_descripcion_perfil_datos($proyecto, $perfil)
	{
		$proyecto = quote($proyecto);
		$perfil = quote($perfil);
		$sql = "SELECT 	nombre as 			perfil_datos_nombre,
						descripcion as 		perfil_datos_descripcion
				FROM 	apex_usuario_perfil_datos
				WHERE 	proyecto = $proyecto
				AND 	usuario_perfil_datos = $perfil";
		return toba::db()->consultar($sql);
	}
	
	//---------------------------------------------------------------------
	//------ Perfil de Datos ----------------------------------------------
	//---------------------------------------------------------------------
	
	static function get_lista_perfil_datos($proyecto)
	{
		$proyecto = quote($proyecto);
		$sql = "SELECT 	proyecto,
						usuario_perfil_datos,
						nombre,
						descripcion						
				FROM 	apex_usuario_perfil_datos 
				WHERE	proyecto = $proyecto";
		$datos = toba::db()->consultar($sql);
		return $datos;
	}
}
?>
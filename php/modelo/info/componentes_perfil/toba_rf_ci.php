<?php 
class toba_rf_ci extends toba_rf_componente
{
	/*
	function __construct($padre=null) 
	{
		//parent::__construct($nombre, $padre=null)
	}*/

	function cargar_datos_pantallas()
	{
		
	}

	function cargar_datos_dependencias()
	{
		$sql = "SELECT 	o.proyecto as 			proyecto, 
					o.objeto as 			objeto,
					o.nombre as 			nombre,
					o.clase as 				clase,
					o.subclase as			subclase,
					o.subclase_archivo as	subclase_archivo,
					c.icono as				icono,
					(SELECT COUNT(*) 
						FROM apex_objeto_dependencias dd
						WHERE dd.objeto_proveedor = o.objeto
						AND dd.proyecto = '$proyecto' $excluir_padre ) as consumidores_externos,
					d.objeto_proveedor as 	dep
			FROM 	apex_objeto o LEFT OUTER JOIN apex_objeto_dependencias d
					ON o.objeto = d.objeto_consumidor AND o.proyecto = d.proyecto,
					apex_clase c
			WHERE 	
					o.objeto = '$componente' 
				AND o.proyecto = '$proyecto'
				AND o.clase = c.clase";
	}
	
	
	
}
?>
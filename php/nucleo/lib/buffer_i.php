<?php
include("buffer.php");

class buffer_i extends buffer
{
	var $tabla;

	function buffer_i($id, $tabla, $fuente)
	{
		$this->tabla = $tabla;
		$definicion = $this->generar_definicion($fuente);
		parent::buffer($id, $definicion, $fuente);
	}
	//-------------------------------------------------------------------------------

	function generar_definicion($fuente)
	{
		global $db;
		$metadatos = $db[$fuente][apex_db]->obtener_metadatos( $this->tabla );
		$metadatos = $this->filtrar_metadatos( $metadatos );
		//Busco las claves
		foreach($metadatos['constraints'] as $constraint){
			if($constraint['contype']=="p"){
				$pk = $constraint['conkey'];
				break;
			}
		}
		$num_col_pk = explode(",",substr($pk,1,strlen($pk)-2));
		//ei_arbol($numcols_pk,"PK");
		
		//Creo la definicion
		//ATENCION: Faltan lo UNIQUE
		$definicion['tabla'] = $this->tabla;
		$secuencia = 0;
		for($a=0;$a<count($metadatos['columnas']);$a++)
		{
			//-<1>- Genero la entrada en la lista de claves o columnas
			if(in_array($metadatos['columnas'][$a]['num_col'], $num_col_pk)){
				//Es una clave
				$definicion['clave'][]=$metadatos['columnas'][$a]['columna'];
				$definicion['no_duplicado'][]=$metadatos['columnas'][$a]['columna'];
			}else{
				$definicion['columna'][]=$metadatos['columnas'][$a]['columna'];
			}
			//-<2>- NO DUPLICADOS
			if($metadatos['columnas'][$a]['not_null']=="t"){
				$definicion['no_nulo'][]=$metadatos['columnas'][$a]['columna'];
			}
			//-<3>- SECUENCIAS
			if(preg_match("/nextval/",$metadatos['columnas'][$a]['default'])){
				$definicion['secuencia'][$secuencia]['col']=$metadatos['columnas'][$a]['columna'];
				$temp = preg_split("|\"|", $metadatos['columnas'][$a]['default']);
				$definicion['secuencia'][$secuencia]['col']=$metadatos['columnas'][$a]['columna'];
				$definicion['secuencia'][$secuencia]['seq']=$temp[1];
			}
		}
		//ei_arbol($definicion);
		//ei_arbol($metadatos);
		return $definicion;
	}
	//-------------------------------------------------------------------------------

	function filtrar_metadatos($metadatos)
	//Permite que un hijo filtre metadatos
	//Esto es para los casos
	{
		return $metadatos;
	}
	//-------------------------------------------------------------------------------
}
?>
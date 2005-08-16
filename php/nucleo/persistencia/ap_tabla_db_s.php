<?php
require_once("ap_tabla_db.php");

/*
	Administrador de persistencia a DB con mapeo SIMPLE
	Supone que la tabla de datos se va a mapear a una tabla del modelo de datos
	y los nombres de las columnas son identicos
*/
class ap_tabla_db_s extends ap_tabla_db
{
	protected $secuencias;

	//-------------------------------------------------------------------------------
	//---------------  SINCRONIZACION con la DB   -----------------------------------
	//-------------------------------------------------------------------------------

	protected function preparar_sincronizacion()
	//Generacion de estructuras comunes a todo el proceso de sincronizacion	
	{
		foreach($this->columnas as $columna)
		{
			if( $columna['secuencia']!=""){
				$this->secuencias[$columna['columna']] = $columna['secuencia'];
			}
		}
	}

	protected function insertar($id_registro)
	{
		$sql = $this->generar_sql_insert($id_registro);
		$this->log("registro: $id_registro - " . $sql); 
		$this->ejecutar_sql( $sql );
		//Actualizo las secuencias
		if(count($this->secuencias)>0){
			foreach($this->campos_secuencia as $columna => $secuencia){
				$this->datos[$id_registro][$columna] = recuperar_secuencia($secuencia, $this->fuente);
			}
		}
	}
	
	protected function generar_sql_insert($id_registro)
	{
		$a=0;
		$registro = $this->datos[$id_registro];
		foreach($this->columnas as $columna)
		{
			$col = $columna['columna'];
			$es_insertable = ($columna['secuencia']=="") && ($columna['externa'] != 1);
			if( $es_insertable )
			{
				if(!isset($registro[$col])){
					$valores_sql[$a] = "NULL";
				}else{
					if(	$this->es_numerica($columna['tipo']) ){
						$valores_sql[$a] = $registro[$col];
					}else{
						$valores_sql[$a] = "'" . addslashes(trim($registro[$col])) . "'";
					}
				}
			}
			$columnas_sql[$a] = $col;
			$a++;
		}
		$sql = "INSERT INTO " . $this->tabla .
				" ( " . implode(", ", $columnas_sql) . " ) ".
				" VALUES (" . implode(", ", $valores_sql) . ");";
		return $sql;
	}
	//-------------------------------------------------------------------------------

	protected function modificar($id_registro)
	{
		$sql = $this->generar_sql_update($id_registro);
		$this->log("registro: $id_registro - " . $sql); 
		ejecutar_sql( $sql, $this->fuente);
	}
	
	function generar_sql_update($id_registro)
	// Modificacion de claves
	{
		$registro = $this->datos[$id_registro];
		//Genero las sentencias de la clausula SET para cada columna
		foreach($this->columnas as $columna){
			$col = $columna['columna'];
			//columna modificable: no es secuencia, no es extena, no es PK 
			//	(excepto que se se declare explicitamente la alteracion de PKs)
			$es_modificable = ($columna['secuencia']=="") && ($columna['externa'] != 1) 
							&& ( ($columna['pk'] != 1) || (($columna['pk'] == 1) && $this->flag_modificacion_clave ) );
			if( $es_modificable ){
				if(!isset($registro[$col])){
					$set[] = "$col = NULL";
				}else{
					if(	$this->es_numerica($columna['tipo']) ){
						$set[] = "$col = " . $registro[$col];
					}else{
						$set[] = "$col = '" . addslashes(trim($registro[$col])) . "'";
					}
				}
			}
		}
		//Armo el SQL
		$sql = "UPDATE " . $this->tabla . " SET ".
				implode(", ",$set) .
				" WHERE " . implode(" AND ",$this->generar_sql_where_registro($id_registro) ) .";";
		return $sql;		
	}
	//-------------------------------------------------------------------------------

	protected function eliminar($id_registro)
	{
		$sql = $this->generar_sql_delete($id_registro);
		$this->log("registro: $id_registro - " . $sql); 
		ejecutar_sql( $sql, $this->fuente);
		return $sql;
	}

	protected function generar_sql_delete($id_registro)
	{
		$registro = $this->datos[$id_registro];
		if($this->baja_logica){
			$sql = "UPDATE " . $this->tabla .
					" SET " . $this->baja_logica_columna . " = '". $this->baja_logica_valor ."' " .
					" WHERE " . implode(" AND ",$sql_where) .";";
		}else{
			$sql = "DELETE FROM " . $this->tabla .
					" WHERE " . implode(" AND ",$this->generar_sql_where_registro($id_registro) ) .";";
		}
		return $sql;
	}
	//-------------------------------------------------------------------------------

	function generar_sql_where_registro($id_registro)
	//Genera la sentencia WHERE correspondiente a un registro
	{
		foreach($this->clave as $clave)
		{
			$tipo_dato = $this->columnas[ $this->indice_columnas[ $clave ] ]['tipo'];
			if( $this->es_numerica($tipo_dato) ){
				$sql[] = "( $clave = " . $this->cambios[$id_registro]['clave'][$clave] .")";
			}else{
				$sql[] = "( $clave = '" . $this->cambios[$id_registro]['clave'][$clave] ."')";		
			}
		}
		return $sql;
	}

	function es_numerica($tipo)
	{
		return ($tipo == "E") || ($tipo == "N");
	}

	//-------------------------------------------------------------------------------
	//------------  GENERADORES de SQL  ---------------------------------------------
	//-------------------------------------------------------------------------------
	
	protected function generar_sql_select()
	{
		foreach($this->columnas as $col){
			if(!$col['externa']){
				$columnas[] = $this->tabla  . "." . $col['columna'];
			}
		}
		$sql =	" SELECT	" . implode(",	",$columnas); 
		if(isset($this->alias)){	
			$sql .= " FROM "	. $this->tabla  . " " . $this->alias;
		}else{
			$sql .= " FROM "	. $this->tabla;
		}
		if(isset($this->from)){
			$sql .= ", " . implode(",",$this->from);
		}
		if(isset($this->where)){
			$sql .= " WHERE " .	implode(" AND ",$this->where) .";";
		}
		$this->log("SQL de carga - " . $sql); 
		return $sql;
	}
	//-------------------------------------------------------------------------------
}
?>
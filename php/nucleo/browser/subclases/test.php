<?php
require_once("nucleo/browser/clases/objeto_mt_s_abm.php");

class objeto_mt_abms_x extends objeto_mt_abms
/*
 	@@acceso: nucleo
	@@desc: Extension de la clase ABMS para realizar validaciones especificas
*/
{
	function objeto_mt_abms_x($id,&$solicitud)
/*
 	@@acceso: nucleo
	@@desc: Muestra la definicion del OBJETO
*/
	{	parent::objeto_mt_abms($id, $solicitud);	}
	//-------------------------------------------------------------------------------
	
	function procesar_etapa_PM()
/*
 	@@acceso: interno
	@@desc: PROCESAR MODIFICACION
*/
	{
		$this->etapa_actual = "PM";
		$this->cargar_post();
		if( $_POST[$this->submit]==$this->submit_mod )//			( 1 ) MODIFICAR
		{		
			$this->etapa_actual = "PM-U";
			if( $this->validar_estado() ) // Validacion OK
			{
				if( $this->iniciar_transaccion() ) //Comienzo la TRANSACCION
				{
					$sql = $this->dependencias["formulario"]->obtener_sql("update");
					ei_arbol($sql,"SQL");
					
                    $string = $sql[0];
                    $sql_1 = str_replace("exclusivo_toba	= NULL","exclusivo_toba = 0",$string); 
					//$sql_1 = str_replace("NULL","0",$string); 
					echo $sql_1;

					if( $this->ejecutar_sql($sql) ){ 
						$clave = $this->dependencias["formulario"]->obtener_clave();
						$this->memoria["clave"] = $clave;
						$this->finalizar_transaccion();						
						if($this->dependencias["formulario"]->info_ut_formulario["auto_reset"]){
							unset($this->memoria);
							$this->memoria["proxima_etapa"] = "PA";
							$this->dependencias["formulario"]->limpiar_interface();//Limpio el FORM
						}else{
							//Se pueden modificar las claves?
							$this->control_modificacion_claves();
						}
					}else{ //ERROR UPDATE
						$this->memoria["proxima_etapa"] = "PM";
						//Se pueden modificar las claves?
						$this->control_modificacion_claves();
						$this->abortar_transaccion("Error MODIFICANDO el registro");
						$this->estado_proceso = "ERROR";
					}
				}else{	//La transaccion no se inicio
					$this->memoria["proxima_etapa"] = "PM";
					$this->estado_proceso = "ERROR";
					//Se pueden modificar las claves?
					$this->control_modificacion_claves();
				}
			}
			else{	// Error en la validacion
				$this->memoria["proxima_etapa"] = "PM";
				$this->estado_proceso = "ERROR";
				//Se pueden modificar las claves?
				$this->control_modificacion_claves();
			}
		}
		elseif(( $_POST[$this->submit]==$this->submit_eli)//		( 2 ) ELIMINAR
			&& ($this->dependencias["formulario"]->permitir_eliminar() ))
		{
			$this->etapa_actual = "PM-D";
			if( $this->iniciar_transaccion() ) //Comienzo la TRANSACCION
			{
				$sql = $this->dependencias["formulario"]->obtener_sql("delete");
				//ei_arbol($sql,"Datos maestro");
				//echo $sql;
				if( $this->ejecutar_sql($sql) ){ //OK
					$this->finalizar_transaccion();// Fin TRANSACCION
					$this->estado_proceso = "OK";//-------------> Termino todo OK
					$this->dependencias["formulario"]->limpiar_interface();
					$this->memoria["proxima_etapa"] = "PA";
				}else{ //ERROR Eliminando
					$this->memoria["proxima_etapa"] = "PM";
					$this->abortar_transaccion("Error ELIMINANDO el registro");
					$this->estado_proceso = "ERROR";
				}
			}else{	//La transaccion no se inicio
				$this->memoria["proxima_etapa"] = "PM";
				$this->estado_proceso = "ERROR";
			}
		}
 	}
	//-------------------------------------------------------------------------------	
	
}
//#############################################################################################
//#############################################################################################

?>
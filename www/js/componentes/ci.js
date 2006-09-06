ci.prototype = new ei();
var def = ci.prototype;
def.constructor = ci;
//--------------------------------------------------------------------------------
//Clase ci 
function ci(instancia, form, input_submit, id_en_controlador) {
	this._instancia = instancia;						//Nombre de la instancia del objeto, permite asociar al objeto con el arbol DOM
	this._form = form;									//Nombre del form contenedor del objeto
	this._input_submit = input_submit;					//Campo que se setea en el submit del form 
	this._id_en_controlador = id_en_controlador;		//ID del tab actual
	this.controlador = null;							//CI contenedor
	this._deps = {};									//Listado asociativo de dependencias
	this._en_submit = false;							//�Esta en proceso de submit el CI?
	this._silencioso = false;							//�Silenciar confirmaciones y alertas? Util para testing
	this._evento_implicito = new evento_ei('', true, '');	//Por defecto se valida los objetos contenidos
	this._parametros = "";								//Parametros opcionales que se pasan al server
	this.reset_evento();
}

	def.agregar_objeto = function(objeto, identificador) {
		objeto.set_controlador(this);
		this._deps[identificador] = objeto;
	};

	def.dependencia = function(identificador) {
		return this._deps[identificador];
	};
	
	def.iniciar = function() {
		for (var dep in this._deps) {
			this._deps[dep].iniciar();
		}
	};
	
	//Retorna el nodo DOM donde se muestra el componente
	def.nodo = function() {
		return document.getElementById(this._instancia + '_cont');	
	};
	
	//---Eventos	
	def.set_evento = function(evento) {
		this._evento = evento;
		this.submit();
	};
	

	//---SUBMIT
	//El proceso de SUBMIT se divide en partes:
	//1- Se sube hasta el CI raiz
	//2- El raiz analiza si puede hacerlo (recorriendo los hijos)
	//2-Se envia el submit a los hijos y se hace el procesamiento para PHP (esto es irreversible)
	//Intenta realizar el submit de todos los objetos asociados
	def.submit = function() {
		if (this.controlador && !this.controlador.en_submit()) { //Primero debe consultar si su padre est� en proceso
			return this.controlador.submit();
		}

		this._en_submit = true;
		if (! this.controlador) { //Si es el padre de todos, borrar las notificaciones
			notificacion.limpiar();
			if (this.puede_submit()) {
				this.submit_recursivo();
				//toba.set_ajax(this);
				toba.comunicar_eventos();
			} else {
				if (window. notificacion) {
					notificacion.mostrar(this);
				}
			}
		} else {
			this.submit_recursivo();
		}
		this._en_submit = false;
	};
	
	def.submit_recursivo = function()
	{
		for (var dep in this._deps) {
			this._deps[dep].submit();
		}
		if (this._evento.id !== '') {
			document.getElementById(this._input_submit).value = this._evento.id;
			document.getElementById(this._input_submit + "__param").value = this._parametros;
		}
	};
	
	def.en_submit = function() {
		return this._en_submit;		
	};
	
	//Chequea si es posible realiza el submit de todos los objetos asociados
	def.puede_submit = function() {
		if (this._evento) {
			//- 1 - Hay que realizar las validaciones y preguntarle a los hijos si pueden hacer submit
			//		La validaci�n no es recursiva para evitar doble chequeos en los hijos
			var ok = this.validar(false);
			ok = ok && this.objetos_pueden_submit();
			if(!ok) {
				this.reset_evento();
				return false;
			} 
			//- 2 - Hay que llamar a una ventana de control especifica para este evento?
			if(existe_funcion(this, "evt__" + this._evento.id)){
				if(! ( this["evt__" + this._evento.id]() ) ){
					this.reset_evento();
					return false;
				}
			}
			//- 3 - Hay que confirmar la ejecucion del evento?
			//La confirmacion se solicita escribiendo el texto de la misma
			if(this._evento.confirmar !== "") {
				if (!this._silencioso && !(confirm(this._evento.confirmar))){
					this.reset_evento();
					return false;
				}
			}
			return true;
		} else {
			return true;
		}
	};
	
	def.objetos_pueden_submit = function() {
		if(this._evento && this._evento.validar) {
			var ok = true;
			for (var dep in this._deps) {
				ok = this._deps[dep].puede_submit() && ok;
			}
			return ok;			
		} else {
			this.resetear_errores();
			return true;
		}
	};
	
	def.resetear_errores = function() {
		for (var dep in this._deps) {
			this._deps[dep].resetear_errores();
		}
		this.notificar(false);
	};
	
	//---VALIDACION
	//Realiza la validaci�n de este objeto, y opcionalmente de los que est�n contenidos
	def.validar = function(recursivo) {
		if (typeof recursivo == 'undefined') {
			recursivo = true;
		}
		var validacion_particular = 'evt__validar_datos';
		var ok = true;
		if(this._evento && this._evento.validar) {
			if (existe_funcion(this, validacion_particular)) {
				ok = ok && this[validacion_particular]();	
			}
			if (recursivo) {
				for (var dep in this._deps) {
					ok = ok && this._deps[dep].validar(recursivo);
				}
			}
		}
		return ok;
	};
	
	//---Notificaciones
	def.notificar = function(mostrar) {
		var barra = document.getElementById('barra_' + this._instancia);
		if (barra) {
			if (mostrar) {
				barra.style.display = '';
			} else {
				barra.style.display = 'none';
			}
		}
	};

	//---Navegaci�n 

	def.ir_a_pantalla = function(pantalla) {
		this.set_evento(new evento_ei('cambiar_tab_' + pantalla, true, ''));
	};
	
	
	def.ir_a_anterior = function() {
		this.ir_a_pantalla('_anterior');	
	};	
		
	def.ir_a_siguiente = function() {
		this.ir_a_pantalla('_siguiente');
	};

	//--- Control de TABS
	
	def.activar_tab = function(id) {
		var boton = this.get_tab(id);
		if (boton.onclick_viejo !== '') {
			boton.onclick = boton.onclick_viejo;
		}
	};

	def.desactivar_tab = function(id) {
		var boton = this.get_tab(id);
		boton.onclick_viejo = boton.onclick;
		boton.onclick = '';
	};

	def.mostrar_tab = function (id) {
		tab = this.get_tab(id).parentNode;
		tab.style.display = '';
	}

	def.ocultar_tab = function (id) {
		tab = this.get_tab(id).parentNode;
		tab.style.display = 'none';
	}

	def.get_tab = function(id) {
		if (id == this._id_en_controlador) {
			notificacion.agregar('No es posible eliminar el tab correspondiente a la pantalla actual');
			notificacion.mostrar();
			return;
		}
		return document.getElementById(this._input_submit + '_cambiar_tab_' + id);
	}	
	
toba.confirmar_inclusion('componentes/ci');

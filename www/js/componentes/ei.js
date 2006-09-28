/**
 * Representa un evento que ser� consumido por un CI
 * @param id Identificador del evento, ej: 'modificar'
 * @param validar �Se debe validar antes de hacer submit?
 * @param confirmar �Se debe confirmar antes de hacer submit?
 * @constructor 
 */
function evento_ei(id, validar, confirmar, parametros) {
	this.id = id;
	this.validar = (typeof validar == 'undefined') ? true : validar;
	this.confirmar = (typeof confirmar == 'undefined') ? false : confirmar;
	this.parametros = parametros;
	this._silencioso = false;
}


function ei(instancia, input_submit) {
	this._instancia = instancia;
	this._input_submit = input_submit;
}
def = ei.prototype;
def.constructor = ei;

	def.iniciar = function() {
	};

	def.set_controlador = function(ci) {
		this.controlador = ci;
	};
	
	//----------------------------------------------------------------
	//---Eventos	 
	def.set_evento = function(evento, hacer_submit) {
		if (typeof hacer_submit == 'undefined') {
			hacer_submit = true;
		}
		this._evento = evento;
		if (hacer_submit) {
			this.submit();
		}
	};

	def.set_evento_implicito = function(evento) {
		this._evento_implicito = evento;
	};
	
	def.reset_evento = function() {
		this._evento = this._evento_implicito;
	};
		
	//---Submit
	def.submit = function() {
		var padre_esta_listo = this.controlador && !this.controlador.en_submit();
		if (padre_esta_listo) {
			return this.controlador.submit();
		}
	};
	
	def.puede_submit = function() {
		if(this._evento && existe_funcion(this, "evt__" + this._evento.id)){
			if(! ( this["evt__" + this._evento.id]() ) ){
				this.reset_evento();
				return false;
			}
		}
		return true;
	};

	def.resetear_errores = function() {
	};
	
	def.invocar_vinculo = function(id_evento, id_vinculo) {
		// Busco la extension de modificacin de vinculos
		var funciv = 'modificar_vinculo__' + id_evento;
		if (existe_funcion(this, funciv)) {
			this[funciv](id_vinculo);
		}
		vinculador.invocar(id_vinculo);
	};

	//----------------------------------------------------------------  
	//---Servicios graficos 
	def.cuerpo = function() {
		return document.getElementById('cuerpo_' + this._instancia);	
	};
	
	def.raiz = function() {
		return this.cuerpo().parentNode;
	};
	
	def.cambiar_colapsado = function() {
		cambiar_colapsado(this.obtener_boton_colapsar(), this.cuerpo());		
	};
	
	def.colapsar = function() {
		colapsar(this.obtener_boton_colapsar(), this.cuerpo());
	};
	
	def.descolapsar = function() {
		descolapsar(this.obtener_boton_colapsar(), this.cuerpo());
	};
	
	def.obtener_boton_colapsar = function() {
		return document.getElementById('colapsar_boton_' + this._instancia);
	};

	def.desactivar_boton = function(id) {
		this.get_boton(id).disabled = true;
	};

	def.activar_boton = function(id) {
		this.get_boton(id).disabled = false;
	};

	def.ocultar_boton = function(id) {
		this.get_boton(id).style.display = 'none';
	};

	def.mostrar_boton = function(id) {
		this.get_boton(id).style.display = '';
	};
	
	def.get_boton = function(id) {
		return document.getElementById(this._input_submit + '_' + id);
	};

toba.confirmar_inclusion('componentes/ei');
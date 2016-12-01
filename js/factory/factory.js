angular
  .module('myApp')
  	.factory('usuarioFactory', function (usuarioService) {
  		var objeto = {};
  		objeto.nombreDelFactory = "factory de usuario";
  		objeto.traerTodo = traerTodo;
  		objeto.traerUno = traerUno;
  		objeto.borrar = borrar;
  		objeto.modificar = modificar;
  		objeto.insertar = insertar;
  		return objeto;

  		function traerTodo () {
	      	return usuarioService.traerTodo();
	    }

	    function traerUno (id) {
	      	return usuarioService.traerUno(id);
	    }

	    function borrar (id) {
	      	return usuarioService.borrar(id);
	    }

	    function modificar (usuario) {
	    	return usuarioService.modificar(usuario);
	    }

	    function insertar (usuario) {
	    	return usuarioService.insertar(usuario);
	    }
  });

angular
  .module('myApp')
  	.factory('votacionFactory', function (votacionService) {
  		var objeto = {};
  		objeto.nombreDelFactory = "factory de votaciones";
  		objeto.traerTodo = traerTodo;
  		objeto.traerUna = traerUna;
  		objeto.borrar = borrar;
  		objeto.modificar = modificar;
  		objeto.insertar = insertar;
  		return objeto;

  		function traerTodo () {
	      	return votacionService.traerTodo();
	    }

	    function traerUna (id) {
	      	return votacionService.traerUna(id);
	    }

	    function borrar (id) {
	      	return votacionService.borrar(id);
	    }

	    function modificar (votacion) {
	    	return votacionService.modificar(votacion);
	    }

	    function insertar (votacion) {
	    	return votacionService.insertar(votacion);
	    }
  });
angular
  .module('myApp')
  .service('usuarioService', function ($http) {

    function success(data){
      return data;
    }

    function fail(error){
      console.error(error);
    }

    var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "ws";

    function traerUrl(param){
        if(param==null){
          return url;
        } else {
          return url + "/" + param;
        }
      }

    this.traerTodo = function () {
      return $http.get(traerUrl("usuarios"))
      .then(success,fail);
    }

    this.traerUno = function (id) {
      return $http.get(traerUrl("usuario/" + id))
      .then(success,fail);
    }

    this.borrar = function(id){
      return $http.delete(traerUrl("usuario/" + id))
      .then(success,fail);
    }

    this.modificar = function(usuario){
      return $http.put(traerUrl("usuario/"), usuario)
      .then(success,fail);
    }

    this.insertar = function(usuario){
      return $http.post(traerUrl("usuario/"), usuario)
      .then(success,fail);
    }
  });

angular
  .module('myApp')
  .service('votacionService', function ($http) {

    function success(data){
      return data;
    }

    function fail(error){
      console.error(error);
    }

    var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "ws";

    function traerUrl(param){
        if(param==null){
          return url;
        } else {
          return url + "/" + param;
        }
      }

    this.traerTodo = function () {
      return $http.get(traerUrl("votaciones"))
      .then(success,fail);
    }

    this.traerUna = function (id) {
      return $http.get(traerUrl("votacion/" + id))
      .then(success,fail);
    }

    this.borrar = function(id){
      return $http.delete(traerUrl("votacion/" + id))
      .then(success,fail);
    }

    this.modificar = function(votacion){
      return $http.put(traerUrl("votacion/"), votacion)
      .then(success,fail);
    }

    this.insertar = function(votacion){
      return $http.post(traerUrl("votacion/"), votacion)
      .then(success,fail);
    }
  });
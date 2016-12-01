app.controller("controlPersona", function($scope, $auth, $state){
  
  $scope.isAuthenticated = function() {
    return $auth.isAuthenticated();
  };

  $scope.logout=function(){
    $auth.logout();
    $state.reload();
    $state.go('persona.menu');
  }
});

app.controller("controlPersonaMenu", function($scope, $state, $auth){

  $scope.logged = $auth.isAuthenticated();

  $scope.irAlta = function(){
    $state.go('persona.alta');
  };
});

app.controller("controlPersonaAlta", function($scope, FileUploader, $auth, $state, $http, votacionFactory){


  $scope.votacion = {};
  /*if(!$auth.isAuthenticated()){
    $state.go('persona.login');
  }*/

  $scope.uploader = new FileUploader({url: 'PHP/upload.php'});
  $scope.uploader.queueLimit = 1; // indico cuantos archivos permito cargar
            
      /* Si quiero restringir los archivos a imagenes añado este filtro */
      $scope.uploader.filters.push({
              name: 'imageFilter',
              fn: function(item, options) {
                  var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                  return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
              }
          });

          /** funcion para mi boton cargar si quiero agregar funcionalidad, 
           de lo contrario uso el item.upload() en la vista **/
          $scope.cargar = function(){
            /** llamo a la funcion uploadAll para cargar toda la cola de archivos **/
            $scope.uploader.uploadAll();
            /** agrego mi funcionalidad **/

          }
      /***********************************************
      *  Funciones callbacks que nos dan informacion *
      *  en el proceso de carga de archivos          *
      ***********************************************/

      // $scope.uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
      //     console.info('onWhenAddingFileFailed', item, filter, options);
      // };
    //       $scope.uploader.onAfterAddingFile = function(fileItem) {
    //           console.info('onAfterAddingFile', fileItem);
    //       };
    //       $scope.uploader.onAfterAddingAll = function(addedFileItems) {
    //           console.info('onAfterAddingAll', addedFileItems);
    //       };
    //       $scope.uploader.onBeforeUploadItem = function(item) {
    //           console.info('onBeforeUploadItem', item);
    //       };
    //       $scope.uploader.onProgressItem = function(fileItem, progress) {
    //           console.info('onProgressItem', fileItem, progress);
    //       };
    //       $scope.uploader.onProgressAll = function(progress) {
    //           console.info('onProgressAll', progress);
    //       };
    //       $scope.uploader.onSuccessItem = function(fileItem, response, status, headers) {
    //           console.info('onSuccessItem', fileItem, response, status, headers);
    //       };
          $scope.uploader.onErrorItem = function(fileItem, response, status, headers) {
              console.info('onErrorItem', fileItem, response, status, headers);
          };
    //       $scope.uploader.onCancelItem = function(fileItem, response, status, headers) {
    //           console.info('onCancelItem', fileItem, response, status, headers);
    //       };
           $scope.uploader.onCompleteItem = function(fileItem, response, status, headers) {
              console.info('onCompleteItem', fileItem, response, status, headers);
           };
          $scope.uploader.onCompleteAll = function() {
              console.info('Se cargo con exito');
              console.info('uploader', $scope.uploader);
          };

    $scope.Guardar = function() {
      console.log($scope.votacion);
      votacionFactory.insertar($scope.votacion)
        .then(function(respuesta){
            console.log(respuesta.data);
            $state.go("persona.menu");
        },
             function(respuesta){
            console.error(respuesta);
        });
    }

});

app.controller("controlPersonaGrilla", function($scope, $http, $auth, $state, votacionFactory){
    $scope.DatoTest="**grilla**";
    $scope.ListadoPersonas = {};
  
  votacionFactory.traerTodo()
  .then(function(respuesta) {       

         $scope.ListadoPersonas = respuesta.data;
         console.log(respuesta.data);

    },function errorCallback(response) {
         $scope.ListadoPersonas= [];
        console.log( response);
        
   });



  $scope.Borrar=function(persona){
    votacionFactory.borrar(persona.id)
    .then(function(response){
          console.log(response);
          $state.reload();
          },
          function(response){
        console.error(response);
    });
  }




  $scope.Modificar=function(id){
    
    if(!$auth.isAuthenticated()){
      alert("Usted no posee permisos");
    } else {
      console.log("Modificar"+id);
    }
  }

});


app.controller("controlPersonaGrillaUser", function($scope, $http, $auth, $state, usuarioFactory){
    
    $scope.ListadoUsuarios = {};
  
  usuarioFactory.traerTodo()
  .then(function(respuesta) {       

         //$scope.ListadoUsuarios = respuesta.data.listado;
         console.log(respuesta.data);

    },function errorCallback(response) {
         $scope.ListadoUsuarios= [];
        console.log( response);
        
   });

  $scope.Borrar=function(user){
    
      $http.post('PHP/nexo.php', { datos: {accion :"borrarUser", id: user.id}})
      .then(function(response){
            console.log(response);
            $state.reload();
            },
            function(response){
          console.error(response);
      });
  }

});


app.controller("controlLogin", function($scope, $auth, $state){

  if($auth.isAuthenticated()){
    console.info("Logged: ", $auth.getPayload(), $auth.isAuthenticated());
  }else {
    console.info("No esta logueado: ", $auth.getPayload(), $auth.isAuthenticated());
  }


  $scope.authenticate = function(provider) {
    $auth.authenticate(provider)
      .then(function(response) {
        console.log($auth.isAuthenticated());
      })
      .catch(function(response) {
        // Something went wrong.
      });
  };


  $scope.Ingresar = function(){

    var user = {usuario:$scope.persona.user, clave:$scope.persona.password, dni:$scope.persona.dni};

    $auth.login(user)
    .then(function(respuesta){
       console.info("info respuesta", respuesta);


      if($auth.isAuthenticated()){
        console.info("Logged: ", $auth.getPayload(), $auth.isAuthenticated());
        $state.reload();
        $state.go('persona.menu');
      }else {
        console.info("No esta logueado: ", $auth.getPayload(), $auth.isAuthenticated());
      }
    },function(respuesta){
       console.error("Error Login", respueta);
    });
  }
  
  
});

app.controller("controlRegister", function($scope, $http, $state){
    $scope.usuario = {};
    
    $scope.Registrar = function(){
        $http.post('PHP/nexo.php', {datos: {accion:"registrar", usuario: $scope.usuario}})
        .then(function(respuesta){
            console.log(respuesta.data);
            $state.go("persona.menu");
        },
             function(respuesta){
            console.error(respuesta);
        });
    }
});
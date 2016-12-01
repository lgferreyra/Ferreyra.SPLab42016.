var app = angular.module("myApp",['ui.router', 'angularFileUpload', 'satellizer']);

app.config( function($stateProvider, $urlRouterProvider, $authProvider){


  $authProvider.loginUrl="ferreyra.leonardo/ws/PHP/server/jwt/php/auth.php";
  $authProvider.tokenName="myToken";
  $authProvider.tokenPrefix="myApp";
  $authProvider.authHeader="data";
  
  
  $stateProvider
    .state(
      "persona", {
        url:"/persona",
        abstract: true,
        templateUrl:"abstractPersona.html",
        controller:"controlPersona"
      }
      )
    .state(
      "persona.menu", {
        url:"/menu",
        views:{
          'contenido':{
            templateUrl:"personaMenu.html",
            controller:"controlPersonaMenu"
          }
        }
      }
      )
    .state(
      "persona.grilla", {
        url:"/grilla",
        views:{
          'contenido':{
            templateUrl:"personaGrilla.html",
            controller:"controlPersonaGrilla"
          }
        }
      }
      )
    .state(
      "persona.grillaUser", {
        url:"/grillaUser",
        views:{
          'contenido':{
            templateUrl:"personaGrillaUser.html",
            controller:"controlPersonaGrillaUser"
          }
        }
      }
      )
    .state(
      "persona.alta", {
        url:"/alta",
        params: {
            votacion: null
        },
        views:{
          'contenido':{
            templateUrl:"personaAlta.html",
            controller:"controlPersonaAlta"
          }
        }
      }
      )
    .state(
      "persona.login", {
        url:"/login",
        views:{
          'contenido':{
            templateUrl:"login.html",
            controller:"controlLogin"
          }
        }
      }
      )
    .state(
      "persona.register", {
        url:"/register",
        params: {
            usuario: null
        },
        views:{
          'contenido':{
            templateUrl:"register.html",
            controller:"controlRegister"
          }
        }
      }
      );
    $urlRouterProvider.otherwise('/persona/menu');
});


var app = angular.module("LocalServer",[]);


app.controller("localserver", ["$scope","$http", function($scope,$http) {

  $scope.layout = "grid";

  $scope.set_layout = function(layout){
    $scope.layout = layout;
  }





  $scope.open = function(project){
    window.location = "atm://open?url=file://"+project+"/";
  }


  $scope.resourse = function(folder,resource){
    if($scope.config.hostname=='home.dev'){
      return 'http://'+folder+'.dev/'+resource;
    }else{
      return 'http://'+folder+'.'+$scope.config.local_ip+'.xip.io/'+resource;
    }
  }
  $scope.launch = function(folder){
    if($scope.config.hostname==$scope.config.domain){
      window.location = 'http://'+folder+'.dev';
    }else{
      window.location = 'http://'+folder+'.'+$scope.config.local_ip+'.xip.io';
    }
  }

  $scope.xip = function(){
    if($scope.config.hostname!==$scope.config.domain){
      window.location = 'http://'+$scope.config.domain;
    }else{
      var split = $scope.config.domain.split('.');
      window.location = 'http://'+split[0]+'.'+$scope.config.local_ip+'.xip.io';
    }
  }

  $http({ method: 'GET', url: '/app/config.php' }).then(
    function successCallback(response) {
      $scope.config = response.data;
      $scope.config.hostname = document.location.hostname;
      if($scope.config.hostname==$scope.config.domain){
        $scope.config.xip = false;
      }else{
        $scope.config.xip = true;
      }
    },
    function errorCallback(response) {

    }
  );

}]);

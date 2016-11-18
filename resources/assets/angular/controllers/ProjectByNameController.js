'use strict';

angular.module('itracker')
    .controller('ProjectsByNameController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.projects = [];

        $scope.getProjects().success(function(data, status, headers, config) {
            angular.forEach(data,function(proj){
                if(!proj.template && proj.id != 9793820)
                    $scope.projects.push($scope.getProjectPack(proj.id));
            })
        })
    }])
'use strict';

angular.module('itracker')
    .controller('ProjectsByDeptController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.depts = [];
        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data,function(dept){
                var department = {};
                $scope.getGroup(dept.id).success(function (data, status, headers, config) {
                    department.name = data.name;
                    department.id = data.id;


                    department.projects = $scope.getDepartmentProjects(department.id);
                    $scope.depts.push(department);
                })
            })
        })
    }])
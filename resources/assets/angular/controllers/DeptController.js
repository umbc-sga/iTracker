'use strict';

angular.module('itracker')
    .controller('DepartmentController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.id = 0;

        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data, function(group){
                var group_href = replace_All(replace_All(group.name.toLowerCase()," ", "-") , "&", "and");
                if($routeParams.departmentName == group_href){
                    $scope.id = group.id;
                }
            })
            $scope.getGroup($scope.id).success(function (data, status, headers, config) {
                $scope.department = data;
                var people = [];
                angular.forEach(data.memberships,function(person){
                    $scope.getExtraPersonInfo(person.id).success(function(data, status, headers, config) {
                        var personInfo = person;
                        personInfo.bio = data.bio;
                        personInfo.major = data.major;
                        personInfo.classStanding = data.classStanding;
                        personInfo.hometown = data.hometown;
                        personInfo.fact = data.fact;
                        personInfo.position = data.position;
                        people.push(personInfo);
                    })
                })
                $scope.department.memberships = people;
                $scope.getExtraDeptInfo($scope.id).success(function (data, status, headers, config) {
                    $scope.department.description = data.description;
                })
                $scope.department.projects = $scope.getDepartmentProjects($scope.id);

            })

        })
    }])
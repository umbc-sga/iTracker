'use strict';

angular.module('itracker')
    .controller('PeopleByDeptController', ['$scope','$http', '$routeParams',
        function ($scope, $http, $routeParams) {
        $scope.depts = [];
        $scope.scrollTo = function(id) {
            console.log('go yo ' + id);
            $anchorScroll(id);
        };
        var badEmails = ['sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'];
        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data,function(dept){
                var department = {};
                $scope.getGroup(dept.id).success(function (data, status, headers, config) {
                    department.name = data.name;
                    department.id = data.id;

                    var people = [];
                    angular.forEach(data.memberships, function(person){
                        if(badEmails.indexOf(person.email_address) == -1) {
                            people.push($scope.getPersonPack(person.id));
                        }
                    });
                    department.people = people;
                    $scope.depts.push(department);
                })
            })
        })
    }]);
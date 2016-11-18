'use strict';

angular.module('itracker')
    .controller('PeopleByNameController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.people = [];
        var badEmails = ['sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'];

        $scope.getPeople().success(function(data, status, headers, config) {
            angular.forEach(data, function(person){
                if(badEmails.indexOf(person.email_address) == -1){
                    $scope.people.push($scope.getPersonPack(person.id));
                }
            })
        })
    }])
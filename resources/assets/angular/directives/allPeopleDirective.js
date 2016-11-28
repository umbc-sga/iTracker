'use strict';

angular.module('itracker')
    .directive('allPeople', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    $scope.people = [];

                    basecampService.getPeople().then((response) => $scope.people = response.data);
                }],
                templateUrl: '/angular/allPeople'
            };
        }]);

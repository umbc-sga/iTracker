'use strict';

angular.module('itracker')
    .directive('person', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    let personId = $routeParams.personId;

                    $scope.events = [];

                    $scope.person = {};
                    $scope.loaded = false;

                    basecampService.getPerson(personId)
                        .then((response) => $scope.person = response.data)
                        .finally(() => $scope.loaded = true);
                }],
                templateUrl: '/angular/people.person'
            };
        }]);

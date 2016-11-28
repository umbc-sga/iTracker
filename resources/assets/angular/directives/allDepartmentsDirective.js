'use strict';

angular.module('itracker')
    .directive('allDepartments', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    $scope.departments = [];

                    basecampService.getGroups().then((response) => $scope.departments = response.data);
                }],
                templateUrl: '/angular/allDepartments'
            };
        }]);

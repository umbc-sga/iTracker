'use strict';

angular.module('itracker')
    .directive('departmentView', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                scope: {
                    department: '='
                },
                controller: ['$scope', ($scope) => {
                    $scope.loaded = false;
                    basecampService.getGroup($scope.department.id).then((response) => {
                        $scope.department = response.data;
                        $scope.loaded = true;
                    }).catch((response) => $log.error('Error when getting department: ', response));
                }],
                templateUrl: '/angular/dept.departmentView'
            };
        }]);

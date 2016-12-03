'use strict';

angular.module('itracker')
    .directive('department', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    $scope.name = $routeParams.departmentName;
                    $scope.department = {};
                    $scope.loaded = false;

                    basecampService.getDepartment($routeParams.departmentName).then((response) => {
                        $scope.department = response.data;
                    }).catch((err) => {
                        $log.error('Error while getting department info.', err);
                    }).finally(()=>{
                        $scope.loaded = true;
                    });
                }],
                templateUrl: '/angular/dept.department'
            };
        }]);

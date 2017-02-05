'use strict';

angular.module('itracker')
    .directive('departmentView', ['$routeParams', '$log', 'basecampService', 'apiService',
        function($routeParams, $log, basecampService, apiService){
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
                templateUrl: apiService.root+'/angular/dept.departmentView'
            };
        }]);

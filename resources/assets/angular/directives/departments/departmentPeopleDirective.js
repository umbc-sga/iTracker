'use strict';

angular.module('itracker')
    .directive('departmentPeople', ['$routeParams', '$log', 'basecampService', 'apiService',
        function($routeParams, $log, basecampService, apiService){
            return {
                restrict: 'C',
                scope: {
                    groups: '='
                },
                controller: ['$scope', ($scope) => {
                    $scope.departments = [];

                    /**
                     * Get group data
                     */
                    for(let group of $scope.groups) {
                        basecampService.getGroup(group.id).then((response) => {
                            response.data.loaded = true;
                            $scope.departments.push(response.data)
                        });
                    }
                }],
                templateUrl: apiService.root+'/angular/dept.departmentPeople'
            };
        }]);

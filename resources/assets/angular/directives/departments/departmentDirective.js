'use strict';

angular.module('itracker')
    .directive('department', ['$routeParams', '$log', 'basecampService', 'dataService',
        function($routeParams, $log, basecampService, dataService){
            return {
                restrict: 'C',
                controller: ['$scope', '$filter', ($scope, $filter) => {
                    $scope.name = $routeParams.departmentName;
                    $scope.department = {};
                    $scope.loaded = false;

                    $scope.orgUser = null;
                    $scope.orgPermissions = null;

                    /**
                     * Get department
                     */
                    basecampService.getDepartment($routeParams.departmentName).then((response) => {
                        $scope.department = response.data;
                    }).catch((err) => {
                        $log.error('Error while getting department info.', err);
                    }).finally(()=>{
                        $scope.loaded = true;
                    });

                    /**
                     * Keep authenticated user up to date
                     */
                    $scope.$watch(()=>dataService.main.user, function(user, oldValue){
                        if(user != null)
                            for(let organization of user.organizations)
                                if ($filter('departmentHref')(organization.organization.name) == $scope.name) {
                                    $scope.orgPermissions = organization;
                                    return $scope.orgUser = user;
                                }

                        $scope.orgUser = null;
                    });
                }],
                templateUrl: '/angular/dept.department'
            };
        }]);

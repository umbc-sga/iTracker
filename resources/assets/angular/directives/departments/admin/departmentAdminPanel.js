'use strict';

angular.module('itracker')
    .directive('departmentAdmin', ['$routeParams', '$log', 'basecampService', 'dataService', 'apiService',
        function($routeParams, $log, basecampService, dataService, apiService){
            return {
                restrict: 'C',
                scope: {
                    'user': '=',
                    'permissions': '=',
                    'department': '='
                },
                controller: ['$scope', ($scope) => {
                    $scope.perms = [];
                    $scope.title = '';

                    /**
                     * Watch permissions
                     */
                    $scope.$watch('permissions', (permissions) => {
                        if(permissions && permissions.role.permissions) {
                            let list = [];

                            for(let perm of permissions.role.permissions)
                                list.push(perm.permission);

                            $scope.perms = list;
                            $scope.title = permissions.role.title;
                        }
                    })
                }],
                templateUrl: apiService.root+'/angular/dept.admin.departmentAdmin'
            };
        }]);

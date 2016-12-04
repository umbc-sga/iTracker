'use strict';

angular.module('itracker')
    .directive('departmentAdmin', ['$routeParams', '$log', 'basecampService', 'dataService',
        function($routeParams, $log, basecampService, dataService){
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

                    $scope.$watch('permissions', (permissions) => {
                        $log.debug(permissions);
                        if(permissions && permissions.role.permissions) {
                            let list = [];

                            for(let perm of permissions.role.permissions)
                                list.push(perm.permission);

                            $scope.perms = list;
                            $scope.title = permissions.role.title;
                        }
                    })
                }],
                templateUrl: '/angular/dept.admin.departmentAdmin'
            };
        }]);

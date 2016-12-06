'use strict';

angular.module('itracker')
    .directive('officerExec', ['$routeParams', '$log', 'basecampService', 'apiService',
        function($routeParams, $log, basecampService, apiService){
            return {
                restrict: 'C',
                scope: {
                    'user': '=',
                    'permissions': '=',
                    'department': '='
                },
                controller: ['$scope', '$filter', ($scope, $filter) => {
                    let departmentName = () => $filter('departmentHref')($scope.department.name);

                    /**
                     * Modify profile
                     * @param profile profile information
                     * @param token csrf token
                     * @param internalScope form scope
                     */
                    $scope.modifyProfile = (profile, token, internalScope) => {
                        $log.debug('exit function');
                        $log.info(profile);

                        return apiService.request('/dept/'+$scope.department.id+'/profileEdit', 'PUT', {
                            _method: 'PUT',
                            _token: token,
                            profile: profile.api_id,
                            bio: profile.biography,
                            classStanding: profile.classStanding,
                            major: profile.major,
                            hometown: profile.hometown,
                            fact: profile.fact
                        })
                            .then((response) => {
                                internalScope.errors = [];
                                if(response.data)
                                    basecampService.getDepartment(departmentName())
                                        .then((response) => $scope.department = response.data);
                            })
                            .catch((response) => {
                                internalScope.errors = response.data;
                            });
                    };

                    /**
                     * Make person executive
                     * @param person Person object
                     */
                    $scope.makeExec = (person) => {
                        if(!person)
                            return;

                        return basecampService.changeRole(person.id, $scope.department.id,'makeExec')
                            .then((response) => {
                                if(response.data)
                                    basecampService.getDepartment(departmentName())
                                        .then((response) => $scope.department = response.data);
                            });
                    };

                    /**
                     * Make person cabinet
                     * @param person Person object
                     */
                    $scope.makeCabinet = (person) => {
                        if(!person)
                            return;

                        return basecampService.changeRole(person.id, $scope.department.id,'makeCabinet')
                            .then((response) => {
                                if(response.data)
                                    basecampService.getDepartment(departmentName())
                                        .then((response) => $scope.department = response.data);
                            });
                    };
                }],
                templateUrl: '/angular/dept.admin.officerExec'
            };
        }]);

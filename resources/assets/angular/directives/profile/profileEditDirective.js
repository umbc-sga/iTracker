'use strict';

angular.module('itracker')
    .directive('profileEdit', ['$routeParams', '$log', 'basecampService',
        'errorService', 'apiService', '$location',
        function($routeParams, $log, basecampService, errorService, apiService, $location){
        return {
            restrict: 'C',
            scope: {
                personId: '=',
                exitFunction: '='
            },
            controller: ['$scope', function($scope){
                $scope.action = $routeParams.action;
                let profileId = $routeParams.profileId ? $routeParams.profileId : $scope.personId;

                $scope.profile = null;
                $scope.errors = errorService.getErrors();
                $scope.submitting = false;
                $scope.loading = true;

                let getProfile = () => basecampService.getPersonProfile(profileId)
                    .then((response) => $scope.profile = response.data)
                    .catch((response) => $scope.profile = null)
                    .finally(() => $scope.loading = false);

                let timeout = null;

                $scope.$watch('personId', (id) => {
                    if(id) {
                        $scope.loading = true;
                        profileId = id;
                    }

                    if(timeout)
                        clearTimeout(timeout);

                    timeout = setTimeout(getProfile, 300);
                });

                $scope.submit = (token) => ($scope.exitFunction ? $scope.exitFunction : (token) => {
                    $scope.submitting = true;

                    return apiService.request('profileStore', 'PUT', {
                        _method: 'PUT',
                        _token: token,
                        profile: $scope.profile.api_id,
                        bio: $scope.profile.biography,
                        classStanding: $scope.profile.classStanding,
                        major: $scope.profile.major,
                        hometown: $scope.profile.hometown,
                        fact: $scope.profile.fact
                    })
                        .then((response) => {
                            $scope.submitting = false;
                            $location.url(response.data.redirectTo);
                        })
                        .catch((response) => {
                            $scope.submitting = false;
                            $scope.errors = response.data;
                        });
                })($scope.profile, token, $scope);
            }],
            templateUrl: apiService.root+'/angular/profile.editProfile'
        };
    }]);

'use strict';

angular.module('itracker')
    .directive('profileEdit', ['$routeParams', '$log', 'basecampService', 'errorService', 'apiService', '$location',
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

                $scope.profile = {};
                $scope.errors = errorService.getErrors();
                $scope.loading = false;

                basecampService.getPersonProfile(profileId)
                    .then((response) => $scope.profile = response.data);

                $scope.submit = (token) => ($scope.exitFunction ? $scope.exitFunction($scope.profile, token) : () => {
                    $scope.loading = true;

                    apiService.request('profileStore', 'PUT', {
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
                            $scope.loading = false;
                            //$location.url(response.data.redirectTo);
                        })
                        .catch((response) => {
                            $scope.loading = false;
                            $scope.errors = response.data;
                        });
                })();
            }],
            templateUrl: '/angular/profile.editProfile'
        };
    }]);

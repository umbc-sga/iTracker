'use strict';

angular.module('itracker')
    .directive('profileEdit', ['$routeParams', '$log', 'basecampService', 'errorService',
        function($routeParams, $log, basecampService, errorService){
        return {
            restrict: 'C',
            controller: ['$scope', function($scope){
                $scope.action = $routeParams.action;
                let profileId = $routeParams.profileId;

                $scope.profile = {};
                $scope.errors = errorService.getErrors();

                basecampService.getPersonProfile(profileId)
                    .then((response) => $scope.profile = response.data);
            }],
            templateUrl: '/angular/profile.editProfile'
        };
    }]);

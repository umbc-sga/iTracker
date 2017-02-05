'use strict';

angular.module('itracker')
    .directive('personProfile', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    profile: '='
                },
                templateUrl: apiService.root+'/angular/profile.personProfile'
            };
        }]);

'use strict';

angular.module('itracker')
    .directive('meetTheTeam', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    teamTitle: '@',
                    members: '=',
                    showPositions: '='
                },
                templateUrl: apiService.root+'/angular/meetTheTeam'
            };
        }]);
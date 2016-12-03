'use strict';

angular.module('itracker')
    .directive('meetTheTeam', [function(){
            return {
                restrict: 'C',
                scope: {
                    teamTitle: '@',
                    members: '='
                },
                templateUrl: '/angular/meetTheTeam'
            };
        }]);